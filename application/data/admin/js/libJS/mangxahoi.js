$(document).ready(function(){  
    //---------------xóa 1 sản phẩm------ 
    $('body').on('click','.ok_del_mangxahoi',function(){
        $btn = $(this).button('loading');
        MangXHID = $(this).attr('MangXHID');
        $.post(base_url+'mangxahoi/delete_mangxahoi',{"MangXHID":MangXHID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){
                    message(1,'Xóa thành công!'); 
                    reset_pagination_all_mangxahoi_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                } 
            });
    })
    //------xóa nhiều sản phẩm-------------
    $('#btn_del_more_mangxahoi').click(function(){
        $arr_MangXHID = count_check_mangxahoi();
        if( $arr_MangXHID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_mangxahoi',function(){
        $btn = $(this).button('loading');
        $arr_MangXHID = count_check_mangxahoi();
        $.post(base_url+'mangxahoi/delete_more_mangxahoi',{"arr_MangXHID":$arr_MangXHID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false);
                   // ------------- load lại sản phẩm 
                    reset_pagination_all_mangxahoi_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click(); 
            });
        }) 

    //-----đếm số lượng item được check----------
    function count_check_mangxahoi(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $MangXHID = $(this).attr('MangXHID');
                $count_check.push($MangXHID); 
            }
        })
        return $count_check;
    } 

    //------------change hiện thị sản phẩm---------
    $('body').on('change','#mangxahoi_admin .check_hienthi',function(){
        $HienThi = 0;
        $t = $(this);
        $MangXHID = $(this).attr('MangXHID');
        if( $(this).is(':checked') ){
            $HienThi = 1;
        }else{
            $HienThi = 0;
        } 
        $.post(base_url + 'mangxahoi/update_hienthi_mangxahoi',({"HienThi":$HienThi,"MangXHID":$MangXHID})).done(function(data){
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
    function init_mangxahoi_admin(){
        $.post(base_url + 'mangxahoi/count_all_mangxahoi_admin').done(function(data){
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
                    get_mangxahoi_admin(num);  
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
                    get_mangxahoi_admin(num);  
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_mangxahoi_admin(1);
        })
    }
    init_mangxahoi_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){ 
        $.post(base_url + 'mangxahoi/count_all_mangxahoi_admin').done(function(data){
            $number = parseInt($('.selector_limit_item').val());   
            $total_page = Math.ceil(data/$number); 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            get_mangxahoi_admin(1);
            $to = ($number > $result.count) ? $result.count:$number;
            info_page_item(1,$to,data);
        }) 
    }) 
    function get_mangxahoi_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'mangxahoi/get_mangxahoi_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#mangxahoi_admin tbody').html($result.list_mangxahoi); 
            $(".tablesorter").trigger('update');    
            if ($result.list_mangxahoi == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_all_mangxahoi_admin(){
        $.post(base_url + 'mangxahoi/count_all_mangxahoi_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            if( $page > $total_page ){
                $page = $total_page;
            }
            ($page == 0) ? $page = 1 : $page;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_mangxahoi_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort sản phẩm-----------
    $("#mangxahoi_admin").tablesorter({headers: {
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
        $('#MangXHID').val('');
        $('html,body').animate({'scrollTop': 0},200);
        load_ajax_out('.form_add_edit');
    }
    $('.reset_form_add_edit').click(function(){
        reset_form_add_edit();
    })

    $('body').on('click','.add_mangxahoi',function (){
        $('.form_add_edit').removeClass('form_edit');
        $('.form_add_edit').addClass('form_add');
        $('.form_add_edit').removeAttr('MangXHID');
        $('.close_add_edit').show();
        reset_form_add_edit();
    })   

    function add_mangxahoi(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'mangxahoi/insert_mangxahoi',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Thêm thành công!');
                    // ------------- load lại danh mục
                    reset_pagination_all_mangxahoi_admin();  
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    }
    // ---------------EDIT danh muc---------------
    $('body').on('click','.edit_mangxahoi',function(){
        MangXHID = $(this).attr('MangXHID'); 
        validator.resetForm();
        $.post(base_url + 'mangxahoi/get_chitiet_mangxahoi_admin',({"MangXHID":MangXHID})).done(
            function(data){
                kq = JSON.parse(data); 
                $('#fieldID').val(kq['Image']);
                $('#thumb_image').attr('src',kq['Image']);
                $('#TieuDe').val(kq['TieuDe']);
                $('#MangXHID').val(kq['MangXHID']);
                $('#input_link').val(kq['Link']);
                $('.form_add_edit').removeClass('form_add');
                $('.form_add_edit').addClass('form_edit');
                $('.form_add_edit').attr('MangXHID',kq['MangXHID']);
                $('.close_add_edit').hide();
                $('html,body').animate({'scrollTop': 0},200);
                load_ajax_out('.form_add_edit');
            })
    })

    function edit_mangxahoi(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'mangxahoi/edit_mangxahoi',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $page = parseInt($('.pagination_item .selected').html());
                    // get_mangxahoi_admin($page); 
                    message(1,'Chỉnh sửa thành công!');
                    // ------------- load lại danh mục 
                    reset_pagination_all_mangxahoi_admin();      
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
                add_mangxahoi();         
            else if($(".form_add_edit").hasClass('form_edit'))
                edit_mangxahoi();
        }
    }); 

})