<?php
class Capnhat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('danhmuc_model');
        $this->load->Model('loaisanpham_model');
        $this->load->Model('sanpham_model');
    }

    public function load_danhmuc()
    {
    	if($this->input->post('server') == 1){
    		$icon = 'fa fa-cloud-upload';
    		$danhmuc = $this->danhmuc_model->all_danhmuc(); //-----load từ server
    	}else{
    		$icon = 'fa fa-refresh';
    		$danhmuc = $this->danhmuc_model->get_danhmuc(); //-----load từ website
    	}
    	$stt = 1;
    	$t='';
    	if(!empty($danhmuc) && is_array($danhmuc)){
	    	foreach ($danhmuc as $item) {
	    		$t.='<tr>
	    			<td class="text_center">
	                    <label for="radio_loaisanpham_'.$item['DanhMucID'].'">
	                        <span class="wrapper_radio">
	                            <input id="radio_danhmuc_'.$item['DanhMucID'].'" class="radio_danhmuc" type="radio" value="'.$item['DanhMucID'].'" name="radio_danhmuc" >
	                            <label for="radio_danhmuc_'.$item['DanhMucID'].'"></label>
	                        </span>
	                    </label>
	                </td>
	    			<td>
	                    <label for="radio_danhmuc_'.$item['DanhMucID'].'">
	    					'.$item['TenDanhMuc'].'
						</label>
					</td>
					<td class="text_center">
                        <a href="#confim_capnhat_theo_danhmuc" DanhMucID="'.$item['DanhMucID'].'" class="btn btn-info fancybox_element capnhat_theo_danhmuc"
                        	data-toggle="tooltip" data-placement="top" title="Cập nhật tất cả Loại sản phẩm và Sản phẩm theo Danh mục '.$item['TenDanhMuc'].'">
                        	<i class="'.$icon.'"></i>
                    	</a>
					</td>
	    		</tr>';
	    	}
	    }else{
            $t.='<tr><td colspan="8">Không có danh mục!</td></tr>';
	    }
	    $result = array(
	    	"count" => count($danhmuc),
	    	"list" => $t
    	);
    	echo json_encode($result);
    }

    public function load_loaisanpham()
    {
    	$DanhMucID = $this->input->post('DanhMucID');

    	if($this->input->post('server') == 1){
    		$icon = 'fa fa-cloud-upload';
    		$loaisanpham = $this->loaisanpham_model->loaisanpham_on_DanhMucID($DanhMucID); //-----load từ server
    	}else{
    		$icon = 'fa fa-refresh';
    		$loaisanpham = $this->loaisanpham_model->get_loaisp_on_danhmuc($DanhMucID); //-----load từ website
    	}

    	$stt = 1;
    	$t='';
    	if(!empty($loaisanpham)  && is_array($loaisanpham)){
	    	foreach ($loaisanpham as $item) {
	    		$t.='<tr>
	    			<td class="text_center">
	                    <label for="radio_loaisanpham_'.$item['LoaiSPID'].'">
	                        <span class="wrapper_radio">
	                            <input id="radio_loaisanpham_'.$item['LoaiSPID'].'" class="radio_loaisanpham" type="radio" value="'.$item['LoaiSPID'].'" name="radio_loaisanpham" >
	                            <label for="radio_loaisanpham_'.$item['LoaiSPID'].'"></label>
	                        </span>
	                    </label>
	                </td>
	    			<td>
	                    <label for="radio_loaisanpham_'.$item['LoaiSPID'].'">
	    					'.$item['TenLoaiSP'].'<br>
	    					<i>'.$item['MaLoaiSP'].'</i>
						</label>
					</td>
					<td class="text_center">
                        <a href="#confim_capnhat_theo_loaisanpham" LoaiSPID="'.$item['LoaiSPID'].'" class="btn btn-info fancybox_element capnhat_theo_loaisanpham"
                        	data-toggle="tooltip" data-placement="top" title="Cập nhật tất cả Sản phẩm theo Loại sản phẩm '.$item['TenLoaiSP'].'">
                        	<i class="'.$icon.'"> </i>
                    	</a>
					</td>
	    		</tr>';
	    	}
	    }else{
            $t.='<tr><td colspan="8">Không có loại sản phẩm!</td></tr>';
	    }
	    $result = array(
	    	"count" => count($loaisanpham),
	    	"list" => $t
    	);
    	echo json_encode($result);
    }

    public function load_sanpham()
    {
    	$LoaiSPID = $this->input->post('LoaiSPID');

    	if($this->input->post('server') == 1){
        	// $cauhinh = $this->cauhinh_model->get_cauhinh();
        	// $path_image = 'ftp://'.$cauhinh['username_ftp'].':'.$cauhinh['password_ftp'].'@'.$cauhinh['hostname_ftp'];
	        // $path_image.='/';
    		$icon = 'fa fa-cloud-upload';
    		$sanpham = $this->sanpham_model->all_sanpham_loaisanpham_server($LoaiSPID); //-----load từ server
    	}else{
    		$icon = 'fa fa-refresh';
    		$sanpham = $this->sanpham_model->all_sanpham_loaisanpham_host($LoaiSPID); //-----load từ website
	        // $path_image = PATH_IMAGE;
    	}

    	$stt = 1;
    	$t='';

    	// $list  = $this->main_lib->connect_ftp();
    	// foreach ($list as $hinh) {
    	// 	$t.= '<img class="imgsp_wrapper" src="'.$path_image.$hinh.'" >';
    	// }

    	if(!empty($sanpham)  && is_array($sanpham)){
			foreach ($sanpham as $item) {
				$t.='<tr>
		    			<td class="text_center">'.$stt.'</td>';
    					if($this->input->post('server') == 1){
			                $t.='<td colspan="3">'.$item['TenSP'].'<br>
					                	<b>'.$item['MaSP'].'</b>
			                	</td>';
	                	 }else{
	                	 	$t.='<td><img class="imgsp_wrapper" src="'.PATH_IMAGE.$item['SanPhamID'].TYPE_IMAGE.'" onerror="imgError(this)" ></td>
			                <td>
			                	<a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($item['TenSP'])).'_'.$item['SanPhamID'].'">
				                	'.$item['TenSP'].'<br>
				                	<b>'.$item['MaSP'].'</b>
			                	</a>
		                	</td>';
	                	 }
						$t.='<td class="text_center">
                        	<a href="#confim_sanpham" SanPhamID="'.$item['SanPhamID'].'" class="btn btn-info fancybox_element capnhat_sanpham"
	                        	data-toggle="tooltip" data-placement="top" title="Cập nhật thông tin Sản phẩm">
	                        	<i class="'.$icon.'"></i>
                        	</a>
						</td>
		    		</tr>';
				$stt++;
			}
	    }else{
            $t.='<tr><td colspan="8">Không có sản phẩm!</td></tr>';
	    }
    	$result = array(
	    	"count" => count($sanpham),
	    	"list" => $t,
    	);
    	echo json_encode($result);
    }

    public function get_select_loaisp()
    {
    	echo $this->main_lib->get_select_loaisp();
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















