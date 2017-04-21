<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    private $quyen_admin;
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model');
        $this->load->Model('sanpham_model'); 
        $this->load->Model('danhmuc_model');
        $this->load->Model('loaisanpham_model'); 
        $this->load->Model('hoadononline_model'); 
        $this->load->Model('thongtin_model'); 
        $this->load->Model('cauhinh_model'); 
        $this->load->Model('ngayupdate_model');          
        $this->load->Model('email_model');          
        $this->load->Model('member_model');          
        $this->quyen_admin = $this->session->userdata("quyen_admin");
    }  
    public function get_now()
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("Y/m/d H:i:s"); 
        echo $date;
    }
    public function w_sidebar(){
        $w = $_POST['w_sidebar'];
        $data = array(
            'w_sidebar' => $w
        );
        $this->session->set_userdata($data);
        echo $w;
    } 

    public function status_system()
    {
        $result = array(
            "connect_server" => $this->main_lib->connect_server(),   
            "connect_server_ftp" => $this->main_lib->connect_ftp_server(),
        );
        echo json_encode($result);
    }

    public function index()
    {
        if( $this->session->userdata("login_admin") == 0 ){
            $this->load->view('admin/login');
        }else{
            $data['count_hoadon'] = $this->hoadononline_model->count_filter_hoadononline_admin(0);
            $data['count_sanpham'] = $this->sanpham_model->count_all_sp_admin();
            $data['count_danhmuc'] = $this->danhmuc_model->count_all_danhmuc_admin();
            $data['count_loaisp'] = $this->loaisanpham_model->count_all_loaisp_admin();

            $data['menuActive'] = 'tongquan';
            $data['title'] = 'Tổng quan';
            $data = array_merge($this->main_lib->get_data_admin() , $data);

            $this->load->view('admin/headerAdmin',$data);
            $this->load->view('admin/asideAdmin',$data);
            $this->load->view('admin/index',$data);
            $this->load->view('admin/footerAdmin');
        }
    }

    public function hoadononline_moinhat(){
        $hoadon = $this->hoadononline_model->hoadononline_moinhat_limit(10,0);
        $offset = 0;
        if(!empty($hoadon)){  
            $t = '<table class="table_item "> 
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Ngày</th>
                    <th>Tổng tiền</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>';  
            foreach ($hoadon as $item) {
                $offset++;            
                $date = new DateTime($item['Ngay']);
                $date = $date->format(" H:i -  d/m/Y");   
                $MaHoaDon = (isset($item['MaHoaDon']) && is_null($item['MaHoaDon'])) ? $item['MaHoaDon'] : 'DDHBBS'.$item['HoaDonOnlineID'];
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td>'.$MaHoaDon.'</td> 
                        <td>'.$date.'</td> 
                        <td>'.number_format($item['TongTien'],'0',',','.').' VNĐ</td>'; 
                        if( $this->main_lib->connect_server() ){
                            $member = $this->member_model->chitiet_member_host_on_MemberID_server($item['MemberID']);
                        }else{
                            $member = $this->member_model->chitiet_member_host($item['MemberID']);
                        }
                        if(!empty($member)){
                            $t.='<td>'.$member['Ten'];
                            if($member['Is_Member'] == 'true'){
                                $t.='<i class="notice_mem">( Member )</i>';
                            }else{
                                $t.='<i class="notice_mem">( Khách )</i>';
                            }
                            $t.='</td>
                            <td>'.$member['Phone'].'</td>'; 
                        }else{
                            $t.='<td></td><td></td>';
                        }
                        $t.='<td class="text_center">
                                <a class="btn btn-primary btn_chitiet_hoadon fancybox" data-toggle="tooltip" data-placement="top" title="Xem chi tiết hóa đơn" HoaDonOnlineID="'.$item['HoaDonOnlineID'].'" href="'.base_url().'hoadononline/get_chitiet_hoadon/'.$item['HoaDonOnlineID'].'">
                                <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>'; 
            }  
            $t.='</tbody>
            </table>';
        }else{
            $t='<p class="">Không có đơn hàng!</p>';
        }
        return $t;
    } 

    public function sanpham()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{ 
            if( $this->quyen_admin == 'SANPHAM' || $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'sanpham';
                $data['title'] = 'Sản phẩm';                        
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                $data['danhmuc'] = $this->danhmuc_model->get_danhmuc();
                //print_r($data['danhmuc']);die;
                $data['select_loaisp'] = $this->main_lib->get_select_loaisp();
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/sanpham/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    } 
    public function danhmuc()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{
            if( $this->quyen_admin == 'SANPHAM' || $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'danhmuc';
                $data['title'] = 'Danh mục';              
                $data['ngayupdate'] = $this->ngayupdate_model->get_ngayupdate(); 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/danhmuc/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    }        
    public function loaisanpham()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{ 
            if( $this->quyen_admin == 'SANPHAM' || $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'loaisanpham';
                $data['title'] = 'Loại sản phẩm';           
                $data['ngayupdate'] = $this->ngayupdate_model->get_ngayupdate(); 
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                $data['danhmuc'] = $this->danhmuc_model->get_danhmuc();
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/loaisanpham/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    }  
    public function binhluan()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{ 
            if( $this->quyen_admin == 'SANPHAM' || $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'binhluan';
                $data['title'] = 'Bình luận sản phẩm';  
                $data['email_default'] = $this->email_model->get_email_default(); 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/binhluan/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    }  
    public function address(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{ 
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'address';
                $data['title'] = 'Dữ liệu tỉnh thành';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/address/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);
                
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    }

    public function hoadononline()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{ 
            $data['menuActive'] = 'hoadononline';
            $data['title'] = 'Hóa đơn online'; 

            $data = array_merge($this->main_lib->get_data_admin() , $data);
            //print_r( $data); die;
            $this->load->view('admin/headerAdmin',$data);
            $this->load->view('admin/asideAdmin',$data);
            $this->load->view('admin/hoadononline/index',$data);
            $this->load->view('admin/footerAdmin');
        }
    } 
    
    public function thongke()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{  
            $data['menuActive'] = 'thongke';
            $data['title'] = 'Thống kê đơn hàng'; 
            $data = array_merge($this->main_lib->get_data_admin() , $data);

            $this->load->view('admin/headerAdmin',$data);
            $this->load->view('admin/asideAdmin',$data);
            $this->load->view('admin/thongke/index',$data);
            $this->load->view('admin/footerAdmin');
        }
    }     

    public function tintuc(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{
            print_r($this->quyen_admin);
            
            if( $this->quyen_admin == 'TINTUC' || $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'tintuc';
                $data['title'] = 'Tin tức'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/tintuc/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    }     

    public function mangxahoi()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{  
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'mangxahoi';
                $data['title'] = 'Mạng xã hội'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/mangxahoi/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    } 
     public function slide()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{  
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'slide';
                $data['title'] = 'Slide'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/slide/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    }     

    public function member()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{  
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'member';
                $data['title'] = 'Thành viên và khách hàng'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/member/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    }     


    public function lienhe()
    {
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{  
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'lienhe';
                $data['title'] = 'Liên hệ của khách hàng'; 
                $data['email_default'] = $this->email_model->get_email_default(); 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/lienhe/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    }    

    public function thongtin(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{   
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'thongtin';
                $data['title'] = 'Trang thông tin'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $data['ngayupdate'] = $this->ngayupdate_model->get_ngayupdate();
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/thongtin/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }                
        }
    } 

    public function quanlytrang(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{   
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'quanlytrang';
                $data['title'] = 'Quản lý trang'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data); 
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/quanlytrang/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }                
        }
    } 

    public function cauhinh(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{   
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'cauhinh';
                $data['title'] = 'Cấu hình'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $data['ngayupdate'] = $this->ngayupdate_model->get_ngayupdate();
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/cauhinh/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }
        }
    }     

    public function user(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{    
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'user';
                $data['title'] = 'Quản lí người dùng'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/user/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    } 

    public function email(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{    
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'email';
                $data['title'] = 'Tài khoản email'; 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/email/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    } 

    public function dongbo(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{    
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'dongbo';
                $data['title'] = 'Đồng bộ dữ liệu'; 
                $data['count_hoadon'] = $this->hoadononline_model->count_all_hoadononline_host(); 
                $data['count_member'] = $this->member_model->count_member_new(); 
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/dongbo/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    } 

    public function capnhat(){
        if( $this->session->userdata("login_admin") != 1 ){
            $this->load->view('admin/login');
        }else{    
            if( $this->quyen_admin == 'ADMIN' ){
                $data['menuActive'] = 'capnhat';
                $data['title'] = 'Cập nhật dữ liệu';  
                $data = array_merge($this->main_lib->get_data_admin() , $data);
    
                $data['select_loaisp'] = $this->main_lib->get_select_loaisp();
                $data['ngayupdate'] = $this->ngayupdate_model->get_ngayupdate();
                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('admin/capnhat/index',$data);
                $this->load->view('admin/footerAdmin');
            }else{
                $data['menuActive'] = '';
                $data['title'] = 'Không cho phép truy cập';
                $data = array_merge($this->main_lib->get_data_admin() , $data);

                $this->load->view('admin/headerAdmin',$data);
                $this->load->view('admin/asideAdmin',$data);
                $this->load->view('error/no_permission',$data);
                $this->load->view('admin/footerAdmin');
            }            
        }
    } 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















