<?php
class ngayupdate_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }  
    public function get_ngayupdate(){
        $query = $this->db->get('ngayupdate');
        return $query->row_array();
    }  
    public function update_ngayupdate($data){
        // $this->db->where("NgayUpdateID",1);
        $this->db->update("ngayupdate",$data);
        return true;
    }  
}

