$(document).ready(function(){   
    // ------------------------------------
    $('#load_website').click(function(){
        $(this).addClass('btn-success active').removeClass('btn-default');
        $('#load_server').removeClass('btn-success active').addClass('btn-default');
        $('.load_from').html('<i class="fa fa-cloud"></i>');
        load_danhmuc(); 
    })    

    $('#load_server').click(function(){
        $(this).addClass('btn-success active').removeClass('btn-default');
        $('#load_website').removeClass('btn-success active').addClass('btn-default');
        $('.load_from').html('<i class="fa fa-server"></i>');
        load_danhmuc();
    })
    // ------------------------------------

    function load_get_data_2($element){
        $($element).html('<tr><td colspan=20 class="text_center">'+ $('.wrapper_load_window_phone').html() +'</td></tr>');  
    }

    // ---------------load danh mục---------------------
    function load_danhmuc () { 
        $('#load_server').hasClass('active')? server = 1 : server = 0;
        load_get_data_2('.list_danhmuc tbody'); 
        $.post(base_url+'capnhat/load_danhmuc',{"server":server}).done(
            function(data){
                result = JSON.parse(data);
                $('.list_danhmuc tbody').html(result.list);
                $('[data-toggle="tooltip"]').tooltip();  
                $('.list_danhmuc tbody tr:first-child .radio_danhmuc').prop("checked", true);
                $('.count_danhmuc').html(result.count);
                load_loaisanpham();
            }) 
    }
    load_danhmuc();

    // ----------------------load_loaisanpham---------------
    function load_loaisanpham () {
        $('#load_server').hasClass('active')? server = 1 : server = 0;
        if($('.radio_danhmuc').is(':checked')){
            load_get_data_2('.list_loaisanpham tbody');
            DanhMucID = $('.radio_danhmuc:checked').val();
            $.post(base_url+'capnhat/load_loaisanpham',{"DanhMucID":DanhMucID, "server":server}).done(
                function(data){
                    result = JSON.parse(data);
                    $('.list_loaisanpham tbody').html(result.list);
                    $('[data-toggle="tooltip"]').tooltip();  
                    $('.list_loaisanpham tbody tr:first-child .radio_loaisanpham').prop("checked", true);
                    $('.count_loaisanpham').html(result.count);
                    load_sanpham();
                }) 
        }else{
            $('.list_loaisanpham tbody').html('<tr><td colspan="8">Không có loại sản phẩm!</td></tr>');
            $('.count_loaisanpham').html('0');
            load_sanpham();
        }
        reload_select_loaisp();
    }
    load_loaisanpham();

    $('body').on('change','.radio_danhmuc',function(){
        load_loaisanpham();
    }) 

    function reload_select_loaisp(){
        $.post(base_url+'capnhat/get_select_loaisp',{}).done(
            function(data) {
                $('#select_update_gia_sanpham').html('<option value="0" selected>Cập nhật giá theo loại sản phẩm</option>' + data);
            })
    }

    // ---------------load sanpham --------------------
    function load_sanpham(){        
        $('#load_server').hasClass('active')? server = 1 : server = 0;

        if($('.radio_loaisanpham').is(':checked')){
            load_get_data_2('.list_sanpham tbody');
            LoaiSPID = $('.radio_loaisanpham:checked').val();
            $.post(base_url+'capnhat/load_sanpham',{"LoaiSPID":LoaiSPID, "server":server}).done(
                function(data){
                    result = JSON.parse(data);
                    $('.list_sanpham tbody').html(result.list);
                    $('[data-toggle="tooltip"]').tooltip();  
                    $('.count_sanpham').html(result.count);
                }) 
        }else{
            $('.list_sanpham tbody').html('<tr><td colspan="8">Không có sản phẩm!</td></tr>');
            $('.count_sanpham').html('0');
        }
    }
    load_sanpham();

    $('body').on('change','.radio_loaisanpham',function(){
        load_sanpham();
    }) 

    // -----------------cap nhat all--------------------
    $('#capnhat_all').click(function() {
        content_confim = $('.content_confim').html();
    })

    $('#ok_capnhat_all').click(function(event) {
        if( !$('#ok_capnhat_all').hasClass('active') ){
            $('#ok_capnhat_all').addClass('active').button('loading');
            $('#cancel_capnhat_all').hide();

            $('#confim_update .content_load').html( 'Đang cập nhật...' + $('.wrapper_load_window_phone').html() );
            $.post(base_url+'data/update_all',{}).done(
                function(data){
                    $('#ok_capnhat_all').button('reset');
                    if(data == 1 || data == 11){
                        $('#confim_update .content_load').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> Cập nhật hoàn thành</p>');
                        message(1,'Cập nhật hoàn thành');  
                        load_danhmuc();
                    }else{
                        $('#confim_update .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Cập nhật lỗi</p>');
                        message(2,'Cập nhật lỗi');  
                    }
                }) 
        }else{
            $.fancybox.close();
            $('#cancel_capnhat_all').show();
            $('#ok_capnhat_all').removeClass('active');
            $('#confim_update .content_confim').html(content_confim);
        }
    });

    // -----------------cap nhat theo DANH MUC--------------------
    $('body').on('click','.capnhat_theo_danhmuc',function() {
        content_confim_4 = $('#confim_capnhat_theo_danhmuc .content_confim').html();
        $('#ok_capnhat_theo_danhmuc').attr('DanhMucID',$(this).attr('DanhMucID'));
    })

    $('#ok_capnhat_theo_danhmuc').click(function(event) {
        if( !$('#ok_capnhat_theo_danhmuc').hasClass('active') ){
            $('#ok_capnhat_theo_danhmuc').addClass('active').button('loading');
            $('#cancel_capnhat_theo_danhmuc').hide();
            DanhMucID = $('#ok_capnhat_theo_danhmuc').attr('DanhMucID');

            // $('#load_server').hasClass('active')? loai_capnhat = 'update_1_danhmuc' : loai_capnhat = 'update_loaisanpham';

            $('#confim_capnhat_theo_danhmuc .content_load').html( 'Đang cập nhật...' + $('.wrapper_load_window_phone').html() );
            $.post(base_url+'data/update_1_danhmuc/' + DanhMucID,{'DanhMucID':DanhMucID}).done(
                function(data){
                    $('#ok_capnhat_theo_danhmuc').button('reset');
                    if(data == 1 || data == 11){
                        $('#confim_capnhat_theo_danhmuc .content_load').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> Cập nhật hoàn thành</p>');
                        message(1,'Cập nhật hoàn thành');  
                        load_danhmuc();
                    }else{
                        $('#confim_capnhat_theo_danhmuc .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Cập nhật lỗi</p>');
                        message(2,'Cập nhật lỗi');  
                    }
                }) 
        }else{
            $.fancybox.close();
            $('#cancel_capnhat_theo_danhmuc').show();
            $('#ok_capnhat_theo_danhmuc').removeClass('active');
            $('#confim_capnhat_theo_danhmuc .content_confim').html(content_confim_4);
        }
    });

    // -----------------cap nhat theo LOAI SAN PHAM--------------------
    $('body').on('click','.capnhat_theo_loaisanpham',function() {
        content_confim_2 = $('#confim_capnhat_theo_loaisanpham .content_confim').html();
        $('#ok_capnhat_theo_loaisanpham').attr('LoaiSPID',$(this).attr('LoaiSPID'));
    })

    $('#ok_capnhat_theo_loaisanpham').click(function(event) {
        if( !$('#ok_capnhat_theo_loaisanpham').hasClass('active') ){
            $('#ok_capnhat_theo_loaisanpham').addClass('active').button('loading');
            $('#cancel_capnhat_theo_loaisanpham').hide();
            LoaiSPID = $('#ok_capnhat_theo_loaisanpham').attr('LoaiSPID');

            $('#confim_capnhat_theo_loaisanpham .content_load').html( 'Đang cập nhật...' + $('.wrapper_load_window_phone').html() );
            $.post(base_url+'data/update_1_loaisanpham/' + LoaiSPID,{'LoaiSPID':LoaiSPID}).done(
                function(data){
                    $('#ok_capnhat_theo_loaisanpham').button('reset');
                    if(data == 1 || data == 11){
                        $('#confim_capnhat_theo_loaisanpham .content_load').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> Cập nhật hoàn thành</p>');
                        message(1,'Cập nhật hoàn thành');  
                        load_loaisanpham();
                    }else if(data == -1){
                        $('#confim_capnhat_theo_loaisanpham .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Danh mục của Loại sản phẩm không tồn tại</p>');
                        message(2,'Cập nhật lỗi');  
                    }else{
                        $('#confim_capnhat_theo_loaisanpham .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Cập nhật lỗi</p>');
                        message(2,'Cập nhật lỗi');  
                    }
                }) 
        }else{
            $.fancybox.close();
            $('#cancel_capnhat_theo_loaisanpham').show();
            $('#ok_capnhat_theo_loaisanpham').removeClass('active');
            $('#confim_capnhat_theo_loaisanpham .content_confim').html(content_confim_2);
        }
    });

    // -----------------cap nhat theo san pham--------------------
    $('body').on('click','.capnhat_sanpham',function() {
        content_confim_3 = $('#confim_sanpham .content_confim').html();
        $('#ok_sanpham').attr('SanPhamID',$(this).attr('SanPhamID'));
    })

    $('#ok_sanpham').click(function(event) {
        if( !$('#ok_sanpham').hasClass('active') ){
            $('#ok_sanpham').addClass('active').button('loading');
            $('#cancel_sanpham').hide();
            SanPhamID = $('#ok_sanpham').attr('SanPhamID');

            $('#confim_sanpham .content_load').html( 'Đang cập nhật...' + $('.wrapper_load_window_phone').html() );
            $.post(base_url+'data/update_1_sanpham/' + SanPhamID,{'SanPhamID':SanPhamID}).done(
                function(data){
                    $('#ok_sanpham').button('reset');
                    if(data == 1 || data == 11){
                        $('#confim_sanpham .content_load').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> Cập nhật hoàn thành</p>');
                        message(1,'Cập nhật hoàn thành');  
                        load_sanpham();
                    }else if(data == -1){
                        $('#confim_sanpham .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Loại sản phẩm của Sản phẩm không tồn tại</p>');
                        message(2,'Cập nhật lỗi');  
                    }else{
                        $('#confim_sanpham .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Cập nhật lỗi</p>');
                        message(2,'Cập nhật lỗi');  
                    }
                }) 
        }else{
            $.fancybox.close();
            $('#cancel_sanpham').show();
            $('#ok_sanpham').removeClass('active');
            $('#confim_sanpham .content_confim').html(content_confim_3);
        }
    });


    // -----------------XOA ALL--------------------
    $('body').on('click','#xoa_all',function() {
        content_confim_5 = $('#confim_xoa_all .content_confim').html(); 
    })

    $('#ok_xoa_all').click(function(event) {
        if( !$('#ok_xoa_all').hasClass('active') ){
            $('#ok_xoa_all').addClass('active').button('loading');
            $('#cancel_xoa_all').hide(); 

            $('#confim_xoa_all .content_load').html( 'Đang xóa dữ liệu...' + $('.wrapper_load_window_phone').html() );
            $.post(base_url+'data/xoa_all',{}).done(
                function(data){
                    $('#ok_xoa_all').button('reset');
                    if(data == 1){
                        $('#confim_xoa_all .content_load').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> Xóa hoàn thành</p>');
                        message(1,'Xóa hoàn thành');   
                        load_danhmuc(); 
                    }else{
                        $('#confim_xoa_all .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-warning"></i> Xóa lỗi</p>');
                        message(2,'Xóa lỗi');  
                    }
                }) 
        }else{
            $.fancybox.close();
            $('#cancel_xoa_all').show();
            $('#ok_xoa_all').removeClass('active');
            $('#confim_xoa_all .content_confim').html(content_confim_5);
        }
    }); 


    // ================== UPDATE GIA SAN PHAM==================

    $('#select_update_gia_sanpham').val() != 0 ? $('#update_gia_sanpham').removeAttr('disabled') : '';

    $('#select_update_gia_sanpham').change(function(){
        if($(this).val() != 0){
            $('#update_gia_sanpham').removeAttr('disabled');
        }else{
            $('#update_gia_sanpham').attr('disabled','disabled');
        }
    })
    $('#update_gia_sanpham').click(function(){
        if($('#select_update_gia_sanpham').val() != 0){
            TenLoaiSP = $('#select_update_gia_sanpham option:selected').html();
            $('.title_loaisp_gia_update').html(TenLoaiSP);
        }
    })
    $('#ok_update_gia_sanpham').click(function(){
        if( !$(this).hasClass('active') ){
            $(this).addClass('active');
            LoaiSPID = $('#select_update_gia_sanpham').val();
            if(LoaiSPID != 0){
                var $btn = $(this).button('loading');
                load_ajax_in('.inner_table_content_right');
                $('#cancel_update_gia_sanpham').attr('disabled','disabled');
                $('#confim_update_gia .content_load').html('Đang tiến hành cập nhật ' + $('.wrapper_load_window_phone').html());
                $.post(base_url+'data/update_gia_sanpham',{"LoaiSPID":LoaiSPID}).done(
                    function(data){
                        result = JSON.parse(data);
                        load_ajax_out('.inner_table_content_right');
                        $('#cancel_update_gia_sanpham').removeAttr('disabled').hide();
                        $btn.button('reset');
                        if(result.count  == -1){
                            $('#confim_update_gia .content_load').html('<p class="bg_red notice_syn"><i class="fa fa-times"></i> Cập nhật lỗi!</p>');
                            message(2,'Cập nhật lỗi!'); 
                        }else{
                            $('#confim_update_gia .content_load').html('<p class="bg_green notice_syn"><i class="fa fa-check"></i> '+ result.count +' sản phẩm đã được cập nhật giá</p>');
                            $('.ngay_update_gia_sanpham').html(result.now);
                            message(1,'Cập nhật thành công!'); 
                        }
                    })
            }else{
                $.fancybox.close();
                message(2,'Cập nhật không thành công!');
            }
        }else{
            $(this).removeClass('active');
            $.fancybox.close();
            $('#cancel_update_gia_sanpham').show();
            $('#confim_update_gia .content_load').html('Việc cập nhật sẽ xóa hoàn toàn dữ liệu cũ, bạn có chắc muốn tiến hành cập nhật ?');
        }
    }) 
    // ========= UPDATE GIA SAN PHAM========== 
})