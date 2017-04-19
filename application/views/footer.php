        </div>
    </div>
</div>
    <footer>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-md-offset-1">
                        <div class="subscribe-header">
                            <h4 class="subscribe-heading"><i class="fa fa-envelope"></i>Sign up for our newsletter</h4>
                            <p>Enter your email and we’ll send you a coupon with 10% off your next order</p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-8 col-md-offset-0 col-sm-offset-2">
                        <form id="subscribeform" class="subscribeform" action="#" method="post">
                            <input type="email" name="email" placeholder="Enter your e-mail">
                            <input type="submit" name="email-submit" value="sign up!">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="footer-widgets">
                        <div class="col-md-3 col-sm-6">
                            <div class="widget footer-widget about-widget">
                                <div class="widget-content">
                                    <div class="footer-logo">
                                        <a href="index-2.html" title="Rosa Logo">
                                            <img src="img/logo.png" alt="Rosa logo"/>
                                        </a>
                                    </div>
                                    <div style="background: url(img/map.png) no-repeat center center / contain; float: left; width: 100%">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing, sed do eiusmod tempor incididunt ut labore et. Lorem ipsum dolor sit amet.</p>
                                        <div class="contact-infos">
                                            <div class="cotact-info contact-address">
                                                <div class="contact-icon">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </div>
                                                <p class="contact-content"><?=$thongtin['TenCuaHang']?></p>
                                            </div>
                                            <div class="cotact-info contact-phone">
                                                <div class="contact-icon">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                </div>
                                                <p class="contact-content"> Điện thoại: </b><?=$thongtin['SDT']?></p>
                                            </div>

                                            <div class="cotact-info contact-email">
                                                <div class="contact-icon">
                                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                                </div>
                                                <p class="contact-content"> Email: </b><?=$thongtin['Email']?></p>

                              
                                            </div>
                                            <div class="cotact-info contact-phone">
                                                <div class="contact-icon">
                                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                                </div>
                                                <p class="contact-content">Địa chỉ: </b><?=$thongtin['DiaChi']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="widget footer-widget product-widget">
                                <h4 class="widget-title">SALES OFF<span class="toggle-btn"></span></h4>
                                <div class="widget-content mobile-collapse">
                                    <?php foreach ($tintuc_moinhat as $item) { ?>
                                       
                                        <div class="product">
                                            <div class="product-thumb">
                                                <a href="<?=base_url()?>tin-tuc/<?=url_title(removesign($item['TieuDe']))?>_<?=$item['TinTucID']?>" class="thumb-link">
                                                    <img class="front-img" src="<?=$item['Image']?>" alt="Product Front" style="height: 30px">
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <h5 class="product-name"><a href="#"><?=$item['TieuDe']?></a></h5>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-4">
                            <div class="widget footer-widget custom-menu-widget">
                                <h4 class="widget-title">My account<span class="toggle-btn"></span></h4>
                                <div class="widget-content mobile-collapse">
                                    <ul class="menu custom-menu account-menu">
                                    
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>">Trang chủ</a></li>
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>gioi-thieu-cua-hang.html" >Giới thiệu</a></li>   
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>san-pham/trang-1.html">Sản phẩm</a></li>
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>tin-tuc/trang-1.html">Tin tức</a></li>
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>lien-he.html">Liên hệ</a></li>
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>member/login.html">Đăng nhập</a></li>
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>member/signup.html">Đăng ký</a></li>
                                        <li class="menu-item"><a class="bullet" href="<?=base_url()?>huong-dan-mua-hang.html">Hướng dẫn mua hàng</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <div class="widget footer-widget custom-menu-widget">
                                <h4 class="widget-title">Fanpage<span class="toggle-btn"></span></h4>
                                <div class="widget-content mobile-collapse">
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="menu footer-menu">
                            <li class="menu-item"><a href="#">About</a></li>
                            <li class="menu-item"><a href="#">Blog</a></li>
                            <li class="menu-item"><a href="#">Contact</a></li>
                            <li class="menu-item"><a href="#">FAQ</a></li>
                            <li class="menu-item"><a href="#">Account</a></li>
                            <li class="menu-item"><a href="#">Wishlist</a></li>
                        </ul>
                        <p class="copyright">Copyright &copy; 2017 <a href="#">CodeChant</a>. All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="socials footer-socials">
                            <a href="#" class="social s-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" class="social s-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" class="social s-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" class="social s-rss"><i class="fa fa-rss" aria-hidden="true"></i></a>
                            <a href="#" class="social s-g-plus"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                            <a href="#" class="social s-pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </footer>
    
   
    <a id="toTop" class="toTop" href="#header"><i class="fa fa-angle-up"></i></a>

       <script type="text/javascript" src="<?=data_url?>js/general.js" ></script>  
        <script type="text/javascript" src="<?=data_url?>js/fancybox/jquery.fancybox.js" ></script>  
        <script type="text/javascript" src="<?=data_url?>js/validate/jquery.validate.js" ></script>   
        <script type="text/javascript" src="<?=data_url?>js/fotorama/fotorama.js"></script> 
        <script type="text/javascript" src="<?=data_url?>js/carouFredSel/jquery.carouFredSel-6.2.0-packed.js"></script> 
        <script type="text/javascript" src="<?=data_url?>js/animate_from_to/jquery.animate_from_to-1.0.js"></script> 
        <script type="text/javascript" src="<?=data_url?>js/waypoint/waypoint.js"></script>   
        <script type="text/javascript" src="<?=data_url?>js/dotdotdot/jquery.dotdotdot.js"></script> 

        <script src="<?=dataadmin_url?>js/mcustomscrollbar/jquery.mCustomScrollbar.js" ></script>
        <script src="<?=dataadmin_url?>js/mcustomscrollbar/jquery.mousewheel.min.js" ></script> 

        <script type="text/javascript"> 
            var base_url = '<?=base_url();?>'; 
            var data_url = base_url + 'application/data/';
            var dataadmin_url = base_url + 'application/data/admin/';
        </script>

        <script src="<?=data_url?>js/general.js" ></script> 
        <script src="<?=data_url?>js/main.js"></script>
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script> 

        
        <script src="<?=data_url?>shop/js/bootstrap.min.js"></script>
        <script src="<?=data_url?>shop/js/owl.carousel.min.js"></script>
        <script src="<?=data_url?>shop/js/jquery.countdown.js"></script>
        <script src="<?=data_url?>shop/js/jquery-ui.min.js"></script>
        <script src="<?=data_url?>shop/js/jquery.fancybox.js"></script>
        <script src="<?=data_url?>shop/js/jquery.elevatezoom.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAmiJjq5DIg_K9fv6RE72OY__p9jz0YTMI"></script>
       <script src="<?=data_url?>shop/js/map.js"></script>
        <script src="<?=data_url?>shop/js/custom.js"></script>

    </body>
</html>









