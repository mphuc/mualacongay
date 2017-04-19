<?php define('dataadmin_url',base_url().'application/data/admin/'); ?>
<?php define('data_url',base_url().'application/data/');?>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Admin | Mua là có ngay</title>
    <link rel="shortcut icon" href="<?=dataadmin_url?>img/logo1.png">
    <link href="<?=dataadmin_url?>css/cssLogin.css" rel="stylesheet" type="text/css" />
    <link href="<?=dataadmin_url?>css/general.css" rel="stylesheet" type="text/css" />
    <link href="<?=dataadmin_url?>css/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?=dataadmin_url?>css/font-awesome.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $this->session->userdata("tenadmin");?>
<form id="login_box" method="post" >
    <div class="form_group">
        <div class="icon_login"><span class="fa fa-user"></span></div>
        <input type="text" name="Username" id="username" autofocus class="form_control" placeholder="Tên đăng nhập..." minlength="3" required/>
    </div>
    <div class="form_group">
        <div class="icon_login"><span class="fa fa-lock"></span></div>
        <input type="password" name="Password" id="Password" class="form_control" placeholder="Mật khẩu..." minlength="3" required />
    </div>
    <button type="submit" name="login" id="submit_login" class="form_control">Đăng nhập <span class="fa fa-arrow-circle-right"></span></button>
    <p class="notice"></p>
</form> 

<div class="wrapper_load_window_phone">
    <div class="load_window_phone">
        <span class="l-1"></span>
        <span class="l-2"></span>
        <span class="l-3"></span>
        <span class="l-4"></span>
        <span class="l-5"></span>
        <span class="l-6"></span>
    </div>
</div>

<footer>
<?php
    $thongtin = $this->thongtin_model->get_thongtin();
    echo $thongtin['Copyright'];
?>
</footer>

<!--        popup_bottom--> 
<script type="text/javascript" src="<?=data_url?>js/jquery-2.1.1.min.js"></script> 
<script type="text/javascript" src="<?=data_url?>js/validate/jquery.validate.js" ></script>
<script src="<?=dataadmin_url?>js/general.js" ></script>

<script>
    $(document).ready(function(){
//  -------------------------login---------------------------

        $("#login_box").validate({
            submitHandler: function(form) { 
                login();
            }
        });      

        function login(){    
            $content_btn = $('#submit_login').html();
            $('#submit_login').html('loading...').attr('disabled','disabled');
            $('.notice').html($('.wrapper_load_window_phone').html()).show();

            $.post('<?=base_url()?>user/login_user',$('#login_box').serialize()).done(
            function(data){ 
                if(data==1){
                    $('.notice').hide();
                    location.reload();
                }else{
                    $('#submit_login').html($content_btn).removeAttr('disabled');
                    notice('red','<i class="fa fa-warning"></i> Đăng nhập không thành công!');
                }
            }); 
        } 

    })
</script>
</body>
</html>

















