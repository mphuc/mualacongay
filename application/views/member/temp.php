<article class="right_content bg_right_content"> 
    <form class="form_control history_member" > 
        <h2 class="title_check_out">Đơn hàng chưa hoàn tất </h2>
        <table class="table_control">
            <thead>
                <td>STT</td>
                <td>Mã đơn hàng</td>
                <td>Ngày đặt</td> 
            </thead>
            <tbody> 
                <?=$hoadononline;?>
            </tbody>
        </table>
    </form>
</article> 

<script type="text/javascript">

$(document).ready(function(){   

    $('.history_member tbody tr.item').click(function(){
        $HoaDonOnlineID = $(this).attr('HoaDonOnlineID');
        $detail = $(this).parent().find('.detail_'+$HoaDonOnlineID+' .wrapper_table_chitiet');

        if($detail.css('display') == 'block'){  
            $(this).removeClass('tr_active');
            $detail.stop().slideUp();
        } else{ 
            if(!$detail.find('.table_chitiet tbody').hasClass('showed')){
                $.post(base_url+'member/get_chitiethoadon_temp',{"HoaDonOnlineID":$HoaDonOnlineID}).done(
                function(data){
                    $detail.find('.table_chitiet tbody').html(data).addClass('showed');
                })
            }
            $(this).addClass('tr_active');
            $detail.stop().slideToggle();
        }
    })

    $('body').on('click','.submit_cart_temp',function(){
        $('.submit_cart_temp').button('loading');
        $.post(base_url+'cart/checkout_cart_temp',{"HoaDonOnlineID":$HoaDonOnlineID}).done(
        function(data){
            $('.submit_cart_temp').button('reset');
            if(data == 1){
                window.location.href = base_url + 'cart.html';
            }
        })
    })

})

</script>