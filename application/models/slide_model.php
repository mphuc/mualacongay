<?php
class Slide_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }
    public function get_slide(){ 
        $this->db->where('HienThi',1); 
        $query = $this->db->get('slide');
        return $query->result_array();
    } 
 
    // --------------lay tat ca san pham + phan trang------------- 

    public  function insert_slide($data){
        $this->db->insert('slide',$data);
        return 1;
    }    

    public function update_slide($data,$SlideID){
        $this->db->where("SlideID",$SlideID);
        $this->db->update("slide",$data);
        return true;
    }

    public function delete_slide($SlideID){
        $this->db->where('SlideID',$SlideID);
        $this->db->delete("slide");
        return true;
    }    
// ----------------------------ADMIN----------------------------------
    public function get_chitiet_slide_admin($SlideID=0){ 
        $this->db->where('SlideID',$SlideID);
        $query = $this->db->get('slide');
        return $query->row_array();
    } 

    public function get_slide_admin($number, $offset){
        $this->db->select('slide.*');  
        $this->db->limit($number,$offset);  
        $query = $this->db->get('slide');
        return $query->result_array();
    } 
    public function count_all_slide_admin(){  
        $query = $this->db->get('slide');
        return $query->num_rows();
    } 
}












