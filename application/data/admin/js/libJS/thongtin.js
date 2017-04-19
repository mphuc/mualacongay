$(document).ready(function(){    
    $('body').on('change','.list_thongtincuahang input[type="radio"]',function(event) {
        $('#ok_update_thongtin').removeAttr('disabled');
    });

    $('body').on('click','#ok_update_thongtin',function(){
        $('#ok_update_thongtin').button('loading');
        ThongTinID = $('.ThongTinID').val();
        TenCuaHang = $('.TenCuaHang').val();
        DiaChi = $('.DiaChi').val();
        SDT = $('.SDT').val();
        Email = $('.Email').val();
        Website = $('.Website').val();
        khuyenmai = $('.khuyenmai').val();
        $.post(base_url + 'data/update_thongtin',{'khuyenmai': khuyenmai,'ThongTinID':ThongTinID, 'TenCuaHang':TenCuaHang,'DiaChi': DiaChi, 'SDT':SDT, 'Email':Email, 'Website':Website }).done(
            function(data){
                $('#ok_update_thongtin').button('reset');
                result = JSON.parse(data);
                if( typeof result === 'object') {
                    $.fancybox.close();
                    $('.TenCuaHang').val(result.thongtin.TenCuaHang);
                    $('.DiaChi').val(result.thongtin.DiaChi);
                    $('.SDT').val(result.thongtin.SDT);
                    $('.Email').val(result.thongtin.Email);
                    $('.Website').val(result.thongtin.Website); 
                    $('.khuyenmai').val(result.thongtin.khuyenmai);
                    $('.last_update span').html(result.now); 
                    message(1,'Cập nhật thành công!');
                }else{ 
                    message(2,'Cập nhật không thành công!');
                } 
            })
    })

})