<aside class="wrapper_content_right">  
    <h1 class="title_admin_right bg_title"><span class="fa fa-dashboard"></span> Tổng quan</h1>
    <div class="table_content_right"> 
        <div class="inner_table_content_right"> 
             <div class="tongquan">
                <a href="<?=base_url()?>admin/hoadononline" class="item btn-info">
                     <div class="icon_notice"><span class="fa fa-cart-arrow-down"></span></div>
                     <div class="title_tongquan"> 
                        <p class="count_tongquan"><?=$count_hoadon?></p>
                        <p class="">Đơn hàng mới</p> 
                     </div>
                     <p class="bottom_item"> Xem tất cả đơn hàng <i class="fa fa-arrow-right"></i> </p>
                </a>                  
                <a href="<?=base_url()?>admin/sanpham" class="item btn-info">
                     <div class="icon_notice"><span class="fa fa-cubes"></span></div>
                     <div class="title_tongquan">
                        <p class="count_tongquan"><?=$count_sanpham?></p>
                        <p class="">Sản phẩm</p>
                     </div>
                     <p class="bottom_item"> Xem tất cả sản phẩm <i class="fa fa-arrow-right"></i> </p>
                </a>                  
                <a href="<?=base_url()?>admin/danhmuc" class="item btn-info">
                     <div class="icon_notice"><span class="fa fa-list"></span></div>
                     <div class="title_tongquan">
                        <p class="count_tongquan"><?=$count_danhmuc?></p>
                        <p class="">Danh mục</p>
                     </div>
                     <p class="bottom_item">Xem tất cả danh mục <i class="fa fa-arrow-right"></i> </p>
                </a>                  
                <a href="<?=base_url()?>admin/loaisanpham" class="item btn-info">
                     <div class="icon_notice"><span class="fa fa-life-saver "></span></div>
                     <div class="title_tongquan">
                        <p class="count_tongquan"><?=$count_loaisp?></p>
                        <p class="">Loại sản phẩm</p>
                     </div>
                     <p class="bottom_item"> Xem tất cả loại sản phẩm <i class="fa fa-arrow-right"></i> </p>
                </a>       
                <div class="block_tongquan">
                    <div class="col-sm-12 item_2 ">  
                        <fieldset>
                            <legend>Đơn đặt hàng mới nhất</legend>
                            <div class="table_hoadononline_moinhat">
                                <?=$hoadononline_moinhat;?>
                            </div>
                        </fieldset>
                    </div>                    

<!--                     <div class="col-sm-5 item_2">  
                        <fieldset>
                            <legend>Tình trạng hệ thống</legend>
                            <p class="item_tinhtrang">Kết nối Web service: 
                            <?php if($test_webservice) 
                                    echo '<span class="alert alert-success"><i class="fa fa-check"></i> Có thể kết nối</span>';
                                else 
                                    echo '<span class="alert alert-danger"><i class="fa fa-times"></i> Không thể kết nối</span>'; 
                            ?>
                            </p>
                            <p class="item_tinhtrang">Kết nối tài khoản FTP:
                            <?php if($test_ftp_server) 
                                    echo '<span class="alert alert-success"><i class="fa fa-check"></i> Có thể kết nối</span>';
                                else 
                                    echo '<span class="alert alert-danger"><i class="fa fa-times"></i> Không thể kết nối</span>'; 
                            ?>
                            </p>
                            <p class="item_tinhtrang">Đăng nhập tài khoản Server:
                            <?php if($test_account_server) 
                                    echo '<span class="alert alert-success"><i class="fa fa-check"></i> Có thể đăng nhập</span>';
                                else 
                                    echo '<span class="alert alert-danger"><i class="fa fa-times"></i> Không thể đăng nhập</span>'; 
                            ?>
                            </p>

                        </fieldset>
                    </div>   --> 
                            
                </div>            
             </div>  
        </div><!-- inner_table_content_right -->
    </div><!-- table_content_right-->  
</aside>
