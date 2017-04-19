<aside class="wrapper_content_right">  
    <h1 class="title_admin_right bg_title"><span class="fa fa-cloud-upload"></span>Cập nhật dữ liệu</h1>
    <div class="table_content_right"> 
        <div class="inner_table_content_right"> 
            <div class="form-horizontal block_capnhat">  
                <div class="nav_item">

                    <div class="col-md-6"> 
                        <a href="#confim_xoa_all" class="btn btn-danger fancybox_element" id="xoa_all">Xóa tất cả <i class="fa fa fa-trash-o"> </i></a>
                        <div id="confim_xoa_all">
                            <h2 class="title_popup">Xác nhận</h2>
                            <div class="wrapper_confim">
                                <div class="content_confim">
                                    <p>Xóa tất cả <b>Danh mục</b>, <b>Loại sản phẩm</b>, <b>Sản phẩm</b></p>
                                    <p class="content_load">
                                        Các dữ liệu liên quan như <b>Bình luận sản phẩm</b> và <b>Đơn đặt hàng online</b> cũng sẽ bị xóa khỏi hệ thống.<br>
                                        Bạn có chắc muốn tiến hành cập nhật ?
                                    </p>
                                </div>
                                <button id="ok_xoa_all" class="btn btn-info" data-loading-text="Đang tiến hành xóa dữ liệu..."  autocomplete="off">Đồng ý</button>
                                <button id="cancel_xoa_all" class="btn btn-danger close_fancybox">Hủy</button>
                            </div>
                        </div>
                        
                        <a href="#confim_update" class="btn btn-info fancybox_element" id="capnhat_all">Cập nhật tất cả lên website <i class="fa fa-cloud-upload"> </i></a>
                        <div id="confim_update">
                            <h2 class="title_popup">Xác nhận</h2>
                            <div class="wrapper_confim">
                                <div class="content_confim">
                                    <p>Cập nhật tất cả <b>Danh mục</b>, <b>Loại sản phẩm</b>, <b>Sản phẩm</b></p>
                                    <p class="content_load">Việc cập nhật sẽ xóa hoàn toàn dữ liệu cũ.<br>
                                    Bạn có chắc muốn tiến hành cập nhật ?</p>
                                </div>
                                <button id="ok_capnhat_all" class="btn btn-info" data-loading-text="Đang tiến hành cập nhật..."  autocomplete="off">Đồng ý</button>
                                <button id="cancel_capnhat_all" class="btn btn-danger close_fancybox">Hủy</button>
                            </div>
                        </div> 
                        <div class="last_update">Cập nhật lần cuối: <span class="ngay_update_sanpham"><?=date("H:i:s d/m/Y", strtotime($ngayupdate['SanPham']))?></span></div>
                    </div> 

                    <div class="col-md-6 block_capnhat_top"> 
                        <select id="select_update_gia_sanpham" >
                            <option value="0" selected>Cập nhật giá theo loại sản phẩm</option>
                            <?=$select_loaisp?>
                        </select>  
                        <div id="block_capnhat_gia_sanpham">
                            <a href="#confim_update_gia" disabled class="btn btn-info fancybox_element" id="update_gia_sanpham">Cập nhật giá sản phẩm <i class="fa fa-dollar"> </i></a>
                            <div id="confim_update_gia">
                                <h2 class="title_popup">Xác nhận</h2>
                                <div class="wrapper_confim">
                                    <p>Cập nhật <i><b>giá bán</b></i>, <i><b>giá khuyến mãi</b></i> và <i><b>thuế</b></i> của tất cả sản phẩm trong loại: <b class="title_loaisp_update">Quần áo bé gái</b>.</p>
                                    <p class="content_load">Bạn có chắc muốn tiến hành cập nhật ?</p>
                                    <button id="ok_update_gia_sanpham" class="btn btn-info" data-loading-text="Đang tiến hành cập nhật..."  autocomplete="off">Đồng ý</button>
                                    <button id="cancel_update_gia_sanpham" class="btn btn-danger close_fancybox">Hủy</button>
                                </div>
                            </div>
                        </div>
                        <div class="last_update">Cập nhật lần cuối: <span class="ngay_update_gia_sanpham"><?=date("H:i:s d/m/Y", strtotime($ngayupdate['Gia_SanPham']))?></span></div>
                    </div> 
                    
                </div>  

                <div class="block_button_load">
                    <button class="btn btn-success" id="load_website">Duyệt dữ liệu từ website <i class="fa fa-cloud"> </i></button>
                    <i class="fa fa-exchange"></i>
                    <button class="btn btn-default" id="load_server">Duyệt dữ liệu từ máy chủ <i class="fa fa-server"> </i></button>
                </div>

                <div class="col_capnhat">
                    <!-- -----------------danh mục------------- -->
                    <div class="list_danhmuc">
                        <table class="table_item table_capnhat"> 
                            <thead><th colspan="5"><span class="load_from"><i class="fa fa-cloud"></i></span> Danh mục sản phẩm (<span class="count_danhmuc"></span>)</th></thead>
                            <tbody> 

                            </tbody>
                        </table>   
                        <div id="confim_capnhat_theo_danhmuc">
                            <h2 class="title_popup">Xác nhận</h2>
                            <div class="wrapper_confim">
                                <div class="content_confim">
                                    <p>Cập nhật tất cả <b>Sản phẩm</b>, <b>Loại sản phẩm</b> theo <b>Danh mục</b></p>
                                    <p class="content_load">Việc cập nhật sẽ xóa hoàn toàn dữ liệu <b>Sản phẩm</b>,<b>Loại sản phẩm</b> cũ.<br>
                                    Bạn có chắc muốn tiến hành cập nhật ?</p>
                                </div>
                                <button id="ok_capnhat_theo_danhmuc" class="btn btn-info" data-loading-text="Đang tiến hành cập nhật..."  autocomplete="off">Đồng ý</button>
                                <button id="cancel_capnhat_theo_danhmuc" class="btn btn-danger close_fancybox">Hủy</button>
                            </div>
                        </div>   
                    </div>        
                    <!-- -----------------danh mục------------- -->

                    <!-- -----------------loại sản phẩm------------- -->
                    <div class="list_loaisanpham">
                        <table class="table_item table_capnhat"> 
                            <thead><th colspan="5"><span class="load_from"><i class="fa fa-cloud"></i></span> Loại sản phẩm (<span class="count_loaisanpham"></span>)</th></thead>
                            <tbody> 

                            </tbody>
                        </table>  
                        <div id="confim_capnhat_theo_loaisanpham">
                            <h2 class="title_popup">Xác nhận</h2>
                            <div class="wrapper_confim">
                                <div class="content_confim">
                                    <p>Cập nhật tất cả <b>Sản phẩm</b> trong <b>Loại sản phẩm</b></p>
                                    <p class="content_load">Việc cập nhật sẽ xóa hoàn toàn dữ liệu <b>Sản phẩm</b> cũ.<br>
                                    Bạn có chắc muốn tiến hành cập nhật ?</p>
                                </div>
                                <button id="ok_capnhat_theo_loaisanpham" class="btn btn-info" data-loading-text="Đang tiến hành cập nhật..."  autocomplete="off">Đồng ý</button>
                                <button id="cancel_capnhat_theo_loaisanpham" class="btn btn-danger close_fancybox">Hủy</button>
                            </div>
                        </div>      
                    </div>  
                    <!-- -----------------loại sản phẩm------------- -->
                </div>           

                <!-- -----------------sản phẩm------------- -->
                <div class="col_capnhat list_sanpham">
                    <table class="table_item table_capnhat"> 
                        <thead><th colspan="5"><span class="load_from"><i class="fa fa-cloud"></i></span> Sản phẩm (<span class="count_sanpham"></span>)</th></thead>
                        <tbody> 

                        </tbody>
                    </table> 
                    <div id="confim_sanpham">
                        <h2 class="title_popup">Xác nhận</h2>
                        <div class="wrapper_confim">
                            <div class="content_confim">
                                <p>Cập nhật thông tin <b>Sản phẩm</b></p>  
                                <p class="content_load">Bạn có chắc muốn tiến hành cập nhật?</p>
                            </div>
                            <button id="ok_sanpham" class="btn btn-info" data-loading-text="Đang tiến hành cập nhật..."  autocomplete="off">Đồng ý</button>
                            <button id="cancel_sanpham" class="btn btn-danger close_fancybox">Hủy</button>
                        </div>
                    </div>       
                </div>   
                <!-- -----------------sản phẩm------------- -->

            </div> 
        </div><!-- inner_table_content_right -->
    </div><!-- table_content_right-->  
</aside>  
