$(document).ready(function(){ 

    $('#ok_connect').click(function(){ 
        if( !$('#ok_connect').hasClass('active') ){
            $('#ok_connect').button('loading'); 
            $('.load_connect').html($('.wrapper_load_window_phone').html());
            $('#cancel_connect').hide();
            $('.title_sync').html('<p class="pull-left">Đang đồng bộ </p> <div class="load_title">' + $('.wrapper_load_window_phone').html() + '</div>');

            $.post(base_url+'data/sync_to_server',{}).done(
            function(data){ 
                $('#ok_connect').button('reset');
                result = JSON.parse(data);
                if(typeof(result) == 'object'){  
                    $('#ok_connect').addClass('active');
                    if(result.check_hoadon && result.check_member){
                        t = '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> hoàn thành</p>'+
                            '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> hoàn thành</p>';
                            message(1,'Đồng bộ hoàn thành');  
                    }else if(!result.check_member && !result.check_hoadon){
                        t = '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> chưa hoàn thành</p>'+
                            '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> chưa hoàn thành</p>';
                            message(2,'Đồng bộ lỗi');  
                    }else if(!result.echeck_hoadon){
                        t = '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> hoàn thành</p>'+
                            '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> chưa hoàn thành</p>';
                            message(2,'Đồng bộ chưa hoàn thành');  
                    }else if(!result.check_member){
                        t = '<p class="bg_red notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>thành viên</b> chưa hoàn thành</p>'+
                            '<p class="bg_green notice_syn"><i class="fa fa-check"></i> Đồng bộ <b>hóa đơn</b> hoàn thành</p>';
                            message(2,'Đồng bộ chưa hoàn thành');  
                    }
                    $('.title_sync').html(t);
                    $('.load_member').html(result.update_Member + ' thành viên mới');
                    $('.load_hoadononline').html(result.update_HoaDonOnline + ' hóa đơn mới');
                    $('.content_disconnect').show(); 
                } 
            })  
        }else{
            $.fancybox.close(); 
            $('.title_sync').html('Đồng bộ dữ liệu với máy chủ, bao gồm:');
            $('.load_member').html('');
            $('.load_hoadononline').html('');
            $('#cancel_connect').show();
            $('#ok_connect').removeClass('active');
        }
    })

    $('#cancel_connect').click(function(){
        $('.title_sync').html('Đồng bộ dữ liệu với máy chủ, bao gồm:');
        $('.load_member').html('');
        $('.load_hoadononline').html('');
        $('.content_disconnect').show();
        $('#ok_connect').button('reset');
    })

})