<div class="col-lg-3 col-sm-4">
    <div class="module shop-widget category-widget secondary-module">
        <h4 class="module-title"><i class="fa fa-bars" aria-hidden="true"></i>Danh mục sản phẩm<span class="toggle-btn"></span></h4>
        <div class="module-content mobile-collapse">
            <ul class="menu side-menu">
                <?=$sidebar;?>
               
            </ul>
        </div>
    </div>
                    
                   
        <div class="module shop-widget top-widget secondary-module">
            <h4 class="module-title linked-title"><a href="#"><i class="fa fa-check-square" aria-hidden="true"></i>Sản phẩm mới nhất</a><span class="toggle-btn"></span></h4>
            <div class="module-content mobile-collapse">
                <ul class="widget-products">
                    <?php foreach ($product_new as $value) { ?>
                      
                    
                    <li class="widget-product">
                        <a class="widget-item-img" href="<?=base_url()?>san-pham/<?=url_title(removesign($value['TenSP']))?>_<?=$value['SanPhamID']?>">
                            <img src="<?php echo $value['images'] ?>" alt="Product Thumb">
                        </a>
                        <div class="widget-product-content">
                            <h5 class="product-name"><a href="<?=base_url()?>san-pham/<?=url_title(removesign($value['TenSP']))?>_<?=$value['SanPhamID']?>"><?php echo $value['TenSP'] ?></a></h5>
                           
                            <p class="price"><?php echo number_format($value['GiaMoi']) ?> VNĐ</p>
                        </div>
                    </li>
                    <?php } ?>
                    
                </ul>
            </div>
        </div>
        
        
        <div class="module shop-widget testimonial-widget secondary-module">
            <h4 class="module-title"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>Khách hàng nói<span class="toggle-btn"></span></h4>
            <div class="module-content mobile-collapse">
                <div class="widget-testimonials">    
                    <div id="testimonials-carousel" class="owl-carousel">
                        <div class="testimonial">
                            <blockquote>“This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. In molestie augue magna. Pellentesque felis lorem, pulvinar sed eros non, sagittis consequat urna."</blockquote>
                            <div class="client-avatar">
                                <img src="<?=data_url?>shop/img/client/client-1.png" alt="Client Avatar">
                            </div>
                            <div class="client-info">
                                <h4 class="clinet-name">Jane Doe</h4>
                                <p class="client-desig">Online Marketer</p>
                            </div>
                        </div>
                        <div class="testimonial">
                            <blockquote>“This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. In molestie augue magna. Pellentesque felis lorem, pulvinar sed eros non, sagittis consequat urna."</blockquote>
                            <div class="client-avatar">
                                <img src="<?=data_url?>shop/img/client/client-2.png" alt="Client Avatar">
                            </div>
                            <div class="client-info">
                                <h4 class="clinet-name">Cornelius Reeves</h4>
                                <p class="client-desig">Project Manager</p>
                            </div>
                        </div>
                        <div class="testimonial">
                            <blockquote>“This is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit.Lorem ipsum dolor sit amet, consectetur adipiscing elit. In molestie augue magna. Pellentesque felis lorem, pulvinar sed eros non, sagittis consequat urna."</blockquote>
                            <div class="client-avatar">
                                <img src="<?=data_url?>shop/img/client/client-3.png" alt="Client Avatar">
                            </div>
                            <div class="client-info">
                                <h4 class="clinet-name">Jochen Rechsteiner</h4>
                                <p class="client-desig">Stylish Marketer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
<!-- <section id="container">  
    <ul class="path">
        <li class="first"> <a href="<?=base_url()?>"><i class="fa fa-home"></i> Trang chủ</a> </li>
        <?php if (isset($path_1)) { ?>
            <li><?=$path_1?></li>
        <?php } ?>        
        <?php if (isset($path_2)) { ?>
            <li><?=$path_2?></li>
        <?php } ?>
    </ul>

    <article class="left_content"> 
        <aside id="aside_menu">
            <div class="defaultTitle">
                <span>Danh mục</span>
            </div>
            <div class="defaultContent aside_menu_content">
                <ul >
                    <?=$sidebar;?>
                </ul>
            </div>  
        </aside> 

        <div class="slide_sanpham_right">
            <div class="defaultTitle">
                <span>Sản phẩm mới</span>
                <div class="nav_slide_right">
                    <i class="prev"><b class="fa fa-chevron-left"></b></i>
                    <i class="next"><b class="fa fa-chevron-right"></b></i>
                </div>
            </div>
            <div class="defaultContent">  
                <div id="slide_right">
                    <div class="wrapper_slide_right">
                        <div class="main_slide_right">
                            <?=$slide_sanpham;?>
                        </div>
                    </div>
                </div>
            </div> 
        </div>  
    </article> -->