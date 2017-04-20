<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loaisp extends CI_Controller {
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
    public function index($LoaiSPID,$page=0){ 
        $history=1;
        if(isset($_POST['history'])){
            $history = $_POST['history']; 
        }    

        $number = ($this->session->userdata("per_page")) ? $this->session->userdata("per_page") : PER_PAGE;
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 

        $data['list_sanpham'] = $this->sanpham_model->get_sanpham_on_loai($LoaiSPID,$number,$offset);
        // $data['list_gia'] = $this->main_lib->get_gia_sanpham($data['list_sanpham']); 
        $data['loaisp'] = $this->loaisanpham_model->get_chitiet_loaisp($LoaiSPID);
        $loaisp = $data['loaisp'];
        $data['path_1'] = '<a href="'.base_url().'danh-muc/'.$loaisp['DanhMucID'].'/'.url_title(removesign($loaisp['TenDanhMuc'])).'">'.$loaisp['TenDanhMuc'].'</a>';

        $count_all_sp = $this->sanpham_model->count_sanpham_on_loai($LoaiSPID);
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
        
        $data['sidebar'] = $this->main_lib->get_sidebar(0,$LoaiSPID);
        $data['title'] = $data['loaisp']['TenLoaiSP'].' || Mua là có ngay';
        $data = array_merge($this->main_lib->get_data_index() , $data);
        $data['product_new'] = $this->main_lib->get_product_new();
        ($history == 1) ? $this->load->view('header',$data):0;
        ($history == 1) ? $this->load->view('aside',$data):0;
        $this->load->view('main',$data);
        ($history == 1) ? $this->load->view('footer',$data):0;
    }   

    // ------------ADMIN-----------
    public function echo_loaisp_admin($loaisp,$offset){
        $t = '';
        if(!empty($loaisp)){
            $dm = $this->danhmuc_model->get_all_danhmuc_admin();
            foreach ($loaisp as $item) { 
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td class="text_center">#'.$item['LoaiSPID'].'</td>    
                        <td>'.$item['MaLoaiSP'].'</td>     
                        <td>'.$item['TenLoaiSP'].'</td>     
                        <td >';
                                foreach ($dm as $key) {
                                    if($item['DanhMucID'] == $key['DanhMucID']) 
                                        $t.=$key['TenDanhMuc'];
                                }
                        $t.='</td> 
                        <td class="text_center">
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_tintuc toggle_form_add_edit" LoaiSPID = "'.$item['LoaiSPID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_tintuc dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_danhmuc" value="Đồng ý" LoaiSPID = "'.$item['LoaiSPID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                        </td>
                    </tr>';
            } 
        }else{
            $t.='<tr><td colspan="8">Không có loại sản phẩm!</td></tr>';
        }            
        return $t;
    }

    public function get_loaisp_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $loaisp = $this->loaisanpham_model->get_loaisp_admin($number,$offset);
        $list_loaisp = $this->echo_loaisp_admin($loaisp,$offset);
        $count = $this->loaisanpham_model->count_all_loaisp_admin();
        $result = array(
            'list_loaisp' => $list_loaisp,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_loaisp_admin(){
        echo $this->loaisanpham_model->count_all_loaisp_admin();
    }

    public function insert_loaisp(){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date= date("Y/m/d H:i:s"); 
       
        $kq = $this->loaisanpham_model->insert_loaisanpham($_POST); 

        if(!$kq){
            echo -1;
        }else{
            echo 1;
        }
    }

    public function edit_loaisp(){    
      
        if($this->loaisanpham_model->update_loaisanpham($_POST,$_POST['LoaiSPID']))
            echo 1;
        else
            echo 0;
    }
    public function get_chitiet_loaisp_admin(){
        $DanhMucID = $_POST['LoaiSPID'];
        echo json_encode($this->loaisanpham_model->chitiet_loaisanpham_admin($DanhMucID) );
    }

    public function delete_loaisp(){
        $TinTucID = $_POST['LoaiSPID'];
        if( $this->loaisanpham_model->delete_loaisanpham($TinTucID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

}

