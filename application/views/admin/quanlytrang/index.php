<aside class="wrapper_content_right"> 
    <h1 class="title_admin_right bg_title"><span class="fa fa-file-text-o"></span> Quản lý trang</h1>
    <div class="table_content_right">  

        <div class="inner_table_content_right"> 
            <fieldset id="thongtin_admin" > 
                <legend>Trang thông tin</legend>  
                <div class="wrapper_table_item">
                    <table class="table_item tablesorter" id="table_thongtin_admin" >
                        <thead>
                        <tr> 
                            <th></th> 
                            <th>Trang</th>  
                            <th>Tùy chỉnh</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>  
                                <td>1</td>
                                <td class="title_trang"><a href="<?=base_url()?>gioi-thieu-cua-hang.html">Giới thiệu cửa hàng</a></td>
                                <td class="text_center">              
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_thongtin toggle_form_add_edit" Trang = "GioiThieu" >
                                        <i class="fa fa-pencil"></i>
                                    </button> 
                                </td>
                            </tr> 
                            <tr>
                                <td>2</td>
                                <td class="title_trang"><a href="<?=base_url()?>lien-he.html">Thông tin liên hệ</a></td>
                                <td class="text_center">              
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_thongtin toggle_form_add_edit" Trang = "LienHe" >
                                        <i class="fa fa-pencil"></i>
                                    </button> 
                                </td>  
                            </tr>
                            <tr>
                                <td>3</td>
                                <td class="title_trang"><a href="<?=base_url()?>huong-dan-mua-hang.html">Hướng dẫn mua hàng</a></td>
                                <td class="text_center">              
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_thongtin toggle_form_add_edit" Trang = "HuongDanMuaHang" >
                                        <i class="fa fa-pencil"></i>
                                    </button> 
                                </td>  
                            </tr>
                            <tr>
                                <td>4</td>
                                <td class="title_trang">Bản đồ GoogleMap</td>
                                <td class="text_center">              
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_thongtin toggle_form_add_edit" Trang = "GoogleMap" >
                                        <i class="fa fa-pencil"></i>
                                    </button> 
                                </td>  
                            </tr>                         
                            <tr>
                                <td>5</td>
                                <td class="title_trang">Fanpage Like</td>
                                <td class="text_center">              
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_thongtin toggle_form_add_edit" Trang = "Fanpage_Like" >
                                        <i class="fa fa-pencil"></i>
                                    </button> 
                                </td>  
                            </tr>                          
                            <tr>
                                <td>7</td>
                                <td class="title_trang">Bản quyền Website</td>
                                <td class="text_center">              
                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_thongtin toggle_form_add_edit" Trang = "Copyright" >
                                        <i class="fa fa-pencil"></i>
                                    </button> 
                                </td>  
                            </tr>
                        </tbody>
                    </table> 
                </div> <!-- end wrapper_table_item -->
            </fieldset>
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
                    <form class="form_add_edit form-horizontal" > 
                        <fieldset > 
                            <legend class="title_trang_edit">Trang thông tin</legend>    
                            <div class="form-group type_input">
                                <input type="text" class="form-control" id="input_noidung" placeholder="..." minlength="4" required>
                            </div>      
                            <div class="form-group clear_both tinymce"> 
                                <textarea class="form-control editor" id="tinymce4_noidung"  minlength="4" required></textarea>                              
                            </div>        
                            <div class="col-md-12 block_button_form">
                                <button type="submit" class="btn btn-info ok_add_edit" data-loading-text="loading..." >Đồng ý</button>
                                <button type="reset" class="btn btn-default toggle_form_add_edit">Hủy</button>
                            </div>
                        </fieldset> 
                    </form> 
            </div>
        </div><!-- inner_table_content_right -->
    </div><!-- form_content_right--> 
</aside>
