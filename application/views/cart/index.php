<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
    
    <div class="content_cart"> 
        <div class="alert_cart"></div>
        <table id="cart_summary" class="cart_summery">
            <?=$shopping_cart;?> 
         <?php if(count($this->cart->contents()) > 0){?>
            <tr class="cart_total_price">
                <td colspan="5" class="text-right">Tổng thành tiền</td>
                <td class="price" id="total_product"><span class="price"><?=number_format($this->cart->total(),'0',',','.');?></b> VNĐ</span></td>
            </tr>
        <?php } ?>
        </table>

        <?php if(count($this->cart->contents()) > 0){?>
                <a href="<?=base_url()?>cart/thanh_toan/" class="btn btn_cart btn btn-default" style="margin-top: 30px; float: right;"><span>Tiến hành đặt hàng <i class="fa fa-arrow-circle-o-right"> </i></span></a>
            </div>                
        <?php } ?>

        <div class="left_cart"> 
            <a style="margin-top: 30px; float: left;" href="<?=base_url()?>" class="btn btn btn-default "><span>Tiếp tục mua hàng ...  <i class="fa fa-arrow-circle-o-right"> </i></span></a> 
        </div>
    </div> 
</div>
</div>