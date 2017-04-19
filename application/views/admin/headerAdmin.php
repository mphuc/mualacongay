<?php define('dataadmin_url',base_url().'application/data/admin/'); ?>
<?php define('data_url',base_url().'application/data/');?>  
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Admin | <?=$title?></title>
    <link rel="shortcut icon" href="<?=data_url?>img/icon.png">
    <link rel="stylesheet" href="<?=data_url?>css/fotorama/fotorama.css">  
    
    <link href="<?=dataadmin_url?>css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?=dataadmin_url?>css/mainAdmin.css" rel="stylesheet" type="text/css" />
    <link href="<?=dataadmin_url?>css/bootstrap.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/general.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/animate.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/bootstrap-table/bootstrap-table.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/mcustomscrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/tablesorter/style.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/jquery.paginate/style.css" rel="stylesheet" type="text/css" /> 
    <link href="<?=dataadmin_url?>css/jPaginator/jPaginator.css" rel="stylesheet" type="text/css" />  
    <link href="<?=dataadmin_url?>css/tablesorter/style.css" rel="stylesheet" type="text/css" />   
    <link href="<?=dataadmin_url?>css/animate/animate.css" rel="stylesheet" type="text/css" />   
    <link href="<?=dataadmin_url?>css/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" />    
  
    <script src="<?=dataadmin_url?>js/jquery-2.1.1.min.js" type="text/javascript"></script>
 
</head>
<body  data-context-parent="" data-context="" >
    <div id="wrapper_loader">
        <div id='loader'>
            <div class="spinner">
                <div class="spinner-container container1">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
                </div>
                <div class="spinner-container container2">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
                </div>
                <div class="spinner-container container3">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
                </div>
            </div>
        </div> 
    </div>
    <div id="overlay_load"></div>
    <div id="container">
        <header>
            <div class="sidebar_toggle"><span class="fa fa-dedent"></span></div>
            <div class="logo_admin"><a href="<?=base_url()?>" title="<?=$thongtin['Website']?>"><?=$thongtin['Website']?></a></div>
            <!-- <div class="status_connect connect_server">
                <i class="fa fa-server"></i> Web Service: 
                <a target="blank" href="<?=$link_server?>"><?=$link_server?></a>
            </div>
            <div class="status_connect connect_server_ftp">
                <i class="fa fa-plug"></i> FTP: 
                <a target="blank" href="<?=$link_server_ftp?>"><?=$link_server_ftp?></a>
            </div> -->
            <div class="header_right">
                <div class="item_header_right">
                    <a class="label_item_header dropdown_togle">
                        <span class="fa fa-shopping-cart icon_header_right"></span>
                        <span class="count_header"><?=$count_all_hoadononline_moinhat?></span>
                        <!-- <span class="icon_more_header_right fa fa-caret-down"></span> -->
                    </a>
                    <div class="content_item_header dropdown_menu">
                        Có <b class="green"><?=$count_all_hoadononline_now?></b> đơn đặt hàng mới trong ngày<br>
                        Tất cả <b class="green"><?=$count_all_hoadononline_moinhat?></b> đơn đặt hàng mới<br>
                        Xem tất cả: <a a href="<?=base_url()?>admin/hoadononline">Đơn đặt hàng</a>
                    </div>
                </div>
                <div class="item_header_right">
                    <a class="label_item_header dropdown_togle">
                        <span class="fa fa-envelope-o icon_header_right"></span>
                        <span class="count_header"><?=$count_all_lienhe?></span>
                        <!-- <span class="icon_more_header_right fa fa-caret-down"></span> -->
                    </a>
                    <div class="content_item_header dropdown_menu">
                        Có <b class="green"><?=$count_all_lienhe?></b> liên hệ của khách hàng<br> 
                        Xem tất cả: <a a href="<?=base_url()?>admin/lienhe">Liên hệ khách hàng</a>
                    </div>
                </div> 
                <div class="info_admin">
                    <a class="img_name_admin dropdown_togle">
                        <img src="<?=dataadmin_url?>img/default.png">
                        <p><?=$this->session->userdata("username_admin")?></p>
                    </a>
                    <div class="setting_admin dropdown_menu">
                        <ul>
                            <li><a href="#change_password" class="fancybox_change_pass"><i class="fa fa-times"> </i> <span> Đổi mật khẩu<span></a></li>
                            <li><a href="<?=base_url()?>user/logout_user"><i class="fa fa-mail-forward"></i> <span> Thoát<span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header> 

        <div class="wrapper_change_password">
            <div id="change_password">
                <h2 class="title_popup">Thay đổi mật khẩu</h2>
                <form id="form_change" class="form_control" method="post"> 
                    <div>
                        <label>Mật khẩu hiện tại:</label>
                        <input type="password" name="Old_password" minlength="3" required class="form-control">
                    </div>
                    <div>
                        <label>Mật khẩu mới:</label>
                        <input type="password" name="Password" minlength="3" required id="password" class="form-control">
                    </div>         
                    <div>
                        <label>Nhập lại mật khẩu mới:</label>
                        <input type="password" name="re_Password" minlength="3" required equalTo="#password" class="form-control">
                    </div>  
                    <div class="bottom_change"> 
                            <button id="submit_change" class="btn btn-info" type="submit" data-loading-text="Loading...">Đồng ý</button>
                            <div class="notice"></div>
                        </div> 
                    </div> 
                </form>
            </div>
        </div>
















