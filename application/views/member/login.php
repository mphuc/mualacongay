<article class="right_content"> 
    <div class="defaultTitle ">
        <span>Đăng nhập</span>
    </div>
    <form id="form_login" class="form_control" method="post"> 
        <div>
            <label><span>* </span>Tên đăng nhập hoặc email:</label>
            <div class="input_icon"><input type="text" name="Username" autofocus minlength="3" required><i class="fa fa-user"></i></div>
        </div>
        <div>
            <label><span>* </span>Mật khẩu:</label>
            <div>
                <div class="input_icon"><input type="password" name="Password" minlength="3" required><i class="fa fa-key"></i></div>
                <div class="bottom_signup">
                    <button id="submit_login" class="btn" type="submit" data-loading-text="Loading..."  autocomplete="off">Đăng nhập</button>
                    <div class="notice"></div>
                    <div class="block_checkbox_form"> 
                        <label for="checkbox_signup">Bạn chưa có tài khoản,<a href="<?=base_url()?>member/signup.html"> Đăng ký ngay!</a></label>
                        <p><a href="<?=base_url()?>member/reset.html">Quên mật khẩu?</a></p>
                    </div> 
                </div>
            </div>
        </div>   
    </form>
</article> 

<script type="text/javascript">
    $(document).ready(function(){
        $("#form_login").validate({
            submitHandler: function(form) { 
                login();
            }
        });      

        function login(){    
            var $btn = $('#submit_login').button('loading');
            $.post(base_url+'member/login_member',$("#form_login").serialize()).done(
            function(data){ 
                $btn.button('reset');
                if(data == 1){
                    window.location.href = base_url;
                }else {
                    notice('red','<i class="fa fa-warning"></i> Đăng nhập thất bại!');
                }
            });  
        } 
    })
</script>