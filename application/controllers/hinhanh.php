<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sanpham extends CI_Controller {
    var $loaihienthi ;
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model'); 
        $this->load->Model('loaisanpham_model');
        $this->load->Model('danhmuc_model');  
    }

    public function index($IDsp)
    {
        $data['menuActive'] = 'home';
        $data['title'] = 'Trang chủ || Mua là có ngay';

        $data['chitiet_sanpham'] = $this->sanpham_model->get_chitiet_sanpham($IDsp);

        $data['danhmuc'] = $this->danhmuc_model->get_danhmuc();
        $data['sidebar'] = $this->main_lib->get_sidebar();

        $this->load->view('header',$data); 
        $this->load->view('sanpham/index',$data);
        $this->load->view('footer',$data); 
    }

}
?>