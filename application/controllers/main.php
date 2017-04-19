<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model');  
        $this->load->Model('danhmuc_model');  
        $this->load->Model('loaisanpham_model');  
        $this->load->Model('mangxahoi_model');  
        $this->load->Model('tintuc_model');  
        $this->load->Model('thongtin_model');   
    }

	public function index(){  
        $data['menuActive'] = 'trangchu';
        $data['title'] = 'Trang chủ ||  Mua là có ngay';

        $number = ($this->session->userdata("per_page")) ? $this->session->userdata("per_page") : PER_PAGE;
        $page = 1;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 

        $data['list_sanpham'] = $this->sanpham_model->get_sanpham_limit($number,$offset);
        if( $this->main_lib->connect_server() ) {
            $data['list_gia'] = $this->main_lib->get_gia_sanpham($data['list_sanpham']); 
        }
        $count_all_sp = $this->sanpham_model->count_all_sp();
        $data['all_page'] = ceil($count_all_sp/$number);
        $data['cur_page'] = $page; 

        $count_list = count($data['list_sanpham']);
        $from = ($offset == 1) ? $offset : $offset+1;
        $to = $offset+$number;
        $to = ($count_all_sp > $to) ? $to : $count_all_sp; 
        $data['from'] = $from; 
        $data['to'] = $to; 
        $data['all'] = $count_all_sp; 
 
        $data['sidebar'] = $this->main_lib->get_sidebar(); 

        $data['product_new'] = $this->main_lib->get_product_new();

        $data = array_merge($this->main_lib->get_data_index() , $data);
       
        $this->load->view('header',$data); 
        $this->load->view('aside',$data);
        $this->load->view('main',$data);
        $this->load->view('footer',$data);  
    }   
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















