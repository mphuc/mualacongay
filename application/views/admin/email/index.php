<aside class="wrapper_content_right"> 
    <h1 class="title_admin_right bg_title"><span class="fa fa-envelope"></span> Tài khoản email</h1>
    <div class="table_content_right">  
        <div class="inner_table_content_right">
            <div class="nav_item" > 
                <div class="nav_left_item">
                    <div> 
                        <button type="button" title="Thêm tài khoản email mới" class="btn btn-info add_email toggle_form_add_edit">Thêm tài khoản email mới <i class="fa fa-envelope"></i></button>
                        <div type="submit" title="Xóa bài viết đã chọn" class="btn btn-danger btn_del_more disabled dropdown_togle" id="btn_del_more_email">
                            Xóa đã chọn <i class="fa fa-trash-o"></i>
                            <div class="dropdown_menu">
                                <p class="dropdown_title">Bạn có muốn xóa?</p>
                                <input type="button" class="btn btn-info ok_del_more_email" value="Đồng ý">
                                <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                            </div>
                        </div>
                    </div>  
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
                <table id="email_admin" class="table_item" >
                    <thead>
                    <tr> 
                        <th></th>
                        <th data-field="checkbox" class="th_check_all" data-switchable="false">
                            <span class="wrapper_label">
                                <input type="checkbox" id="checkbox_all" >
                                <label for="checkbox_all" data-toggle="tooltip" title="Chọn tất cả" data-placement="right"></label> 
                            </span>  
                        </th>
                        <th>Protocol</th> 
                        <th>Smtp_host</th> 
                        <th>Smtp_port</th> 
                        <th>Smtp_user</th> 
                        <th>Mặc định</th> 
                        <th>Chỉnh sửa</th> 
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
                        <button type="button" title="Quay lại" class="btn btn-info toggle_form_add_edit"><i class="fa fa-arrow-left "></i> Quay lại</button>
                    </div>  
                </div> 
            </div> 
            <div class="wrapper_form_add_edit">   
                <!-- hiện thị form add hoặc edit -->
                    <form class="form_add_edit form-horizontal">                 
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="protocol">Protocol:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="protocol" name="protocol" minlength="2" required >
                            </div>
                        </div>                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="smtp_host">Smtp_host:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="smtp_host" name="smtp_host" minlength="2" required >
                            </div>
                        </div>                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="smtp_port">Smtp_port:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="smtp_port" name="smtp_port" minlength="2" required >
                            </div>
                        </div>                        
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="smtp_user">Smtp_user:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="smtp_user" name="smtp_user" minlength="2" required  autocomplete="off">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="smtp_pass">Smtp_pass:</label>
                            <div class="col-sm-10"> 
                                <div class="input-group group_show_pass">
                                    <input type="password" class="form-control" id="smtp_pass" name="smtp_pass" minlength="2" required  autocomplete="off">
                                    <span class="input-group-btn"> 
                                        <button class="btn btn-default show_pass" id="show_pass" type="button"><i class="fa fa-eye"></i></a>
                                    </span>
                                </div> 
                            </div> 
                        </div>   
                        <div class="col-md-12 block_button_form">
                            <button type="submit" class="btn btn-info ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>
                            <button type="reset" class="btn btn-default toggle_form_add_edit">Hủy</button>
                        </div>
                        <input type="hidden" name="EmailID" id="EmailID" val="">
                    </form> 
            </div>
        </div><!-- inner_table_content_right -->
    </div><!-- form_content_right--> 
</aside>
