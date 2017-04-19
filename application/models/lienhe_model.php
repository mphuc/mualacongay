<?php
class Lienhe_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }
    public function get_lienhe(){ 
        $this->db->where('HienThi',1); 
        $query = $this->db->get('lienhe');
        return $query->result_array();
    } 
  
    public  function insert_lienhe($data){
        $this->db->insert('lienhe',$data);
        return 1;
    }     

    public function delete_lienhe($LienHeID){
        $this->db->where('LienHeID',$LienHeID);
        $this->db->delete("lienhe");
        return true;
    }    
// ----------------------------ADMIN---------------------------------- 
    public function get_lienhe_admin($number, $offset){
        $this->db->select('lienhe.*');  
        $this->db->order_by("Ngay DESC");
        $this->db->limit($number,$offset);  
        $query = $this->db->get('lienhe');
        return $query->result_array();
    } 
    public function count_all_lienhe_admin(){  
        $query = $this->db->get('lienhe');
        return $query->num_rows();
    } 
}












