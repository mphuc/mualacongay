<?php
    $quyen_admin = $this->session->userdata("quyen_admin");
?>
<aside class="content_left">
    <div class="scroll_content_left scroll_aside">
        <ul class="sidebar_admin">
            <li <?php if($menuActive == 'tongquan') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin" class="item_menu_admin">
                    <span class="icon_menu_admin fa fa-dashboard"></span><span class="title_menu_admin">Tổng quan</span>
                </a>
            </li> 
            <?php if( $quyen_admin == 'TINTUC' || $quyen_admin == 'ADMIN' ) { ?>
            <li <?php if($menuActive == 'tintuc') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/tintuc" class="item_menu_admin"><span class="icon_menu_admin fa fa-newspaper-o"></span><span class="title_menu_admin">Tin tức</span></a>
            </li>   
            <?php } ?>

            <?php if( $quyen_admin == 'SANPHAM' || $quyen_admin == 'ADMIN' ) { ?>
             <li>
                <div class="item_menu_admin"><span class="icon_menu_admin fa fa-cubes"></span><span class="title_menu_admin">Quản lý sản phẩm</span><span class="more_icon fa fa-angle-right"></span></div>
                <ul class="group_menu_admin">
                    <li <?php if($menuActive == 'danhmuc') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/danhmuc">
                            <span class="icon_menu_admin fa fa-list"></span>
                            <span class="title_sub_menu_admin">Danh mục</span>
                        </a>
                    </li>
                    <li <?php if($menuActive == 'loaisanpham') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/loaisanpham">
                            <span class="icon_menu_admin fa fa-life-saver"></span>
                            <span class="title_sub_menu_admin">Loại sản phẩm</span>
                        </a>
                    </li>                    
                    <li <?php if($menuActive == 'sanpham') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/sanpham">
                            <span class="icon_menu_admin fa fa-dropbox"></span>
                            <span class="title_sub_menu_admin">Sản phẩm</span>
                        </a>
                    </li>
                    <li <?php if($menuActive == 'binhluan') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/binhluan">
                            <span class="icon_menu_admin fa fa-pencil"></span>
                            <span class="title_sub_menu_admin">Bình luận sản phẩm</span>
                        </a>
                    </li>                    
                </ul> 
            </li>  
            <?php } ?>
            <?php if($quyen_admin == 'ADMIN' ) { ?>
            <li <?php if($menuActive == 'hoadononline') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/hoadononline" class="item_menu_admin"><span class="icon_menu_admin fa fa-shopping-cart"></span><span class="title_menu_admin">Đơn đặt hàng Online</span></a>
            </li>              
            <li <?php if($menuActive == 'thongke') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/thongke" class="item_menu_admin"><span class="icon_menu_admin fa fa-bar-chart"></span><span class="title_menu_admin">Thống kê doanh thu</span></a>
            </li>       
              
            <?php if( $quyen_admin == 'ADMIN' ) { ?>
            <li <?php if($menuActive == 'address') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/address" class="item_menu_admin"><span class="icon_menu_admin fa fa-location-arrow"></span><span class="title_menu_admin">Dữ liệu tỉnh thành</span></a>
            </li>              
            <li <?php if($menuActive == 'mangxahoi') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/mangxahoi" class="item_menu_admin"><span class="icon_menu_admin fa fa-globe"></span><span class="title_menu_admin">Liên kết mạng xã hội</span></a>
            </li>
            <li <?php if($menuActive == 'slide') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/slide" class="item_menu_admin"><span class="icon_menu_admin fa fa-file-image-o"></span><span class="title_menu_admin">Slide</span></a>
            </li>             
            <li <?php if($menuActive == 'member') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/member" class="item_menu_admin"><span class="icon_menu_admin fa fa-user"></span><span class="title_menu_admin"><span>Thành viên & khách hàng</span></span></a>
            </li>   
            <li <?php if($menuActive == 'lienhe') echo 'class="menu_active_sidebar_left"';?>>
                <a href="<?=base_url()?>admin/lienhe" class="item_menu_admin"><span class="icon_menu_admin fa fa-envelope-o"></span><span class="title_menu_admin">Liên hệ của khách hàng</span></a>
            </li>   
            <?php } ?>
            <li>
                <div class="item_menu_admin"><span class="icon_menu_admin fa fa-database"></span><span class="title_menu_admin">Hệ thống</span><span class="more_icon fa fa-angle-right"></span></div>
                <ul class="group_menu_admin">
                    <!-- <li <?php if($menuActive == 'cauhinh') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/cauhinh">
                            <span class="icon_menu_admin fa fa-gears"></span>
                            <span class="title_sub_menu_admin">Cấu hình kết nối</span>
                        </a>
                    </li> -->
                    <li <?php if($menuActive == 'user') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/user">
                            <span class="icon_menu_admin fa fa-users"></span>
                            <span class="title_sub_menu_admin">Quản lý người dùng</span>
                        </a>
                    </li>                      
                    <li <?php if($menuActive == 'thongtin') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/thongtin">
                            <span class="icon_menu_admin fa fa-info-circle"></span>
                            <span class="title_sub_menu_admin">Thông tin website</span>
                        </a>
                    </li>                      
                    <li <?php if($menuActive == 'quanlytrang') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/quanlytrang">
                            <span class="icon_menu_admin fa fa-file-text-o"></span>
                            <span class="title_sub_menu_admin">Quản lý trang</span>
                        </a>
                    </li>                     
                    <li <?php if($menuActive == 'email') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/email">
                            <span class="icon_menu_admin fa fa-envelope"></span>
                            <span class="title_sub_menu_admin">Tài khoản email</span>
                        </a>
                    </li>                     
                    <!-- <li <?php if($menuActive == 'dongbo') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/dongbo">
                            <span class="icon_menu_admin fa fa-cloud-download"></span>
                            <span class="title_sub_menu_admin">Đồng bộ dữ liệu</span>
                        </a>
                    </li>   
                    <li <?php if($menuActive == 'capnhat') echo 'class="menu_active_sidebar_left"';?>>
                        <a href="<?=base_url()?>admin/capnhat">
                            <span class="icon_menu_admin fa fa-cloud-upload"></span>
                            <span class="title_sub_menu_admin">Cập nhật dữ liệu</span>
                        </a>
                    </li>  -->
                </ul> 
            </li>  
            <?php } ?>

        </ul> 
    </div>
</aside>

<div class="content_right"> 

