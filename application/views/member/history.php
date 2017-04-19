<article class="right_content bg_right_content"> 
    <form class="form_control history_member" > 
        <h2 class="title_check_out">Lịch sử mua hàng </h2>
        <table class="table_control">
            <thead>
                <td>STT</td>
                <td>Mã đơn hàng</td>
                <td>Ngày đặt</td>
                <td>Tình trạng</td>
                <td>Tổng tiền (VNĐ)</td>
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
                
                $detail.find('.table_chitiet tbody').append($('.wrapper_load_ajax').clone().show());

                $.post(base_url+'member/get_chitiethoadon',{"HoaDonOnlineID":$HoaDonOnlineID}).done(
                function(data){
                    $detail.find('.table_chitiet tbody').html(data).addClass('showed');
                })
            }
            $(this).addClass('tr_active');
            $detail.stop().slideToggle();
        }
    })

})

</script>