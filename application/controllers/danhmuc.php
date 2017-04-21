<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Danhmuc extends CI_Controller {
    private $arr_loaihienthi = array();
    public function __construct(){ 
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model'); 
        $this->load->Model('loaisanpham_model');
        $this->load->Model('danhmuc_model');  
        $this->load->Model('hinhanh_model'); 
        $this->load->Model('mangxahoi_model');  
        $this->load->Model('tintuc_model');   
        $this->load->Model('thongtin_model');   
    }  
    // ------------INDEX------------
    public function index($DanhMucID,$page=0){ 



        $history=1;
        if(isset($_POST['history'])){
            $history = $_POST['history']; 
        }    

        $number = ($this->session->userdata("per_page")) ? $this->session->userdata("per_page") : PER_PAGE;
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 

        $data['list_sanpham'] = $this->sanpham_model->get_sanpham_on_danhmuc_index($DanhMucID,$number,$offset);
        print_r($data['list_sanpham']);die;
        // $data['list_gia'] = $this->main_lib->get_gia_sanpham($data['list_sanpham']); 
        $data['danhmuc'] = $this->danhmuc_model->get_chitiet_danhmuc($DanhMucID);
        if ($data['danhmuc']['lock_dm'] == 1)
        {
            session_start();
            if (!isset($_SESSION['lock_ql']))
            {
                redirect('/lock', 'location');
            }
        }
        $count_all_sp = $this->sanpham_model->count_sanpham_on_danhmuc_index($DanhMucID);
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
        $data['sidebar'] = $this->main_lib->get_sidebar($DanhMucID,0);
        $data['product_new'] = $this->main_lib->get_product_new();
        $data['title'] = $data['danhmuc']['TenDanhMuc'].' || Mua là có ngay';
        $data = array_merge($this->main_lib->get_data_index() , $data);
        
        ($history == 1) ? $this->load->view('header',$data):0;
        ($history == 1) ? $this->load->view('aside',$data):0;
        $this->load->view('main',$data);
        ($history == 1) ? $this->load->view('footer',$data):0;
    }
      
    // ================================== ADMIN ========================================
    public function echo_danhmuc_admin($danhmuc,$offset){

        $t = '';
        if(!empty($danhmuc)){
            $count = $this->danhmuc_model->count_all_danhmuc_admin();
            foreach ($danhmuc as $item) {
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td class="text_center">#'.$item['DanhMucID'].'</td>    
                        <td>'.$item['TenDanhMuc'].'</td>   
                        <td>'.$item['thutu'].'</td>   
                        <td class="text_center">
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_tintuc toggle_form_add_edit" DanhMucID = "'.$item['DanhMucID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_tintuc dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_danhmuc" value="Đồng ý" DanhMucID = "'.$item['DanhMucID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                        </td>
                    </tr>';
            } 
        }else{
            $t.='<tr><td colspan="8">Không có danh mục sản phẩm!</td></tr>';
        }
        return $t;
    }

    public function get_danhmuc_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $danhmuc = $this->danhmuc_model->get_danhmuc_admin($number,$offset);
        $list_danhmuc = $this->echo_danhmuc_admin($danhmuc,$offset);
        $count = $this->danhmuc_model->count_all_danhmuc_admin();
        $result = array(
            'list_danhmuc' => $list_danhmuc,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_danhmuc_admin(){
        echo $this->danhmuc_model->count_all_danhmuc_admin();
    }
    public function insert_danhmuc(){

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date= date("Y/m/d H:i:s"); 

       
        $data = array( 
            "TenDanhMuc"=>$_POST['TieuDe'],
            "thutu"=>$_POST['thutu'],
        );
        $kq = $this->danhmuc_model->insert_danhmuc($data); 
    
        if(!$kq){
            echo -1;
        }else{
            echo 1;
        }
    }

    public function edit_danhmuc(){    
        
        $data = array( 
            "TenDanhMuc"=>$_POST['TenDanhMuc'],
            "thutu"=>$_POST['thutu']
        );
        if($this->danhmuc_model->update_danhmuc($data,$_POST['DanhMucID']))
            echo 1;
        else
            echo 0;
    }
    public function get_chitiet_danhmuc_admin(){
        $DanhMucID = $_POST['DanhMucID'];
        echo json_encode($this->danhmuc_model->get_chitiet_danhmuc_admin($DanhMucID) );
    }

    public function delete_danhmuc(){
        
        $TinTucID = $_POST['LoaiSPID'];
        if( $this->danhmuc_model->delete_danhmuc($TinTucID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

}

