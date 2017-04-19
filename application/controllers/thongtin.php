<?php
class thongtin extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->Model('mangxahoi_model');  
        $this->load->Model('thongtin_model');   
    } 

    // ================================== INDEX ===============================
    public function gioithieu()
    {
        $gioithieu = $this->thongtin_model->get_thongtin();
        $data['noi_dung_trang'] = $gioithieu['GioiThieu'];
        $data['title'] = 'Giới thiệu cửa hàng || Mua là có ngay';
        $data['sidebar'] = $this->main_lib->get_sidebar(); 
        $data['menuActive'] = 'gioithieu';
        $data = array_merge($this->main_lib->get_data_index() , $data);
        $data['product_new'] = $this->main_lib->get_product_new();
        $this->load->view('header',$data); 
        $this->load->view('aside',$data); 
        $this->load->view('thongtin/index',$data);
        $this->load->view('footer',$data); 
    }     

    public function lienhe()
    { 
        $data['thongtin'] = $this->thongtin_model->get_thongtin();
        $data['title'] = 'Liên hệ || Mua là có ngay';
        $data['menuActive'] = 'lienhe';
        $data['sidebar'] = $this->main_lib->get_sidebar(); 
        $data = array_merge($this->main_lib->get_data_index() , $data);
        $data['product_new'] = $this->main_lib->get_product_new();
        $this->load->view('header',$data); 
        $this->load->view('aside',$data); 
        $this->load->view('thongtin/lienhe',$data);
        $this->load->view('footer',$data); 
    } 

    public function huongdanmuahang()
    { 
        $gioithieu = $this->thongtin_model->get_thongtin();
        $data['noi_dung_trang'] = $gioithieu['HuongDanMuaHang'];
        $data['title'] = 'Hướng dẫn mua hàng || Mua là có ngay';
        $data['sidebar'] = $this->main_lib->get_sidebar(); 
        $data['menuActive'] = 'huongdanmuahang';
        $data = array_merge($this->main_lib->get_data_index() , $data);

        $this->load->view('header',$data); 
        $this->load->view('aside',$data); 
        $this->load->view('thongtin/index',$data);
        $this->load->view('footer',$data); 
    } 
    //-----------------------------ADMIN trang thong tin--------------------  
 
    public function edit_thongtin(){    
        $data = array(  
            $this->input->post('Trang')=>$this->input->post('NoiDung'),  
        );
        if($this->thongtin_model->update_thongtin($data) )
            echo 1;
        else
            echo 0;
    }   

    public function get_chitiet_thongtin_admin(){
        $Trang = $this->input->post('Trang');
        $t = $this->thongtin_model->get_thongtin_admin();
        echo $t[$Trang];
    }
    //-----------------------------ADMIN trang thong tin--------------------  

    //-----------------------------ADMIN thong tin cua hang--------------------  
    public function get_thongtin_admin(){
        $thongtin = $this->thongtin_model->get_thongtincuahang();
        $stt=0;
        $t='<div class="wrapper_popup">
                <h2 class="title_popup">Thông tin cửa hàng</h2>
                <div class="content_popup">
                    <p>Chọn <b>thông tin của hàng </b>mà bạn muốn cập nhật:</p>
                    <table class="list_thongtincuahang">
                        <thead>
                            <th>STT</th>
                            <th>Tên cửa hàng</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Chọn</th>
                        </thead>
                        <tbody>';
                        if(!empty($thongtin)){ 
                            foreach ($thongtin as $item) {
                                $t.='<tr>
                                    <td>'.$stt.'</td>
                                    <td>'.$item['TenCuaHang'].'</td>
                                    <td>'.$item['DiaChi'].'</td>
                                    <td>'.$item['SDT'].'</td>
                                    <td>'.$item['Email'].'</td>
                                    <td>'.$item['Website'].'</td>
                                    <td class="text_center"> 
                                        <span class="wrapper_radio">
                                            <input id="thongtin_'.$item['ThongTinID'].'" type="radio" name="thongtin" value="'.$item['ThongTinID'].'">
                                            <label for="thongtin_'.$item['ThongTinID'].'"></label>
                                        </span> 
                                    </td>
                                </tr>';
                                $stt++;
                            }
                        }else{
                            $t.='<tr><td colspan="4">Không có thông tin về cửa hàng!</td></tr>';
                        }  
                $t.='</tbody>
                </table>
             </div>
             <div class="wrapper_confim">
                <p class="alert_update_sanpham">Việc cập nhật sẽ xóa hoàn toàn dữ liệu cũ, bạn có chắc muốn tiến hành cập nhật ?</p>
                <button id="ok_update_thongtin" disabled class="btn btn-info" data-loading-text="Đang tiến hành cập nhật..."  autocomplete="off">Cập nhật</button>
                <button id="cancel_update_thongtin" class="btn btn-danger close_fancybox">Hủy</button>
            </div>
        </div>';

        echo $t;
    }
    //-----------------------------ADMIN thong tin cua hang--------------------  

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















