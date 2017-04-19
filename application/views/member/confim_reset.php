<article class="right_content"> 
    <div class="defaultTitle ">
        <span>Reset mật khẩu</span>
    </div> 
    <form id="form_change" class="form_control" method="post"> 
        <input type="hidden" name="token_reset" value="<?=$token_reset?>" >
        <div> 
            <label class="input_icon">Xin chào <b><?=$member['Ten']?></b></label>
        </div> 
        <?php if( $this->main_lib->connect_server() ){ ?>
            <div>
                <label><span>* </span>Mật khẩu mới</label>
                <div class="input_icon"><i class="fa fa-lock"></i><input type="password" name="Password" id="password" autofocus minlength="3" autocomplete="off" required></div>
            </div>        
            <div>
                <label><span>* </span>Nhập lại mật khẩu mới:</label>
                <div>
                    <div class="input_icon"><i class="fa fa-refresh"></i><input type="password" name="re_Password" minlength="3" required equalTo="#password"></div>
                    <div class="bottom_signup"> 
                        <button id="submit_change" class="btn" type="submit" data-loading-text="Loading...">Đổi mật khẩu</button>
                        <div class="notice"></div>
                    </div> 
                </div> 
            </div>  
        <?php } else {?>
        <p class="warning_connect">Hệ thống hiện thời đang nâng cấp, vui lòng quay lại sau!</p>
        <?php } ?>
</form>
</article> 

<script type="text/javascript">

    $(document).ready(function(){   
         $("#form_change").validate({
            submitHandler: function(form) { 
                change();
            }
        });      

        function change(){    
            var $btn = $('#submit_change').button('loading');
            $.post(base_url+'member/set_password_reset',$("#form_change").serialize()).done(
            function(data){ 
                $btn.button('reset');
                if(data == 0){
                    notice('red','<i class="fa fa-warning"></i> Không thể xử lý yêu cầu vào lúc này!');
                }else if(data == 1){
                    notice('green','<i class="fa fa-check"></i> Cập nhật mật khẩu thành công!');
                    setTimeout(function(){
                        window.location.href = base_url + 'member/login.html';
                    },3000);
                }else{
                    notice('red','<i class="fa fa-warning"></i> Cập nhật lỗi!');
                }
            });  
        } 
    })

</script>