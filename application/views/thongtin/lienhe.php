<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
    <div class="bg_right_content content_lienhe"> 
    	<?=$thongtin['LienHe']?>
    	<!-- <div class="thongtin_lienhe col-md-4">
			<p><b><?=$thongtin['TenCuaHang']?></b></p>
			<p><b>Địa chỉ: </b>55/5 Mool Rangsit-Nakonnayok Rd., Bungyeetho, Thanyaburi, Pathumthani 12130
Bangkok, Thailand</p>
			<p><b>SĐT: </b>+86.71712356689</p>
			<p><b>Email: </b>info@gdgclub.net</p>
			<p><b>Website: </b>gdgclub.org</p>
    	</div>
    	<div class="thongtin_lienhe col-md-4">
			<p><b>GDG HÀ NỘI</b></p>
			<p><b>Địa chỉ: </b><?=$thongtin['DiaChi']?>Chung Cư CT3A Mễ Trì Thượng, Mễ Trì Thượng, Mễ Trì, Từ Liêm, Hà Nội</p>
			
    	</div>
    	<div class="thongtin_lienhe col-md-4">
			<p><b>GDG HỒ CHÍ MINH</b></p>
			<p><b>Địa chỉ: 216A Nguyễn Thái Bình</p>
			
    	</div>
    	<div class="iframe_googlemap">
	    	<div><?=$thongtin['GoogleMap']?>  	</div>
	    	<p class="title_googlemap">
	    		<b>Địa chỉ: </b>Hà nội
	    	</p>
    	</div> -->

    	<div class="gui_lienhe col-md-6 col-md-push-3">
    		 <form id="form_lienhe" class="form_control" method="post"> 
    		 	<fieldset>
    		 		<legend>Gửi thông tin liên hệ</legend>
			        <div>
			            <label><span>* </span>Tên của bạn:</label>
			            <div class="input_icon"><input type="text" name="Ten" minlength="3" autocomplete="off" required></div>
			        </div>
			        <div>
			            <label><span>* </span>Điện thoại:</label>
			            <div class="input_icon"><input type="number" maxlength="20" name="Phone" minlength="3" autocomplete="off" required></div>
			        </div> 	   
			        <div>     
			            <label><span>* </span>Email:</label>
		                <div class="input_icon"><input type="email" name="Email" minlength="3" autocomplete="off" required></div>
					</div> 
			        <div>
			            <label><span>* </span>Nội dung liên hệ:</label>
			            <div>
			            	<div class="input_icon">
								
								<textarea class="noidung" required="" minlength="3" name="NoiDung" placeholder="" autocomplete="off" aria-required="true"></textarea>
							</div>
			                <div class="bottom_signup">
			                    <button id="submit_lienhe" class="btn" type="submit" data-loading-text="Loading..."  autocomplete="off">Gửi thông tin liên hệ</button>
			                    <div class="notice"></div> 
			                </div>
			            </div>
			        </div>   
			 	</fieldset>
		    </form>
    	</div>
    </div>
</div>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $("#form_lienhe").validate({
            submitHandler: function(form) { 
                lienhe();
            }
        });      

        function lienhe(){    
            var $btn = $('#submit_lienhe').button('loading');
            $.post(base_url+'lienhe/insert_lienhe',$("#form_lienhe").serialize()).done(
            function(data){ 
                $btn.button('reset');
                if(data == 1){
                    notice('green','<i class="fa fa-check"></i> Cảm ơn bạn đã gửi liên hệ,<br> chúng tôi sẽ trả lời bạn trong thời gian sớm nhất!');
                	setTimeout(function(){
                		window.location = base_url;
                	},3000)
                }else {
                    notice('red','<i class="fa fa-warning"></i> Gửi không thành công, vui lòng thử lại!');
                }
            });  
        } 
    })
</script>