$(document).ready(function(){  
    //---------------xóa 1 sản phẩm------ 
    $('body').on('click','.ok_del_slide',function(){
        $btn = $(this).button('loading');
        SlideID = $(this).attr('SlideID');
        $.post(base_url+'slide/delete_slide',{"SlideID":SlideID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){
                    message(1,'Xóa thành công!'); 
                    reset_pagination_all_slide_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                } 
            });
    })
    //------xóa nhiều sản phẩm-------------
    $('#btn_del_more_slide').click(function(){
        $arr_SlideID = count_check_slide();
        if( $arr_SlideID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_slide',function(){
        $btn = $(this).button('loading');
        $arr_SlideID = count_check_slide();
        $.post(base_url+'slide/delete_more_slide',{"arr_SlideID":$arr_SlideID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false);
                   // ------------- load lại sản phẩm 
                    reset_pagination_all_slide_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click(); 
            });
        }) 

    //-----đếm số lượng item được check----------
    function count_check_slide(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $SlideID = $(this).attr('SlideID');
                $count_check.push($SlideID); 
            }
        })
        return $count_check;
    } 

    //------------change hiện thị sản phẩm---------
    $('body').on('change','#slide_admin .check_hienthi',function(){
        $HienThi = 0;
        $t = $(this);
        $SlideID = $(this).attr('SlideID');
        if( $(this).is(':checked') ){
            $HienThi = 1;
        }else{
            $HienThi = 0;
        } 
        $.post(base_url + 'slide/update_hienthi_slide',({"HienThi":$HienThi,"SlideID":$SlideID})).done(function(data){
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
    function init_slide_admin(){
        $.post(base_url + 'slide/count_all_slide_admin').done(function(data){
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
                    get_slide_admin(num);  
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
                    get_slide_admin(num);  
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_slide_admin(1);
        })
    }
    init_slide_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){ 
        $.post(base_url + 'slide/count_all_slide_admin').done(function(data){
            $number = parseInt($('.selector_limit_item').val());   
            $total_page = Math.ceil(data/$number); 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            get_slide_admin(1);
            $to = ($number > $result.count) ? $result.count:$number;
            info_page_item(1,$to,data);
        }) 
    }) 
    function get_slide_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'slide/get_slide_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#slide_admin tbody').html($result.list_slide); 
            $(".tablesorter").trigger('update');    
            if ($result.list_slide == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_all_slide_admin(){
        $.post(base_url + 'slide/count_all_slide_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            if( $page > $total_page ){
                $page = $total_page;
            }
            ($page == 0) ? $page = 1 : $page;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_slide_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort sản phẩm-----------
    $("#slide_admin").tablesorter({headers: {
        0: { sorter: false },
        1: { sorter: false },
        2: { sorter: false },
        3: { sorter: false },
        5: { sorter: false } 
    }});

    // ---------------THÊM DANH MỤC-------------------
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

     //-----------------ADD mang xa hoi---------------
    function reset_form_add_edit(){
        $('#input_link').val('');
        $('#thumb_image').attr('src','')  
        $('#fieldID').val('').focus(); 
        $('#TieuDe').val(''); 
        $('#SlideID').val('');
        $('html,body').animate({'scrollTop': 0},200);
        load_ajax_out('.form_add_edit');
    }
    $('.reset_form_add_edit').click(function(){
        reset_form_add_edit();
    })

    $('body').on('click','.add_slide',function (){
        $('.form_add_edit').removeClass('form_edit');
        $('.form_add_edit').addClass('form_add');
        $('.form_add_edit').removeAttr('SlideID');
        $('.close_add_edit').show();
        reset_form_add_edit();
    })   

    function add_slide(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'slide/insert_slide',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Thêm thành công!');
                    // ------------- load lại danh mục
                    reset_pagination_all_slide_admin();  
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    }
    // ---------------EDIT danh muc---------------
    $('body').on('click','.edit_slide',function(){
        SlideID = $(this).attr('SlideID'); 
        validator.resetForm();
        $.post(base_url + 'slide/get_chitiet_slide_admin',({"SlideID":SlideID})).done(
            function(data){
                kq = JSON.parse(data); 
                $('#fieldID').val(kq['Image']);
                $('#thumb_image').attr('src',kq['Image']);
                $('#TieuDe').val(kq['TieuDe']);
                $('#SlideID').val(kq['SlideID']);
                $('#input_link').val(kq['Link']);
                $('.form_add_edit').removeClass('form_add');
                $('.form_add_edit').addClass('form_edit');
                $('.form_add_edit').attr('SlideID',kq['SlideID']);
                $('.close_add_edit').hide();
                $('html,body').animate({'scrollTop': 0},200);
                load_ajax_out('.form_add_edit');
            })
    })

    function edit_slide(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'slide/edit_slide',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $page = parseInt($('.pagination_item .selected').html());
                    // get_slide_admin($page); 
                    message(1,'Chỉnh sửa thành công!');
                    // ------------- load lại danh mục 
                    reset_pagination_all_slide_admin();      
                    toggle_form_add_edit();
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        ) 
        return false;
    }

    var validator = $(".form_add_edit").validate({
        submitHandler: function(form) {
            if($(".form_add_edit").hasClass('form_add'))
                add_slide();         
            else if($(".form_add_edit").hasClass('form_edit'))
                edit_slide();
        }
    }); 

})