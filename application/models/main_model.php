<?php
class main_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_danhmuc(){
        $query = $this->db->get('danhmuc');
        return $query->result_array();
    }
    public function get_chitiet_danhmuc($IDdanhmuc){
        $this->db->where('IDdanhmuc',$IDdanhmuc);
        $query = $this->db->get('danhmuc');
        return $query->row_array();
    }
    public function get_chitiet_loaisp($IDloaisp){
        $this->db->where('IDloaisp',$IDloaisp);
        $query = $this->db->get('loaisanpham');
        return $query->row_array();
    }
//    ----------------------------------------

}












