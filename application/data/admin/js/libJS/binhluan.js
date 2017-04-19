$(document).ready(function(){   
    $('body').on('change','.checkbox_item',function(){
        $tr = $(this).parents('tr');
        if( $(this).is(':checked') ){ 
            while($tr.next('tr.item_traloi_binhluan').length > 0){
                $tr = $tr.next('tr.item_traloi_binhluan')
                $tr.addClass('bg_check'); 
            }
        }else{
            while($tr.next('tr.item_traloi_binhluan').length > 0){
                $tr = $tr.next('tr.item_traloi_binhluan')
                $tr.removeClass('bg_check'); 
            }
        }
    })
    //------xóa nhiều binh luan-------------
    $('#btn_del_more_baiviet').click(function(){
        $arr_binhluanID = count_check_binhluan();
        if( $arr_binhluanID == '' ){
            $('.btn_del_more').addClass('disabled');
        }else{ 
        }
    })
    $('body').on('click','.ok_del_more_binhluan',function(){ 
        $btn = $(this).button('loading');
        $arr_BinhLuanID = count_check_binhluan();
        $.post(base_url+'binhluan/delete_more_binhluan',{"arr_BinhLuanID":$arr_BinhLuanID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    message(1,'Xóa thành công!');
                    $('#checkbox_all').attr('checked',false);
                    // if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_binhluan_admin(); 
                    // else
                        // reset_pagination_search_binhluan_admin();
                }else{
                    message(2,'Xóa không thành công!');
                }
                $('.dropdown_close').click();
            });
    })  

    //-----đếm số lượng item được check----------
    function count_check_binhluan(){
        $count_check  = [];
        $arr = $('.table_content_right tbody .checkbox_item');
        $.each($arr,function(i){
            if($(this).is(':checked')){
                $binhluanID = $(this).attr('BinhLuanID');
                $count_check.push($binhluanID); 
            }
        })
        return $count_check;
    } 
    //------------change hiện thị binh luan---------
    $('body').on('change','#binhluan_admin .check_hienthi',function(){
        $HienThi = 0;
        $BinhLuanID = $(this).attr('BinhLuanID');
        if( $(this).is(':checked') ){
            $HienThi = 1;
        }else{
            $HienThi = 0;
        } 
        $.post(base_url + 'binhluan/update_hienthi_binhluan',({"HienThi":$HienThi,"BinhLuanID":$BinhLuanID})).done(function(data){
            if(data == 1){
                message(1,'Cập nhật thành công!');
            }else{
                message(2,'Cập nhật không thành công!');
            }
        })
    })

    $('body').on('change','#binhluan_admin .check_hienthi_2',function(){
        $HienThi = 0;
        $TraLoi_BinhLuanID = $(this).attr('TraLoi_BinhLuanID');
        if( $(this).is(':checked') ){
            $HienThi = 1;
        }else{
            $HienThi = 0;
        } 
        $.post(base_url + 'binhluan/update_hienthi_traloi_binhluan',({"HienThi":$HienThi,"TraLoi_BinhLuanID":$TraLoi_BinhLuanID})).done(function(data){
            if(data == 1){
                message(1,'Cập nhật thành công!');
            }else{
                message(2,'Cập nhật không thành công!');
            }
        })
    })

     // -----------Phân trang sản phẩm-------------- 
    function init_binhluan_admin(){
        $.post(base_url + 'binhluan/count_all_binhluan_admin').done(function(data){
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
                    // if( trim($('#input_search').val()) != '' )
                        // search_binhluan_admin(num);  
                    // else
                        get_binhluan_admin(num);
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
                    // if( trim($('#input_search').val()) != '' )
                        search_binhluan_admin(num);  
                    // else
                        // get_binhluan_admin(num);
                    $(".pagination_sp1").trigger("reset",{ selectedPage:num }); 
                }
            }); 
            get_binhluan_admin(1);
        })
    }
    init_binhluan_admin(); //----khởi tạo---
    $('.selector_limit_item').change(function(){
        // $key = trim($('#input_search').val());  
        // if($key != ''){
            // reset_pagination_search_binhluan_admin();  
        // }else{  
            $.post(base_url + 'binhluan/count_all_binhluan_admin').done(function(data){
                $number = parseInt($('.selector_limit_item').val());   
                $total_page = Math.ceil(data/$number); 
                $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:1 });  
                get_binhluan_admin(1);
                $to = ($number > $result.count) ? $result.count:$number;
                info_page_item(1,$to,data); 
            })
        // }
    }) 
    function get_binhluan_admin($page){  
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0,$page=1;  
        $.post(base_url + 'binhluan/get_binhluan_admin',({'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#binhluan_admin tbody').html($result.list_sp); 
            $(".tablesorter").trigger('update');    
            $('[data-toggle="tooltip"]').tooltip();
            $('#binhluan_admin textarea').textareaAutoSize();

            if ($result.list_sp == '')
                $from = 0;
            else
                ($offset == 1)?$from = $offset:$from = $offset+1;
            $to = $offset+$number;
            $to = ($result.count > $to)?$to:$result.count; 
            info_page_item($from,$to,$result.count); 
        })
    }
    function reset_pagination_all_binhluan_admin(){
        $.post(base_url + 'binhluan/count_all_binhluan_admin').done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = $('.pagination_item .selected').html();
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            get_binhluan_admin($page);  
        })
    } 
    function info_page_item($from,$to,$total){  
        $('.from_record').html($from);
        $('.to_record').html($to);
        $('.total_record').html($total);
    } 
 
    // ------SEARCH SẢN PHẨM--------- 
    $('.form_search').on('submit',function(e){
        load_get_data();

        e.preventDefault();
        $key = trim($('#input_search').val()); 
        if($key == ''){
            reset_pagination_all_binhluan_admin();
            $('#input_search').removeClass('bg_search');
        }else{ 
            $('#input_search').addClass('bg_search');
            $number = parseInt($('.selector_limit_item').val());  
            $.post(base_url + 'binhluan/search_binhluan_admin',({'key':$key,'number':$number,'offset':0})).done(function(data){
                $result = JSON.parse(data);
                $('#binhluan_admin tbody').html($result.list_search);
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
    function search_binhluan_admin($page){ 
        load_get_data();

        $number = parseInt($('.selector_limit_item').val());   
        $key = $('#input_search').val(); 
        ($page != 1) ? $offset = ($page-1)*$number : $offset = 0;
        ($page == 0) ? $offset = 0 : $offset = $offset;
        $.post(base_url + 'binhluan/search_binhluan_admin',({'key':$key,'number':$number,'offset':$offset})).done(function(data){
            $result = JSON.parse(data);
            $('#binhluan_admin tbody').html($result.list_search);
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
    function reset_pagination_search_binhluan_admin(){
        $key = $('#input_search').val();
        $.post(base_url + 'binhluan/count_search_binhluan_admin',({'key':$key})).done(function(data){
            $number = $('.selector_limit_item').val();   
            $total_page = Math.ceil(data/$number); 
            $page = 1;
            $(".pagination_sp1").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page });  
            $(".pagination_sp2").trigger("reset",{ nbPages:$total_page,nbVisible:8,minSlidesForSlider:2,selectedPage:$page }); 
            search_binhluan_admin($page);  
        })
    }  

    $('.clear_search').click(function(){
        $('#input_search').val(''); 
        reset_pagination_all_binhluan_admin();
        $('#input_search').removeClass('bg_search');
    })  
   
    // ---------------EDIT BINH LUAN main--------------
    $('body').on('click','.edit_binhluan',function(){
        // autosize($('#binhluan_admin textarea') );

        $(document)
        .one('focus.textarea', 'textarea', function(){
            var savedValue = this.value;
            this.value = '';
            this.baseScrollHeight = this.scrollHeight;
            this.value = savedValue;
        })
        .on('input.textarea', '.textarea', function(){
            var minRows = this.getAttribute('data-min-rows')|0,
                 rows;
            this.rows = minRows;
        console.log(this.scrollHeight , this.baseScrollHeight);
            rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 17);
            this.rows = minRows + rows;
        });

        $tr = $(this).parents('tr');
        $tr.find('.noidung_binhluan').removeAttr('disabled').focus(); 
        $(this).removeClass('edit_binhluan btn-primary').addClass('save_binhluan btn-success').html('<i class="fa fa-save"></i>').attr('data-original-title','Lưu');
    })
    $('body').on('click','.save_binhluan',function(){
        $save_binhluan = $(this);
        $noidung_binhluan = $(this).parents('tr').find('.noidung_binhluan'); 
        NoiDung = $noidung_binhluan.val();

        if(NoiDung.trim() != ''){
            BinhLuanID = $(this).attr('BinhLuanID');
            $.post(base_url+'binhluan/edit_binhluan',{"BinhLuanID":BinhLuanID,"NoiDung":NoiDung}).done(
                function(data){ 
                    if(data == 1){  
                        $noidung_binhluan.attr('disabled','disabled');
                        $save_binhluan.addClass('edit_binhluan btn-primary').removeClass('save_binhluan btn-success').html('<i class="fa fa-pencil"></i>').attr('data-original-title','Chỉnh sửa');
                        message(1,'Chỉnh sửa thành công!'); 
                    }else{ 
                        message(2,'Có lỗi xảy ra!');
                    }
                }
            ) 
        }else{
            $noidung_binhluan.focus();
            message(2,'Nội dung không được để trống!');
        }
    }) 

// ---------------EDIT BINH LUAN sub--------------
    $('body').on('click','.edit_traloi_binhluan',function(){
        $tr = $(this).parents('tr');
        $tr.find('.noidung_traloi_binhluan').removeAttr('disabled').focus(); 
        $(this).removeClass('edit_traloi_binhluan btn-primary').addClass('save_traloi_binhluan btn-success').html('<i class="fa fa-save"></i>').attr('data-original-title','Lưu');
    })
    $('body').on('click','.save_traloi_binhluan',function(){
        $save_traloi_binhluan = $(this);
        $noidung_traloi_binhluan = $(this).parents('tr').find('.noidung_traloi_binhluan'); 
        NoiDung = $noidung_traloi_binhluan.val();

        if(NoiDung.trim() != ''){
            TraLoi_BinhLuanID = $(this).attr('TraLoi_BinhLuanID');
            $.post(base_url+'binhluan/edit_traloi_binhluan',{"TraLoi_BinhLuanID":TraLoi_BinhLuanID,"NoiDung":NoiDung}).done(
                function(data){ 
                    if(data == 1){  
                        $noidung_traloi_binhluan.attr('disabled','disabled');
                        $save_traloi_binhluan.addClass('edit_traloi_binhluan btn-primary').removeClass('save_traloi_binhluan btn-success').html('<i class="fa fa-pencil"></i>').attr('data-original-title','Chỉnh sửa');
                        message(1,'Chỉnh sửa thành công!'); 
                    }else{ 
                        message(2,'Có lỗi xảy ra!');
                    }
                }
            ) 
        }else{
            $noidung_traloi_binhluan.focus();
            message(2,'Nội dung không được để trống!');
        }
    }) 

    // -----------------------DEL BINH LUAN-------------------
    $('body').on('click','.ok_del_binhluan',function(){
        $btn_this = $(this);
        $btn = $(this).button('loading');
        BinhLuanID = $(this).attr('BinhLuanID');
        $.post(base_url+'binhluan/delete_binhluan',{"BinhLuanID":BinhLuanID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){  
                    // if( trim($('#input_search').val()) == '' )
                        reset_pagination_all_binhluan_admin(); 
                    // else
                        // reset_pagination_search_binhluan_admin();
                    message(1,'Xóa thành công!');
                }else{
                    message(2,'Xóa không thành công!');
                }
            });
    })

    $('body').on('click','.ok_del_traloi_binhluan',function(){
        $btn_this = $(this);
        $btn = $(this).button('loading');
        TraLoi_BinhLuanID = $(this).attr('TraLoi_BinhLuanID');
        $.post(base_url+'binhluan/delete_traloi_binhluan',{"TraLoi_BinhLuanID":TraLoi_BinhLuanID}).done(
            function(data){
                $btn.button('reset');
                if( data == 1 ){ 
                    $btn_this.parents('tr').remove();
                    message(1,'Xóa thành công!'); 
                }else{
                    message(2,'Xóa không thành công!');
                }
            });
    })    

    // -----------------send email---------------
    $('body').on('click','.send_mail_binhluan',function(){
        BinhLuanID = $(this).attr('BinhLuanID');
        $tr = $(this).parents('tr');
        email = $tr.find('.email').html();
        $('#to_mail').val(email);
        $('.form_add_edit').attr('email',email).attr('BinhLuanID',BinhLuanID);
        tinyMCE.editors['message'].setContent('');
        $('#subject').val('');
        
        load_ajax_out('.form_add_edit');
    })
    function send_mail(){ 
        $btn = $('.ok_send_mail').button('loading');
        BinhLuanID = $('.form_add_edit').attr('BinhLuanID');
        email = $('.form_add_edit').attr('email');
        subject = $('#subject').val();
        message_email = tinyMCE.editors['message'].getContent();  
        load_ajax_in('.content_send_mail');
        $('.toggle_form_add_edit').attr('disabled','disabled');
        
        $.post(base_url+'binhluan/traloi_binhluan_email',{"subject":subject,"message":message_email,"email":email,"BinhLuanID":BinhLuanID}).done(
            function(data){
                $btn.button('reset');
                load_ajax_out('.content_send_mail');
                $('.toggle_form_add_edit').removeAttr('disabled');
                if( data == 1 ){  
                    $('#subject').val('');
                    tinyMCE.editors['message'].setContent('');
                    reset_pagination_all_binhluan_admin();
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