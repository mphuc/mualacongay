<?php
class Tintuc_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();  
    }
    public function get_chitiet_tintuc($TinTucID=0){ 
        $this->db->where('HienThi',1);
        $this->db->where('TinTucID',$TinTucID);
        $query = $this->db->get('tintuc');
        return $query->row_array();
    } 

    // -----------------search index---------------
    public function search_tintuc($key){ 
        $this->db->where('HienThi',1);
        $this->db->like('TieuDe',$key);
        $this->db->order_by("Ngay DESC");
        $query = $this->db->get('tintuc',5, 0);
        return $query->result_array();
    }       

    public function search_all_tintuc($key,$number,$offset){ 
        $this->db->where('HienThi',1);
        $this->db->like('TieuDe',$key);
        $this->db->order_by("Ngay DESC");
        $this->db->limit($number,$offset);
        $query = $this->db->get('tintuc');
        return $query->result_array();
    }  

    public function count_all_search_tintuc($key){
        $this->db->where('HienThi',1);
        $this->db->like('TieuDe',$key);
        $query = $this->db->get('tintuc');
        return $query->num_rows();
    }    
    // --------------lay tat ca san pham + phan trang-------------
    public function get_tintuc_limit($number,$offset){  
        $this->db->where('HienThi',1);
        $this->db->limit($number,$offset);
        $this->db->order_by("Ngay DESC");
        $query = $this->db->get('tintuc');
        return $query->result_array();
    }   
    
    public function count_all_tintuc(){    
        $this->db->where('HienThi',1);
        $query = $this->db->get('tintuc');
        return $query->num_rows();
    }      

    public  function insert_tintuc($data){
        $this->db->insert('tintuc',$data);
        return 1;
    }    

    public function update_tintuc($data,$TinTucID){
        $this->db->where("TinTucID",$TinTucID);
        $this->db->update("tintuc",$data);
        return true;
    }

    public function delete_tintuc($TinTucID){
        $this->db->where('TinTucID',$TinTucID);
        $this->db->delete("tintuc");
        return true;
    }    
// ----------------------------ADMIN----------------------------------
    public function get_chitiet_tintuc_admin($TinTucID=0){ 
        $this->db->where('TinTucID',$TinTucID);
        $query = $this->db->get('tintuc');
        return $query->row_array();
    } 

    public function get_tintuc_admin($number, $offset){
        $this->db->select('tintuc.*');  
        $this->db->limit($number,$offset); 
        $this->db->order_by("Ngay DESC");
        $query = $this->db->get('tintuc');
        return $query->result_array();
    } 
    public function count_all_tintuc_admin(){  
        $query = $this->db->get('tintuc');
        return $query->num_rows();
    }
    // ----------------------search------------------
    public function search_tintuc_admin($key,$number, $offset){
        $this->db->select('tintuc.*'); 
        $this->db->like('TieuDe',$key);
        $this->db->order_by("Ngay DESC");
        $query = $this->db->get('tintuc',$number, $offset);
        return $query->result_array();
    }    
    public function count_search_tintuc_admin($key){ 
        $this->db->like('TieuDe',$key);         
        $query = $this->db->get('tintuc');
        return $query->num_rows();
    }
 
}












