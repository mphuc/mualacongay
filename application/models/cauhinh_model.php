<?php
class cauhinh_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }  
    public function get_cauhinh(){
        $query = $this->db->get('cauhinh');
        return $query->row_array();
    }  
    // ----------------------------ADMIN---------------------------------- 
    public function update_cauhinh($data,$CauHinhID){
        $this->db->where("CauHinhID",$CauHinhID);
        $this->db->update("cauhinh",$data);
        return true;
    } 
    public function get_cauhinh_admin(){
        $query = $this->db->get('cauhinh');
        return $query->row_array();
    }  
}












