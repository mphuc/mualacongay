<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hoadononline extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('hoadononline_model'); 
        $this->load->Model('loaisanpham_model');
        $this->load->Model('danhmuc_model');  
        $this->load->Model('hinhanh_model');  
        $this->load->Model('hoadononline_model');  
        $this->load->Model('member_model');  
        $this->load->Model('sanpham_model');  
    }
//-----------------------------ADMIN--------------------  

    public function echo_hoadononline_admin($hoadon,$offset){ 
        $t = ''; 
        // print_r($hoadon);
        if(!empty($hoadon)){  
            foreach ($hoadon as $item) {
                $MaHoaDon = (isset($item['MaHoaDon']) && is_null($item['MaHoaDon'])) ? $item['MaHoaDon'] : 'DDHBBS'.$item['HoaDonOnlineID'];
                $offset++;                    
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td>'.$MaHoaDon.'</td> 
                        <td>'.date("H:i:s d/m/Y", strtotime($item['Ngay'])).'</td> 
                        <td>'.number_format($item['TongTien'],'0',',','.').' VNĐ</td>';
                        // if( $this->main_lib->connect_server() ){
                            if( $item['TinhTrang'] == -1 ){
                                $tinhtrang = 'Đã hủy';
                            }else if( $item['TinhTrang'] == 2 ){
                                $tinhtrang = 'Đã chuyển hàng';
                            }else if( $item['TinhTrang'] == 1 ){
                                $tinhtrang = 'Đang chuyển hàng';
                            }else if( $item['TinhTrang'] == 0 ){
                                $tinhtrang = 'Chưa chuyển hàng';
                            }
                            $t.='<td>'.$tinhtrang.'</td>';
                        
                        if( $this->main_lib->connect_server() ){
                            $member = $this->member_model->chitiet_member_host_on_MemberID_server($item['MemberID']);
                        }else{
                            $member = $this->member_model->chitiet_member_host($item['MemberID']);
                        }
                        $t.='<td>'.$member['Ten'];
                        if($member['Is_Member'] == true){
                            $t.='<i class="notice_mem">( Member )</i>';
                        }else{
                            $t.='<i class="notice_mem">( Khách )</i>';
                        }
                        if( $item['PayMent'] == 1 ){
                            $payment = 'GDG';
                        }else if( $item['PayMent'] == 2 ){
                            $payment = 'BTC';
                        }
                        if( $item['ThanhToan'] == 0 ){
                            $ThanhToan = '<a href="'.base_url().'hoadononline/update_status_thanhtoan/'.$item['HoaDonOnlineID'].'"><span class="label label-danger">Chưa thanh toán</span></a>';
                        }else if( $item['ThanhToan'] == 1 ){
                            $ThanhToan = '<a href="'.base_url().'hoadononline/update_status_thanhtoan/'.$item['HoaDonOnlineID'].'"><span class="label label-success">Đã thanh toán</span></a>';
                        }
                        if( $item['GiaoHang'] == 0 ){
                            $GiaoHang = '<a href="'.base_url().'hoadononline/update_status_giaohang/'.$item['HoaDonOnlineID'].'"><span class="label label-danger">Chưa giao hàng</span></a>';
                        }else if( $item['GiaoHang'] == 1 ){
                            $GiaoHang = '<a href="'.base_url().'hoadononline/update_status_giaohang/'.$item['HoaDonOnlineID'].'"><span class="label label-success">Đã giao hàng</span></a>';
                        }
                        $t.='</td>
                        <td>'.$member['Phone'].'</td>'; 
                        $t.='<td class="text_center">
                                <a class="btn btn-primary btn_chitiet_hoadon fancybox" data-toggle="tooltip" data-placement="top" title="Xem chi tiết hóa đơn" HoaDonOnlineID="'.$item['HoaDonOnlineID'].'" href="'.base_url().'hoadononline/get_chitiet_hoadon/'.$item['HoaDonOnlineID'].'">
                                <i class="fa fa-eye"></i>
                                </a>
                            </td>
                           
                            <td class="text_center">
                                '.($ThanhToan).'
                            </td>
                            <td class="text_center">
                                '.($GiaoHang).'
                            </td>
                        </tr>'; 

            }  
        }else{
            $t.='<tr><td colspan="8">Không có đơn hàng!</td></tr>';
        }
        $t = mb_check_encoding($t, 'UTF-8') ? $t : utf8_encode($t);
        return $t;
    } 

    public function update_status_giaohang($HoaDonOnlineID=0)
    {

       $chitiethoadon = $this->hoadononline_model->get_info_hoadon_temp($HoaDonOnlineID);
       if ($chitiethoadon['GiaoHang'] == 0)
            $status = 1;
        else
            $status = 0;
        $data = array('GiaoHang' => $status);

        $this -> hoadononline_model -> update_hoadononline_giaohang($data,$HoaDonOnlineID);
        header('Location: '.base_url().'admin/hoadononline/');
    }
    public function update_status_thanhtoan($HoaDonOnlineID=0)
    {
       $chitiethoadon = $this->hoadononline_model->get_info_hoadon_temp($HoaDonOnlineID);
       if ($chitiethoadon['ThanhToan'] == 0)
            $status = 1;
        else
            $status = 0;
        $data = array('ThanhToan' => $status);

        $this -> hoadononline_model -> update_hoadononline_giaohang($data,$HoaDonOnlineID);
        header('Location: '.base_url().'admin/hoadononline/');
    }

    public function get_chitiet_hoadon($HoaDonOnlineID=0){
        $t=''; 
        $hoadon = $this->hoadononline_model->get_info_hoadon($HoaDonOnlineID);
        $MaHoaDon = (isset($hoadon['MaHoaDon']) && is_null($hoadon['MaHoaDon'])) ? $hoadon['MaHoaDon'] : 'DDHBBS'.$hoadon['HoaDonOnlineID'];
        
        if(!empty($hoadon)){
            $chitiethoadon = $this->hoadononline_model->get_chitiethoadon($HoaDonOnlineID); 
            $date = new DateTime($hoadon['Ngay']);
            $date = $date->format(" H:i -  d/m/Y");
            $t='<div class="wrapper_popup">
                    <h2 class="title_popup">Chi tiết hóa đơn</h2>
                    <div class="chitiet_hoadon">
                        <div class="left_hoadon">';
                        if( $this->main_lib->connect_server() ){
                            $member = $this->member_model->chitiet_member_host_on_MemberID_server($hoadon['MemberID']); 
                        }else{
                            $member = $this->member_model->chitiet_member_host($hoadon['MemberID']); 
                        }
                        if(!empty($member)){
                            $t.='<p><b>Khách hàng: </b>'.$member['Ten'].' - '.$member['Phone'].'</p>';
                        }else{
                            $t.='<p><b>Khách hàng:</b></p>';
                        }
                        $t.='<p><b>Ngày đặt: </b>'.$date.'</p>
                        </div>
                        <div class="right_hoadon">
                            <p><b>Mã đơn hàng: </b>'.$MaHoaDon.'</p>';
                            if( $hoadon['TinhTrang'] == -1 ){
                                $tinhtrang = 'Đã hủy';
                            }else if( $hoadon['TinhTrang'] == 1 ){
                                $tinhtrang = 'Đã chuyển hàng';
                            }else if( $hoadon['TinhTrang'] == 2 ){
                                $tinhtrang = 'Đang chuyển hàng';
                            }else if( $hoadon['TinhTrang'] == 0 ){
                                $tinhtrang = 'Chưa chuyển hàng';
                            }
                            $t.='<p><b>Tình trạng: </b>'.$tinhtrang .'</p>
                        </div>
                        <div class="content_popup">
                            <table>
                                <thead>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá x SL</th>
                                    <th>Thành tiền</th>
                                </thead>
                                <tbody>';
                                if(!empty($chitiethoadon)){ 
                                    if( $this->main_lib->connect_server() ){
                                        $dem = 1;
                                        foreach ($chitiethoadon as $item) {
                                            $sanpham_server = $this->sanpham_model->Chitiet_SanPham_server($item['SanPhamID']);
                                            $sanpham = $sanpham_server[0];
                                            $t.='<tr>
                                                    <td><i>'.$dem.'.</i></td>
                                                    <td><a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($sanpham["TenSP"])).'_'.$sanpham['SanPhamID'].'">'.$sanpham["TenSP"].' - '.$sanpham["MaSP"].'</a></td> 
                                                    <td>'.number_format($item['DonGia'],'0',',','.').' x '.$item['SoLuong'].'</td>
                                                    <td>'.number_format($item['ThanhTien'],'0',',','.').'</td>
                                                </tr> 
                                                ';
                                            $dem++;
                                        }
                                    }else{
                                        $dem = 1;
                                        foreach ($chitiethoadon as $item) {
                                            $t.='<tr>
                                                    <td><i>'.$dem.'.</i></td>
                                                    <td><a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($item["TenSP"])).'_'.$item['SanPhamID'].'">'.$item["TenSP"].' - '.$item["MaSP"].'</a></td> 
                                                    <td>'.number_format($item['DonGia'],'0',',','.').' x '.$item['SoLuong'].'</td>
                                                    <td>'.number_format($item['ThanhTien'],'0',',','.').'</td>
                                                </tr> 
                                                ';
                                            $dem++;
                                        } 
                                    }
                                }else{
                                    $t.='<tr><td colspan="4">Không có sản phẩm!</td></tr>';
                                }  
                        $t.='</tbody>
                        </table>
                     </div>
                    <div class="">
                        <p><b>Tổng tiền: </b>'.number_format($hoadon['TongTien'],'0',',','.').' VNĐ</p>
                        <p><b>Địa chỉ giao hàng: </b>'.$hoadon['DiaChiNhanHang'].'</p>
                    </div>
                </div>
            </div>';
        }else{
            $t.='<div class="wrapper_popup">
                    <h2 class="title_popup">Chi tiết hóa đơn</h2>
                    <div class="chitiet_hoadon">
                        <p class="bg_red"><i class="fa fa-warning"></i> Không có dữ liệu, vui lòng kiểm tra lại!</p>
                    </div>
                </div>';
        }
        echo $t;
    }
 

    public function thongke_hoadon(){
        $Nam = $_POST['Nam'];
        $result = $this->hoadononline_model->thongke_hoadononline($Nam);

        // foreach ($result as $item) {
        //     print_r($item);
        // }
        echo json_encode($result);
    }

// -----get sanpham-----------
    public function get_hoadononline_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $hoadon = $this->hoadononline_model->get_hoadononline_admin($number,$offset);        
        $list_sp = $this->echo_hoadononline_admin($hoadon,$offset);
        $count = $this->hoadononline_model->count_all_hoadononline();
        $result = array(
            'list_sp' => $list_sp,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_hoadononline_admin(){
        echo $this->hoadononline_model->count_all_hoadononline();
    }
// -----get sanpham-----------

// ---------------search------------------
    public function search_hoadononline_admin(){
        $key = $_POST['key'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $hoadon = $this->hoadononline_model->search_hoadononline_admin($key,$number,$offset);
        $list_search = $this->echo_hoadononline_admin($hoadon,$offset); 

        $count = $this->hoadononline_model->count_search_hoadononline_admin($key);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_search_hoadononline_admin(){
        $key = $_POST['key'];
        echo $this->hoadononline_model->count_search_hoadononline_admin($key);
    }
// ---------------search------------------
// ------------------filter-----------------
    public function filter_hoadononline_admin(){
        $val = $_POST['val'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->hoadononline_model->filter_hoadononline_admin($val,$number,$offset);
        $list_search = $this->echo_hoadononline_admin($sp,$offset); 
        $count = $this->hoadononline_model->count_filter_hoadononline_admin($val);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_filter_hoadononline_admin(){
        $val = $_POST['val'];
        echo $this->hoadononline_model->count_filter_hoadononline_admin($val);
    }
// ------------------filter-----------------

    public function update_tinhtrang(){
        $data = array( 
            'TinhTrang'=>$_POST['TinhTrang'], 
        );
        if($this->hoadononline_model->update_tinhtrang($data,$_POST['HoaDonOnlineID']))
            echo 1;
        else
            echo 0;
    }

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















