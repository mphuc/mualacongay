<aside class="wrapper_content_right"> 
    <h1 class="title_admin_right bg_title"><span class="fa fa-shopping-cart"></span> Đơn đặt hàng Online</h1>
    <div class="table_content_right">  
        <div class="inner_table_content_right">
            <div class="nav_item" > 
                <div class="nav_left_item">  
                    <form action="" class="form_search ac-custom ac-checkbox ac-checkmark" autocomplete="off"> 
                        <input type="text" class="form-control show_popup_form" id="input_search" value="" placeholder="Tìm kiếm...">
                        <span class="fa fa-times clear_search"></span>
                    </form> 

                    <form class="form_filter"> 
                        <p>Lọc theo:</p>
                        <label for="filter_on_loai">
                            <span class="wrapper_radio">
                                <input id="filter_on_loai" type="radio" value="1" name="filter" >
                                <label for="filter_on_loai"></label>
                            </span>Thành viên website
                        </label>
                        <label for="filter_on_loai2">
                            <span class="wrapper_radio">
                                <input id="filter_on_loai2" type="radio" value="0" name="filter" >
                                <label for="filter_on_loai2"></label>
                            </span>Khách mua hàng
                        </label> 
                        <label for="clear_filter">
                            <span class="wrapper_radio">
                                <input id="clear_filter" class="clear_filter" type="radio" name="filter">
                                <label for="clear_filter"></label>
                            </span>Tất cả
                        </label> 
                    </form>

                </div> 
                <div class="nav_right_item">
                    <div class="page_item">
                        <select id="selector_limit_item" class="selector_limit_item" > 
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
                <table id="member_admin" class="table_item " >
                    <thead>
                    <tr> 
                        <th></th> 
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>   
                        <th>Ngày sinh</th>
                        <th>Giới tính</th> 
                        <th>Địa chỉ</th> 
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
</aside> 