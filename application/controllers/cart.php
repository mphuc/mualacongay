<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {
    private $date;
    public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->date = date("Y-m-d") . 'T' . date("H:i:s");

        $this->load->Model('main_model');
        $this->load->Model('sanpham_model');
        $this->load->Model('danhmuc_model');
        $this->load->Model('hinhanh_model');
        $this->load->Model('hoadononline_model');
        $this->load->Model('member_model');
        $this->load->Model('address_model');
        $this->load->Model('mangxahoi_model');
        $this->load->Model('tintuc_model');
        $this->load->Model('thongtin_model');
    }
    // ------------INDEX------------
    public function index(){
        $data['menuActive'] = 'home';
        $data['title'] = 'Giỏ hàng || Mua là có ngay';

        $data['sidebar'] = $this->main_lib->get_sidebar();
        $data['product_new'] = $this->main_lib->get_product_new();
        $data['shopping_cart'] = $this->show_cart();
        $data = array_merge($this->main_lib->get_data_index() , $data);

        $this->load->view('header',$data);
        $this->load->view('aside',$data);
        $this->load->view('cart/index',$data);
        $this->load->view('footer',$data);
    }

    public function show_cart(){
        $cart = $this->cart->contents();
        if( count($cart) > 0 ){
            $t='
                <tbody><tr>
                    <th class="cart_product">Hình ảnh </th>
                    <th class="cart_description">Tên sản phẩm</th>
                    <th class="cart_avail">Số lượng</th>
                    <th class="cart_unit_price">Giá</th>
                    <th class="cart_total">Tổng</th>
                    <th class="cart_total">Xóa</th>
                </tr>';
            foreach ($cart as $item){
                $SP = $this->sanpham_model->get_chitiet_sanpham($item['id']);
                $image = isset($SP['Image'])?$SP['Image']:'';
                $t.='
                    <tr class="item" SanPhamID="'.$SP['SanPhamID'].'">
                        
                        <td class="img_product_cart"><a href="'.base_url().'san-pham/'.url_title(removesign($SP['TenSP'])).'_'.$SP['SanPhamID'].'"><img style="height:80px;" src="'.$SP['images'].'" onerror="imgError(this)" ></a></td>
                        <td>
                            <a href="'.base_url().'san-pham/'.url_title(removesign($SP['TenSP'])).'_'.$SP['SanPhamID'].'">'.$SP['TenSP'].'</a>
                        </td>
                        <td>
                            <div class="block_quantity">
                                <input type="button" class="sub_quantity" value="-">
                                <input type="text" class="value_quantity" value="'.$item['qty'].'">
                                <input type="button" class="add_quantity" value="+">
                            </div>
                        </td>
                        <td class="giaban">'.number_format($item['price'],'0',',','.').'</td>
                        <!-- <td class="thue">'.$item['thue'].' </td> -->
                        <td><span class="thanhtien" >'.number_format( $item['subtotal'],'0',',','.').'</span></td>
                        <td><div class="remove_cart text-center"><span class="fa fa-trash"></span></div></td>
                    </tr>';
            }
            $t.='</tbody>';
        }else{
            $t='<p class="noitems">Giỏ hàng trống!</p>';
        }
        return $t;
    }

    public function add_cart(){
        $SoLuong = $_POST['SoLuong'];
        $SanPhamID = $_POST['SanPhamID']; //-------@@-----------//
        $update = 0;

        $SP = $this->sanpham_model->get_chitiet_sanpham($SanPhamID);
        if( $this->main_lib->connect_server() ) {
            $gia_sp = $this->sanpham_model->get_gia_1_sanpham($SanPhamID);
            $giaban = (isset($gia_sp['GiaMoi'])) ? $gia_sp['GiaMoi'] : $gia_sp['GiaCu'];
            $thue = ( isset($gia_sp['Thue']) ) ? $gia_sp['Thue'] : 0;
            $price = round($giaban + $giaban * $thue / 100 , 0);
        }else{
            $giaban = (isset($SP['GiaMoi'])) ? $SP['GiaMoi'] : $SP['GiaCu'];
            $thue = ( isset($SP['Thue']) ) ? $SP['Thue'] : 0;
            $price = round($giaban + $giaban * $thue / 100 , 0);
        }
        $data=array(
            "id" => $SP['SanPhamID'],
            "name" =>  1,
            "qty" => $SoLuong,
            "price" => ($price == 0 || $price == null)? 1 : $price,  //-- giá dã có thuế
            "giaban" => ($giaban == 0 || $giaban == null) ? 1 : $giaban ,  //-- giá chua thuế
            "thue" => $thue,
        );

        foreach($this->cart->contents() as $item){
            if($item['id'] == $SP['SanPhamID']){
                $SoLuong = $item['qty'] + $SoLuong ;
                $update = array(
                    "rowid" => $item['rowid'],
                    "qty" => $SoLuong,
                );
            }
        }
        if( $update == 0 ){
            $this->cart->insert($data);
        }else{
            $this->cart->update($update);
        }

        //------- hóa don online tạm-----
        if( $this->session->userdata("login_member") ){

            $Token = $this->session->userdata('token_member');
            $hoadon = $this->hoadononline_model->check_token($Token);
            if( empty($hoadon) ){
                $data2=array(
                    "TongTien" => $this->cart->total(),
                    "Ngay" => $this->date,
                    "MemberID" => $this->session->userdata('id_member'),
                    "Is_HoaDon" => false,
                    "Token" => $Token,
                );
                $HoaDonOnlineID = $this->hoadononline_model->insert_hoadononline_temp($data2);
            }else{
                $data2=array(
                    "TongTien" => $this->cart->total(),
                );
                $HoaDonOnlineID = $hoadon['HoaDonOnlineID'];
                $this->hoadononline_model->update_hoadononline_temp($data2,$HoaDonOnlineID);
            }

            $chitiethoadon = $this->hoadononline_model->check_sp_chitiethoadon($HoaDonOnlineID,$SanPhamID);
            // print_r($chitiethoadon);
            // print_r($giaban);
            if( empty($chitiethoadon) ){
                $data2=array(
                    "SanPhamID" => $SanPhamID ,
                    "SoLuong" => $SoLuong ,
                    "DonGia" => $giaban ,
                    "Thue" => $thue ,
                    "ThanhTien" => $price*$SoLuong,
                    "HoaDonOnlineID" => $HoaDonOnlineID ,
                );
                $this->hoadononline_model->insert_chitiethoadononline_temp($data2);
            }else{
                $data2=array(
                    "SoLuong" => $SoLuong ,
                    "ThanhTien" => $price*$SoLuong,
                );
                $ChiTietOnlineID  = $chitiethoadon['ChiTietOnlineID'];
                $this->hoadononline_model->update_chitiethoadononline_temp($data2,$ChiTietOnlineID);
            }
        }

        $count = count($this->cart->contents());
        echo $count;
    }

    public function update_cart(){
        $SoLuong = $_POST['SoLuong'];
        $SanPhamID = $_POST['SanPhamID'];

        //-----update cart session-------
        foreach($this->cart->contents() as $item){
            if($item['id'] == $SanPhamID){
                $update = array(
                    "rowid" => $item['rowid'],
                    "qty" => $SoLuong,
                );
            }
        }
        $this->cart->update($update);

        //-----update cart tạm-------
        if( $this->session->userdata("login_member") ){
            $Token = $this->session->userdata('token_member');
            $hoadon = $this->hoadononline_model->check_token($Token);
            $HoaDonOnlineID = $hoadon['HoaDonOnlineID'];
            $chitiethoadon = $this->hoadononline_model->check_sp_chitiethoadon($HoaDonOnlineID,$SanPhamID);
            $ChiTietOnlineID  = $chitiethoadon['ChiTietOnlineID'];

            $SP = $this->sanpham_model->get_chitiet_sanpham($SanPhamID);
            if( $this->main_lib->connect_server() ) {
                $gia_sp = $this->sanpham_model->get_gia_1_sanpham($SanPhamID);
                $giaban = (isset($gia_sp['GiaMoi'])) ? $gia_sp['GiaMoi'] : $gia_sp['GiaCu'];
                $thue = ( isset($gia_sp['Thue']) ) ? $gia_sp['Thue'] : 0;
                $price = round($giaban + $giaban * $thue / 100 , 0);
            }else{
                $giaban = (isset($SP['GiaMoi'])) ? $SP['GiaMoi'] : $SP['GiaCu'];
                $thue = ( isset($SP['Thue']) ) ? $SP['Thue'] : 0;
                $price = round($giaban + $giaban * $thue / 100 , 0);
            }

            $data2=array(
                "SoLuong" => $SoLuong ,
                "ThanhTien" => $price*$SoLuong,
            );
            $this->hoadononline_model->update_chitiethoadononline_temp($data2,$ChiTietOnlineID);
        }
        //---------hiện thị cart-----
        echo $this->show_cart();
    }

    public function remove_cart(){
        $SanPhamID = $_POST['SanPhamID'];

        //-----remove cart session-------
        $data=$this->cart->contents();
        foreach($data as $item){
            if($item['id'] == $SanPhamID){
                $item['qty'] = 0;
                $delOne = array("rowid" => $item['rowid'], "qty" => $item['qty']);
            }
        }
        $this->cart->update($delOne);

        //-----remove cart t?m-------
        if( $this->session->userdata("login_member") ){
            $Token = $this->session->userdata('token_member');
            $hoadon = $this->hoadononline_model->check_token($Token);
            $HoaDonOnlineID = $hoadon['HoaDonOnlineID'];
            $this->hoadononline_model->delete_chitiethoadon($HoaDonOnlineID,$SanPhamID);

            $chitiethoadon = $this->hoadononline_model->get_chitiethoadon_temp($HoaDonOnlineID);
            if(count($chitiethoadon) == 0){
                $this->hoadononline_model->delete_hoadononline_by_token($Token);
            }
            echo $SanPhamID;
        }

        echo "Xoa san pham thanh cong";
    }

    public function count_cart(){
        $count = count($this->cart->contents());
        echo $count;
    }
// =============================THANH TOAN==============================
    public function thanh_toan(){
        if( count($this->cart->contents()) > 0 ){
            $data['menuActive'] = 'home';
            $data['title'] = 'Thanh toán || Mua là có ngay';

            $data['tinhtp'] = $this->address_model->get_tinhtp();
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['shopping_cart'] = $this->show_cart_checkout();

            if( $this->session->userdata("login_member") ){
                $MemberID = $this->session->userdata("id_member");
            }else if( $this->session->userdata("login_khachonline") ){
                $MemberID = $this->session->userdata("id_khachonline");
            }else{
                $MemberID = 0;
            }

            if( $MemberID != 0){
                $data['chitiet_member'] = $this->member_model->chitiet_member($MemberID);
                $XaPhuongID = $data['chitiet_member']['XaPhuongID'];
                if($XaPhuongID != 0){
                    $address = $this->address_model->get_address_on_xaphuong($XaPhuongID);
                    $data['TinhTPID'] = $address['TinhTPID'];
                }
                if( !$this->session->userdata("login_khachonline") ){
                    $data['readonly_input'] = ' readonly ';
                }
            }

            $data['path_1'] = '<a href="'.base_url().'cart.html">Giỏ hàng</a>';
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data);
            $this->load->view('aside',$data);
            $this->load->view('cart/thanh_toan',$data);
            $this->load->view('footer',$data);
        }else{
            redirect('cart','refresh');
        }
    }

    public function show_cart_checkout(){
        $cart = $this->cart->contents();
        if( count($cart) > 0 ){
            $t='<thead>
                    <td>Sản phẩm</td>
                    <td>Thành tiền (VNÐ)</td>
                </thead>
                <tbody>';
            foreach ($cart as $item){
                $SP = $this->sanpham_model->get_chitiet_sanpham($item['id']);
                $image = isset($SP['Image'])?$SP['Image']:'';
                $t.='
                    <tr class="item" SanPhamID="'.$SP['SanPhamID'].'">
                        <td>
                            <a href="'.base_url().'san-pham/'.url_title(removesign($SP['TenSP'])).'_'.$SP['SanPhamID'].'">'.$SP['TenSP'].'</a>
                            <p class="giavon">'.number_format($item['price'],'0',',','.').' VNÐ x '.$item['qty'].'</p>
                        </td>
                        <td><span class="tonggia" >'.number_format( $item['subtotal'],'0',',','.').'</span></td>
                    </tr>';
            }
            $t.='</tbody>';
        }else{
            $t='<p class="noitems">Giỏ hàng trống!</p>';
        }
        return $t;
    }

    public function checkout(){
        // -----------------------------------
        $cart = $this->cart->contents();
        $check_done = 0;
        if(count($cart) != 0){
            // --------tính tổng thuế của hóa đơn-------------
            $tong_gia_chua_thue = 0;
            foreach ($cart as $item_cart) {
                $tong_gia_chua_thue = $tong_gia_chua_thue + $item_cart['giaban']*$item_cart['qty'];
            };
            $tong_thue = $this->cart->total() - $tong_gia_chua_thue;
            // print_r($tong_thue);

            // -----------insert KhachOnline--------
            if( $this->session->userdata("login_member") ){
                $MemberID_Server = $this->session->userdata("id_server_member");
            }else{
                $NgaySinh = date_create($_POST['NamSinh'].'-01-01');
                $NgaySinh = date_format($NgaySinh,"Y-m-d");

                //-------kiểm tra Member, để sau này đồng bộ xuống server--------
                ( $this->main_lib->connect_server() ) ? $New_Member = 0 : $New_Member = 1;

                $data=array(
                    "Ten" => $_POST['Ten'],
                    "Email" => isset($_POST['Email'])?$_POST['Email']:'',
                    "DiaChi" => $_POST['DiaChi'],
                    "Phone" => $_POST['Phone'],
                    "NgaySinh" => $NgaySinh,
                    "GioiTinh" => isset($_POST['GioiTinh'])?$_POST['GioiTinh']:'',
                    "XaPhuongID" => $_POST['XaPhuongID'],
                    "Is_Member" => false,
                    "New_Member" => $New_Member,
                );
                $MemberID_host = $this->member_model->insert_member_host($data);
                // if( $this->main_lib->connect_server() ){
                //     $MemberID_Server = $this->member_model->insert_member_server($data);
                //     $this->member_model->update_member_host(array("MemberID_Server"=>$MemberID_Server),$MemberID_host);
                // }

                $data = array(
                    "username_khachonline" => $_POST['Ten'],
                    "id_khachonline" => $MemberID_host,
                    "login_khachonline" => 1
                );
                $this->session->set_userdata($data);

                //---xóa session của Member
                $this->session->unset_userdata(array('login_member' => 1));
            }
            // -----------insert KhachOnline--------

            // ----------------insert HoaDonOnline-------
            $address = $this->address_model->get_address_on_xaphuong($_POST['XaPhuongID']);
            $DiaChiNhanHang = $_POST['DiaChi'].','.$address['TenXaPhuong'].','.$address['TenQuanHuyen'].','.$address['TenTinhTP'];

            ini_set("memory_limit",-1);
            ini_set('MAX_EXECUTION_TIME', -1);

            if( $this->main_lib->connect_server() ){ //----------nếu đã kết nối thì lưu xuống server------
                // ----------------insert HoaDonOnline server-------
                $data=array(
                    "TongTien" => $this->cart->total(),
                    "Ngay" => $this->date,
                    "GhiChu" => $_POST['GhiChu'],
                    "MemberID" => $MemberID_Server,
                    "DiaChiNhanHang" => $DiaChiNhanHang,
                    "GiaShip" => $_POST['GiaShip'],
                    "Is_HoaDon" => true,
                    "Thue" => $tong_thue,
                    "PayMent" => $_POST['PayMent'],
                    "Website" => $this->main_lib->Server_name(),
                );
                $HoaDonOnlineID_Server = $this->hoadononline_model->insert_hoadononline_server($data);
                // print_r($HoaDonOnlineID_Server);
                if( is_numeric($HoaDonOnlineID_Server)  && $HoaDonOnlineID_Server != -1 ){
                    //---------------set HoaDonOnlineID trong "done" page-----
                    $this->session->set_userdata(array("HoaDonOnlineID_member" => $HoaDonOnlineID_Server));

                    // nếu đã login -> có đơn hàng token trong đơn hàng -> xóa đơn hàng này khi đã lưu xuống server
                    if( $this->session->userdata("login_member") ){
                        $Token = $this->session->userdata('token_member');
                        $hoadon = $this->hoadononline_model->check_token($Token);
                        $HoaDonOnlineID  = $hoadon['HoaDonOnlineID'];
                        $this->hoadononline_model->delete_chitiethoadon_by_HoaDonOnlineID($HoaDonOnlineID);
                        $this->hoadononline_model->delete_hoadononline_by_token($Token);
                    }

                    // ------------ insert chitiethoadononline server----------
                    $arr_cart = array_values($cart);
                    $count = 0;
                    $max_loop = count($arr_cart);
                    while ($count < $max_loop){
                        $SP = $this->sanpham_model->get_chitiet_sanpham($arr_cart[$count]['id']);
                        $data=array(
                            "SanPhamID" => $arr_cart[$count]['id'] ,
                            "SoLuong" => $arr_cart[$count]['qty'] ,
                            "GiaVon" => $SP['GiaVon'] ,
                            "DonGia" => $arr_cart[$count]['giaban'] ,
                            "Thue" => $arr_cart[$count]['thue'] ,
                            "ThanhTien" => $arr_cart[$count]['subtotal'] ,
                            "HoaDonOnlineID" => $HoaDonOnlineID_Server ,
                        );
                        $result = $this->hoadononline_model->insert_chitiethoadononline_server($data);
                        if($count == $max_loop - 1){
                            $check_done = 1; // đã hoàn thành insert hoadon và chitiethoadon xuống server
                        }
                        // if( $result == 1){
                            $count++;
                        // }
                    }

                }else{
                    $check_done = 0;
                }
            }else if( !$this->session->userdata("login_member") ){ //-------nếu ko kết nối + chưa login thì mới lưu vào host-----
                // ----------------insert HoaDonOnline host-------
                $data=array(
                    "TongTien" => $this->cart->total(),
                    "Ngay" => $this->date,
                    "GhiChu" => $_POST['GhiChu'],
                    "MemberID" => $MemberID_host,
                    "DiaChiNhanHang" => $DiaChiNhanHang,
                    "GiaShip" => $_POST['GiaShip'],
                    "Is_HoaDon" => true,
                    "Thue" => $tong_thue,
                    "PayMent" => $_POST['PayMent'],
                    'TinhTrang' => 0,
                    'ThanhToan' => 0,
                    'GiaoHang' => 0
                );
                $HoaDonOnlineID_host = $this->hoadononline_model->insert_hoadononline_temp($data);

                //---------------set HoaDonOnlineID trong "done" page-----
                $this->session->set_userdata(array("HoaDonOnlineID_member" => $HoaDonOnlineID_host));

                // ------------ insert chitiethoadononline host ----------
                $arr_cart = array_values($cart);
                $count = 0;
                $max_loop = count($arr_cart);
                while ($count < $max_loop){
                    $data=array(
                        "SanPhamID" => $arr_cart[$count]['id'] ,
                        "SoLuong" => $arr_cart[$count]['qty'] ,
                        "DonGia" => $arr_cart[$count]['giaban'] ,
                        "Thue" => $arr_cart[$count]['thue'] ,
                        "ThanhTien" => $arr_cart[$count]['subtotal'] ,
                        "HoaDonOnlineID" => $HoaDonOnlineID_host ,
                        'GiaVon' => 0

                    );
                    $result = $this->hoadononline_model->insert_chitiethoadononline_temp($data);
                    if($count == $max_loop - 1){
                        $check_done = 1; // đã hoàn thành insert hoadon và chitiethoadon leen host
                    }
                    if( $result == 1){
                        $count++;
                    }
                }
            }else{ //-------nếu đã login thì chuyển Is_HoaDon -> 1 ------
                $Token = $this->session->userdata('token_member');
                $hoadon = $this->hoadononline_model->check_token($Token);
                $HoaDonOnlineID = $hoadon['HoaDonOnlineID'];

                $data=array(
                    "GhiChu" => $_POST['GhiChu'],
                    "DiaChiNhanHang" => $DiaChiNhanHang,
                    "GiaShip" => $_POST['GiaShip'],
                    "Is_HoaDon" => true,
                    "Token" => '',
                    "PayMent" => $_POST['PayMent']
                );
                if($this->hoadononline_model->update_hoadononline_temp($data,$HoaDonOnlineID)){
                    $check_done = 1; // đã hoàn thành update
                }

                //---------------set HoaDonOnlineID trong "done" page-----
                $this->session->set_userdata(array("HoaDonOnlineID_member" => $HoaDonOnlineID));
            }
        }
        if($check_done == 1){
            // ---xóa dữ liệu giỏ hàng----
            $this->cart->destroy();
            echo 'done';
        }else{
            echo -1;
        }
    }

    // ==================DONE===================
    public function done(){
        if( $this->session->userdata("HoaDonOnlineID_member") ){
            $data['menuActive'] = 'home';
            $data['title'] = 'Thanh toán || Mua là có ngay';
            if( $this->session->userdata("HoaDonOnlineID_member") ){
                $data['HoaDonOnlineID'] = $this->session->userdata("HoaDonOnlineID_member");
                
                $data['Get_DonHang_Id'] = $Get_DonHang_Id = $this ->hoadononline_model->get_info_hoadon_temp($data['HoaDonOnlineID']);
                // thanh toán bằng BTC
                
                if ($Get_DonHang_Id['PayMent'] == 2)
                {
                    $get_invoid = $this ->hoadononline_model-> get_invoid($Get_DonHang_Id['HoaDonOnlineID']);
                   
                    if (count($get_invoid) == 0)
                    {
                        $amount_btc = $this-> convert_btc($Get_DonHang_Id['TongTien']);

                        $payout_address = "1PM3cxWf4FdS4DLXBKLNiGLDkibZxnMYEJ";
                        $confirmations = 0;
                        $fee_level = "low";
                        $callback = urlencode("https://shop.gdgclub.org/cart/callback");
                        $dataa = file_get_contents("https://bitaps.com/api/create/payment/". $payout_address. "/" . $callback . "?confirmations=" . $confirmations. "&fee_level=" . $fee_level);
                        $respond = json_decode($dataa,true);
                        $datas = array('payment_code' => $respond['payment_code'],
                                        'invoice' => $respond['invoice'],
                                        'my_address' => $respond['address'],
                                        'input_address' => $respond['address'],
                                        'payment_code' => $respond['payment_code'],
                                        'payment_code' => $respond['payment_code'],
                                        'amount' => $amount_btc * 100000000,
                                        'cart_id' => $Get_DonHang_Id['HoaDonOnlineID'],
                                        'callback' => $callback,
                                        'date_created' => date('Y-m-d H:i:s'),
                                        'received' => 0,
                                        'confirmations' => 0,
                                        'url' => '',
                                        'tx_hash' => '',
                                        'payout_tx_hash' => '',
                                        'payout_service_fee' => '',
                                        'payout_miner_fee' => '',
                                        'customer_id' => 0
                         );
                        $this ->hoadononline_model->insert_invoid($datas);
                        $data['respond'] = $datas;
                    }
                    else
                    {
                       $data['respond'] = $get_invoid;
                    }
                }

                //print_r($data['Get_DonHang_Id']); die;
                //$this->session->unset_userdata(array('HoaDonOnlineID_member' => $data['HoaDonOnlineID']));
            }else{
                $data['HoaDonOnlineID'] = '';
                redirect('cart','refresh');
            }
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data = array_merge($this->main_lib->get_data_index() , $data);

            $this->load->view('header',$data);
            $this->load->view('aside',$data);
            $this->load->view('cart/done',$data);
            $this->load->view('footer',$data);
        }else{
            redirect('cart','refresh');
        }
    }

    public function callback(){

        $get_invoid_by_payment_code = $this -> hoadononline_model -> get_invoid_by_payment_code($_POST['code']);
        count($get_invoid_by_payment_code) === 0 && die();
        $data = file_get_contents("https://bitaps.com/api/address/". $get_invoid_by_payment_code['input_address']);
        $respond = json_decode($data); // Response array
        $received = doubleval($respond->received);
        if ($received >= doubleval($get_invoid_by_payment_code['amount'])){
            $datas = array('ThanhToan' => 1);
            $this -> hoadononline_model -> update_hoadononline_temp($datas,$get_invoid_by_payment_code['cart_id']);
        }
        
    }

    public function convert_btc($amount_vnd)
    {
        $usd = file_get_contents("http://vietcombank.com.vn/ExchangeRates/ExrateXML.aspx");
        $xml=simplexml_load_string($usd);
        if (!$xml->Exrate[18]['Transfer'])
        {
            $price_now = 22550;
            $amount_usd = $amount_vnd/$price_now;
        }
        else
        {
            $price_now = $xml->Exrate[18]['Transfer'];
            $amount_usd = $amount_vnd/$price_now;
        }
        $url = "https://blockchain.info/tobtc?currency=USD&value=" . (string)$amount_usd;
        return $amount_btc = file_get_contents($url);
    }
    public function conver_vnd($amount_btc)
    {
        $homepage = implode('', file('https://blockchain.info/vi/ticker'));
        $usd_bitcoin = json_decode($homepage);
        if (!$usd_bitcoin->USD->last){
            $price = 725;
        }
        else
        {
            $price = $usd_bitcoin->USD->last;
        }   
        $usd = file_get_contents("http://vietcombank.com.vn/ExchangeRates/ExrateXML.aspx");
        $xml=simplexml_load_string($usd);
        if (!$xml->Exrate[18]['Transfer'])
        {
            $price_now = 22550;
        }
        else
        {
            $price_now = $xml->Exrate[18]['Transfer'];
        }
        return $price*$price_now*$amount_btc;
    }
    // =============================checkout_cart_temp===============
    public function checkout_cart_temp(){
        $this->cart->destroy();
        $HoaDonOnlineID = $_POST['HoaDonOnlineID'];

        $chitiethoadon = $this->hoadononline_model->get_chitiethoadon_temp($HoaDonOnlineID);
        foreach ($chitiethoadon as $item) {
            if( $this->main_lib->connect_server() ){
                $gia_sp = $this->sanpham_model->get_gia_1_sanpham($item['SanPhamID']);
                $giaban = (isset($gia_sp['GiaMoi'])) ? $gia_sp['GiaMoi'] : $gia_sp['GiaCu'];
                $price = round($giaban + $giaban * $gia_sp['Thue'] / 100 , 0);
                $thue = $gia_sp['Thue'];
            }else{
                $giaban = (isset($item['GiaMoi'])) ? $item['GiaMoi'] : $item['GiaCu'];
                $price = round($giaban + $giaban * $item['Thue'] / 100 , 0);
                $thue = $item['Thue'];
            }
            $data=array(
                "id" => $item['SanPhamID'],
                "name" =>  1,
                "qty" => $item['SoLuong'],
                "price" => $price,  //-- giá dã có thu?
                "giaban" => $giaban ,  //-- giá chua thu?
                "thue" => $thue,
            );
            $this->cart->insert($data);
        }

        $hoadon =$this->hoadononline_model->get_info_hoadon_temp($HoaDonOnlineID);
        $data2 = array(
            "token_member" => $hoadon['Token'],
            "HoaDonOnlineID_member" => $hoadon['HoaDonOnlineID']
        );
        $this->session->set_userdata($data2);

        echo 1;
    }
}

