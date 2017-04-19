<aside class="wrapper_content_right">  
    <h1 class="title_admin_right bg_title"><span class="fa fa-gears"></span>Cấu hình</h1>
    <div class="table_content_right"> 
        <div class="inner_table_content_right"> 
            <form class="form_add_edit form-horizontal" id="form_cauhinh">  

                <fieldset>
                    <legend>Chế độ kết nối:</legend>                     
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for=""></label>
                        <div class="col-sm-10 block_connect"> 
                            <div class="item_connect">
                                <button type="button" class="connect <?=($cauhinh['connect_server']) ? 'active' : ''?>">Kết nối đến máy chủ <i class="fa fa-server"></i></button>
                                <div class="last_update">Kết nối máy chủ lúc: <span class="ngayupdate"><?=date("H:i:s d/m/Y", strtotime($ngayupdate['Connect']))?></span></div>
                            </div>
                            <div class="item_connect">
                                <button type="button" class="disconnect <?=($cauhinh['connect_server']) ? '' : 'active'?>">Kết nối đến hosting <i class="fa fa-cloud"></i></button>
                                <div class="last_update">Kết nối hosting lúc: <span class="ngayupdate"><?=date("H:i:s d/m/Y", strtotime($ngayupdate['Connect']))?></span></div>
                            </div>
                        </div>   
                    </div> 

                    <input type="hidden" name="CauHinhID" id="CauHinhID" value="<?=$cauhinh['CauHinhID']?>">
                    <div id="confim_connect">
                        <h2 class="title_popup">Xác nhận</h2>
                        <div class="wrapper_confim">
                            <p><b>Kết nối đến máy chủ <i class="fa fa-server"></i></b></p>
                            <div class='wrapper_content_disconnect'>
                                <div class="title_sync">Việc kết nối sẽ đồng bộ dữ liệu với máy chủ, bao gồm:</div>
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

                    <div id="confim_disconnect">
                        <h2 class="title_popup">Xác nhận</h2>
                        <div class="wrapper_confim">
                            <p><b>Kết nối đến hosting <i class="fa fa-cloud"></i></b></p>
                            <div class='wrapper_content_disconnect'>
                                <p class="title_sync_host">Tất các các dữ liệu sau sẽ được lưu trữ trên hosting</p> 
                                <ul class='content_disconnect'>
                                    <li>
                                        <p class="pull-left"><i class="fa fa-arrow-circle-o-right"></i> Thành viên mới</p>
                                    </li>
                                    <li>
                                        <p class="pull-left"><i class="fa fa-arrow-circle-o-right"></i> Đơn đặt hàng online</p>
                                    </li>
                                </ul>
                                <button type="button" id="ok_disconnect" class="btn btn-info" data-loading-text="Đang tiến hành kết nối..."  autocomplete="off">Đồng ý</button>
                                <button type="button" id="cancel_disconnect" class="btn btn-danger close_fancybox">Hủy</button>
                            </div>
                        </div>
                    </div>

                </fieldset>
 

                <!-- -------------------WebService-------------- -->
                <fieldset>
                    <legend>WebService:</legend>  
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="hostname">Hostname:</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control" id="hostname" name="hostname_webservice" value="<?=$cauhinh['hostname_webservice']?>">
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="port">Port:</label>
                        <div class="col-sm-10"> 
                            <input type="digrits" class="form-control" id="port" name="port_webservice" value="<?=$cauhinh['port_webservice']?>" maxlength="5">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="username_webservice">Username:</label>
                        <div class="col-sm-10"> 
                            <input type="digrits" class="form-control" id="username_webservice" name="username_webservice" value="<?=$cauhinh['username_webservice']?>" >
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="password_webservice">Password:</label>
                        <div class="col-sm-10"> 
                            <div class="input-group group_show_pass">
                                <input type="password" class="form-control" id="password_webservice" name="password_webservice"  value="<?=$cauhinh['password_webservice']?>">
                                <span class="input-group-btn"> 
                                    <button class="btn btn-default show_pass" id="show_pass_webservice" type="button"><i class="fa fa-eye"></i></a>
                                </span>
                            </div> 
                        </div> 
                    </div>  
                    <button type="button" class="btn btn-info" id="test_web_server">Kiểm tra kết nối <i class="fa fa-flash"> </i></button>
                </fieldset>
                <!-- -------------------WebService-------------- -->


                <!-- -------------------Fpt Server-------------- -->
                <fieldset> 
                    <legend>Fpt Server:</legend>                           
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="hostname">Hostname:</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control" id="hostname" name="hostname_ftp" value="<?=$cauhinh['hostname_ftp']?>">
                        </div>
                    </div>    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="port">Port:</label>
                        <div class="col-sm-10"> 
                            <input type="digrits" class="form-control" id="port" name="port_ftp" value="<?=$cauhinh['port_ftp']?>" maxlength="5">
                        </div>
                    </div>             
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="username_ftp">Username:</label>
                        <div class="col-sm-10"> 
                            <input type="text" class="form-control" id="username_ftp" name="username_ftp" value="<?=$cauhinh['username_ftp']?>">
                        </div>
                    </div>             
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="password_ftp">Password:</label>
                        <div class="col-sm-10"> 
                            <div class="input-group group_show_pass">
                                <input type="password" class="form-control" id="password_ftp" name="password_ftp"  value="<?=$cauhinh['password_ftp']?>">
                                <span class="input-group-btn"> 
                                    <button class="btn btn-default show_pass" id="show_pass" type="button"><i class="fa fa-eye"></i></a>
                                </span>
                            </div> 
                        </div> 
                    </div>      
                    <button type="button" class="btn btn-info" id="test_ftp_server">Kiểm tra kết nối <i class="fa fa-flash"> </i></button>
                    <div class="col-md-12 block_button_form">
                        <button type="submit" class="btn btn-info ok_add_edit ">Lưu thay đổi</button>
                    </div>      
                    <input type="hidden" name="CauHinhID" value="<?=$cauhinh['CauHinhID']?>">
                </fieldset>     
                <!-- -------------------Fpt Server-------------- -->

            </form> 
        </div><!-- inner_table_content_right -->
    </div><!-- table_content_right-->  
</aside>  
