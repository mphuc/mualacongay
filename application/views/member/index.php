<article class="right_content bg_right_content"> 
    <!-- ====================== form thông tin khách hàng ============ -->
    <form id="form_member" class="form_control" method="post"> 
        <h2 class="title_check_out">Thông tin tài khoản </h2>
        <?php if( !$connect_server){ ?>
            <p class="warning_connect">Bạn không thể cập nhật thông tin tài khoản vào lúc này!</p>
        <?php } ?>
        <div class="col_form">
            <div>
                <label>Họ tên:</label> 
                <input type="text" name="Ten" minlength="3" required value="<?php echo isset($chitiet_member)?($chitiet_member['Ten'] ):'';?>" >
            </div>
            <div>
                <label>Giới tính:</label> 
                <div class="clear"> 
                    <select id="gioitinh" name="GioiTinh" class="width_100" >
                        <option value="">Giới tính</option> 
                        <option value="1" <?=isset($chitiet_member['GioiTinh']) ? ($chitiet_member['GioiTinh'] == 'true'?' selected ':' '):''; ?>>Nam</option>
                        <option value="0" <?=isset($chitiet_member['GioiTinh']) ? ($chitiet_member['GioiTinh'] == 'true'?' ':' selected '):''; ?>>Nữ</option>
                    </select>          
                </div>              
            </div>              
              
            <div>
                <label>Số điện thoại:</label>
                <input type="tel" name="Phone" minlength="3" required value="<?=isset($chitiet_member['Phone'])?($chitiet_member['Phone'] ):'';?>" >
            </div>                      
            <div>
                <label>Email:</label>
                <input type="email" name="Email" minlength="3" value="<?=isset($chitiet_member['Email'])?($chitiet_member['Email'] ):'';?>" >
            </div>      
        </div>    

        <div class="col_form">
            <div class="select_nomal">
                <label>Ngày sinh:</label>
                <div class="clear"> 
                    <select id='days' name='Days'></select>
                    <select id='months' name='Months'></select>
                    <select id='years' name='Years'></select>
                </div> 
            </div> 
            <div>
                <label>Địa chỉ:</label>
                <input type="text" name="DiaChi" minlength="3" value="<?=isset($chitiet_member['DiaChi'])?($chitiet_member['DiaChi'] ):'';?>">
            </div>
            <div>
                <label>Tỉnh thành phố:</label>
                <div class="clear block_tinhtp">  
                    <select id="tinhtp" name="TinhTP" class="width_100">
                        <option value="" >Tỉnh-Thành</option>
                        <?php foreach ($tinhtp as $item) {  
                            if( isset($TinhTPID) ){
                                $selected = ($item['TinhTPID']==$TinhTPID)?' selected ':'';
                            }
                            echo '<option value="'.$item['TinhTPID'].'" '.$selected.' >'.$item['TenTinhTP'].'</option>';
                        } ?>
                    </select> 
                </div>
            </div>
            <div>
                <label>Quận huyện:</label>
                <div class="clear block_quanhuyen"> 
                    <select id="quanhuyen" name="QuanHuyen" class="width_100">
                        <option value="">Quận-Huyện</option>
                    </select>
                </div>
            </div>

            <div>
                <label>Xã phường:</label>
                <div class="clear block_xaphuong"> 
                    <select id="xaphuong" name="XaPhuongID" class="width_100">
                        <option value="">Xã-Phường</option>
                    </select>
                </div>
            </div>    
        </div>    
        <input type="hidden" name="MemberID" value="<?=isset($chitiet_member['MemberID'])?($chitiet_member['MemberID'] ):'';?>" >
        <input type="hidden" name="MemberID_Server" value="<?=isset($chitiet_member['MemberID_Server'])?($chitiet_member['MemberID_Server'] ):'';?>" >
        <div class="bottom_signup"> 
            <button id="submit_update_member" class="btn" type="submit" data-loading-text="Đang tiến hành cập nhật..." autocomplete="off">Cập nhật thông tin <i class="fa fa-check"> </i></button>
            <div class="notice"></div>
        </div> 
    </form>

</article> 

<?php
    if(isset($chitiet_member['NgaySinh'])){
        $date=strtotime($chitiet_member['NgaySinh']);
        $year=date("Y",$date); 
        $month=date("m",$date); 
        $day=date("d",$date); 
    }else{
        $year=date("Y",$date); 
        $month=date("m",$date); 
        $day=date("d",$date); 
    }
?>  

<script type="text/javascript" src="<?=data_url?>js/dobPicker/dobPicker.js"></script> 
<script type="text/javascript">
    $(document).ready(function(){   

        $.dobPicker({
            daySelector: '#days',
            monthSelector: '#months',
            yearSelector: '#years',

            // Default option values
            dayDefault: '<?=$day?>',
            monthDefault: '<?=$month?>',
            yearDefault: '<?=$year?>',
        });

 
        $("#form_member").validate({
            submitHandler: function(form) { 
                update_member();
            }
        });       

        function update_member(){ 
            if(check_address()){   
                var $btn = $('#submit_update_member').button('loading');
                $.post(base_url+'member/update_member',$("#form_member").serialize()).done(
                function(data){ 
                    $btn.button('reset');
                    if(data == 0){ 
                        notice('red','<i class="fa fa-warning"></i> Không thể xử lý yêu cầu vào lúc này!');                
                    }else if(data == 1){ 
                        notice('green','<i class="fa fa-check"></i> Cập nhật thành công!');
                    }else{
                        notice('red','<i class="fa fa-warning"></i> Cập nhật lỗi!');
                    }
                });   
            }
        } 
        function check_address() {
            $check = false;
            if($('#tinhtp').val() != ''){
                $('.block_tinhtp label').remove();  
                if($('#quanhuyen').val() == ''){
                    $('.block_quanhuyen').append('<label class="error"> Chọn quận huyện</label>');
                    $check = false;
                }else if($('#xaphuong').val() == ''){
                    $('.block_quanhuyen label').remove();  
                    $('.block_xaphuong').append('<label class="error"> Chọn xã phường</label>');
                    $check = false;
                }else{
                    $('.block_xaphuong label').remove();  
                    $check = true;
                }
            }else{
                $check = true;
            }
            return $check;
        }

        $('#tinhtp').change(function(){
            $('#quanhuyen').html('<option value="">Quận-Huyện</option>');
            $('#xaphuong').html('<option value="">Xã-Phường</option>');
            get_quanhuyen(auto_load=0); 
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


 
    })
</script>