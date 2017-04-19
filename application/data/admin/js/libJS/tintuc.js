$(document).ready(function(){ 
    //---------------xóa 1 sản phẩm------- 
    $('body').on('click','.ok_del_tintuc',function(){
        $btn = $(this).button('loading');
        TinTucID = $(this).attr('TinTucID');
        $.post(base_url+'tintuc/delete_tintuc',{"TinTucID":TinTucID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_tintuc_admin(); 
                    else
                        reset_pagination_search_tintuc_admin();
                }else{
                    message(2,'Xóa không thành công!');
                }
            });
    })
    //------xóa nhiều sản phẩm-------------
    $('#btn_del_more_baiviet').click(function(){
        $arr_TinTucID = count_check_tintuc();
        if( $arr_TinTucID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_sp',function(){ 
        $btn = $(this).button('loading');
        $arr_TinTucID = count_check_tintuc();
        $.post(base_url+'tintuc/delete_more_tintuc',{"arr_TinTucID":$arr_TinTucID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false);
                   // ------------- load lại sản phẩm
                    if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_tintuc_admin(); 
                    else
                        reset_pagination_search_tintuc_admin();
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click();
            });
    })  

    //-----đếm số lượng item được check----------
    function count_check_tintuc(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $TinTucID = $(this).attr('TinTucID');
                $count_check.push($TinTucID); 
            }
        })
        return $count_check;
    } 
    //------------change hiện thị tin tuc---------
    $('body').on('change','#tintuc_admin .check_hienthi',function(){
        $HienThi = 0;
        $t = $(this);
        $TinTucID = $(this).attr('TinTucID');
        if( $(this).is(':checked') ){
            $HienThi = 1;
        }else{
            $HienThi = 0;
        } 
        $.post(base_url + 'tintuc/update_hienthi_tintuc',({"HienThi":$HienThi,"TinTucID":$TinTucID})).done(function(data){
            if(data == 1){
                $t.parents('tr').find('.hienthi_sort').html($HienThi); 
                $(".tablesorter").trigger('update'); 
                message(1,'Cập nhật thành công!');
            }else{
                message(2,'Cập nhật không thành công!');
            }
        })

    })

     // -----------Phân trang sản phẩm-------------- 
    function init_tintuc_admin(){
        $.post(base_url + 'tintuc/count_all_tintuc_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number);  
            $(".pagination_sp1").jPaginator({
                nbPages:$total_page,
                speed: 5,
                nbVisible:8,
                selectedPage:1, 
                overBtnLeft:'.pre_left',
                overBtnRight:'.next_right',
                maxBtnLeft:'.first_left',
                maxBtnRight:'.last_right',
                minSlidesForSlider:2,
                onPageClicked: function(a,num) { 
                    if( trim($('#input_search').val()) != '' )
                        search_tintuc_admin(num);  
                    else
                        get_tintuc_admin(num);
                    $(".pagination_sp2").trigger("reset",{ selectedPage:num }); 
                }
            });     
            $(".pagination_sp2").jPaginator({
                nbPages:$total_page,
                speed: 5,
                nbVisible:8,
                selectedPage:1, 
                overBtnLeft:'.pre_left',
                overBtnRight:'.next_right',
                maxBtnLeft:'.first_left',
                maxBtnRight:'.last_right',
                minSlidesForSlider:5,
                onPageClicked: function(a,num) { 
                    if( trim($('#input_search').val()) != '' )
                        search_tintuc_admin(num);  
                    else
                        get_tintuc_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_tintuc_admin(1);
        })
    }
    init_tintuc_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){
        $key = trim($('#input_search').val());  
        if($key != ''){
            reset_pagination_search_tintuc_admin();  
        }else{  
            $.post(base_url + 'tintuc/count_all_tintuc_admin').done(function(data){
                $number = parseInt($('.selector_limit_item').val());   
                $total_page = Math.ceil(data/$number); 
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                get_tintuc_admin(1);
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item(1,$to,data); 
            })
        }
    }) 
    function get_tintuc_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'tintuc/get_tintuc_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#tintuc_admin tbody').html($result.list_sp); 
            $(".tablesorter").trigger('update');    
            if ($result.list_sp == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count); 
        })
    }
    function reset_pagination_all_tintuc_admin(){
        $.post(base_url + 'tintuc/count_all_tintuc_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_tintuc_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort sản phẩm-----------
    $("#tintuc_admin").tablesorter({headers: {
        0: { sorter: false },
        1: { sorter: false },
        2: { sorter: false },
        3: { sorter: false },
        5: { sorter: false },
    }});
    
    // ------SEARCH SẢN PHẨM--------- 
    $('.form_search').on('submit',function(e){
        load_get_data();

        e.preventDefault();
        $key = trim($('#input_search').val()); 
        if($key == ''){
            reset_pagination_all_tintuc_admin();
            $('#input_search').removeClass('bg_search');
        }else{ 
            $('#input_search').addClass('bg_search');
            $number = parseInt($('.selector_limit_item').val());  
            $.post(base_url + 'tintuc/search_tintuc_admin',({'key':$key,'number':$number,'offset':0})).done(function(data){
                $result = JSON.parse(data);
                $('#tintuc_admin tbody').html($result.list_search);
                $(".tablesorter").trigger('update'); 
                $total_page = Math.ceil($result.count/$number);  
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $from = ($result.list_search == '') ? 0:1;
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item($from,$to,$result.count);   
            }) 
        } 
        $('.popup_form_search').hide();  
    })
    function search_tintuc_admin($page){ 
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        $key = $('#input_search').val(); 
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset;
        $.post(base_url + 'tintuc/search_tintuc_admin',({'key':$key,'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#tintuc_admin tbody').html($result.list_search);
            $(".tablesorter").trigger('update');
            if ($result.list_search == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1; 
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count;
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_search_tintuc_admin(){
        $key = $('#input_search').val();
        $.post(base_url + 'tintuc/count_search_tintuc_admin',({'key':$key})).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            search_tintuc_admin($page);  
        })
    }  

    $('.clear_search').click(function(){
        $('#input_search').val(''); 
        reset_pagination_all_tintuc_admin();
        $('#input_search').removeClass('bg_search');
    })  
  
     //-----------------ADD sp---------------
    function reset_form_add_edit(){
        validator.resetForm();
        $('#input_tieude').val('');   
        tinyMCE.editors['tinymce4_mota'].setContent(''); 
        tinyMCE.editors['tinymce4_noidung'].setContent(''); 
        $('html,body').animate({'scrollTop': 0},200);
        load_ajax_out('.form_add_edit');
    }
    $('.reset_form_add_edit').click(function(){
        reset_form_add_edit();
    })

    $('body').on('click','.add_sp',function (){
        $('.form_add_edit').removeClass('form_edit');
        $('.form_add_edit').addClass('form_add');
        $('.form_add_edit').removeAttr('IDsp');
        $('.close_add_edit').show();
        reset_form_add_edit();
    })   

    function add_baiviet(){
        $('.ok_add_edit').button('loading');
        TieuDe = $('#input_tieude').val();
        NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        MoTa = tinyMCE.editors['tinymce4_mota'].getContent(); 
        images = $('#fieldID').val();
        $.post(base_url+'tintuc/insert_tintuc',{
            "TieuDe":TieuDe,"MoTa":MoTa,"NoiDung":NoiDung,"images" :images}).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $('#input_tieude').focus();
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Thêm thành công!');
                    // ------------- load lại sản phẩm
                    if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_tintuc_admin(); 
                    else
                        reset_pagination_search_tintuc_admin();  
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    }
    // ---------------EDIT sp---------------
    $('body').on('click','.edit_tintuc',function(){
        $(".form_add_edit p.error").remove();
        TinTucID = $(this).attr('TinTucID');
        $.post(base_url + 'tintuc/get_chitiet_tintuc_admin',{"TinTucID":TinTucID}).done(function(data){
            kq = JSON.parse(data);
            $('#input_tieude').val(kq['TieuDe']);   
            tinyMCE.editors['tinymce4_noidung'].setContent(kq['NoiDung']);  
            tinyMCE.editors['tinymce4_mota'].setContent(kq['MoTa']);  
            $('.form_add_edit').removeClass('form_add');
            $('.form_add_edit').addClass('form_edit');
            $('.form_add_edit').attr('TinTucID',kq['TinTucID']);
            $('.close_add_edit').hide();
            $('html,body').animate({'scrollTop': 0},10);
            load_ajax_out('.form_add_edit');
        })
    })

    function edit_baiviet(){
        $('.ok_add_edit').button('loading');
        TinTucID = $('.form_add_edit').attr('TinTucID'); 
        TieuDe = $('#input_tieude').val(); 
        NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        MoTa = tinyMCE.editors['tinymce4_mota'].getContent();  
        images = $('#fieldID').val();
        $.post(base_url+'tintuc/edit_tintuc',{
            "TinTucID":TinTucID,"TieuDe":TieuDe,"NoiDung":NoiDung,"MoTa":MoTa,"images" :images
        }).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $page = parseInt($('.pagination_item .selected').html());
                    // get_tintuc_admin($page); 
                    message(1,'Chỉnh sửa thành công!');
                    // ------------- load lại danh mục
                    if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_tintuc_admin(); 
                    else
                        reset_pagination_search_tintuc_admin();
                    toggle_form_add_edit();
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        ) 
        return false;
    } 

    function validate_tinymce(){
        NoiDung = tinyMCE.editors['tinymce4_noidung'].getContent(); 
        MoTa = tinyMCE.editors['tinymce4_mota'].getContent();  
        result = 1;
        $(".form_add_edit p.error").remove();

        if(strip_tags(MoTa) == ''){
            $('<p class="error">Nhập mô tả bài viết.</p>').insertAfter('#tinymce4_mota');
            result = 0;
        }else{
            $('#tinymce4_mota').next('.error').remove();
        }
        if(strip_tags(NoiDung) == ''){
            $('<p class="error">Nhập nội dung bài viết.</p>').insertAfter('#tinymce4_noidung');
            result = 0;
        }else{
            $('#tinymce4_noidung').next('.error').remove();
        }  

        if($('#input_tieude').val().trim() == ''){
            result = 0;
            $('html,body').animate({'scrollTop':$('#input_tieude').parent().offset().top - 50},1);
        }else if(strip_tags(MoTa) == ''){
            tinyMCE.editors['tinymce4_mota'].focus()
            $('html,body').animate({'scrollTop':$('#tinymce4_mota').parent().offset().top - 50},1);
        }else if(strip_tags(NoiDung) == ''){
            tinyMCE.editors['tinymce4_noidung'].focus()
            $('html,body').animate({'scrollTop':$('#tinymce4_noidung').parent().offset().top - 50},1);
        }
        return result;
    }

    $(".form_add_edit").submit(function(){
        validate_tinymce();
    })
     $('.iframe-btn').fancybox({    
        'type'      : 'iframe', 
        fitToView: false,
        autoSize: false,
        autoDimensions: false,
        width: '95%',
        height: '95%',  
    }); 

    $('.close_thumb_image').click(function(e){
        e.stopPropagation();
        $('#thumb_image').attr('src',dataadmin_url + 'img/notFound.png');
        $('#fieldID').val('');
        return false;
    })    
    $('body').on('click','.fancybox',function(){
        return false;
    })
    $('#fieldID').keyup(function(){
        $('#thumb_image').attr('src',$('#fieldID').val());  
    })

    $('body').on('click','.fancybox_image',function(e){
        e.stopPropagation();
        url = $(this).attr('src'); 
        $('<a class="fancybox" href="' + url + '"/>').fancybox({ 
            type:'image',
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            height: '95%',  
        }).click();
        return false;
    }) 
    validator = $(".form_add_edit").validate({
        submitHandler: function(form) {
            if(validate_tinymce()){
                if($(".form_add_edit").hasClass('form_add'))
                    add_baiviet();         
                else if($(".form_add_edit").hasClass('form_edit'))
                    edit_baiviet();
            }
        }
    });  

})