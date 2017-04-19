<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model');  
        $this->load->Model('danhmuc_model');  
        $this->load->Model('loaisanpham_model');  
        $this->load->Model('member_model');  
        $this->load->Model('address_model');  
        $this->load->Model('hoadononline_model');  
        $this->load->Model('mangxahoi_model');  
        $this->load->Model('tintuc_model');
        $this->load->Model('email_model');
        $this->load->Model('thongtin_model');
    }

    public function index(){  
        if( $this->session->userdata("login_member") == 0 ){
            redirect('member/login','refresh');
        }else{
            $data['menuActive'] = 'info';
            $data['title'] = 'Trang chủ || Mua là có ngay';

            $data['tinhtp'] = $this->address_model->get_tinhtp();
     
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['chitiet_member'] = $this->member_model->chitiet_member($this->session->userdata("id_member"));
 
            $XaPhuongID = $data['chitiet_member']['XaPhuongID'];  
            if($XaPhuongID != 0){
                $address = $this->address_model->get_address_on_xaphuong($XaPhuongID);
                $data['TinhTPID'] = $address['TinhTPID'];
            } 
            $data['product_new'] = $this->main_lib->get_product_new();
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data);
            $this->load->view('member/aside',$data);
            $this->load->view('member/index',$data);
            $this->load->view('footer',$data); 
        } 
    }  	

    public function signup(){ 
        $data['menuActive'] = 'home';
        $data['title'] = 'Đăng ký làm thành viên || Mua là có ngay'; 
        $data['sidebar'] = $this->main_lib->get_sidebar();
        $captcha = $this->main_lib->create_captcha();
        $this->session->set_userdata('captcha_signup',$captcha['word']); 
        $data['captcha'] = $captcha['image']; 

        $data = array_merge($this->main_lib->get_data_index() , $data);

        $this->load->view('header',$data); 
        $this->load->view('aside',$data);
        $this->load->view('member/signup',$data);
        $this->load->view('footer',$data); 
    }   

    public function reload_captcha_signup(){
        $captcha = $this->main_lib->create_captcha();
        $this->session->set_userdata('captcha_signup',$captcha['word']); 
        echo $captcha['image'];
    }

    public function signup_member(){  
        $check = 0;
        $captcha_signup = $this->input->post('captcha_signup');
        if( strtolower($captcha_signup) == strtolower($this->session->userdata('captcha_signup')) ){
            $NgaySinh = date_create($_POST['Years'].'-'.$_POST['Months'].'-'.$_POST['Days']);
            $NgaySinh = date_format($NgaySinh,"Y-m-d");

            //-------kiểm tra Member, để sau này đồng bộ xuống server--------
            ( $this->main_lib->connect_server() ) ? $New_Member = 0 : $New_Member = 1;

            $data=array(
                "Ten" => $_POST['Ten'],
                "DiaChi" => null, 
                "NgaySinh" => $NgaySinh,
                "Email" => $_POST['Email'], 
                "Phone" => $_POST['Phone'], 
                "Username" => $_POST['Username'],
                "Password" => sha1($_POST['Password']),              
                "GioiTinh" => $_POST['GioiTinh'],
                "XaPhuongID" => NULL,  
                "Is_Member" => true,  
                "New_Member" => $New_Member,  
            );
            $MemberID = $this->member_model->insert_member_host($data);
            if( $this->main_lib->connect_server() ){
                $MemberID_Server = $this->member_model->insert_member_server($data);
                $this->member_model->update_member_host(array("MemberID_Server"=>$MemberID_Server),$MemberID);
                // print_r($MemberID_Server);
            } 

            if( is_numeric($MemberID) ){  
                if(isset($MemberID_Server)){
                    if(!is_numeric($MemberID_Server)){ 
                        $this->member_model->delete_member($MemberID); // ---------nếu insert server lỗi thì xóa member đã insert trên host
                        $check = 1;
                        echo -1;
                    }
                }
                if($check == 0){
                    $data2 = array(
                        "username_member" => $_POST['Username'],
                        "id_member" => $MemberID, 
                        "id_server_member" => isset($MemberID_Server) ? $MemberID_Server : 0, 
                        "pass_member" => sha1($_POST['Password']), 
                        "login_member" => 1,
                        "token_member" => uniqid('token_',true)
                    );
                    $this->session->set_userdata($data2); 

                    //---xóa session của KhachOnline
                    $item = array(
                        'login_khachonline' => 1, 
                    );
                    $this->session->unset_userdata($item);
                    
                    //---thêm sản phẩm trong session cart vào bảng tạm---
                    $this->add_cart_from_session();
                    echo 1;
                }
            }else{
                echo -1;
            } 
        }else{
            echo -2;
        }
    }

    public function check_username_email(){
        $Username = $this->input->post('Username');
        $check_username = $this->member_model->check_username($Username); 

        $Email = $this->input->post('Email');
        $check_email = $this->member_model->check_email($Email);
        $result = array(
            "check_username"=>$check_username,
            "check_email"=>$check_email,
        );
        echo json_encode($result);
    }
    // ========================= ĐĂNG NHẬP ================
    public function login(){ 
        // if( $this->session->userdata("login_member") == 1 ){
        //     redirect('member','refresh');
        // }else{
            $data['menuActive'] = 'home';
            $data['title'] = 'Đăng nhập || Mua là có ngay'; 
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data); 
            $this->load->view('aside',$data);
            $this->load->view('member/login',$data);
            $this->load->view('footer',$data); 
        // }
    }   

    public function login_member(){     
        $Username = $_POST['Username'];
        $Password = sha1($_POST['Password']); 

        $result_login = $this->member_model->login_member($Username,$Password);

        // print_r($result_login);

        if( !empty($result_login) ){ 
            $user = $result_login;
            $data2 = array(
                "username_member" => $user['Username'],
                "id_member" => $user['MemberID'], 
                "id_server_member" => $user['MemberID_Server'], 
                "pass_member" => $user['Password'], 
                "login_member" => 1,
                "token_member" => uniqid('token_',true)
            );
            $this->session->set_userdata($data2); 

            //---xóa session của KhachOnline
            $item = array(
                'login_khachonline' => 1, 
            );
            $this->session->unset_userdata($item);

            //---thêm sản phẩm trong session cart vào bảng tạm---
            $this->add_cart_from_session(); 
            echo 1;
        }else{
            echo -1;
        } 
    }
 
    public function add_cart_from_session(){
        $cart = $this->cart->contents();
        if(count($cart) != 0){
            $Token = $this->session->userdata('token_member');
            $hoadon = $this->hoadononline_model->check_token($Token);
            if( empty($hoadon) ){
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $date= date("Y/m/d H:i:s"); 
                $data1=array( 
                    "TongTien" => $this->cart->total(),   
                    "Ngay" => $date,   
                    "MemberID" => $this->session->userdata('id_member'),    
                    "Is_HoaDon" => false,
                    "Token" => $Token,
                ); 
                $HoaDonOnlineID = $this->hoadononline_model->insert_hoadononline_temp($data1);  
            }else{
                $data2=array( 
                    "TongTien" => $this->cart->total(),   
                ); 
                $HoaDonOnlineID = $hoadon['HoaDonOnlineID'];
                $this->hoadononline_model->update_hoadononline_temp($data2,$HoaDonOnlineID);  
            }         

            foreach ($cart as $item){ 
                $SanPhamID = $item['id']; 
                $chitiethoadon = $this->hoadononline_model->check_sp_chitiethoadon($HoaDonOnlineID,$SanPhamID);
                if( empty($chitiethoadon) ){ 
                    $data2=array( 
                        "SanPhamID" => $item['id'] ,  
                        "SoLuong" => $item['qty'] ,   
                        "DonGia" => $item['giaban'] ,   
                        "Thue" => $item['thue'] ,   
                        "ThanhTien" => $item['subtotal'],   
                        "HoaDonOnlineID" => $HoaDonOnlineID ,
                    ); 
                    $this->hoadononline_model->insert_chitiethoadononline_temp($data2);  
                }else{
                    $data2=array(  
                        "SoLuong" => $item['qty'] ,   
                        "ThanhTien" => $item['subtotal'],   
                    ); 
                    $ChiTietOnlineID  = $chitiethoadon['ChiTietOnlineID'];
                    $this->hoadononline_model->update_chitiethoadononline_temp($data2,$ChiTietOnlineID);  
                }   
            }
        }
    }

    // ========================= RESET PASSWORD ================
    public function reset(){ 
        // if( $this->session->userdata("login_member") == 1 ){
            // redirect('member','refresh');
        // }else{
            $data['menuActive'] = 'home';
            $data['title'] = 'Quên mật khẩu || Mua là có ngay'; 
            $data['sidebar'] = $this->main_lib->get_sidebar(); 

            $captcha = $this->main_lib->create_captcha();
            $this->session->set_userdata('captcha_reset_password',$captcha['word']); 
            $data['captcha'] = $captcha['image']; 

            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data); 
            $this->load->view('aside',$data);
            $this->load->view('member/reset',$data);
            $this->load->view('footer',$data); 
        // }
    }   

    public function reset_password(){
        $email = $this->security->xss_clean($this->input->post('email')); 
        $captcha = $this->input->post('captcha') ; 
        if( strtolower($captcha) == strtolower($this->session->userdata('captcha_reset_password')) ){
            $check_email = $this->member_model->get_email_reset($email);
            if(!empty($check_email)){
                $email_default = $this->email_model->get_email_default(); 
                if(!empty($email_default)){
                    $thongtin = $this->thongtin_model->get_thongtin();
                    $config['protocol'] = $email_default['protocol'];
                    $config['smtp_host'] = $email_default['smtp_host'];
                    $config['smtp_port'] = $email_default['smtp_port'];
                    $config['smtp_user'] = $email_default['smtp_user']; 
                    $config['smtp_pass'] = $email_default['smtp_pass'];
                    $config['charset'] = "utf-8";
                    $config['mailtype'] = "html";
                    $config['newline'] = "\r\n";

                    $token_reset = uniqid('reset_');
                    $message = 'Chúng tôi được biết rằng bạn mất mật khẩu đăng nhập '.$thongtin['Website'].'<br><br>Bạn hãy theo đường dẫn sau để tiến hành reset mật khẩu:<br><br>
                    <a href="'.base_url().'member/confim_reset/'.$token_reset.'">'.base_url().'member/confim_reset/'.$token_reset.'</a><br><br>
                    Bạn có thể yêu cầu reset mật khẩu tại <a href="'.base_url().'member/reset.html">'.base_url().'reset.html</a><br><br>
                    Xin cảm ơn!<br><br>';

                    $this->load->library('email');
                    $this->email->initialize($config); 
                    $this->email->from( $email_default['smtp_user']);
                    $this->email->to( trim($email) ); 
                    $this->email->subject( '['.$thongtin['Website'].'] Reset mật khẩu của bạn');
                    $this->email->message( $message );
                    $result = $this->email->send();
                    if($result){ 
                        $insert_token = $this->member_model->update_member_host(array('token_reset'=>$token_reset), $check_email['MemberID']);
                        if($insert_token){
                            $this->session->unset_userdata('captcha_reset_password');
                            echo 1;
                        }else{
                            echo 0;
                        } 
                    }else{
                        echo 0;
                    } 
                }else{
                    echo 0;
                }
            }else{
                echo -2;
            }
        }else{
            echo -1;
        }
    }

    public function confim_reset($token_reset=0){  //-----------chuyến đến trang confim_reset khi nhấp vào link có token_reset
        $token_reset = $this->security->xss_clean($token_reset);
        $member = $this->member_model->get_token_reset($token_reset);
        if(!empty($member)){
            $data['menuActive'] = 'home';
            $data['title'] = 'Reset mật khẩu || Mua là có ngay'; 
            $data['sidebar'] = $this->main_lib->get_sidebar();  
            $data['member'] = $member;  
            $data['token_reset'] = $token_reset;  
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data); 
            $this->load->view('aside',$data);
            $this->load->view('member/confim_reset',$data);
            $this->load->view('footer',$data); 
        }else{
            redirect(); 
        }
    } 

    public function set_password_reset(){ // ------------ đặt lại mật khẩu---
        $token_reset =  $this->input->post('token_reset');
        $Password = sha1($this->input->post('Password')); 

        if( $this->main_lib->connect_server() ){ 
            $member = $this->member_model->get_token_reset($token_reset);
            if(!empty($member)){
                $data = array(
                    "Password"=>$Password,
                    "token_reset"=>''
                );
                $result_update = $this->member_model->update_member_host($data,$member['MemberID']);
                $member_host = $this->member_model->chitiet_member_host($member['MemberID']);
                $result_update_2 = $this->member_model->update_password_member_server($Password,$member_host['MemberID_Server']);

                if($result_update && $result_update_2 ){
                    $data = array( 
                        "pass_member" => $Password,  
                    );
                    $this->session->set_userdata($data); 
                    echo 1;
                } 
            }else{
                echo -1;
            }
        }else{
            echo 0;
        }
    }

    public function reload_captcha_reset_password(){
        $captcha = $this->main_lib->create_captcha();
        $this->session->set_userdata('captcha_reset_password',$captcha['word']); 
        echo $captcha['image'];
    }
    // =========================  RESET PASSWORD ================

    public function logout(){
        $item = array(
            'login_member' => '', 
            "username_member" => '',
            "id_member" => '', 
            "pass_member" => '', 
            "login_member" => '',
            "token_member" => ''
        );
        $this->session->unset_userdata($item); 

        redirect(); 
    }   

    public function update_member(){ 
        if( $this->main_lib->connect_server() == 1 ){
            $NgaySinh = date_create($_POST['Years'].'-'.$_POST['Months'].'-'.$_POST['Days']);
            $NgaySinh = date_format($NgaySinh,"Y-m-d");
            $data=array(
                "Ten" => $_POST['Ten'],
                "DiaChi" => $_POST['DiaChi'], 
                "NgaySinh" => $NgaySinh,
                "Email" => $_POST['Email'], 
                "Phone" => $_POST['Phone'],  
                "GioiTinh" => $_POST['GioiTinh'],  
                "XaPhuongID" => $_POST['XaPhuongID'],  
                "Is_Member" => true,  
            );
            $result_server = $this->member_model->update_member_server($data,$_POST['MemberID_Server']);
            $result_host = $this->member_model->update_member_host($data,$_POST['MemberID']);

            echo ($result_server == 1 && $result_host == 1) ? 1 : -1;
        }else{
            echo 0;
        }
    }

    public function history(){  
        if( $this->session->userdata("login_member") == 0 ){
            redirect('member/login','refresh');
        }else{
            $data['menuActive'] = 'history';
            $data['title'] = 'Lịch sử mua hàng || Mua là có ngay'; 
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['chitiet_member'] = $this->member_model->chitiet_member($this->session->userdata("id_member"));
            $data['hoadononline'] = $this->get_history();
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data);
            $this->load->view('member/aside',$data);
            $this->load->view('member/history',$data);
            $this->load->view('footer',$data); 
        } 
    }   

    public function get_history(){
        if( $this->main_lib->connect_server() ){
            $hoadononline = $this->hoadononline_model->get_hoadononline_on_member($this->session->userdata("id_server_member"));
        }else{
            $hoadononline = $this->hoadononline_model->get_hoadononline_on_member($this->session->userdata("id_member"));
        }
        $t='';
        if(!empty($hoadononline)){ 
            $dem = 1;
            foreach ($hoadononline as $item) {
                $date = new DateTime($item['Ngay']);
                $date = $date->format(" H:i -  d/m/Y");
                $MaHoaDon = (isset($item['MaHoaDon']) && is_null($item['MaHoaDon'])) ? $item['MaHoaDon'] : 'DDHBBS'.$item['HoaDonOnlineID'];
                $t.='<tr class="item" HoaDonOnlineID="'.$item["HoaDonOnlineID"]  .'">
                        <td>'.$dem.'</td>
                        <td>'.$MaHoaDon.'</td>
                        <td>'.$date.'</td>
                        <td>'.$item["TinhTrang"].'</td>
                        <td>'.number_format($item['TongTien'],'0',',','.').'</td>
                    </tr>
                    <tr class="detail detail_'.$item["HoaDonOnlineID"].'">
                        <td colspan="5" class="row_table">
                            <div class="wrapper_table_chitiet">
                                <table class="table_chitiet">
                                    <thead>
                                        <td>STT</td>
                                        <td>Sản phẩm</td>
                                        <td>Đơn giá x SL</td>
                                        <td>Thành Tiền</td>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>';
                $dem++;
            }
        }else{
            $t.='<tr><td colspan="5">Không có đơn hàng!</td></tr>';
        }
        return $t;
    }

    public function get_chitiethoadon(){
        $HoaDonOnlineID = $_POST['HoaDonOnlineID'];
        $chitiethoadon = $this->hoadononline_model->get_chitiethoadon($HoaDonOnlineID);
        $info_hoadon = $this->hoadononline_model->get_info_hoadon($HoaDonOnlineID);
        $t='';
        // print_r($chitiethoadon);
        if(!empty($chitiethoadon)){ 
            if( $this->main_lib->connect_server() ){
                $dem = 1;
                foreach ($chitiethoadon as $item) {
                    $sanpham = $this->sanpham_model->get_chitiet_SanPham($item['SanPhamID']);
                    $giaban = round($item['DonGia'] + $item['DonGia']*$item['Thue']/100 , -3);
                    $t.='<tr>
                            <td><i>'.$dem.'.</i></td>
                            <td><a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($sanpham["TenSP"])).'_'.$sanpham['SanPhamID'].'">'.$sanpham["TenSP"].' - '.$sanpham["MaSP"].'</a></td> 
                            <td>'.number_format($giaban,'0',',','.').' x '.$item['SoLuong'].'</td>
                            <td>'.number_format($item['ThanhTien'],'0',',','.').'</td>
                        </tr> 
                        ';
                    $dem++;
                } 
            }else{ 
                $dem = 1;
                foreach ($chitiethoadon as $item) {
                    $giaban = round($item['DonGia'] + $item['DonGia']*$item['Thue']/100 , -3);
                    $t.='<tr>
                            <td><i>'.$dem.'.</i></td>
                            <td><a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($item["TenSP"])).'_'.$item['SanPhamID'].'">'.$item["TenSP"].' - '.$item["MaSP"].'</a></td> 
                            <td>'.number_format($giaban,'0',',','.').' x '.$item['SoLuong'].'</td>
                            <td>'.number_format($item['ThanhTien'],'0',',','.').'</td>
                        </tr> 
                        ';
                    $dem++;
                }
            }
            $t.='<tr><td colspan="4"><b>Địa chỉ nhận hàng:</b> '.$info_hoadon['DiaChiNhanHang'].'</td></tr> 
                <tr><td colspan="4"><b>Giá Ship:</b> '.number_format($info_hoadon['GiaShip'],'0',',','.').' VNĐ</td></tr>';
        }else{
            $t.='<tr><td colspan="5">Không có sản phẩm!</td></tr>';
        }
        echo $t; 
    }

    // ===================== change ===================
    public function change(){ 
        if( $this->session->userdata("login_member") == 0 ){
            redirect('member/login','refresh');
        }else{
            $data['menuActive'] = 'change';
            $data['title'] = 'Đổi mật khẩu || Mua là có ngay'; 
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data);
            $this->load->view('member/aside',$data);
            $this->load->view('member/change',$data);
            $this->load->view('footer',$data); 
        } 
    }

    public function change_password(){
        $Old_password = sha1($_POST['Old_password']);
        $Password = sha1($_POST['Password']); 

        if( $this->main_lib->connect_server() ){
            if($Old_password != $this->session->userdata("pass_member")){
                echo -1;
            }else{ 
                $result_update = $this->member_model->update_password_member_host($Password,$this->session->userdata("id_member"));
                $member_host = $this->member_model->chitiet_member_host($this->session->userdata("id_member"));
                $result_update_2 = $this->member_model->update_password_member_server($Password,$member_host['MemberID_Server']);

                if($result_update && $result_update_2 ){
                    $data = array( 
                        "pass_member" => $Password,  
                    );
                    $this->session->set_userdata($data); 

                    echo 1;
                }
            }
        }else{
            echo 0;
        }
    }

    // ===============================temp==============================
    public function temp(){ 
        if( $this->session->userdata("login_member") == 0 ){
            redirect('member/login','refresh');
        }else{
            $data['menuActive'] = 'temp';
            $data['title'] = 'Lịch sử mua hàng || Mua là có ngay'; 
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['chitiet_member'] = $this->member_model->chitiet_member($this->session->userdata("id_member"));
            $data['hoadononline'] = $this->get_temp();
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data);
            $this->load->view('member/aside',$data);
            $this->load->view('member/temp',$data);
            $this->load->view('footer',$data); 
        }  
    }

    public function get_temp(){
        $hoadononline = $this->hoadononline_model->get_hoadononline_temp_on_member($this->session->userdata("id_member"));
        $t='';
        $dem = 1;
        if(!empty($hoadononline)){
            foreach ($hoadononline as $item) {
                $date = new DateTime($item['Ngay']);
                $date = $date->format(" H:i -  d/m/Y");
                $t.='<tr class="item" HoaDonOnlineID="'.$item["HoaDonOnlineID"]  .'">
                        <td>'.$dem.'</td>
                        <td>DH'.$item["HoaDonOnlineID"].'</td>
                        <td>'.$date.'</td> 
                    </tr>
                    <tr class="detail detail_'.$item["HoaDonOnlineID"].'">
                        <td colspan="3" class="row_table">
                            <div class="wrapper_table_chitiet">
                                <table class="table_chitiet">
                                    <thead>
                                        <td>STT</td>
                                        <td>Sản phẩm</td>
                                        <td>Số lượng</td> 
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>';
                $dem++;
            } 
        }else{
            $t.='<tr><td colspan="5">Không có đơn hàng!</td></tr>';
        }
        return $t;
    }

    public function get_chitiethoadon_temp(){
        $HoaDonOnlineID = $_POST['HoaDonOnlineID'];
        $chitiethoadon = $this->hoadononline_model->get_chitiethoadon_temp($HoaDonOnlineID);

        $t=''; 
        $dem = 1;
        foreach ($chitiethoadon as $item) {
            $giaban = round($item['DonGia'] + $item['DonGia']*$item['Thue']/100 , -3);
            $t.='<tr>
                    <td><i>'.$dem.'.</i></td>
                    <td><a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($item["TenSP"])).'_'.$item['SanPhamID'].'">'.$item["TenSP"].' - '.$item["MaSP"].'</a></td> 
                    <td>'.$item['SoLuong'].'</td> 
                </tr> 
                ';
            $dem++;
        }  
        $t.='<tr><td colspan="3"><button type="button" class="submit_cart_temp btn btn_info" HoaDonOnlineID = '.$HoaDonOnlineID.'>Hoàn tất đơn hàng</button></td></tr>';
        echo $t; 
    }

    // ==========================ADMIN========================================
    public function echo_member_admin($member,$offset){ 
        $t = '';  
        if(!empty($member)){  
            foreach ($member as $item) {
                $offset++;                    
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td>#'.$item['MemberID'].'</td> 
                        <td>'.$item['Ten'].'</td>  
                        <td>'.$item['Email'].'</td>  
                        <td>'.$item['Phone'].'</td>  
                        <td>'.$item['NgaySinh'].'</td>
                        <td>'.(($item['GioiTinh'] == 1) ? 'Nam' : 'Nữ' ).'</td>
                        <td>'.$item['DiaChi'];
                            $address = $this->address_model->get_address_on_xaphuong($item['XaPhuongID']);
                            if(!empty($address)){
                                $t.=','.$address['TenXaPhuong'].','.$address['TenQuanHuyen'].','.$address['TenTinhTP'];
                            }
                        $t.='</td>
                    </tr>';  
            }  
        }else{
            $t.='<tr><td colspan="8">Không có dữ liệu!</td></tr>';
        }
        $t = mb_check_encoding($t, 'UTF-8') ? $t : utf8_encode($t);
        
        return $t;
    } 

    // -----get sanpham-----------
    public function get_member_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $member = $this->member_model->get_member_admin($number,$offset);        
        $list_member = $this->echo_member_admin($member,$offset);
        $count = $this->member_model->count_all_member_admin();
        $result = array(
            'list_member' => $list_member,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_member_admin(){
        echo $this->member_model->count_all_member_admin();
    }
// -----get sanpham-----------

// ---------------search------------------
    public function search_member_admin(){
        $key = $_POST['key'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $member = $this->member_model->search_member_admin($key,$number,$offset);
        $list_search = $this->echo_member_admin($member,$offset); 

        $count = $this->member_model->count_search_member_admin($key);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_search_member_admin(){
        $key = $_POST['key'];
        echo $this->member_model->count_search_member_admin($key);
    }
// ---------------search------------------
// ------------------filter-----------------
    public function filter_member_admin(){ 
        $val = $_POST['val'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $member = $this->member_model->filter_member_admin($val,$number,$offset);
        $list_search = $this->echo_member_admin($member,$offset); 
        $count = $this->member_model->count_filter_member_admin($val);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_filter_member_admin(){ 
        $val = $_POST['val'];
        echo $this->member_model->count_filter_member_admin($val);
    }
// ------------------filter-----------------
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















