<aside class="wrapper_content_right"> 
    <h1 class="title_admin_right bg_title"><span class="fa fa-info-circle"></span> Thông tin website</h1>
    <div class="table_content_right">  

        <div class="inner_table_content_right">
            <fieldset class="form-horizontal " id="form_thongtin">
                <legend>Thông tin cửa hàng</legend>    
                <div class="form-group">
                    <label class="col-sm-2 control-label" >Tên cửa hàng:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control TenCuaHang" value="<?=$thongtin['TenCuaHang']?>" >
                        <input type="hidden" class="form-control ThongTinID" value="<?=$thongtin['ThongTinID']?>" >
                    </div>
                </div>                
                <div class="form-group">
                    <label class="col-sm-2 control-label" >Địa chỉ:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control DiaChi" value="<?=$thongtin['DiaChi']?>">
                    </div>
                </div>             
                <div class="form-group">
                    <label class="col-sm-2 control-label" >Số điện thoại:</label>
                    <div class="col-sm-10">  
                        <input type="text" class="form-control SDT" value="<?=$thongtin['SDT']?>"> 
                    </div> 
                </div>                          
                <div class="form-group">
                    <label class="col-sm-2 control-label" >Email:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control Email" value="<?=$thongtin['Email']?>"  >
                    </div>
                </div>                        
                <div class="form-group">
                    <label class="col-sm-2 control-label" >Website:</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control Website" value="<?=$thongtin['Website']?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" >Thông tin khuyến mãi</label>
                    <div class="col-sm-10"> 
                        <input type="text" class="form-control khuyenmai" value="<?=$thongtin['khuyenmai']?>">
                    </div>
                </div>
                <div class="col-md-12 block_button_form">
                   <!--  <a href="#" class="btn btn-info fancybox" id="ok_update_thongtin">Cập nhật thông tin cửa hàng <i class="fa fa-cloud-upload"> </i></a> -->
                    <button type="submit" id="ok_update_thongtin" class="btn btn-info ok_add_edit" data-loading-text="loading..." autocomplete="off">Đồng ý</button>
                    <div class="last_update">Cập nhật lần cuối: <span><?=date("H:i:s d/m/Y", strtotime($ngayupdate['ThongTin']))?></span></div>
                </div>       
            </fieldset>          
        </div>   <!-- inner_table_content_right -->
    </div> <!-- table_content_right -->  
</aside>
