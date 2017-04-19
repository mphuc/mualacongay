$(document).ready(function(){    
    //------xóa nhiều binh luan-------------
    $('body').on('click','.ok_del_lienhe',function(){
        $ok_del_lienhe = $(this);
        $btn_this = $(this);
        $btn = $(this).button('loading');
        LienHeID = $(this).attr('LienHeID');
        $.post(base_url+'lienhe/delete_lienhe',{"LienHeID":LienHeID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){   
                    reset_pagination_all_lienhe_admin();  
                    message(1,'Xóa thành công!');
                }else{
                    message(2,'Xóa không thành công!');
                }
            });
    })

    $('#btn_del_more_baiviet').click(function(){
        $arr_LienHeID = count_check_lienhe();
        if( $arr_LienHeID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_lienhe',function(){ 
        $btn = $(this).button('loading');
        $arr_LienHeID = count_check_lienhe();
        $.post(base_url+'lienhe/delete_more_lienhe',{"arr_LienHeID":$arr_LienHeID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false); 
                    reset_pagination_all_lienhe_admin();  
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click();
            });
    })  

    //-----đếm số lượng item được check----------
    function count_check_lienhe(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $lienheID = $(this).attr('LienHeID');
                $count_check.push($lienheID); 
            }
        })
        return $count_check;
    }  
 
     // -----------Phân trang sản phẩm-------------- 
    function init_lienhe_admin(){
        $.post(base_url + 'lienhe/count_all_lienhe_admin').done(function(data){
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
                    get_lienhe_admin(num);
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
                    get_lienhe_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_lienhe_admin(1);
        })
    }
    init_lienhe_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){ 
        $.post(base_url + 'lienhe/count_all_lienhe_admin').done(function(data){
            $number = parseInt($('.selector_limit_item').val());   
            $total_page = Math.ceil(data/$number); 
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
            get_lienhe_admin(1);
            $to = ($number > $result.count) ? $result.count:$number;
            info_page_item(1,$to,data); 
        }) 
    }) 
    function get_lienhe_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'lienhe/get_lienhe_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#lienhe_admin tbody').html($result.list_lienhe); 
            $('[data-toggle="tooltip"]').tooltip(); 

            if ($result.list_lienhe == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count); 
        })
    }
    function reset_pagination_all_lienhe_admin(){
        $.post(base_url + 'lienhe/count_all_lienhe_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_lienhe_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 
    
    // -----------------send email---------------
    $('body').on('click','.send_mail_lienhe',function(){
        Email = $(this).attr('Email'); 
        Ten = $(this).attr('Ten'); 
        $('#to_mail').val(Ten + ' - ' + Email);
        $('.form_add_edit').attr('Email',Email);
        tinyMCE.editors['message'].setContent('');
        $('#subject').val('');

        load_ajax_out('.form_add_edit');
    })
    function send_mail(){ 
        $btn = $('.ok_send_mail').button('loading'); 
        email = $('.form_add_edit').attr('Email');
        subject = $('#subject').val();
        message_email = tinyMCE.editors['message'].getContent();  
        load_ajax_in('.content_send_mail');
        $('.toggle_form_add_edit').attr('disabled','disabled');
        
        $.post(base_url+'lienhe/traloi_lienhe_email',{"subject":subject,"message":message_email,"email":email}).done(
            function(data){
                $btn.button('reset');
                load_ajax_out('.content_send_mail');
                $('.toggle_form_add_edit').removeAttr('disabled');
                if( data == 1 ){  
                    $('#subject').val('');
                    tinyMCE.editors['message'].setContent('');
                    reset_pagination_all_lienhe_admin();
                    toggle_form_add_edit();
                    message(1,'Gửi thành công!'); 
                }else if( data == -2 ){
                    message(3,'Cấu hình tài khoản email <br> trước khi tiến hành gửi mail! <br> <a href="'+base_url+'admin/email">Tài khoản email</a>');
                }else{
                    message(2,'Gửi không thành công!');
                }
            });
        return false;
    }

    function validate_tinymce(){
        message_email = tinyMCE.editors['message'].getContent();  
        result = 1;
        $(".form_add_edit p.error").remove();
        if(strip_tags(message_email) == ''){
            $('<p class="error">Nhập nội dung email.</p>').insertAfter('#message');
            result = 0;
        }else{
            $('#message').next('.error').remove();
        }  
        return result;
    }

    $(".form_add_edit").submit(function(){
        validate_tinymce();
    })

    validator = $(".form_add_edit").validate({
        submitHandler: function(form) {
            if(validate_tinymce()){
                send_mail();
            }
        }
    });  

    // ----------change email default---------------- 
    $('body').on('change','.list_email input[type="radio"]',function(event) {
        $('#ok_update_email').removeAttr('disabled');
    });

    $('body').on('click','#ok_update_email',function(){
        $('#ok_update_email').button('loading');
        EmailID = $('.list_email input[type="radio"]:checked').val();
        smtp_user = $('.list_email input[type="radio"]:checked').parents('tr').find('.smtp_user').html();
        $.post(base_url + 'email/update_default_email',{'EmailID':EmailID}).done(
            function(data){
                $('#from_email').val(smtp_user);
                $('#ok_update_email').button('reset');
                if( data == 1) {
                    $.fancybox.close(); 
                    message(1,'Cập nhật thành công!');
                }else{ 
                    message(2,'Cập nhật không thành công!');
                } 
            })
    })


})