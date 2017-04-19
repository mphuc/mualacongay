<aside class="wrapper_content_right">  
    <h1 class="title_admin_right bg_title"><span class="fa fa-cloud-download"></span>Đồng bộ dữ liệu</h1>
    <div class="table_content_right"> 
        <div class="inner_table_content_right"> 
            <div class="form-horizontal">  
                <div class="form-group">
                    <label class="col-sm-2 control-label label_dongbo" for="port">Đơn đặt hàng mới <i class="fa fa-shopping-cart count_hoadon"></i> :</label>
                    <div class="col-sm-10"> 
                        <label class="form-control-static"><?=$count_hoadon?></label>
                    </div>
                </div>             
                <div class="form-group">
                    <label class="col-sm-2 control-label  label_dongbo" for="username_ftp">Thành viên mới <i class="fa fa-user count_member"></i> :</label>
                    <div class="col-sm-10"> 
                        <label class="form-control-static"><?=$count_member?></label>
                    </div>
                </div>       

                <div class="col-md-12 block_button_form">
                    <a href="#confim_connect" class="btn btn-info fancybox_element" id="dongbo_dulieu">Đồng bộ dữ liệu xuống máy chủ <i class="fa fa-cloud-download"></i></a>
                </div> 

                <div id="confim_connect">
                    <h2 class="title_popup">Xác nhận</h2>
                    <div class="wrapper_confim">
                        <p><b>Đồng bộ dữ liệu <i class="fa fa-cloud-download"></i></b></p>
                        <div class='wrapper_content_disconnect'>
                            <div class="title_sync">Đồng bộ dữ liệu với máy chủ, bao gồm:</div>
                            <ul class='content_disconnect'>
                                <li>
                                    <p class="pull-left"><i class="fa fa-arrow-circle-o-right"></i> Thành viên mới </p>
                                    <p class="load_connect load_member"></p>
                                </li>
                                <li>
                                    <p class="pull-left"><i class="fa fa-arrow-circle-o-right"></i> Đơn đặt hàng online</p>
                                    <p class="load_connect load_hoadononline"></p>
                                </li>
                            </ul>
                        </div>
                        <button type="button" id="ok_connect" class="btn btn-info" data-loading-text="Đang tiến hành kết nối..."  autocomplete="off">Đồng ý</button>
                        <button type="button" id="cancel_connect" class="btn btn-danger close_fancybox">Hủy</button>
                    </div>
                </div>

            </div> 
        </div><!-- inner_table_content_right -->
    </div><!-- table_content_right-->  
</aside>  
