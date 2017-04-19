<article class="right_content bg_right_content"> 
    <form id="form_change" class="form_control" method="post"> 
        <h2 class="title_check_out">Đổi mật khẩu</h2>
      <!--   <?php if( !$connect_server){ ?>
            <p class="warning_connect">Bạn không thể cập nhật mật khẩu vào lúc này!</p>
        <?php } ?> -->
        <div>
            <label><span>* </span>Mật khẩu hiện tại:</label>
            <div class="input_icon"><i class="fa fa-lock"></i><input type="password" name="Old_password" autofocus minlength="3" autocomplete="off" required></div>
        </div>
        <div>
            <label><span>* </span>Mật khẩu mới:</label>
            <div class="input_icon"><i class="fa fa-key"></i><input type="password" name="Password" minlength="3" required id="password"></div>
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
            $.post(base_url+'member/change_password',$("#form_change").serialize()).done(
            function(data){ 
                $btn.button('reset');
                if(data == -1){
                    notice('red','<i class="fa fa-check"></i> Mật khẩu cũ không đúng!');
                }else if(data == 0){
                    notice('red','<i class="fa fa-warning"></i> Không thể xử lý yêu cầu vào lúc này!');
                }else if(data == 1){
                    notice('green','<i class="fa fa-check"></i> Cập nhật thành công!');
                    setTimeout(function(){
                        // window.location.href = base_url;
                    },1000);
                }else{
                    notice('red','<i class="fa fa-warning"></i> Cập nhật lỗi!');
                }
            });  
        } 
    })

</script>