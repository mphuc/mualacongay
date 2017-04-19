$(document).ready(function(){  
    //---------------xóa 1 sản phẩm------ 
    $('body').on('click','.ok_del_user',function(){
        UserID = $(this).attr('UserID');
        $btn = $(this).button('loading');
        $.post(base_url+'user/delete_user',{"UserID":UserID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){
                    message(1,'Xóa thành công!'); 
                    reset_pagination_all_user_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                } 
            });
    })
    //------xóa nhiều sản phẩm-------------
    $('#btn_del_more_user').click(function(){
        $arr_UserID = count_check_user();
        if( $arr_UserID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_user',function(){
        $arr_UserID = count_check_user();
        $btn = $(this).button('loading');
        $.post(base_url+'user/delete_more_user',{"arr_UserID":$arr_UserID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false);
                   // ------------- load lại sản phẩm 
                    reset_pagination_all_user_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click(); 
            });
        }) 

    //-----đếm số lượng item được check----------
    function count_check_user(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $UserID = $(this).attr('UserID');
                $count_check.push($UserID); 
            }
        })
        return $count_check;
    } 

    //------------change hiện thị sản phẩm---------
    $('body').on('change','#user_admin .check_trangthai',function(){
        $TrangThai = 0;
        $t = $(this);
        $UserID = $(this).attr('UserID');
        if( $(this).is(':checked') ){
            $TrangThai = 1;
        }else{
            $TrangThai = 0;
        } 
        $.post(base_url + 'user/update_TrangThai_user',({"TrangThai":$TrangThai,"UserID":$UserID})).done(function(data){
            if(data == 1){
                $t.parents('tr').find('.TrangThai_sort').html($TrangThai); 
                $(".tablesorter").trigger('update'); 
                message(1,'Cập nhật thành công!');
            }else{
                message(2,'Cập nhật không thành công!');
            }
        })

    })
     // -----------Phân trang sản phẩm-------------- 
    function init_user_admin(){
        $.post(base_url + 'user/count_all_user_admin').done(function(data){
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
                    get_user_admin(num);  
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
                    get_user_admin(num);  
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_user_admin(1);
        })
    }
    init_user_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){ 
        $.post(base_url + 'user/count_all_user_admin').done(function(data){
            $number = parseInt($('.selector_limit_item').val());   
            $total_page = Math.ceil(data/$number); 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            get_user_admin(1);
            $to = ($number > $result.count) ? $result.count:$number;
            info_page_item(1,$to,data);
        }) 
    }) 
    function get_user_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'user/get_user_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#user_admin tbody').html($result.list_user); 
            $(".tablesorter").trigger('update');    
            if ($result.list_user == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_all_user_admin(){
        $.post(base_url + 'user/count_all_user_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            if( $page > $total_page ){
                $page = $total_page;
            }
            ($page == 0) ? $page = 1 : $page;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_user_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 

    // --------------sort sản phẩm-----------
    $("#user_admin").tablesorter({headers: {
        0: { sorter: false },
        1: { sorter: false },
        2: { sorter: false }, 
        5: { sorter: false } 
    }});

     //-----------------ADD USER---------------
    function reset_form_add_edit(){
        $('#Username').val('');  
        $('#UserID').val('');
        $('html,body').animate({'scrollTop': 0},200);
        load_ajax_out('.form_add_edit');
    }
    $('.reset_form_add_edit').click(function(){
        reset_form_add_edit();
    })

    $('body').on('click','.add_user',function (){
        $('.block_Password').show();
        $('.form_add_edit').removeClass('form_edit');
        $('.form_add_edit').addClass('form_add'); 
        $('.close_add_edit').show();
        reset_form_add_edit();
    })   

    function add_user(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'user/insert_user',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Thêm thành công!');
                    // ------------- load lại danh mục
                    reset_pagination_all_user_admin();  
                    $('#Username').focus();
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    }


    // ---------------EDIT danh muc---------------
    $('body').on('click','.edit_user',function(){
        $('.block_Username label').remove(); 
        UserID = $(this).attr('UserID'); 
        validator.resetForm();
        $.post(base_url + 'user/get_chitiet_user_admin',({"UserID":UserID})).done(
            function(data){
                kq = JSON.parse(data); 
                $('#Username').val(kq['Username']);  
                $('#Username').attr('old_Username',kq['Username']);  
                $('#Quyen').val(kq['Quyen']);
                $('#UserID').val(kq['UserID']);
                $('.block_Password').hide();

                $('.form_add_edit').removeClass('form_add');
                $('.form_add_edit').addClass('form_edit'); 
                $('.close_add_edit').hide();
                $('html,body').animate({'scrollTop': 0},200);
                load_ajax_out('.form_add_edit');
            })
    })

    function edit_user(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'user/edit_user',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Chỉnh sửa thành công!');
                    reset_pagination_all_user_admin();      
                    toggle_form_add_edit();
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        ) 
        return false;
    }

    // ----------------------check_username---------------------
    $('#Username').keyup(function(){ 
        // check_username();
    })
  
    function check_username(){
        $Username = $('#Username').val();
        $old_Username = $('#Username').attr('old_Username')||'';
        var succeed = true;

        $('.block_Username label').remove(); 
        if($Username.length >= 3){
            $.ajax({
                method:"POST",
                async: false,
                url:base_url+'user/check_username',
                data:{"Username":$Username,"old_Username":$old_Username},
                success: function(data){ 
                    if(data == 0){
                        $('.block_Username').show().append('<label><span class="green"><i class="fa fa-check"></i> Tên người dùng hợp lệ</span></label>');
                        succeed = true;
                    }else{
                        $('#Username').focus();
                        $('.block_Username').show().append('<label class="error">Tên người dùng đã tồn tại</label>');
                        succeed = false;
                    }
                }
            });  
        }  
        return succeed;
    }
    // ----------------------check_username---------------------

    var validator = $(".form_add_edit").validate({
        submitHandler: function(form) {
            if(check_username() == true ){
                if($(".form_add_edit").hasClass('form_add')){
                    add_user();         
                }else if($(".form_add_edit").hasClass('form_edit')){
                    edit_user();
                }
            }
        }
    }); 

})