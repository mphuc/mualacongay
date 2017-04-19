<?php
class email_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }
    public function get_email_default(){ 
        $this->db->where('default',1); 
        $query = $this->db->get('email');
        return $query->row_array();
    }  

    public function get_all_email(){  
        $query = $this->db->get('email');
        return $query->result_array();
    } 

    public  function insert_email($data){
        $this->db->insert('email',$data);
        return 1;
    }    

    public function update_email($data,$EmailID){
        $this->db->where("EmailID",$EmailID);
        $this->db->update("email",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }    

    public function update_all_email($data){ 
        $this->db->update("email",$data);
        return true;
    }

    public function delete_email($EmailID){
        $this->db->where('EmailID',$EmailID);
        $this->db->delete("email");
        return true;
    }    
// ----------------------------ADMIN----------------------------------
    public function get_chitiet_email_admin($EmailID=0){ 
        $this->db->where('EmailID',$EmailID);
        $query = $this->db->get('email');
        return $query->row_array();
    } 

    public function get_email_admin($number, $offset){
        $this->db->select('email.*');  
        $this->db->limit($number,$offset);  
        $query = $this->db->get('email');
        return $query->result_array();
    } 
    public function count_all_email_admin(){  
        $query = $this->db->get('email');
        return $query->num_rows();
    } 
}












