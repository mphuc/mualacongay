<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model');
        $this->load->Model('sanpham_model'); 
        $this->load->Model('danhmuc_model'); 
        $this->load->Model('tintuc_model'); 
        $this->load->Model('mangxahoi_model'); 
    } 
 
    public function error_404()
    {
        $data['menuActive'] = 'home';
        $data['title'] = 'Trang chủ || Mua là có ngay';
 
        $data['sidebar'] = $this->main_lib->get_sidebar();
        $data = array_merge($this->main_lib->get_data_index() , $data);

        $this->load->view('header',$data);  
        $this->load->view('aside',$data);  
        $this->load->view('error/404',$data);
        $this->load->view('footer',$data);
    } 
 
}