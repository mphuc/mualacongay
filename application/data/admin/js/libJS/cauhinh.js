$(document).ready(function(){ 

    function edit_cauhinh(){
        $('.ok_add_edit').button('loading'); 

        $.post(base_url+'cauhinh/edit_cauhinh',$("#form_cauhinh").serialize()).done(
            function(data){
                $('.ok_add_edit').button('reset');
                if(data == 1){  
                    message(1,'Chỉnh sửa thành công!'); 
                }else{
                    $('html,body').animate({'scrollTop': 0},200);
                    message(2,'Có lỗi xảy ra!');
                }
            }
        ) 
        return false;
    }  

    validator = $(".form_add_edit").validate({
        submitHandler: function(form) { 
            edit_cauhinh();
        }
    });  

    $('#test_ftp_server').click(function(){
        $('#test_ftp_server').button('loading'); 

        $.post(base_url+'cauhinh/test_ftp_server',{}).done(
            function(data){
                $('#test_ftp_server').button('reset');
                if(data == 1){  
                    message(1,'Kết nối Fpt Server thành công!'); 
                }else{ 
                    message(2,'Kết nối Fpt Server không thành công!');
                }
            }
        ) 
    })    

    $('#test_web_server').click(function(){
        $('#test_web_server').button('loading'); 

        $.post(base_url+'cauhinh/test_webservice',{}).done(
            function(data){
                $('#test_web_server').button('reset');
                if(data == 1){  
                    message(1,'Kết nối Web Server thành công!'); 
                }else{ 
                    message(2,'Kết nối Web Server không thành công!');
                }
            }
        ) 
    })

    $('#show_pass').mousedown(function(){ 
        $('#form_cauhinh #password_ftp').attr('type','text');
    })    
    $('#show_pass').mouseup(function(){ 
        $('#form_cauhinh #password_ftp').attr('type','password');
    })

    $('#show_pass_server').mousedown(function(){ 
        $('#form_cauhinh #password_server').attr('type','text');
    })    
    $('#show_pass_server').mouseup(function(){ 
        $('#form_cauhinh #password_server').attr('type','password');
    })

    $('#show_pass_webservice').mousedown(function(){ 
        $('#form_cauhinh #password_webservice').attr('type','text');
    })    
    $('#show_pass_webservice').mouseup(function(){ 
        $('#form_cauhinh #password_webservice').attr('type','password');
    })
    // --------------------CONNECT SERVER----------------
    $('.disconnect').click(function(){
        if( !$(this).hasClass('active') ){
             $('<a class="fancybox" href="#confim_disconnect"></a>').fancybox({ 
                openEffect  : 'none',
                closeEffect : 'none',
                height: '95%', 
                helpers : { 
                    overlay : {closeClick: false}
                },
                closeBtn    :false,
                beforeShow: function() { 
                },
                keys : { 
                    close  : null
                }
            }).click();
        }
    })
    $('#ok_disconnect').click(function(){
        CauHinhID = $('#CauHinhID').val();  
        $('#ok_disconnect').button('loading');
        $('#cancel_disconnect').hide();
        $('.title_sync_host').html('<p class="pull-left">Đang kết nối đến hosting</p> <div class="load_title">' + $('.wrapper_load_window_phone').html() + '</div>');

        $.post(base_url+'cauhinh/change_connect_server',{"connect_server":0 ,"CauHinhID":CauHinhID}).done(
        function(data){ 
            $('#ok_disconnect').button('reset');
            $.fancybox.close();
            result = JSON.parse(data);
            if(typeof result == 'object'){  
                $('.ngayupdate').html(result.now);
                message(1,'Đã kết nối đến hoting'); 
                $('#cancel_disconnect').show();
                $('.title_sync_host').html('Tất các các dữ liệu sau sẽ được lưu trữ trên hosting:');

                $('.connect').removeClass('active');
                $('.disconnect').addClass('active');
            }else{ 
                $('.title_sync').html('Kết nối không thành công!'); 
                $('.load_member').html('');
                $('.load_hoadononline').html('');
                message(2,'Kết nối không thành công!');
            }
        })  
    })
    $('#cancel_disconnect').click(function(){
        $('#ok_disconnect').button('reset');
    })

    $('.connect').click(function(){
        if( !$('.connect').hasClass('active') ){
            $('<a class="fancybox" href="#confim_connect"></a>').fancybox({ 
                openEffect  : 'none',
                closeEffect : 'none',
                height: '95%', 
                helpers : { 
                    overlay : {closeClick: false}
                },
                closeBtn    :false,
                beforeShow: function() { 
                },
                keys : { 
                    close  : null
                }
            }).click();
        }
    })
    $('#ok_connect').click(function(){
        if( !$('.connect').hasClass('active') ){
            $('#ok_connect').button('loading');
            $('#cancel_connect').hide();
            $('.title_sync').html('<p class="pull-left">Đang kết nối đến máy chủ</p> <div class="load_title">' + $('.wrapper_load_window_phone').html() + '</div>');
            $('.load_connect').html($('.wrapper_load_window_phone').html());
            $('.content_disconnect').hide();

            CauHinhID = $('#CauHinhID').val();  
            $.post(base_url+'cauhinh/change_connect_server',{"connect_server":1 ,"CauHinhID":CauHinhID}).done(
            function(data){ 
                result = JSON.parse(data);
                if(typeof result == 'object'){  
                    $('.ngayupdate').html(result.now);
                    $('.title_sync').html('Đang đồng bộ dữ liệu...');
                    $('.content_disconnect').show();
                    message(1,'Đã kết nối đến máy chủ'); 
                    $('.connect').addClass('active');
                    $('.disconnect').removeClass('active');

                    $.post(base_url+'data/sync_to_server',{}).done(
                    function(data){ 
                        $('#ok_connect').button('reset');
                        result = JSON.parse(data);
                        if(typeof(result) == 'object'){  
                            if(result.check_hoadon && result.check_member){
                                t = '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đã kết nối đến máy chủ</p>'+
                                    '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> hoàn thành</p>'+
                                    '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> hoàn thành</p>';
                                    message(1,'Đồng bộ hoàn thành');  
                            }else if(!result.check_member && !result.check_hoadon){
                                t = '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đã kết nối đến máy chủ</p>'+
                                    '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> chưa hoàn thành</p>'+
                                    '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> chưa hoàn thành</p>';
                                    message(2,'Đồng bộ lỗi');  
                            }else if(!result.echeck_hoadon){
                                t = '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đã kết nối đến máy chủ</p>'+
                                    '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> hoàn thành</p>'+
                                    '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> chưa hoàn thành</p>';
                                    message(2,'Đồng bộ chưa hoàn thành');  
                            }else if(!result.check_member){
                                t = '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đã kết nối đến máy chủ</p>'+
                                    '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> chưa hoàn thành</p>'+
                                    '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> hoàn thành</p>';
                                    message(2,'Đồng bộ chưa hoàn thành');  
                            }
                             $('.title_sync').html(t);
                            $('.load_member').html(result.update_Member + ' thành viên mới');
                            $('.load_hoadononline').html(result.update_HoaDonOnline + ' hóa đơn mới');
                            $('.content_disconnect').show();
                            $('#cancel_connect').hide();
                        }else{
                            $('#cancel_connect').hide();
                            $('.title_sync').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đã kết nối đến máy chủ</p><p class="bg_red notice_syn"><i class="fa fa-times"></i> Đồng bộ lỗi!</p>');
                            $('.content_disconnect').hide();
                            message(2,'Đồng bộ lỗi'); 
                        }
                    }) 
                }else if(result == -2){
                    $('.title_sync').html('<p class="bg_red notice_syn"><i class="fa fa-times"></i> Lỗi đăng nhập Tài khoản server!</p>');
                    $('.load_member').html('');
                    $('.load_hoadononline').html('');
                    $('.content_disconnect').hide();
                    $('#ok_connect').button('reset');
                    $('#cancel_connect').show();
                    message(2,'Lỗi đăng nhập Tài khoản server!'); 
                }else{
                    $('.title_sync').html('<p class="bg_red notice_syn"><i class="fa fa-times"></i> Không thể kết nối đến máy chủ!</p>');
                    $('.load_member').html('');
                    $('.load_hoadononline').html('');
                    $('.content_disconnect').hide();
                    $('#ok_connect').button('reset');
                    $('#cancel_connect').show();
                    message(2,'Không thể kết nối đến máy chủ!'); 
                }
            })   

        }else{
            $.fancybox.close();
            $('.title_sync').html('Việc kết nối sẽ đồng bộ dữ liệu với máy chủ, bao gồm:');
            $('.load_connect').html('');
            $('.content_disconnect').show();
            $('#cancel_connect').show();
        }
    })
    $('#cancel_connect').click(function(){
        $('.title_sync').html('Việc kết nối sẽ đồng bộ dữ liệu với máy chủ, bao gồm:');
        $('.content_disconnect').show();
        $('#ok_connect').button('reset');
    })
    

})