<aside class="wrapper_content_right"> 
    <h1 class="title_admin_right bg_title"><span class="fa fa-dropbox"></span> Sản phẩm</h1>
    <div class="table_content_right">  
        <div class="inner_table_content_right">
        <div class="nav_item">
            <div class="nav_left_item">
                    <div> 
                        <button type="button" title="Thêm sản phẩm mới" class="btn btn-info toggle_form_add_edit">Sản phẩm mới <i class="fa fa-newspaper-o"></i></button>
                        <div type="submit" title="Xóa tin tức đã chọn" class="btn btn-danger btn_del_more disabled dropdown_togle" id="btn_del_more_sanpham">
                            Xóa đã chọn <i class="fa fa-trash-o"></i>
                            <div class="dropdown_menu">
                                <p class="dropdown_title">Bạn có muốn xóa?</p>
                                <input type="button" class="btn btn-info ok_del_more_sp" value="Đồng ý">
                                <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                            </div>
                        </div>
                    </div>
          
                </div> 
        </div>
            <div class="nav_item" >

                <div class="nav_left_item"> 
                    <form action="" class="form_search ac-custom ac-checkbox ac-checkmark" autocomplete="off"> 
                        <input type="text" class="form-control show_popup_form" id="input_search" value="" placeholder="Tìm kiếm...">
                        <span class="fa fa-times clear_search"></span>
                        <div class="popup_form popup_form_search">
                            <p class="">Tìm kiếm theo: </p> 
                            <label for="search_on_id">
                                <span class="wrapper_label">
                                    <input id="search_on_id" type="checkbox" value="MaSP">
                                    <label for="search_on_id"></label>
                                </span>Mã sản phẩm
                            </label>
                            <label for="search_on_tensp">
                                <span class="wrapper_label">
                                    <input id="search_on_tensp" type="checkbox" checked value="TenSP">
                                    <label for="search_on_tensp"></label>
                                </span>Tên sản phẩm
                            </label> 
                            <button type="submit" class="submit_form_search btn btn-success">Tìm kiếm</button> 
                        </div>
                    </form> 

                    <form class="form_filter"> 
                        <!--<label for="filter_on_hienthi">
                            <span class="wrapper_radio">
                                <input id="filter_on_hienthi" type="radio" value="1" name="filter" loai="Hiển thị" key="HienThiWeb" val="1">
                                <label for="filter_on_hienthi"></label>
                            </span>Hiện thị
                        </label>
                        <label for="filter_on_kohienthi">
                            <span class="wrapper_radio">
                                <input id="filter_on_kohienthi" type="radio" value="0" name="filter" loai="Không hiển thị" key="HienThiWeb" val="0">
                                <label for="filter_on_kohienthi"></label>
                            </span>Không hiện thị
                        </label> -->
                        <label for="filter_on_loaisp">
                            <span class="wrapper_radio">
                                <input id="filter_on_loaisp" class="clear_filter" name="filter" type="radio" key="LoaiSPID" >
                                <label for="filter_on_loaisp"></label>
                            </span>Tất cả
                        </label>
                        <div class="wrapper_filter_on_LoaiSPID">
                            <select id="filter_on_LoaiSPID" key="LoaiSPID">
                                <option value="0" selected>Chọn loại sản phẩm</option>
                                <?=$select_loaisp?>
                            </select>  
                        </div>
                    </form> 

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
                <table id="sp_admin" class="table_item tablesorter" >
                    <thead>
                    <tr> 
                        <th></th>
                        <th data-field="checkbox" class="th_check_all" data-switchable="false">
                            <span class="wrapper_label">
                                <input type="checkbox" id="checkbox_all" >
                                <label for="checkbox_all" data-toggle="tooltip" title="Chọn tất cả" data-placement="right"></label> 
                            </span>  
                        </th>
                        <th>Mã</th>
                        <th>Hình ảnh</th>
                        <th>Tên</th>
                        <th>Giá bán</th>   
                        <th>Chi tiết</th> 
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
                    <form class="form_add_edit form_add form-horizontal" name="myform" novalidate> 
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Tên sản phẩm:</label>
                            <div class="col-sm-10"> 
                                <input type="text" name="input_tieude" class="form-control" id="input_tieude" placeholder="Nhập tên sản phẩm..." minlength="4" required>
                            </div>
                        </div>   
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Mã sản phẩm:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" name="input_masp" id="input_masp" placeholder="Nhập mã sản phẩm..." minlength="4" required>
                            </div>
                        </div>   
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Giá sản phẩm:</label>
                            <div class="col-sm-10"> 
                                <input type="text" class="form-control" name="input_giasp" id="input_giasp" placeholder="Nhập giá sản phẩm..." minlength="4" required>
                            </div>
                        </div>   
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Số lượng sản phẩm:</label>
                            <div class="col-sm-10"> 
                                <input type="number" class="form-control" name="input_soluongsp" id="input_soluongsp" placeholder="Số lượng sản phẩm..." minlength="1" required>
                            </div>
                        </div>           
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="input_tieude">Danh mục sản phẩm:</label>
                            <div class="col-sm-10"> 
                                <select name="input_danhmuc" id="input_danhmuc" class="form-control" >
                                    <?php foreach ($danhmuc as $key => $value) { ?>
                                        <option value="<?php echo $value['LoaiSPID'];?>"><?php echo $value['TenLoaiSP'];?></option>
                                    <?php  } ?>
                                </select>
                                
                            </div>
                        </div>                    
                        <div class="form-group ">
                            <label class="col-sm-2 control-label" for="tinymce4_mota">Mô tả:</label>
                            <div class="col-sm-10"> 
                                <textarea class="form-control" id="tinymce4_mota" placeholder="Mô tả về sản phẩm..."  minlength="4" required ></textarea>
                            </div>
                        </div>
                        <div class="form-group clear_both">
                            <label class="col-sm-2 control-label">Nội dung:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control editor input_noidung" id="tinymce4_noidung"  minlength="4" required></textarea>                              
                            </div>
                        </div> 
                        
                       <!--  <div class="form-group "> 
                            <label class="col-sm-2 control-label">Hình ảnh:</label>
                            <div class="col-sm-10"> 
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fieldID" name="Image" required minlenght="3" placeholder="Đường dẫn hình ảnh...">
                                    <span class="input-group-btn"> 
                                        <a href="<?=base_url()?>kcfinder/browse.php?type=image" class="iframe-btn btn btn-default" type="button" onclick="openKCFinder()">
                                            Chọn ảnh...
                                        </a>
                                    </span>
                                </div> 
                                <div class="image_item"> 
                                    <img id="thumb_image" class="fancybox_image" src="<?=dataadmin_url?>img/notFound.png"> 
                                    <div class="btn_thumb_image close_thumb_image" data-toggle="tooltip" title="Xóa" data-placement="top"><i class="fa fa-times"></i></div>
                                </div>
                            </div> 
                        </div>        
 -->
                         <div class="form-group "> 
                            <label class="col-sm-2 control-label">Hình ảnh:</label>
                            <div class="col-sm-10" id="beforappen"> 
                                <div class="add_append_img">
                                    <a href="<?=base_url()?>kcfinder/browse.php?type=image" class="iframe-btn button_add_img" type="button" onclick="">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="img_append"></div>
                                
                            </div> 
                            
                        </div>  
                        <div class="clearfix"></div>
                        <div class="col-md-12 block_button_form">
                            <button type="submit" class="btn btn-info ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>
                            <button type="reset" class="btn btn-default toggle_form_add_edit">Hủy</button>
                        </div>
                    </form> 
            </div>
        </div><!-- inner_table_content_right -->
    </div><!-- form_content_right--> 
</aside>
<style type="text/css">
    .item_image_ap img{
        width: 150px;
        height: 150px;
        padding: 5px;
    }
     .item_image_ap{
        position: relative;
        width: 150px;
        height: 150px;
        float: left;
        margin-right: 10px;
        margin-bottom: 10px;
        z-index: 999;
    }
     .item_image_ap i{
        position: absolute;
        top: 0px;
        right: 0px;
        cursor: pointer;
        z-index: 9999999;
    }
    .img_append img.images_appen{
    width: 150px; 
    height: 150px;
    float: left;
    margin-right: 10px;
    margin-bottom: 10px;
    border: 1px solid #f3f3f3;
    padding: 5px;
}
.button_add_img.iframe-btn{
    width: 150px;
    height: 150px;
    float: left;
    margin-right: 10px;
    margin-bottom: 10px;
    border: 1px solid #efefef;
    text-align: center;
    background: #efefef;
    border-radius: 5px;
}
.button_add_img.iframe-btn i{
    font-size: 40px;
    color: #777;
    line-height: 145px;
    margin: 0 auto; 
    font-size: 37px;
}
</style>