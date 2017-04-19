<article class="right_content"> 
    <div class="defaultTitle ">
        <span>Quên thông tin tài khoản</span>
    </div>
    <form id="form_reset" class="form_control" method="post">  
        <div>
            <label><span>* </span>Email của bạn:</label>
            <div class="input_icon"><i class="fa fa-envelope-o"></i><input type="email" name="email" autofocus autocomplete="off" minlength="3" required></div>
        </div>
        <div> 
            <label><span>* </span>Mã xác nhận:</label>
            <div>
                <div class=" "><div class="image_captcha"><?=$captcha?></div><button id="refresh_captcha" type="button"><i class="fa fa-refresh"></i></button></div>
                <div class="input_icon"><i class="fa fa-key"></i><input type="text" value="" name="captcha" autocomplete="off" required></div>
                <div class="bottom_signup">
                    <button id="submit_reset" class="btn" type="submit" data-loading-text="Loading..."  autocomplete="off">Reset mật khẩu</button>
                    <div class="notice"></div> 
                </div>
            </div>
        </div>   
    </form>
</article> 

<script type="text/javascript">
    $(document).ready(function(){
        $("#form_reset").validate({
            submitHandler: function(form) { 
                reset();
            }
        });      

        function reset(){    
            var $btn = $('#submit_reset').button('loading');
            $.post(base_url+'member/reset_password',$("#form_reset").serialize()).done(
            function(data){ 
                $btn.button('reset');
                if(data == -1){
                    notice('red','<i class="fa fa-warning"></i> Mã xác nhận không đúng hoặc đã hết hạn!');
                }else if(data == -2){
                    notice('red','<i class="fa fa-warning"></i> Email không tồn tại trong hệ thống!');
                }else if(data == 1){
                    notice('green','<i class="fa fa-check"></i> Thông tin đăng nhập đã được gửi đến Email của bạn,<br>kiểm tra hộp thư và tiến hành đăng nhập!');
                    setTimeout(function(){
                        window.location.href = base_url + 'member/login.html';
                    },5000);
                }else {
                    notice('red','<i class="fa fa-warning"></i> Gửi không thành công, kiểm tra địa chỉ email và thử lại!');
                }
            });  
        } 


        $('#refresh_captcha').click(function(){ 
            $.post(base_url+'member/reload_captcha_reset_password',{}).done(
            function(data){ 
                $('.image_captcha').html(data);
            });  
        })   
    })
</script>