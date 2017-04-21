<?php
class Sanpham extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model'); 
        $this->load->Model('loaisanpham_model');
        $this->load->Model('danhmuc_model');  
        $this->load->Model('hinhanh_model');  
        $this->load->Model('binhluan_model');  
        $this->load->Model('mangxahoi_model');  
        $this->load->Model('tintuc_model');          
        $this->load->Model('ngayupdate_model');     

    }

    public function index($SanPhamID)
    { 

        $data['menuActive'] = 'sanpham';
        $chitiet_sanpham = $this->sanpham_model->get_chitiet_sanpham($SanPhamID);
        $data['chitiet_sanpham'] = $chitiet_sanpham;
        $data['chitiet_hinhanh_sanpham'] = $this->hinhanh_model->get_hinhanh($SanPhamID);

        if(!empty($data['chitiet_sanpham'])){ 
            $data['sanpham_cungloai'] = $this->sanpham_model->get_sanpham_cungloai($data['chitiet_sanpham']['SanPhamID'],$data['chitiet_sanpham']['LoaiSPID']);
            if( $this->main_lib->connect_server() ) {
                $data['list_gia'] = $this->main_lib->get_gia_sanpham($data['sanpham_cungloai']); 
                $gia_sp = $this->sanpham_model->get_gia_1_sanpham($SanPhamID);  
                $data['giacu'] = number_format( round($gia_sp['GiaCu'] + $gia_sp['GiaCu'] * $gia_sp['Thue'] / 100 , 0) ,'0',',','.');
                $data['giamoi'] = number_format( round($gia_sp['GiaMoi'] + $gia_sp['GiaMoi'] * $gia_sp['Thue'] / 100 , 0) ,'0',',','.');
            }else{
                $data['giacu'] = number_format( round($chitiet_sanpham['GiaCu'] + $chitiet_sanpham['GiaCu'] * $chitiet_sanpham['Thue'] / 100 , 0) ,'0',',','.');
                $data['giamoi'] = number_format( round($chitiet_sanpham['GiaMoi'] + $chitiet_sanpham['GiaMoi'] * $chitiet_sanpham['Thue'] / 100 , 0) ,'0',',','.');
            }
            $data['sidebar'] = $this->main_lib->get_sidebar(0,$data['chitiet_sanpham']['LoaiSPID']); 
            $data['loaisp'] = $this->loaisanpham_model->get_loaisp_on_danhmuc($data['chitiet_sanpham']['LoaiSPID']);
            print_r($data['loaisp']);die;

            if ($data['loaisp']['lock_dm'] == 1)
            {
                session_start();
                if (!isset($_SESSION['lock_ql']))
                {
                    redirect('/lock', 'location');
                }
            }

            $data['title'] = $data['chitiet_sanpham']['TenSP'].' || Mua là có ngay';
            $loaisp = $data['loaisp'];
            $data['path_1'] = '<a href="'.base_url().'danh-muc/'.$loaisp['DanhMucID'].'/'.url_title(removesign($loaisp['TenDanhMuc'])).'">'.$loaisp['TenDanhMuc'].'</a>';
            $data['path_2'] = '<a href="'.base_url().'loai/'.$loaisp['LoaiSPID'].'/'.url_title(removesign($loaisp['TenLoaiSP'])).'">'.$loaisp['TenLoaiSP'].'</a>';

            $number = 5;
            $page = 1;
            $offset = ($page != 1) ? ($page-1)*$number : 0; 
            $binhluan = $this->binhluan_model->get_binhluan_SanPhamID($SanPhamID,$number,$offset);
            $data['binhluan'] = $this->echo_binhluan($binhluan);

            $count_binhluan = $this->binhluan_model->count_binhluan_SanPhamID($SanPhamID);
            $data['count_binhluan'] = $count_binhluan; 

            $data['all_page'] = ceil($count_binhluan/$number);
            $data['cur_page'] = $page; 
            $data = array_merge($this->main_lib->get_data_index() , $data);
            $data['product_new'] = $this->main_lib->get_product_new();
            $this->load->view('header',$data); 
            $this->load->view('aside',$data); 
            $this->load->view('sanpham/index',$data);
            $this->load->view('footer',$data); 
        }else{
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['title'] = 'Page Not Found - Mua là có ngay';
            $data = array_merge($this->main_lib->get_data_index() , $data);
            $data['product_new'] = $this->main_lib->get_product_new();
            $this->load->view('header',$data); 
            $this->load->view('aside',$data); 
            $this->load->view('error/404',$data);
            $this->load->view('footer',$data);
        }
    }

    public function echo_binhluan($binhluan){
        $t=''; 
        foreach ($binhluan as $item) {
            $date = new DateTime($item['Ngay']);
            $Ngay = $date->format("H:i -  d/m/Y");
            $t.='
                <li class="item_binhluan">
                    <img class="left_item" src="'.base_url().'application/data/img/user.png">
                    <div class="right_item">
                        <p class="ten_binhluan">'.$item['Ten'].' <span class="email_binhluan"> '.$item['Email'].'</span></p>
                        <p class="noidung_binhluan">'.$item['NoiDung'].'</p>
                        <div class="bottom_item">
                            <span class="traloi_binhluan" BinhLuanID="'.$item['BinhLuanID'].'">Trả lời</span>
                            <span class="ngay_binhluan">'.$Ngay.'</span>
                        </div>
                        <div class="all_binhluan_sub">
                            <ul>';
                                $binhluan_sub = $this->binhluan_model->get_binhluan_sub_BinhLuanID($item['BinhLuanID']);
                                foreach ($binhluan_sub as $item_sub) {
                                    $date = new DateTime($item_sub['Ngay']);
                                    $Ngay = $date->format("H:i -  d/m/Y");
                                    $t.='
                                        <li class="item_binhluan">
                                            <img class="left_item" src="'.base_url().'application/data/img/user.png">
                                            <div class="right_item">
                                                <p class="ten_binhluan">'.$item_sub['Ten'].' <span class="email_binhluan"> '.$item_sub['Email'].'</span></p>
                                                <p class="noidung_binhluan">'.$item_sub['NoiDung'].'</p>
                                                <div class="bottom_item"> 
                                                    <span class="ngay_binhluan">'.$Ngay.'</span>
                                                </div>
                                            </div>

                                        </li>
                                    ';
                                }
                            $t.='</ul>
                        </div>
                        <div class="content_form_sub"></div>
                    </div>
                </li>
            ';
        }
        return $t;
    }

    public function phantrang_binhluan(){
        $number = 5;
        $page = $_POST['page'];
        $SanPhamID = $_POST['SanPhamID'];
        $offset = ($page != 1) ? ($page-1)*$number : 0; 
        $binhluan = $this->binhluan_model->get_binhluan_SanPhamID($SanPhamID,$number,$offset);
        $list_binhluan = $this->echo_binhluan($binhluan); 
        echo $list_binhluan;
    }

    public function phantrang($page=0){ 
        $history=1;
        if(isset($_POST['history'])){
            $history = $_POST['history']; 
        }    

        $number = ($this->session->userdata("per_page")) ? $this->session->userdata("per_page") : PER_PAGE;
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 

        $data['list_sanpham'] = $this->sanpham_model->get_sanpham_limit($number,$offset);
        // $data['list_gia'] = $this->main_lib->get_gia_sanpham($data['list_sanpham']); 
        
        $count_all_sp = $this->sanpham_model->count_all_sp();
        $data['all_page'] = ceil($count_all_sp/$number);
        $data['cur_page'] = $page; 

        $count_list = count($data['list_sanpham']);
        $from = ($count_list == 0) ? 0 : (($offset == 1) ? $offset : $offset+1);
        $to = $offset+$number;
        $to = ($count_all_sp > $to) ? $to : $count_all_sp; 
        $data['from'] = $from; 
        $data['to'] = $to; 
        $data['all'] = $count_all_sp; 

        if($history == 0){
            define('data_url', base_url().'application/data/');
        }     
        $data['sidebar'] = $this->main_lib->get_sidebar();
        $data['product_new'] = $this->main_lib->get_product_new();
        $data['title'] = 'Sản phẩm - Trang '.$page.' || Mua là có ngay';
        $data['menuActive'] = 'sanpham';
        $data = array_merge($this->main_lib->get_data_index() , $data);

        ($history == 1) ? $this->load->view('header',$data):0;
        ($history == 1) ? $this->load->view('aside',$data):0;
        $this->load->view('main',$data);
        ($history == 1) ? $this->load->view('footer',$data):0;
    } 


    public function search_main(){
        if (!$_POST) die();
        $key = $_POST['key'];
        $t='';
        $list_sanpham = $this->sanpham_model->search_sanpham($key);
        $count_sanpham = $this->sanpham_model->count_all_search_sanpham($key);
        if(!empty($list_sanpham)){
            $t.='<h3>Sản phẩm</h3>';
            foreach ($list_sanpham as $item) {
                $t.='<a href="'.base_url().'san-pham/'.url_title(removesign($item['TenSP'])).'_'.$item['SanPhamID'].'">
                        <img src="'.$item['images'].'" onerror="imgError(this)" >
                        <p>'.$item['TenSP'].' - <b>'.$item['MaSP'].'</b></p>
                    </a>';
            }; 
            if($count_sanpham > 5){
                $t.='<a href="'.base_url().'san-pham/search/'.url_title(removesign($key)).'" class="xemthem_search">Xem thêm »</a>';
            }
        }

        $list_tintuc = $this->tintuc_model->search_tintuc($key);
        $count_tintuc = $this->tintuc_model->count_all_search_tintuc($key);
        if(!empty($list_tintuc)){
            $t.='<h3>Tin tức</h3>';
            foreach ($list_tintuc as $item) {
                $t.='<a href="'.base_url().'tin-tuc/'.url_title(removesign($item['TieuDe'])).'_'.$item['TinTucID'].'">
                        <img src="'.$item['Image'].'" onerror="imgError(this)">
                        <p>'.$item['TieuDe'].'</p>
                    </a>';
            }; 
            if($count_tintuc > 5){
                $t.='<a href="'.base_url().'tin-tuc/search/'.url_title(removesign($key)).'" class="xemthem_search">Xem thêm »</a>';
            }
        }
        echo $t;
    }


    public function page_search_sanpham($key,$page=0){
        $key = str_replace('-',' ',$key);

        $history=1;
        if(isset($_POST['history'])){
            $history = $_POST['history']; 
        }    

        $number = PER_PAGE;
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 
 
        $data['list_search_sanpham'] = $this->sanpham_model->search_all_sanpham($key,$number,$offset);

        $count_all_search_sanpham = $this->sanpham_model->count_all_search_sanpham($key);
        $data['all_page'] = ceil($count_all_search_sanpham/$number);
        $data['cur_page'] = $page; 

        $count_list = count($data['list_search_sanpham']);
        $from = ($count_list == 0) ? 0 : (($offset == 1) ? $offset : $offset+1);
        $to = $offset+$number;
        $to = ($count_all_search_sanpham > $to) ? $to : $count_all_search_sanpham; 
        $data['from'] = $from; 
        $data['to'] = $to; 
        $data['all'] = $count_all_search_sanpham; 

        if($history == 0){
            define('data_url', base_url().'application/data/');
        }
        $data['key'] = $key;        
        $data['sidebar'] = $this->main_lib->get_sidebar();
        $data['title'] = 'Tìm kiếm - Trang '.$page.' || Mua là có ngay';
        $data = array_merge($this->main_lib->get_data_index() , $data);
        
        ($history == 1) ? $this->load->view('header',$data):0;
        ($history == 1) ? $this->load->view('aside',$data):0;
        $this->load->view('sanpham/search',$data);
        ($history == 1) ? $this->load->view('footer',$data):0;
        
    }

//-----------------------------ADMIN--------------------  

    public function echo_sp_admin($sp,$offset){
        $t = ''; 
        if(!empty($sp)){  
            foreach ($sp as $item) {
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td>
                        <td class="text_center">
                            <span class="wrapper_label">
                                <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['SanPhamID'].'" SanPhamID = "'.$item['SanPhamID'].'" >
                                <label for="check_sp_'.$item['SanPhamID'].'"></label>
                            </span>
                        </td>
                        <td class="text_center">'.$item['MaSP'].'</td>
                        <td><img class="imgsp_wrapper" src="'.$item['images'].'" onerror="imgError(this)" ></td>
                        <td><a target="blank" href="'.base_url().'san-pham/'.url_title(removesign($item['TenSP'])).'_'.$item['SanPhamID'].'">'.$item['TenSP'].'</a></td> 
                        <td class="giaban_sp">';
                        
                                $t.='<span class="label label-success giamoi ">'.number_format($item['GiaMoi'],'0',',','.').' ₫</span>';
                            
                            
                        
                        $t.='</td> 
                        <td class="text_center">
                            <a href="'.base_url().'sanpham/get_chitiet_sanpham/'.$item['SanPhamID'].'" data-toggle="tooltip" data-placement="top" title="Xem chi tiết sản phẩm"  class="btn btn-primary fancybox btn_chitiet_sanpham" SanPhamID = "'.$item['SanPhamID'].'" >
                                <i class="fa fa-eye"></i>
                            </a>
                            <td class="text_center">
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_sanpham toggle_form_add_edit" SanPhamID = "'.$item['SanPhamID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_sanpham dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_sanpham" value="Đồng ý" SanPhamID = "'.$item['SanPhamID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                        </td>
                        </td> 
                    </tr>';
            } 
        }else{
            $t.='<tr><td colspan="8">Không có sản phẩm!</td></tr>';
        }
        return $t;
    } 
    public function get_chitiet_sanpham_admin(){
        $SanPhamID = $_POST['SanPhamID'];
        echo json_encode($this->sanpham_model->get_chitiet_SanPham_admin($SanPhamID) );
    }
    public function get_chitiet_sanpham($SanPhamID){
        $chitiet_sanpham = $this->sanpham_model->get_chitiet_SanPham_admin($SanPhamID);
        $chitiet_hinhanh_sanpham = $this->hinhanh_model->get_hinhanh($SanPhamID);
            $t='<div class="chitiet_sanpham_admin">
                    <h2 class="title_popup">Chi tiết sản phẩm</h2>
                    <div class="wrapper_chitiet_admin">
                        <div class="left_chitiet_admin">
                            <div class="fotorama"  
                             data-width="100%"
                             data-ratio="2/2"
                             data-max-width="100%"
                             data-nav="thumbs"
                             data-stop-autoplay-on-touch="true"> 
                                <img src="'.PATH_IMAGE.$chitiet_sanpham['SanPhamID'].TYPE_IMAGE.'" onerror="imgError(this)" >';
                                foreach ($chitiet_hinhanh_sanpham as $item) {
                                    $t.='<img src="'.PATH_IMAGE.$item['Image'].TYPE_IMAGE.'" onerror="imgError(this)" >';
                                }
                            $t.='</div>  
                        </div>  

                        <div class="right_chitiet_admin">
                            <h1 class="title_chitiet_sp">'.$chitiet_sanpham['TenSP'].'</h1>
                            <p class="gia_chitiet_sp">';
                            if($this->main_lib->connect_server()){
                                $gia_sp = $this->sanpham_model->get_gia_1_sanpham($SanPhamID);  

                                if($gia_sp['GiaMoi'] != null){ 
                                    $giamoi = round($gia_sp['GiaMoi'] + $gia_sp['GiaMoi'] * $gia_sp['Thue'] / 100 , 0);
                                    $giacu = round($gia_sp['GiaCu'] + $gia_sp['GiaCu'] * $gia_sp['Thue'] / 100 , 0);
                                    if($giamoi != $giacu){
                                        $t.='<span class="giamoi">'.number_format($giamoi,'0',',','.').' ₫</span>
                                             <span class="giacu">'.number_format($giacu,'0',',','.').' ₫</span>';
                                    }else{
                                        $t.='<span class="giamoi">'.number_format($giamoi,'0',',','.').' ₫</span>';
                                    } 
                                }else{
                                    $giacu = round($gia_sp['GiaCu'] + $gia_sp['GiaCu'] * $gia_sp['Thue'] / 100 , 0);
                                    $t.='<span class="giamoi">'.number_format($giacu,'0',',','.').' ₫</span>';
                                } 
                                $t.='</p>
                                <p> Giá đã bao gồm thuế <b>'.$gia_sp['Thue'].' %</b></p>';
                            }else{
                                if($chitiet_sanpham['GiaMoi'] != $chitiet_sanpham['GiaCu']){
                                    $t.='<span class="giamoi">'.number_format($chitiet_sanpham['GiaMoi'],'0',',','.').' ₫</span>
                                         <span class="giacu">'.number_format($chitiet_sanpham['GiaCu'],'0',',','.').' ₫</span>';
                                }else{
                                    $t.='<span class="giamoi">'.number_format($chitiet_sanpham['GiaMoi'],'0',',','.').' ₫</span>';
                                } 
                                $t.='<p> Giá đã bao gồm thuế <b>'.$chitiet_sanpham['Thue'].' %</b></p>
                                     <p>Cập nhật giá lần cuối: '.$chitiet_sanpham['NgayUpdateGia'].'</p>
                                </p>';
                            }
                            $t.='<div class="item_row"><span> Mã sản phẩm: </span> <b>'.$chitiet_sanpham['MaSP'].'</b></div>
                            <div class="item_row"><span>Mô tả:</span>'.$chitiet_sanpham['MoTa'].'</div>
                        </div>
                        <script type="text/javascript" src="'.base_url().'application/data/js/fotorama/fotorama.js"></script> 
                    </div>
                </div> ';
        echo $t;
    }

 
// -----get sanpham-----------
    public function get_sp_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->sanpham_model->get_sp_admin($number,$offset);        
        $list_sp = $this->echo_sp_admin($sp,$offset);
        $count = $this->sanpham_model->count_all_sp_admin();
        $result = array(
            'list_sp' => $list_sp,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_sp_admin(){
        echo $this->sanpham_model->count_all_sp_admin();
    }
// -----get sanpham-----------

// ---------------search------------------
    public function search_sp_admin(){
        $key = $_POST['key'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $type = $_POST['type'];
        $sp = $this->sanpham_model->search_sp_admin($key,$number,$offset,$type);
        $list_search = $this->echo_sp_admin($sp,$offset); 
        $count = $this->sanpham_model->count_search_sp_admin($key,$type);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_search_sp_admin(){
        $key = $_POST['key'];
        $type = $_POST['type'];
        echo $this->sanpham_model->count_search_sp_admin($key,$type);
    }
// ---------------search------------------
// ------------------filter-----------------
    public function filter_sp_admin(){
        $key = 'sanpham.'.$_POST['key'];
        $val = $_POST['val'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->sanpham_model->filter_sp_admin($key,$val,$number,$offset);
        $list_search = $this->echo_sp_admin($sp,$offset); 
        $count = $this->sanpham_model->count_filter_sp_admin($key,$val);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_filter_sp_admin(){
        $key = 'sanpham.'.$_POST['key'];
        $val = $_POST['val'];
        echo $this->sanpham_model->count_filter_sp_admin($key,$val);
    }
// ------------------filter-----------------
    public function insert_sanpham(){
        
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date= date("Y/m/d H:i:s"); 
        $_POST['NgayTao'] = $_POST['NgayUpdateGia'] = date('Y/m/d H:i:s');
        $_POST['GiaMoi'] = $_POST['GiaCu'] = $_POST['GiaVon'];
        $kq = $this->sanpham_model->insert_sanpham($_POST); 

        if($kq){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function edit_sanpham(){    
        $_POST['GiaMoi'] = $_POST['GiaCu'] = $_POST['GiaVon'];
        if($this->sanpham_model->update_sanpham($_POST,$_POST['SanPhamID']))
            echo 1;
        else
            echo 0;
    }
    public function get_chitiet_loaisp_admin(){
        $DanhMucID = $_POST['LoaiSPID'];
        echo json_encode($this->loaisanpham_model->chitiet_loaisanpham_admin($DanhMucID) );
    }

    public function delete_sanpham(){
        $TinTucID = $_POST['SanPhamID'];
        if( $this->sanpham_model->delete_sanpham($TinTucID) ){
            echo 1;
        }else{
            echo -1;
        }
    }


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















