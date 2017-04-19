<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
    <div id="check_out">

        <!-- ====================== form thông tin khách hàng ============ -->
        <div class="row">
            <div class="col-md-6">
                <form id="form_checkout" class="form_control" method="post"> 
                    <h2 class="title_check_out" style="margin-bottom: 10px;">Thông tin khách hàng</h2>
                    <div>
                        <label>Họ tên:</label> 
                        <input type="text" name="Ten" minlength="3" required value="<?=isset($chitiet_member)?($chitiet_member['Ten'] ):'';?>" <?=isset($readonly_input) ? $readonly_input : '' ?> >
                        <select required id="gioitinh" name="GioiTinh" <?=isset($readonly_input) ? $readonly_input : '' ?>>
                            <option value="">Giới tính</option> 
                            <option value="1" <?=isset($chitiet_member) ? ($chitiet_member['GioiTinh'] == 'true'?' selected ':' '):''; ?>>Nam</option>
                            <option value="0" <?=isset($chitiet_member) ? ($chitiet_member['GioiTinh'] == 'true'?' ':' selected '):''; ?>>Nữ</option>
                        </select>                        
                        <select id="NamSinh" name="NamSinh" <?=isset($readonly_input) ? $readonly_input : '' ?>>
                            <option value="">Năm sinh</option>  
                            <?php
                                if(isset($chitiet_member)){
                                    $date=strtotime($chitiet_member['NgaySinh']);
                                    $year=date("Y",$date); 
                                }else{
                                    $year = '2015';
                                }

                                $now = getdate();
                                for ($y=$now["year"]; $y >= 1900  ; $y--) { 
                                    $selected = ( $y==$year )?' selected ':'';
                                    echo '<option value="'.$y.'" '.$selected.' >'.$y.'</option>';
                                };    
                            ?>
                        </select>
                    </div>               
                    <div>
                        <label>Số điện thoại:</label>
                        <input type="number" name="Phone" minlength="3" maxlength="20" required value="<?=isset($chitiet_member)?($chitiet_member['Phone'] ):'';?>" <?=isset($readonly_input) ? $readonly_input : '' ?>>
                    </div>                      
                    <div>
                        <label>Email:</label>
                        <input type="email" name="Email" minlength="3" value="<?=isset($chitiet_member)?($chitiet_member['Email'] ):'';?>" <?=isset($readonly_input) ? $readonly_input : '' ?>>
                    </div>    
                    <div>
                        <label>Địa chỉ nhận hàng:</label>

                        <input type="text" name="DiaChi" minlength="3" required value="<?=isset($chitiet_member)?($chitiet_member['DiaChi'] ):'';?>">

                        <select id="tinhtp" name="TinhTP" required style="width: 100%">
                            <option value="" >Tỉnh-Thành</option>
                            <?php foreach ($tinhtp as $item) {  
                                    if(isset($TinhTPID)){
                                        $selected = ($item['TinhTPID']==$TinhTPID)?' selected ':'';
                                    }
                                    echo '<option value="'.$item['TinhTPID'].'" '.$selected.' >'.$item['TenTinhTP'].'</option>';
                            } ?>
                        </select>
                        <select id="quanhuyen" name="QuanHuyen" required style="width: 100%">
                            <option value="">Quận-Huyện</option>
                        </select>
                        <select id="xaphuong" name="XaPhuongID" required style="width: 100%">
                            <option value="">Xã-Phường</option>
                        </select>

                        <input type="hidden" name="GiaShip" class="ship_cost_hidden">

                    </div>      
                    <div>
                        <label>Ghi chú về đơn hàng:</label>
                        <textarea name="GhiChu" placeholder="Ghi chú..."></textarea>
                    </div> 
                    <div id="" style="display: none !important;"> 
                        <h2 class="title_check_out">Phương thức thanh toán</h2>

                        <div class="alert_cart"></div>
                        <p><input checked="true" type="radio" style="width: 40px; margin-top: 3px;" name="PayMent" value="1"><b>Điểm GDG</b></p>
                        <p><input type="radio" style="width: 40px; margin-top: 3px;" value="2" name="PayMent"><b>Bitcoin</b></p>
                        
                        
                    </div>
                    <div class="bottom_signup text-center"> 
                        <button id="submit_checkout" class="btn btn btn-default" type="submit">Hoàn tất đặt hàng <i class="fa fa-check"> </i></button>
                        <div class="notice"></div>
                    </div> 
                </form>
            </div>

        <!-- ====================== form thông tin khách hàng ============ -->

        
           
        
        <!-- =============== Đơn hàng của bạn ================ -->
    <div class="col-md-6">
        <div class="content_cart"> 
            <h2 class="title_check_out">Đơn hàng của bạn</h2>

            <div class="alert_cart"></div>
            <table class="table_control" style="margin-bottom: 10px;">
                <tbody>
                    <?=$shopping_cart;?>
                </tbody>
            </table>

            <?php if(count($this->cart->contents()) > 0){?>
                <div class="right_cart">
                    <p>Tổng tiền hàng:     <b class="total_cart"><?=number_format($this->cart->total(),'0',',','.');?></b> VNĐ</p>
                    <p>Phí giao hàng:   <b class="ship_cost">  Chọn [Quận-Huyện] </b> VNĐ</p>
                    <p>Tổng tiền thanh toán:    <b class="tonggia_donhang">  </b> VNĐ </p>
                   
                </div>                
            <?php } ?> 
        </div>
        <!-- =============== Đơn hàng của bạn ================ -->
        </div>
    </div> 
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){   

        // ==========================check_out====================
     
        $("#form_checkout").validate({
            submitHandler: function(form) { 
                checkout();
            }
        });  

        function checkout(){
            $('#submit_checkout').button('loading');
            $.post(base_url+'cart/checkout',$("#form_checkout").serialize()).done(
            function(data){ 
                $('#submit_checkout').button('reset');
                if(data == 'done'){
                    window.location.href = base_url+'cart/'+data;
                }else{
                    notice('red','<i class="fa fa-warning"></i> Đặt hàng không thành công, vui lòng kiểm tra lại!');
                }
            }); 
        };
     
        $('#tinhtp').change(function(){
            $('#quanhuyen').html('<option value="">Quận-Huyện</option>');
            $('#xaphuong').html('<option value="">Xã-Phường</option>');
            get_quanhuyen(auto_load=0);
            ship_cost();
        })    

        $('#quanhuyen').change(function(){
            get_xaphuong();
        })

        function get_quanhuyen(auto_load){
            $.post(base_url+'address/get_quanhuyen',{'TinhTPID':$('#tinhtp').val()}).done(
            function(data){  
                $('#quanhuyen').html(data);
                if(auto_load == 1){
                    get_xaphuong();
                }
            });   
        }

        function get_xaphuong(){
            $.post(base_url+'address/get_xaphuong',{'QuanHuyenID':$('#quanhuyen').val()}).done(
            function(data){  
                $('#xaphuong').html(data);
            }); 
        }

        function auto_address(){
            if($('#tinhtp').val() != ''){
                get_quanhuyen(auto_load=1); 
            }        
        }
        auto_address();

        function ship_cost(){
            if($('#tinhtp').val() != ''){
                $.post(base_url+'address/get_chitiet_tinhtp',{'TinhTPID':$('#tinhtp').val()}).done(
                function(data){   
                    $('.ship_cost_hidden').val(data);
                    $('.ship_cost').html(format_price(data) );
                    $total_cart = parseInt($('.total_cart').html().replace(/[.]/g,''));
                    $ship_cost = parseInt($('.ship_cost').html().replace(/[.]/g,''));
                    $('.tonggia_donhang').html(format_price($total_cart + $ship_cost));
                    

                }); 
            } else{
                $('.ship_cost').html('Chọn [Quận-Huyện]');
                $('.tonggia_donhang').html('...');
                $('.tonggia_donhang_gdg').html('...');
            }  
        }
        ship_cost();
    })
</script>