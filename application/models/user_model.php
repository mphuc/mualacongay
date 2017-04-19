<?php
class user_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    } 

    public function login_user($Username,$Password){
        $this->db->where('TrangThai',1);
        $this->db->where('Username',$Username);
        $this->db->where('Password',$Password);
        $query = $this->db->get('user');
        return $query->row_array();
    } 
    public function update_user($data,$UserID){
        $this->db->where("UserID",$UserID);
        $this->db->update("user",$data);
        return true;
    } 

    public  function insert_user($data){
        $this->db->insert('user',$data);
        return 1;
    }    

    public function delete_user($UserID){
        $this->db->where('UserID',$UserID);
        $this->db->delete("user");
        return true;
    }    
// ----------------------------ADMIN----------------------------------
    public function get_chitiet_user_admin($UserID=0){ 
        $this->db->where('UserID',$UserID);
        $query = $this->db->get('user');
        return $query->row_array();
    } 

    public function get_user_admin($number, $offset){
        $this->db->select('user.*');  
        $this->db->limit($number,$offset);  
        $query = $this->db->get('user');
        return $query->result_array();
    } 
    public function count_all_user_admin(){  
        $query = $this->db->get('user');
        return $query->num_rows();
    } 

    public function check_username($Username){
        $this->db->where('Username',$Username);
        $query = $this->db->get('user');
        return $query->num_rows();
    } 
}












