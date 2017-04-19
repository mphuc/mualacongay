<?php
class Mangxahoi_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }
    public function get_mangxahoi(){ 
        $this->db->where('HienThi',1); 
        $query = $this->db->get('mangxahoi');
        return $query->result_array();
    } 
 
    // --------------lay tat ca san pham + phan trang------------- 

    public  function insert_mangxahoi($data){
        $this->db->insert('mangxahoi',$data);
        return 1;
    }    

    public function update_mangxahoi($data,$MangXHID){
        $this->db->where("MangXHID",$MangXHID);
        $this->db->update("mangxahoi",$data);
        return true;
    }

    public function delete_mangxahoi($MangXHID){
        $this->db->where('MangXHID',$MangXHID);
        $this->db->delete("mangxahoi");
        return true;
    }    
// ----------------------------ADMIN----------------------------------
    public function get_chitiet_mangxahoi_admin($MangXHID=0){ 
        $this->db->where('MangXHID',$MangXHID);
        $query = $this->db->get('mangxahoi');
        return $query->row_array();
    } 

    public function get_mangxahoi_admin($number, $offset){
        $this->db->select('mangxahoi.*');  
        $this->db->limit($number,$offset);  
        $query = $this->db->get('mangxahoi');
        return $query->result_array();
    } 
    public function count_all_mangxahoi_admin(){  
        $query = $this->db->get('mangxahoi');
        return $query->num_rows();
    } 
}












