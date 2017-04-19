<aside class="wrapper_content_right"> 
    <h1 class="title_admin_right bg_title"><span class="fa fa-newspaper-o"></span> Tin tức</h1>
    <div class="table_content_right">  
        <div class="inner_table_content_right">
            <div class="nav_item" > 
                <div class="nav_left_item">
                    <div> 
                        <!-- <button type="button" title="Cấu hình thông tin gửi mail" class="btn btn-info add_sp toggle_form_add_edit">Cấu hình thông tin gửi mail <i class="fa fa-cloud-upload"> </i></button> -->

                        <div type="submit" title="Xóa bình luận đã chọn" class="btn btn-danger btn_del_more disabled dropdown_togle">Xóa bình luận đã chọn <i class="fa fa-trash-o"></i>
                            <div class="dropdown_menu">
                                <p class="dropdown_title">Bạn có muốn xóa?</p>
                                <input type="button" class="btn btn-info ok_del_more_binhluan" value="Đồng ý">
                                <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                            </div>
                        </div> 
                    </div>
                    <!--
                    <form action="" class="form_search ac-custom ac-checkbox ac-checkmark" autocomplete="off"> 
                        <input type="text" class="form-control show_popup_form" id="input_search" value="" placeholder="Tìm kiếm...">
                        <span class="fa fa-times clear_search"></span>
                        <div class="popup_form popup_form_search">
                            <p class="">Tìm kiếm theo: </p> 
                            <label for="search_on_id">
                                <span class="wrapper_radio">
                                    <input id="search_on_id" type="radio" name="search" value="MaHoaDon">
                                    <label for="search_on_id"></label>
                                </span>Email người bình luận
                            </label>
                            <label for="search_on_tensp">
                                <span class="wrapper_radio">
                                    <input id="search_on_tensp" type="radio" name="search" checked value="Ten">
                                    <label for="search_on_tensp"></label>
                                </span>Số điện thoại
                            </label>
                            <label for="search_on_loaisp">  
                                <span class="wrapper_radio">
                                    <input id="search_on_loaisp" type="radio" name="search" value="Phone">
                                    <label for="search_on_loaisp"></label>
                                </span>Số điện thoại đặt hàng
                            </label> 
                            <button type="submit" class="submit_form_search btn btn-success">Tìm kiếm</button> 
                        </div>
                    </form> 
                    -->
                </div> 
                <div class="nav_right_item">
                    <div class="page_item">
                        <select name="" class="selector_limit_item" > 
                            <option value="5">5</option>
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option> 
                            <option value="50">50</option>
                            <option value="100">100</option>  
                            <!-- <option value="1000">1000</option>   -->
                        </select>
                        <div class="info_page_item">Hiện <i class="from_record"></i> <i class="fa fa-caret-right"></i> <i class="to_record"></i> của <i class="total_record"></i> dòng</div>
                    </div> 
                    <!-- -----------PAGINATION--------------  -->
                    <div class="pagination_sp1 pagination_item" > 
                        <span class="first_left"><i class="fa  fa-fast-backward"></i></span>
                        <span class="pre_left"><i class="fa fa-backward"></i></span>
                        <div class='paginator_p_wrap'>
                            <div class='paginator_p_bloc'> </div>
                        </div> 
                        <span class="next_right"><i class="fa fa-forward"></i></span>
                        <span class="last_right"><i class="fa fa-fast-forward"></i></span>
                        <!-- slider -->
                        <div class='paginator_slider' class='ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all'>
                            <a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>
                        </div> 
                    </div>  
                </div>
                 <!-- -----------PAGINATION----------- -->
            </div> 
            <div class="wrapper_table_item">
                <table id="binhluan_admin" class="table_item" >
                    <thead>
                    <tr> 
                        <th></th>
                        <th data-field="checkbox" class="th_check_all" data-switchable="false">
                            <span class="wrapper_label">
                                <input type="checkbox" id="checkbox_all" >
                                <label for="checkbox_all" data-toggle="tooltip" title="Chọn tất cả" data-placement="right"></label> 
                            </span>  
                        </th>
                        <th>Nội dung</th> 
                        <th>Người gửi / Email / SĐT</th>
                        <th>Hiển thị</th> 
                        <th>Tùy chỉnh</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>  
            </div>
            <!-- -----------PAGINATION----------- -->  
            <div class="pagination_sp2 pagination_item" > 
                <span class="first_left"><i class="fa  fa-fast-backward"></i></span>
                <span class="pre_left"><i class="fa fa-backward"></i></span>
                <div class='paginator_p_wrap'>
                    <div class='paginator_p_bloc'> </div>
                </div> 
                <span class="next_right"><i class="fa fa-forward"></i></span>
                <span class="last_right"><i class="fa fa-fast-forward"></i></span>
                <!-- slider -->
                <div class='paginator_slider' class='ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all'>
                    <a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>
                </div>
            </div> 
            <!-- -----------PAGINATION----------- --> 
        </div>   <!-- inner_table_content_right -->
    </div> <!-- table_content_right -->  

    <div class="form_content_right">  
        <div class="inner_table_content_right">
            <div class="nav_item" > 
                <div class="nav_left_item">
                    <div>
                        <button type="button" title="Quay lại" class="btn btn-info toggle_form_add_edit"><i class="fa  fa-arrow-left "></i> Quay lại</button>
                    </div>  
                </div> 
            </div> 
            <div class="wrapper_form_add_edit">   
                <!-- hiện thị form add hoặc edit -->
                    <form class="form_add_edit form-horizontal"> 
                        <fieldset> 
                            <legend>Trả lời bình luận qua email</legend> 
                            <div class="content_send_mail">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="password">Từ:</label>
                                    <div class="col-sm-10"> 
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="from_email" value="<?=(!empty($email_default)) ? $email_default['smtp_user'] : '' ?>" disabled>
                                            <span class="input-group-btn"> 
                                                <a href="<?=base_url()?>email/get_all_email" class="btn btn-default fancybox" data-toggle="tooltip" data-placement="left" title="Thay đổi email hệ thống"><i class="fa fa-envelope-o"></i></a>
                                            </span>
                                        </div> 
                                    </div> 
                                </div>   
                                <div class="form-group ">
                                    <label class="col-sm-2 control-label" for="input_tieude">Đến:</label>
                                    <div class="col-sm-10"> 
                                        <input type="text" class="form-control" id="to_mail" name="to_mail" placeholder="..." minlength="4" required disabled>
                                    </div>
                                </div> 
                                <div class="form-group ">
                                    <label class="col-sm-2 control-label" for="input_tieude">Tiêu đề:</label>
                                    <div class="col-sm-10"> 
                                        <input type="text" class="form-control" id="subject" name="subject" placeholder="..." minlength="4" required>
                                    </div>
                                </div>                           
                                <div class="form-group ">
                                    <label class="col-sm-2 control-label" for="message">Nội dung:</label>
                                    <div class="col-sm-10"> 
                                        <textarea class="form-control" id="message" placeholder="Nội dung email..."  minlength="4" required ></textarea>
                                    </div>
                                </div>        
                                <div class="col-md-12 block_button_form">
                                    <button type="submit" class="btn btn-info ok_send_mail" data-loading-text="loading..." autocomplete="off">Đồng ý</button>
                                    <button type="reset" class="btn btn-default toggle_form_add_edit">Hủy</button>
                                </div>
                            </div>
                        </fieldset>
                    </form> 
            </div>
        </div><!-- inner_table_content_right -->
    </div><!-- form_content_right--> 
</aside>
