<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {
    private $arr_loaihienthi = array();
    private $date;
    public function __construct(){ 
        parent::__construct();
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->date = date("Y/m/d H:i:s"); 

        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model'); 
        $this->load->Model('loaisanpham_model');
        $this->load->Model('danhmuc_model');  
        $this->load->Model('address_model');  
        $this->load->Model('cauhinh_model');  
        $this->load->Model('thongtin_model');  
        $this->load->Model('hinhanh_model');  
        $this->load->Model('hoadononline_model');  
        $this->load->Model('member_model');  
        $this->load->Model('ngayupdate_model');  
        $this->load->Model('binhluan_model');    
    }  
    // ------------INDEX------------
  // ========= UPDATE DATA==========

    public function update_all()
    {
        $this->binhluan_model->delete_all_traloi_binhluan();
        $this->binhluan_model->delete_all_binhluan();
        $this->hoadononline_model->delete_all_chitiethoadononline(); 
        $this->hoadononline_model->delete_all_hoadononline();        

        $this->hinhanh_model->delete_all_hinhanh();
        $this->sanpham_model->delete_all_sanpham();
        $this->loaisanpham_model->delete_all_loaisanpham();
        $this->danhmuc_model->delete_all_danhmuc();

        $update = $this->update_danhmuc();
        if($update == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
            $check = 1;
        }else{
            $check = 0;
        }
        echo $check;
    }

    public function xoa_all()
    {
        $this->binhluan_model->delete_all_traloi_binhluan();
        $this->binhluan_model->delete_all_binhluan();
        $this->hoadononline_model->delete_all_chitiethoadononline(); 
        $this->hoadononline_model->delete_all_hoadononline();        

        $this->hinhanh_model->delete_all_hinhanh();
        $this->sanpham_model->delete_all_sanpham();
        $this->loaisanpham_model->delete_all_loaisanpham();
        $this->danhmuc_model->delete_all_danhmuc();

        // $this->member_model->delete_all_member();

        echo 1;
    }

    // ******************************** DANH MỤC *****************************
    public function update_danhmuc(){  
        $db_danhmuc = $this->danhmuc_model->all_danhmuc();
        // print_r($db_danhmuc);
        $check = 0;
        // --- insert dữ liệu mới vào bảng DanhMuc----
        if(is_array($db_danhmuc)){ 
            if(!empty($db_danhmuc)){ 
                foreach ($db_danhmuc as $item) { 
                     $data = array(
                        'DanhMucID'=>$item['DanhMucID'], 
                        'TenDanhMuc'=>$item['TenDanhMuc'],   
                    );
                    $this->danhmuc_model->insert_danhmuc($data);

                    $this->update_loaisanpham($item['DanhMucID']);
                } 
                $check=1;
            }  
        } 
        if($check == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
        }
        return $check;
    }  

    public function update_1_danhmuc(){  
        $check = 0;
        $DanhMucID = $_POST['DanhMucID'];

        $danhmuc_server = $this->danhmuc_model->chitiet_danhmuc_server($DanhMucID);

        if(is_array($danhmuc_server)){ 
            if(!empty($danhmuc_server)){  
                $danhmuc = $danhmuc_server[0];
                $data = array(
                    'DanhMucID'=>$danhmuc['DanhMucID'], 
                    'TenDanhMuc'=>$danhmuc['TenDanhMuc'],   
                );
                if( $this->danhmuc_model->check_danhmuc($danhmuc['DanhMucID']) == 1 ){
                    $this->danhmuc_model->update_danhmuc($data, $danhmuc['DanhMucID']);
                }else{
                    $this->danhmuc_model->insert_danhmuc($data);
                }

                echo $this->update_loaisanpham($danhmuc['DanhMucID']);
                $check=1;
            }  
        } 
        if($check == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
        }
        if($check == 0)
            echo $check;
    }  

    // ******************************** LOAI SẢN PHẨM *****************************
    public function update_loaisanpham($DanhMucID){  
        if(!empty($_POST['DanhMucID'])){
            $DanhMucID = $_POST['DanhMucID'];
            // $this->loaisanpham_model->delete_loaisanpham_danhmuc($DanhMucID);
        }
        $check = 0;

        $db_loaisanpham = $this->loaisanpham_model->loaisanpham_on_DanhMucID($DanhMucID);
        // print_r($db_loaisanpham);
 
        // --- insert dữ liệu mới vào bảng DanhMuc----
        if(is_array($db_loaisanpham)){ 
            if(!empty($db_loaisanpham)){
                foreach ($db_loaisanpham as $item) { 
                     $data = array(
                        // 'LoaiSPID'=>$item['LoaiSPID'], 
                        'MaLoaiSP'=>$item['MaLoaiSP'], 
                        'TenLoaiSP'=>$item['TenLoaiSP'],   
                        'DanhMucID'=>$item['DanhMucID'],     
                    ); 
                    
                    if($this->loaisanpham_model->check_loaisanpham($item['LoaiSPID']) == 1){
                        $this->loaisanpham_model->update_loaisanpham($data, $item['LoaiSPID']);
                    }else{ 
                        $this->loaisanpham_model->insert_loaisanpham(array_merge( $data,array('LoaiSPID'=>$item['LoaiSPID']) ));
                    }

                    //-------update sản phẩm theo loại sản phẩm
                    $update_sanpham = $this->update_sanpham($item['LoaiSPID']);
                };
                $check=1;
            }else{
                $check=1;
            }
        } 
        if($check == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
        }
        if(!empty($_POST['DanhMucID'])){
            echo $check;
        }else{
            return $check;
        }
    }  

    public function update_1_loaisanpham($LoaiSPID){  
        if(!empty($_POST['LoaiSPID'])){
            $LoaiSPID = $_POST['LoaiSPID']; 
        }
        $check = 0;
        $loaisanpham_server = $this->loaisanpham_model->chitiet_loaisanpham_server($LoaiSPID);
        $loaisanpham = $loaisanpham_server[0];
          
        if(is_array($loaisanpham)){ 
            if(!empty($loaisanpham)){ 
                $data = array(
                    // 'LoaiSPID'=>$item['LoaiSPID'], 
                    'MaLoaiSP'=>$loaisanpham['MaLoaiSP'], 
                    'TenLoaiSP'=>$loaisanpham['TenLoaiSP'],   
                    'DanhMucID'=>$loaisanpham['DanhMucID'],     
                ); 
                
                if($this->loaisanpham_model->check_loaisanpham($LoaiSPID) == 1){ 
                    $this->loaisanpham_model->update_loaisanpham($data, $LoaiSPID);
                }else{ 
                    if($this->danhmuc_model->check_danhmuc($loaisanpham['DanhMucID']) != 1){
                        $danhmuc_server = $this->danhmuc_model->chitiet_danhmuc_server($loaisanpham['DanhMucID']);
                        $danhmuc = $danhmuc_server[0];
                        $data2 = array(
                            'DanhMucID'=>$danhmuc['DanhMucID'], 
                            'TenDanhMuc'=>$danhmuc['TenDanhMuc'],   
                        );
                        $this->danhmuc_model->insert_danhmuc($data2);
                    }
                    $this->loaisanpham_model->insert_loaisanpham(array_merge( $data,array('LoaiSPID'=>$LoaiSPID) ));
                }

                //-------update sản phẩm theo loại sản phẩm
                $update_sanpham = $this->update_sanpham($LoaiSPID);
                $check=1;
            }else{
                $check=1;
            }
        } 
        if($check == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
        }
        if(!empty($_POST['LoaiSPID'])){
            echo $check;
        }else{
            return $check;
        }
    }  

    // ******************************** SẢN PHẨM *****************************
    public function update_sanpham($LoaiSPID){   
        if(!empty($_POST['LoaiSPID'])){
            $LoaiSPID = $_POST['LoaiSPID'];
            $this->sanpham_model->delete_sanpham_loaisanpham($LoaiSPID);
        }
        $check = 0; 

        if($this->loaisanpham_model->check_loaisanpham($LoaiSPID) == 1){
            //--------- lấy danh sách sản phẩm theo loại sản phẩm-----
            // print_r($LoaiSPID);
            $db_sanpham = $this->sanpham_model->all_sanpham_loaisanpham_server($LoaiSPID);
            
            // print_r($db_sanpham);
            if(is_array($db_sanpham) || is_null($db_sanpham)){ 
                if(!empty($db_sanpham)){ 
                    foreach ($db_sanpham as $item) { 
                        $gia = $this->sanpham_model->get_gia_1_sanpham($item['SanPhamID']);
                        $data = array(
                            'MaSP'=>$item['MaSP'], 
                            'TenSP'=>$item['TenSP'], 
                            'GiaVon'=>$item['GiaVon'], 
                            'MoTa'=>isset($item['MoTa'])?$item['MoTa']:'', 
                            'TonKho'=>$item['TonKho'], 
                            'DinhMucTon'=>$item['DinhMucTon'],  
                            'LoaiSPID'=>$item['LoaiSPID'],  
                            'NgayTao'=>isset($item['NgayTao'])?$item['NgayTao']:'', 
                            "GiaMoi" => $gia['GiaMoi'],
                            "GiaCu" => $gia['GiaCu'],
                            "Thue" => $gia['Thue'],
                            "NgayUpdateGia" => $this->date,                        
                        );
                        if($this->sanpham_model->check_sanpham($item['SanPhamID']) == 1){
                            $this->sanpham_model->update_sanpham($data, $item['SanPhamID']);
                        }else{ 
                            $this->sanpham_model->insert_sanpham(array_merge( $data,array('SanPhamID'=>$item['SanPhamID']) ));
                        }
                    }
                    // ----- upload hình ảnh lên host ------
                    $upload_image = $this->upload_image($db_sanpham);
                    if($upload_image == 1){
                        $check = 1;
                    }else{
                        $check = 0;
                    }
                }else{   
                    $check = 1;
                }
            }else{
                $check = 1;
            }
        }else{
            $this->update_1_loaisanpham($LoaiSPID);
        }

        if($check == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
        }

        if(!empty($_POST['LoaiSPID'])){
            echo $check;
        }else{
            return $check;
        }
    }  

    public function update_1_sanpham($SanPhamID){  
        if(!empty($_POST['SanPhamID'])){
            $SanPhamID = $_POST['SanPhamID'];
        }

        $check = 0; 
        $sanpham_sever = $this->sanpham_model->Chitiet_SanPham_server($SanPhamID);
        if(is_array($sanpham_sever)){ 
            if(!empty($sanpham_sever)){ 
                $sanpham = $sanpham_sever[0]; 
                $gia = $this->sanpham_model->get_gia_1_sanpham($SanPhamID);
                $data = array(
                    'MaSP'=>$sanpham['MaSP'], 
                    'TenSP'=>$sanpham['TenSP'], 
                    'GiaVon'=>$sanpham['GiaVon'], 
                    'MoTa'=>isset($sanpham['MoTa'])?$sanpham['MoTa']:'', 
                    'TonKho'=>$sanpham['TonKho'], 
                    'DinhMucTon'=>$sanpham['DinhMucTon'],  
                    'LoaiSPID'=>$sanpham['LoaiSPID'],  
                    'NgayTao'=>isset($isanphamtem['NgayTao'])?$sanpham['NgayTao']:'', 
                    "GiaMoi" => $gia['GiaMoi'],
                    "GiaCu" => $gia['GiaCu'],
                    "Thue" => $gia['Thue'],
                    "NgayUpdateGia" => $this->date,                        
                ); 
                if($this->loaisanpham_model->check_loaisanpham($sanpham['LoaiSPID']) != 1 ){
                    $loaisanpham_server = $this->loaisanpham_model->chitiet_loaisanpham_server($sanpham['LoaiSPID']);
                    $loaisanpham = $loaisanpham_server[0];
                    $data_loaisanpham = array(
                        'MaLoaiSP'=>$loaisanpham['MaLoaiSP'], 
                        'TenLoaiSP'=>$loaisanpham['TenLoaiSP'],   
                        'DanhMucID'=>$loaisanpham['DanhMucID'],     
                    ); 
                    if($this->danhmuc_model->check_danhmuc($loaisanpham['DanhMucID']) != 1){
                        $danhmuc_server = $this->danhmuc_model->chitiet_danhmuc_server($loaisanpham['DanhMucID']);
                        $danhmuc = $danhmuc_server[0];
                        $data_danhmuc = array(
                            'DanhMucID'=>$danhmuc['DanhMucID'], 
                            'TenDanhMuc'=>$danhmuc['TenDanhMuc'],   
                        );
                        $this->danhmuc_model->insert_danhmuc($data_danhmuc);
                    }
                    $this->loaisanpham_model->insert_loaisanpham(array_merge( $data_loaisanpham,array('LoaiSPID'=>$sanpham['LoaiSPID']) ));
                }

                if($this->sanpham_model->check_sanpham($SanPhamID) == 1){
                    $this->sanpham_model->update_sanpham($data, $SanPhamID);
                }else{ 
                    $this->sanpham_model->insert_sanpham(array_merge( $data,array('SanPhamID'=>$SanPhamID) ));
                }

                // ----- upload hình ảnh lên host ------
                $upload_image = $this->upload_image($sanpham_sever);
                if($upload_image == 1){
                    $check = 1;
                }else{
                    $check = 0;
                }
            }else{   
                $check = 1;
            }
        }else{
            $check = 0;
        }

        if($check == 1){
            $this->ngayupdate_model->update_ngayupdate(array('SanPham' => $this->date, ));
        }

        if(!empty($_POST['SanPhamID'])){
            echo $check;
        }else{
            return $check;
        }
    }  

    public function upload_image($db_sanpham){
        $check = 0;
        // ----main----
        $upload_image_main = $this->upload_image_main($db_sanpham);
        if($upload_image_main == 1){
            // -----sub-----
            $arrSanPhamID = $this->get_arrSanPhamID($db_sanpham);
            if(!empty($arrSanPhamID)){
                foreach ($arrSanPhamID as $key => $SanPhamID) {
                    $this->update_hinhanh($SanPhamID);
                }
            }
            $check = 1;
        }else{
            $check = 0;
        }
        return $check;
    }
    // ------------- upload main ---------------------
        public function upload_image_main($db_sanpham){
            $check = 0;
            $config = $this->main_lib->config_ftp();
            $this->ftp->connect($config);

            $arrSanPhamID = $this->get_arrSanPhamID($db_sanpham);
            $cauhinh = $this->cauhinh_model->get_cauhinh();
            $list_files = $this->ftp->list_files('');
            // print_r($list_files);
            // print_r($arrSanPhamID); 
            if(!empty($arrSanPhamID)){
                foreach ($arrSanPhamID as $key => $SanPhamID) {
                    $image = $SanPhamID.TYPE_IMAGE;
                    $path = 'application/data/uploads/image/'.$image;
                    if(in_array($image, $list_files)){
                        $this->ftp->download($image, $path, 'auto'); 
                        // print_r($image.' ');
                    }
                    $check = 1;
                }
            }else{
                $check = 1;
            }
            $this->ftp->close(); 
            return $check;
        }

        public function get_arrSanPhamID($db_sanpham){ 
            $arr =array(); 
            if(!empty($db_sanpham)){
                foreach ($db_sanpham as $item) {
                    $arr[] = $item['SanPhamID'];
                }  
            }
            return $arr;
        }
    // ------------- upload main ---------------------

    // ------------- upload sub ---------------------
        public function update_hinhanh($SanPhamID){
            $check = 0;
            $db_hinhanh = $this->hinhanh_model->get_hinhanh_on_sanphamID($SanPhamID);

            // --- insert dữ liệu mới vào bảng HinhAnh----
            if(!empty($db_hinhanh)){
                // --- xóa tất cả hình ảnh có trong table HinhAnh----
                $result_delete = $this->hinhanh_model->delete_all_hinhanh_on_SanPhamID($SanPhamID);
                if( $result_delete == 1 ){
                    //---upload hình ảnh chi tiết----
                    $upload_image_sub = $this->upload_image_sub($db_hinhanh,$SanPhamID);
                    if($upload_image_sub == 1){
                        //---insert hình ảnh chi tiết----
                        foreach ($db_hinhanh as $item) { 
                             $data = array(  
                                'Image'=>$item['Image'], 
                                'SanPhamID'=>$SanPhamID,  
                            );
                            $this->hinhanh_model->insert_hinhanh($data);
                        };
                        $check = 1;
                    }else{
                        $check = 0;
                    }
                }else{
                    $check = 0;;
                }
            }else{
                $check = 1;
            }
            return $check;
        }

        public function upload_image_sub( $db_hinhanh,$SanPhamID ){
            $check = 0;
            $config = $this->main_lib->config_ftp();
            $this->ftp->connect($config);
            // print_r($db_hinhanh);
            // $arrHinhAnhID = $this->get_arrHinhAnhID($db_hinhanh);
            $cauhinh = $this->cauhinh_model->get_cauhinh();
            $list_files = $this->ftp->list_files('');
            if(is_array($db_hinhanh)){
                if(!empty($db_hinhanh)){
                    foreach ($db_hinhanh as $item) {
                        $image = $item['Image'].TYPE_IMAGE;
                        $path = 'application/data/uploads/image/'.$image;
                        if(in_array($image, $list_files)){
                            $this->ftp->download($image, $path, 'auto'); 
                            // print_r($image.' ');
                        } 
                    } 
                    $check = 1;
                }else{
                    $check = 1;
                }
            }
            $this->ftp->close(); 
            return $check;
        }

        // public function get_arrHinhAnhID($db_hinhanh){ 
        //     $arr = array();
        //     if(!empty($db_hinhanh)){ 
        //         foreach ($db_hinhanh as $item) {
        //             $arr[] = $item['HinhAnhID'];
        //         } 
        //     }
        //     return $arr;
        // }
    // ------------- upload sub ---------------------

    // ******************************** SẢN PHẨM *****************************


    // ********************************GIÁ SẢN PHẨM *****************************
        public function update_gia_sanpham(){
            if(!empty($_POST['LoaiSPID'])){
                $LoaiSPID = $_POST['LoaiSPID'];
                $sanpham = $this->sanpham_model->all_sanpham_loaisanpham_host($LoaiSPID);
            }else{
                $sanpham = $this->sanpham_model->get_SanPham();
            }
            $list_gia = $this->main_lib->get_gia_sanpham($sanpham); 

            if(is_array($list_gia) || $list_gia == ''){ 
                if(!empty($list_gia)){ 
                    foreach ($list_gia as $item_gia) { 
                        $data = array(
                            "GiaMoi" => $item_gia['GiaMoi'],
                            "GiaCu" => $item_gia['GiaCu'],
                            "Thue" => $item_gia['Thue'],
                            "NgayUpdateGia" => $this->date,
                        );
                        $this->sanpham_model->update_sanpham($data,$item_gia['SanPhamID']);
                    } 
                }
                $this->ngayupdate_model->update_ngayupdate(array('Gia_SanPham' => $this->date, ));
            
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $date = date("H:i:s Y/m/d"); 
                $result = array(
                    "count" => count($sanpham),
                    "now" => $date,
                );
            }else{
                $result = array(
                    "count" => -1,
                    "now" => '',
                );   
            } 

            echo json_encode($result);
        }
    // ********************************GIÁ SẢN PHẨM *****************************


    // ******************************** ADDRESS *****************************
    public function update_address(){  
        ini_set("memory_limit",-1);
        ini_set('MAX_EXECUTION_TIME', -1);

        // --- xóa tất cả danh mục có trong table DanhMuc----
        $this->address_model->delete_all_tinhtp();

        // // --- insert dữ liệu mới vào bảng TinhTP----
        $db_tinhtp = $this->address_model->all_tinhtp();
        if(!is_array($db_tinhtp)){
            if(!is_null($db_tinhtp))
                echo 'Không có db_tinhtp!'; 
        } else if(!isset($db_tinhtp[0])){  
             $data = array(
                'TinhTPID'=>$db_tinhtp['TinhTPID'], 
                'TenTinhTP'=>$db_tinhtp['TenTinhTP'], 
                'Loai'=>isset($db_tinhtp['Loai'])?$db_tinhtp['Loai']:0,    
                'GiaShip'=>isset($db_tinhtp['GiaShip'])?$db_tinhtp['GiaShip']:0,     
            );
            $this->address_model->insert_tinhtp($data);
        } else {
            foreach ($db_tinhtp as $item) { 
                 $data = array(
                'TinhTPID'=>$item['TinhTPID'], 
                'TenTinhTP'=>$item['TenTinhTP'], 
                'Loai'=>isset($item['Loai'])?$item['Loai']:0,    
                'GiaShip'=>isset($item['GiaShip'])?$item['GiaShip']:0,     
                );
                $this->address_model->insert_tinhtp($data);
            }
        }  
    }

    // ***************************UPDATE THÔNG TIN*******************
    public function update_thongtin(){
       
        $ThongTinID = $_POST['ThongTinID'];
       
       
        $data = array( 
            'ThongTinID'=>$_POST['ThongTinID'],    
            'TenCuaHang'=>$_POST['TenCuaHang'],    
            'DiaChi'=>$_POST['DiaChi'],     
            'SDT'=>$_POST['SDT'],     
            'Email'=>$_POST['Email'],     
            'Website'=>$_POST['Website'],   
            'khuyenmai'=>$_POST['khuyenmai'],     
        );
     
        $this->thongtin_model->update_thongtin($data);
        $this->ngayupdate_model->update_ngayupdate(array('ThongTin' => $this->date, ));
         $thongtin = $this->thongtin_model->get_1_thongtincuahang($ThongTinID);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("H:i:s Y/m/d"); 
        $result = array(
            "thongtin" => $thongtin,
            "now" => $date,
        );
        echo json_encode($result); 
    }

    // ***************************Đồng bộ dữ liệu xuống server *****************************
    public function sync_to_server(){
        if( $this->main_lib->connect_server() ){
                ini_set("memory_limit",-1);
                ini_set('MAX_EXECUTION_TIME', -1);
                $count_new_member = 0;
                $check_member = 1;
                $check_hoadon = 1;
                // +++++++++++++++ Đồng bộ HoaDonOnline+++++++++++++++++
                    $hoadon = $this->hoadononline_model->get_hoadononline_to_sync();
                    $count_hoadon = 0;
                    $max_loop = count($hoadon); 
                    if( !empty($hoadon) ){
                        while ($count_hoadon < $max_loop){
                            $MemberID_Server = '';
                            $member = '';
                            $member = $this->member_model->chitiet_member_host( $hoadon[$count_hoadon]['MemberID'] );

                            //-----insert Member
                            if($member['New_Member'] == 1){ 
                                $count_new_member++;
                                $MemberID_Server = $this->member_model->insert_member_server($member);
                                $data = array(
                                    "New_Member"=>0,
                                    "MemberID_Server"=>$MemberID_Server,
                                );
                                $this->member_model->update_member_host($data,$hoadon[$count_hoadon]['MemberID']);
                            }else{
                                $MemberID_Server = $member['MemberID_Server'];
                            }//-----insert Member

                            // print_r($MemberID_Server);

                            if( is_numeric($MemberID_Server) ){ 
                                $check_member = 1;
                                //----- insert HoaDonOnline
                                $Ngay = date("Y-m-d", strtotime($hoadon[$count_hoadon]['Ngay']));
                                $Ngay = $Ngay.'T'.date("H:i:s", strtotime($Ngay));
                                $data=array( 
                                    "TongTien" => $hoadon[$count_hoadon]['TongTien'],  
                                    "TinhTrang" => $hoadon[$count_hoadon]['TinhTrang'],  
                                    "Ngay" => $Ngay,   
                                    "GhiChu" => $hoadon[$count_hoadon]['GhiChu'].' - '.$hoadon[$count_hoadon]['Ngay'],   
                                    "MemberID" => $MemberID_Server,   
                                    "DiaChiNhanHang" => $hoadon[$count_hoadon]['DiaChiNhanHang'],
                                    "GiaShip" => $hoadon[$count_hoadon]['GiaShip'],
                                    "Is_HoaDon" => true,
                                    "Thue" => $hoadon[$count_hoadon]['Thue'],
                                    "Website" => $this->main_lib->Server_name(),
                                ); 
                                $HoaDonOnlineID_Server = $this->hoadononline_model->insert_hoadononline_server($data); 
                                //----- insert HoaDonOnline

                                // print_r('*'.$HoaDonOnlineID_Server.'*');
                                //----- insert chitietHoaDonOnline  
                                if( is_numeric($HoaDonOnlineID_Server) && $HoaDonOnlineID_Server != -1 ){
                                    $chitiethoadon = $this->hoadononline_model->get_chitiethoadon_to_sync($hoadon[$count_hoadon]['HoaDonOnlineID']);
                                    if(!empty($chitiethoadon)){
                                        $count_chitiet = 0;
                                        $max_loop2 = count($chitiethoadon);  
                                        while ($count_chitiet < $max_loop2){
                                            $data=array( 
                                                "SanPhamID" => $chitiethoadon[$count_chitiet]['SanPhamID'] ,  
                                                "SoLuong" => $chitiethoadon[$count_chitiet]['SoLuong'] ,   
                                                "DonGia" => $chitiethoadon[$count_chitiet]['DonGia'] ,   
                                                "Thue" => $chitiethoadon[$count_chitiet]['Thue'] ,   
                                                "ThanhTien" => $chitiethoadon[$count_chitiet]['ThanhTien'] ,   
                                                "HoaDonOnlineID" => $HoaDonOnlineID_Server ,
                                            );  
                                            $result_insert_chitiet = $this->hoadononline_model->insert_chitiethoadononline_server($data); 
                                            if($result_insert_chitiet == 1){ //----nếu insert chitiethoadon xong thì tiếp tục
                                                $count_chitiet++;  
                                            }else{ //---nếu insert lỗi 1 chitiethoadon thì ngừng,và xóa hoadon + chitiethoadon đã insert server
                                                $this->hoadononline_model->delete_hoadon_chitiethoadon_error($HoaDonOnlineID_Server);
                                                $error_hoadon = 1;
                                                break;
                                            }
                                            if($count_chitiet == $max_loop2){
                                                //--- nếu đã insert xong tất cả Chitiethoadon thì xóa HoaDonOnline và Chitiethoadon
                                                $this->hoadononline_model->delete_chitiethoadon_by_HoaDonOnlineID($hoadon[$count_hoadon]['HoaDonOnlineID']);
                                                $this->hoadononline_model->delete_hoadononline_by_HoaDonOnlineID($hoadon[$count_hoadon]['HoaDonOnlineID']);
                                                $count_hoadon++;
                                                $check_hoadon = 1; // -- insert xong
                                            }
                                        } 
                                    }else{ 
                                        $check_hoadon = 1; // -- insert xong
                                    }
                                }else{
                                    $check_hoadon = 0; // -- insert lỗi
                                    break;
                                    $count_hoadon++;
                                }
                                //----- insert chitietHoaDonOnline
                            }else{
                                $check_member = 0; // -- insert lỗi
                                break;
                            }//----- insert HoaDonOnline
                        } 
                        if($count_hoadon == $max_loop){
                            $check_hoadon = 1; // -----insert xong
                        }
                    } 
                // +++++++++++++++ Đồng bộ HoaDonOnline+++++++++++++++++

                // +++++++++++++++ Đồng bộ Member Mới+++++++++++++++++
                    $check_member_2 = 1;
                    $member = $this->member_model->get_member_new();
                    $count_member = 0;
                    $max_loop3 = count($member); 
                    if(!empty($member)){
                        while ($count_member < $max_loop3){
                            $MemberID_Server = $this->member_model->insert_member_server($member[$count_member]);
                            if( is_numeric($MemberID_Server) && $MemberID_Server != -1 ){
                                $data = array(
                                    "New_Member"=>0,
                                    "MemberID_Server"=>$MemberID_Server,
                                );
                                $result = $this->member_model->update_member_host($data,$member[$count_member]['MemberID']);
                                if($result == 1){
                                    $count_member++;
                                } 
                                $check_member_2 = 1;
                            }else{
                                $check_member_2 = 0;
                                break;
                            }
                        }
                    } 
                // +++++++++++++++ Đồng bộ Member Mới+++++++++++++++++
                $result = array(
                    "update_HoaDonOnline" => (isset($count_hoadon)) ? $count_hoadon : -1,
                    "update_Member" => ((isset($count_member)) ? $count_member : 0 ) + ((isset($count_new_member)) ? $count_new_member : 0 ),    
                    "check_hoadon" => $check_hoadon,    
                    "check_member" => ($check_member && $check_member_2) ? 1 : 0,    
                );
                echo json_encode($result);
        }else{
            echo -2;
        }
    }
 

}
 