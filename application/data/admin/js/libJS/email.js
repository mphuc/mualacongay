$(document).ready(function(){  
    $('#show_pass').mousedown(function(){ 
        $('#smtp_pass').attr('type','text');
    })    
    $('#show_pass').mouseup(function(){ 
        $('#smtp_pass').attr('type','password');
    })

    //---------------xóa 1 email------ 
    $('body').on('click','.ok_del_email',function(){
        $btn = $(this).button('loading');
        EmailID = $(this).attr('EmailID');
        $.post(base_url+'email/delete_email',{"EmailID":EmailID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){
                    message(1,'Xóa thành công!'); 
                    reset_pagination_all_email_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                } 
            });
    })
    //------xóa nhiều email-------------
    $('#btn_del_more_email').click(function(){
        $arr_EmailID = count_check_email();
        if( $arr_EmailID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_email',function(){
        $btn = $(this).button('loading');
        $arr_EmailID = count_check_email();
        $.post(base_url+'email/delete_more_email',{"arr_EmailID":$arr_EmailID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false);
                   // ------------- load lại sản phẩm 
                    reset_pagination_all_email_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click(); 
            });
        }) 

    //-----đếm số lượng item được check----------
    function count_check_email(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $EmailID = $(this).attr('EmailID');
                $count_check.push($EmailID); 
            }
        })
        return $count_check;
    } 

    //------------change hiện thị sản phẩm---------
    $('body').on('change','#email_admin .check_default',function(){ 
        $EmailID = $(this).attr('EmailID'); 
        $.post(base_url + 'email/update_default_email',({"EmailID":$EmailID})).done(function(data){
            if(data == 1){ 
                message(1,'Cập nhật thành công!');
            }else{
                message(2,'Cập nhật không thành công!');
            }
        })

    })
     // -----------Phân trang sản phẩm-------------- 
    function init_email_admin(){
        $.post(base_url + 'email/count_all_email_admin').done(function(data){
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
                    get_email_admin(num);  
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
                    get_email_admin(num);  
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_email_admin(1);
        })
    }
    init_email_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){ 
        $.post(base_url + 'email/count_all_email_admin').done(function(data){
            $number = parseInt($('.selector_limit_item').val());   
            $total_page = Math.ceil(data/$number); 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            get_email_admin(1);
            $to = ($number > $result.count) ? $result.count:$number;
            info_page_item(1,$to,data);
        }) 
    }) 
    function get_email_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'email/get_email_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#email_admin tbody').html($result.list_email); 
            $('[data-toggle="tooltip"]').tooltip();
            if ($result.list_email == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count);
        })
    }
    function reset_pagination_all_email_admin(){
        $.post(base_url + 'email/count_all_email_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            if( $page > $total_page ){
                $page = $total_page;
            }
            ($page == 0) ? $page = 1 : $page;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_email_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    }   

     //-----------------ADD mang xa hoi---------------
    function reset_form_add_edit(){
        validator.resetForm();
        $('#protocol').focus(); 
        $('#EmailID').val('');
        $('#protocol').val(''); 
        $('#smtp_host').val(''); 
        $('#smtp_port').val(''); 
        $('#smtp_user').val(''); 
        $('#smtp_pass').val(''); 
        $('html,body').animate({'scrollTop': 0},200);
        load_ajax_out('.form_add_edit');
    }
    $('.reset_form_add_edit').click(function(){
        reset_form_add_edit();
    })

    $('body').on('click','.add_email',function (){
        $('.form_add_edit').removeClass('form_edit');
        $('.form_add_edit').addClass('form_add');
        $('.form_add_edit').removeAttr('EmailID');
        $('.close_add_edit').show();
        reset_form_add_edit();
    })   

    function add_email(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'email/insert_email',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    reset_form_add_edit();
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Thêm thành công!'); 
                    reset_pagination_all_email_admin();  
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        )
        return false;
    }
    // ---------------EDIT email---------------
    $('body').on('click','.edit_email',function(){
        EmailID = $(this).attr('EmailID'); 
        validator.resetForm();
        $.post(base_url + 'email/get_chitiet_email_admin',({"EmailID":EmailID})).done(
            function(data){
                kq = JSON.parse(data);   
                $('#EmailID').val(kq['EmailID']); 
                $('#protocol').val(kq['protocol']); 
                $('#smtp_host').val(kq['smtp_host']); 
                $('#smtp_port').val(kq['smtp_port']); 
                $('#smtp_user').val(kq['smtp_user']); 
                $('#smtp_pass').val(kq['smtp_pass']); 

                $('.form_add_edit').removeClass('form_add');
                $('.form_add_edit').addClass('form_edit');
                $('.form_add_edit').attr('EmailID',kq['EmailID']);
                $('.close_add_edit').hide();
                $('html,body').animate({'scrollTop': 0},200);
                load_ajax_out('.form_add_edit');
            })
    })

    function edit_email(){ 
        $('.ok_add_edit').button('loading');
        $.post(base_url+'email/edit_email',$(".form_add_edit").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){ 
                    $page = parseInt($('.pagination_item .selected').html());
                    message(1,'Chỉnh sửa thành công!');
                    reset_pagination_all_email_admin();      
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
                add_email();         
            else if($(".form_add_edit").hasClass('form_edit'))
                edit_email();
        }
    }); 

})