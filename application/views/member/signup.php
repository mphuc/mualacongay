<article class="right_content"> 
    <div class="defaultTitle ">
        <span>Đăng ký làm thành viên</span>
    </div>
    <form id="form_signup" class="form_control" method="post">
        <div>
            <label>Họ tên:</label>
            <div class="input_icon"><input type="text" name="Ten" autofocus minlength="3" required><i class="fa fa-male"></i></div>
        </div>     
        <div>
            <label>Giới tính:</label>
            <select name="GioiTinh" required>
                <option value="1">Nam</option>
                <option value="0">Nữ</option>
            </select>
        </div>   
        <div class="block_ngaysinh">
            <label>Ngày sinh:</label>
            <div>
                <select id="days" name="Days" required type="number"></select>
                <select id="months" name="Months" required type="number"></select>
                <select id="years" name="Years" required type="number"></select>
            </div>
        </div>             
        <div>
            <label>Email:</label>
            <div class="input_icon block_email"><input type="email" name="Email" minlength="3" required id="email"><i class="fa fa-envelope-o"></i></div>
        </div>                
        <div>
            <label>Số điện thoại:</label>
            <div class="input_icon"><input type="number" name="Phone" minlength="3" maxlength="20" required><i class="fa fa-phone"></i></div>
        </div>
        <div>
            <label><span>* </span>Tên đăng nhập:</label>
            <div class="input_icon block_username"><input type="text" name="Username" minlength="3" required id="username" autocomplete="off"><i class="fa fa-user"></i></div>
        </div>
        <div>
            <label><span>* </span>Mật khẩu:</label>
            <div class="input_icon"><input type="password" name="Password" minlength="3" required id="password" autocomplete="off"><i class="fa fa-key"></i></div>
        </div>
        <div>
            <label><span>* </span>Nhập lại mật khẩu:</label>
            <div class="input_icon"><input type="password" minlength="3" required equalTo="#password" autocomplete="off"><i class="fa fa-refresh"></i></div>
        </div>
        <div>
            <label><span>* </span>Mã xác nhận:</label>
            <div>
                <div class=" "><div class="image_captcha"><?=$captcha?></div><button id="refresh_captcha" type="button"><i class="fa fa-refresh"></i></button></div>

                <div class="input_icon"><i class="fa fa-key"></i><input type="text"  value="" name="captcha_signup" autocomplete="off" required></div>

                <div class="bottom_signup block_checkbox_form">
                    <label for="checkbox_signup">Đồng ý làm thành viên của Mua là có ngay</label>
                    <input type="checkbox" id="checkbox_signup" name="agree" required>
                    <div class="bottom_signup"> 
                        <button id="submit_signup" class="btn" type="submit" data-loading-text="Loading..."  autocomplete="off">Đăng ký</button>
                        <div class="notice"></div>
                        <div class="block_checkbox_form">
                            <label>Bạn đã có tài khoản. <a href="<?=base_url()?>member/login.html">  Đăng nhập! </a></label>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</article>  

<script type="text/javascript" src="<?=data_url?>js/dobPicker/dobPicker.js"></script> 
<script type="text/javascript">
    $(document).ready(function(){   

        $.dobPicker({
            daySelector: '#days',
            monthSelector: '#months',
            yearSelector: '#years', 
        });

        //---------------------signup-------------------- 

        $("#form_signup").validate({
            submitHandler: function(form) { 
                signup();
            }
        });      

        function signup(){   
            if(check_username() == true ){
                $('#submit_signup').button('loading');
                $.post(base_url+'member/signup_member',$("#form_signup").serialize()).done(
                function(data){ 
                    $('#submit_signup').button('reset');
                    if(data == 1){
                        window.location.href = base_url;
                    }else if(data == -2){
                        notice('red','<i class="fa fa-warning"></i> Mã xác nhận không đúng hoặc đã hết hạn!');
                    }else{
                        notice('red','<i class="fa fa-warning"></i> Đăng ký không thành công, vui lòng thử lại!');
                    }
                });  
            }   
        } 
        $('#username').on('keyup paste',function(){ 
            // check_username();
        })

        function check_username(){
            $Username = $('#username').val(); 
            $Email = $('#email').val(); 
            var succeed = false;
            $('.block_username label').remove(); 
            if($Username.length >= 3){
                $.ajax({
                    method:"POST",
                    async: false,
                    url:base_url+'member/check_username_email',
                    data:{"Username":$Username, "Email":$Email},
                    success: function(data){ 
                            result = JSON.parse(data);
                            if(typeof result  == 'object'){
                                if(result.check_username == 0){
                                    $('.block_username').show().append('<label class="error"><span class="green"><i class="fa fa-check"></i> Tên đăng nhập hợp lệ</span></label>');
                                }else{
                                    $('#username').focus();
                                    $('.block_username').show().append('<label class="error">Tên đăng nhập đã tồn tại</label>');
                                    succeed = false;
                                }
                                if(result.check_email == 0){
                                    $('.block_email').show().append('<label class="error"><span class="green"><i class="fa fa-check"></i> Email hợp lệ</span></label>');
                                }else{
                                    $('#email').focus();
                                    $('.block_email').show().append('<label class="error">Email đã tồn tại</label>');
                                    succeed = false;
                                }
                                if(result.check_username == 0 && result.check_email == 0){
                                    succeed = true;
                                }

                            }
                    }
                });  
            }  
            return succeed;
        }

        $('#refresh_captcha').click(function(){ 
            $.post(base_url+'member/reload_captcha_signup',{}).done(
            function(data){ 
                $('.image_captcha').html(data);
            });  
        })   

    })
</script>