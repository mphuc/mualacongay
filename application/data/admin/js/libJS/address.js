$(document).ready(function(){   

    $('#ok_update_address').click(function(){
        var $btn = $(this).button('loading');
        load_ajax_in('.inner_table_content_right');
        $('#cancel_update_address').attr('disabled','disabled');
        $.post(base_url+'data/update_address',{}).done(
            function(data){
                load_ajax_out('.inner_table_content_right');
                $('#cancel_update_address').removeAttr('disabled');
                $.fancybox.close();
                $btn.button('reset');
                message(1,'Cập nhật thành công!');
                get_address_admin();
            }) 
    }) 

    // -------get quanhuyen---------------
    $('body').on('click','#address_admin .level0 .item_tinhtp .tentinhtp',function(){
        $tentinhtp = $(this);
        $ul = $(this).parents('.level0').find('.ul_level0');
        if($ul.css('display') == 'block'){
            $(this).find('.arrow').removeClass('rotate');
            $ul.stop().slideUp();
        } else{
            $(this).find('.arrow').addClass('rotate');
            $ul.stop().slideToggle();
           
            if(!$(this).hasClass('active')){
                $ul.html($('.wrapper_load_window_phone').html());
                TinhTPID = $(this).attr('TinhTPID');
                $.post(base_url + 'address/get_address_quanhuyen_admin',({'TinhTPID':TinhTPID})).done(
                    function(data){
                        $ul.html(data);  
                        $tentinhtp.addClass('active');
                })
            }
        }
    })    

    // ---------------tinh tp------------------
    $('body').on('click','.edit_tinhtp',function(){
        $ul = $(this).parents('.level0'); 
        $ul.find('.giaship').removeAttr('readonly').focus(); 
        $(this).removeClass('edit_tinhtp btn-primary').addClass('save_tinhtp btn-success').html('<i class="fa fa-save"></i>').attr('data-original-title','Lưu');
    }) 
    $('body').on('click','.save_tinhtp',function(){
        $save_tinhtp = $(this);
        $ul = $(this).parents('.level0');
        $btn = $(this).button('loading'); 
        GiaShip = $ul.find('.giaship').val().replace(/\D/g,'');
        TinhTPID = $(this).attr('TinhTPID');
        $.post(base_url + 'address/update_tinhtp',({'GiaShip':GiaShip,'TinhTPID':TinhTPID})).done(
            function(data){
                if(data == 1){  
                    $btn.button('reset');
                    message(1,'Chỉnh sửa thành công!'); 
                    $ul.find('.giaship').attr('readonly','readonly');
                    setTimeout(function(){ 
                        $save_tinhtp.addClass('edit_tinhtp btn-primary').removeClass('save_tinhtp btn-success').html('<i class="fa fa-pencil"></i>').attr('data-original-title','Chỉnh sửa');
                        $ul.find('.save_tinhtp').tooltip('hide'); 
                    },200)
                }else{ 
                    message(2,'Có lỗi xảy ra!');
                } 
        })
    })

    $('body').on('click','.ok_delete_tinhtp',function(){
        $ul = $(this).parents('.level0');
        $btn = $(this).button('loading');
        TinhTPID = $(this).attr('TinhTPID');
        $.post(base_url + 'address/delete_tinhtp',({'TinhTPID':TinhTPID})).done(
            function(data){
                if(data == 1){   
                    $ul.remove();
                    message(1,'Xóa thành công!'); 
                }else{ 
                    message(2,'Có lỗi xảy ra!');
                }  
        })
    })
    // --------------get xaphuong------------------
    $('body').on('click','#address_admin .level1 .tenquanhuyen',function(){
        $tenquanhuyen = $(this);
        $ul = $(this).parents('.level1').find('.ul_level1');
        if($ul.css('display') == 'block'){
            $(this).find('.arrow').removeClass('rotate');
            $ul.stop().slideUp();
        } else{
            $(this).find('.arrow').addClass('rotate');
            $ul.stop().slideToggle();

            if(!$(this).hasClass('active')){
                $ul.html($('.wrapper_load_window_phone').html());
                QuanHuyenID = $(this).attr('QuanHuyenID');
                $.post(base_url + 'address/get_address_xaphuong_admin',({'QuanHuyenID':QuanHuyenID})).done(
                    function(data){
                        $ul.html(data);  
                        $tenquanhuyen.addClass('active');
                })
            }
        }
    })
  
    function get_address_tinhtp_admin(){   
        load_ajax_in('.inner_table_content_right');
        $.post(base_url + 'address/get_address_tinhtp_admin',({})).done(
            function(data){
                $('#address_admin').html(data);  
                load_ajax_out('.inner_table_content_right');
                $('[data-toggle="tooltip"]').tooltip();
                $('.priceFormat').priceFormat({
                    prefix: '', 
                    thousandsSeparator: '.',
                    centsLimit: 0, 
                });
        })
    } 
    get_address_tinhtp_admin();


})