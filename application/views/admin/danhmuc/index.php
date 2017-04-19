<aside class="wrapper_content_right">  
    <h1 class="title_admin_right bg_title"><span class="fa fa-list"></span> Danh mục</h1>
    <div class="table_content_right"> 
        <div class="inner_table_content_right">
            <div class="nav_item" >  
                <div class="nav_left_item">
                    <div> 
                        <button type="button" title="Thêm sản phẩm mới" class="btn btn-info toggle_form_add_edit">Thêm danh mục mới <i class="fa fa-newspaper-o"></i></button>
                       
                    </div>
          
                </div> 
                <div class="clearfix"></div><br>
                <div class="nav_left_item">
                    <div class="page_item">
                        <select name="" class="selector_limit_item"> 
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>  
                            <!-- <option value="1000">1000</option>   -->
                        </select>
                        <div class="info_page_item">Hiện <i class="from_record"></i> <i class="fa fa-caret-right"></i> <i class="to_record"></i> của <i class="total_record"></i> dòng</div>
                    </div> 
                </div> 
                <div class="nav_right_item">
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
                     <!-- -----------PAGINATION----------- -->
                </div> <!-- nav_right_item -->
            </div> 
  
            <div class="wrapper_table_item">
                <table id="danhmuc_admin" class="table_item tablesorter" >
                    <thead>
                        <tr> 
                            <th>TT</th> 
                            <th>ID</th> 
                            <th>Tên danh mục</th>  
                            <th>Thứ tự</th> 
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
        </div><!-- inner_table_content_right -->
    </div><!-- table_content_right-->  

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
                    <div class="form_add_edit form_add form-horizontal"> 
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Tên danh mục:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="input_tieude" placeholder="Nhập tên danh mục ..." minlength="4" required>
                            </div>
                        </div>                           
                         <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Thứ tự:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" id="input_thutu" placeholder="Nhập số thứ tự danh mục ..." minlength="4" required>
                            </div>
                        </div>  
                        <div class="col-md-12 block_button_form">
                            <button type="submit" class="btn btn-info ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>
                            <button type="reset" class="btn btn-default toggle_form_add_edit">Hủy</button>
                        </div>
                    </div> 
            </div>
        </div><!-- inner_table_content_right -->
    </div><!-- form_content_right--> 
</aside>
