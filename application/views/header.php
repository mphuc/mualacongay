<?php
define('data_url',         base_url().'application/data/');
define('dataadmin_url',    base_url().'application/data/admin/');
 
?>
<html>
<head>
    <title><?=$title?></title> 
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=data_url?>img/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="<?=data_url?>shop/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/jquery.fancybox.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=data_url?>shop/css/style.css">
    <link rel="stylesheet" href="<?=data_url?>shop/css/responsive.css">
    
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Archivo+Narrow:400,700%7cPathway+Gothic+One" rel="stylesheet"> 
    <link rel="stylesheet" href="<?=data_url?>css/customer.css">
     <script type="text/javascript" src="<?=data_url?>js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?=data_url?>js/bootstrap.js"></script> 
    
    <script src="<?=data_url?>js/owlcarousel/owl.carousel.js"></script>
    <script type="text/javascript">
        function imgError(image) {
            image.onerror = "";
            image.src = dataadmin_url + 'img/notFound.png';
            return true;
        }
    </script>
</head>

<body> 
    <header id="header">
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <nav class="top-blocks">
                    
                        <div class="phone-block top-block">
                            <span class="top-number top-inner">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span class="call-number">Hotline 0123-456-789</span>
                            </span>
                        </div>
                        <div class="accounts-block top-block top-navwrap">
                            <div class="current">
                                <div class="current-label"><i class="fa fa-user" aria-hidden="true"></i> My account</div>
                            </div>
                            <!-- <ul id="account-menu" class="menu account-menu top-menu">
                              <?php if ($this->session->userdata("login_member") == 1){ ?>
                                <a class="login_button"></i> Xin chào: </a>
                                <span class="welcome"> </span> 
                                <div class="ten_member">
                                    <a href="<?=base_url()?>member.html" class="clr_white"> <i class="fa fa-user"></i> <?=$this->session->userdata("username_member")?></a>
                                    <div class="nav_member nav_member_top">
                                        <ul>
                                            <li><a href="<?=base_url()?>member.html"> <i class="fa fa-user"></i><span>Thông tin tài khoản</span></a></li>
                                            <li><a href="<?=base_url()?>member/history.html"> <i class="fa fa-calendar"></i><span>Lịch sử mua hàng</span></a></li>
                                            <li><a href="<?=base_url()?>member/temp.html"> <i class="fa fa-calendar-o"></i><span>Đơn hàng chưa hoàn tất</span></a></li>
                                            <li><a href="<?=base_url()?>member/change.html"> <i class="fa fa-lock"></i><span>Đổi mật khẩu</span></a></li>
                                            <li><a href="<?=base_url()?>member/logout.html" ><i class="fa fa-mail-forward"></i><span>Thoát</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php }else{?>
                                <li class="menu-item"><a href="<?=base_url()?>member/login.html"><i class="fa fa-lock" aria-hidden="true"></i>Đăng nhập </a> </li>
                                <li class="menu-item"><a href="signup.html"><i class="fa fa-user" aria-hidden="true"></i>Đăng ký </a> </li>
                            <?php } ?>
                                
                            </ul> -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="row">
                    <div class="display-flex">
                        <div class="col-sm-3">
                            <div class="header-logo logo">
                                <a href="index.php" title="Rosa Logo">
                                    <img src="<?=data_url?>img/logo.png" alt="" style="width: 240px;"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center">
                            <form id="form_search" class="searchform pt-searchform">
                                <input type="search" class="searchinput search_input" name="searchinput" placeholder="Tìm kiếm..."/>
                                <button type="submit" class="searchsubmit" name="searchsubmit"><i class="fa fa-search"></i></button>
                                 <div class="result_wrapper" style="display: none;"></div>
                            </form>
                            
                        </div>
                        
                       
                        <div class="col-sm-3">
                            <div class="block-minicart">

                            <a class="top_menu_right cart-contents clr_white" href="<?=base_url()?>cart.html">
                                <div class="heading shopping_cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Giỏ hàng (<strong class="count_cart"><span class="count"><?=count($this->cart->contents())?></span></strong>)
                                </div>
                            </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
     <nav class="navbar navbar-default" data-spy="affix" data-offset-top="150">
        <div class="container" style="position: relative">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="barwrap">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </span>
              </button>
            <div class="collapse navbar-collapse" id="main-nav">
              <ul class="nav navbar-nav main-menu">
              
                <li class="menu-item <?=(isset($menuActive) ? (($menuActive=='trangchu') ? 'active' : '') : '' )?>" > <a href="<?=base_url()?>"><i class="fa fa-home"></i> Trang chủ </a> </li>  
                <li class="menu-item <?=(isset($menuActive) ? (($menuActive=='gioithieu') ? 'active' : '') : '' )?>" > <a href="<?=base_url()?>gioi-thieu-cua-hang.html" >Giới thiệu</a></li>   
                <li class="menu-item <?=(isset($menuActive) ? (($menuActive=='sanpham') ? 'active' : '') : '' )?>"> 
                    <a href="<?=base_url()?>san-pham/trang-1.html" > Sản phẩm </a> 
                  <!--   <ul id="block_aside_in_nav">
                        <?=$sidebar;?>
                    </ul> -->
                </li>                         
                <li class="menu-item <?=(isset($menuActive) ? (($menuActive=='tintuc') ? 'active' : '') : '' )?>" > <a href="<?=base_url()?>tin-tuc/trang-1.html" >Tin tức</a> </li>                         
                <li class="menu-item <?=(isset($menuActive) ? (($menuActive=='lienhe') ? 'active' : '') : '' )?>" > <a href="<?=base_url()?>lien-he.html" >Liên hệ</a> </li>
                </ul>
            </div>
        </div>
    </nav>
    
     <div class="hero-area">
        <div class="container">
            <div class="row">
                <div class="supports-shipping">
                    <div class="col-sm-4">
                        <div class="support-shipping">
                            <div class="support-shipping-icon">
                                <i class="fa fa-truck" aria-hidden="true"></i>
                            </div>
                            <div class="support-shipping-content">
                                <h5><a href="#">Miễn phí giao hàng</a></h5>
                                <p>Miễn phí giao hàng cho đơn hàng trên 2.000.000 VNĐ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="support-shipping">
                            <div class="support-shipping-icon">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="support-shipping-content">
                                <h5><a href="#">Hỗ trợ 24/7</a></h5>
                                <p>Liên hệ với chúng tôi để hiểu rõ về mua là có</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="support-shipping">
                            <div class="support-shipping-icon">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </div>
                            <div class="support-shipping-content">
                                <h5><a href="#">Các loại phí khác</a></h5>
                                <p>Chúng tôi trả các khoản phí này vì vậy bạn không phải!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-8">
                    <div id="hero-slider" class="hero-slider owl-carousel">
                      <?php foreach ($slide as $key => $value) { ?>
                        <div style="background-image: url(<?=$value['Image']?>)">
                            
                            <div class="slider-caption">
                                <h2><?php print_r($value['TieuDe']) ?></h2>
                                <a class="btn btn-default btn-big" href="<?php print_r($value['Link']) ?>">Shop Now!</a>
                            </div>
                        </div>
                      <?php } ?>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="banner">
                        <a class="banner-box" href="#">
                            <img src="<?=data_url?>shop/img/banner/img-static1.jpg" alt="banner box 1">
                        </a>
                        <a class="banner-box" href="#">
                            <img src="<?=data_url?>shop/img/banner/img-static2.jpg" alt="banner box 2">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="main-wrap">
        <div class="container">
            <div class="row">