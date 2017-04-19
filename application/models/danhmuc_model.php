<?php
class danhmuc_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->Webservice = $this->main_lib->Webservice('Module_DanhMuc');
    }

    public function get_danhmuc(){ 
        $query = $this->db->query("SELECT * FROM danhmuc ORDER BY thutu ASC");
       
        return $query->result_array();
    } 
    public function get_loaisanpham(){ 
        $query = $this->db->get('loaisanpham');
        return $query->result_array();
    } 

    public function get_chitiet_danhmuc($DanhMucID=0){ 
        $this->db->where('DanhMucID',$DanhMucID);
        $query = $this->db->get("danhmuc");
        return $query->row_array();
    }  


//    ------------------UPDATE DATA ADMIN----------------------
    public function all_danhmuc(){ 
        $result = $this->Webservice->call('All_DanhMuc');
        $err = $this->Webservice->getError();
        
        // print_r($result);

        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['All_DanhMucResult'])){
                if(!isset($result['All_DanhMucResult']['DanhMuc'][0])){ 
                    return array_values($result['All_DanhMucResult']);
                }else{
                    return $result['All_DanhMucResult']['DanhMuc'];
                }
            }   
        }
    } 

    public function chitiet_danhmuc_server($DanhMucID=0){ 
        $result = $this->Webservice->call('Chitiet_DanhMuc',array(array("DanhMucID"=>$DanhMucID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['Chitiet_DanhMucResult'])){
                if(!isset($result['Chitiet_DanhMucResult']['DanhMuc'][0])){ 
                    return array_values($result['Chitiet_DanhMucResult']);
                }else{
                    return $result['Chitiet_DanhMucResult']['DanhMuc'];
                }
            }   
        }
    } 

    public  function insert_danhmuc($data){
        $this->db->insert('danhmuc',$data);
        $last_id = $this->db->insert_id();
        return $last_id; 
    }    

    public function check_danhmuc($DanhMucID=0){ 
        $this->db->where('DanhMucID',$DanhMucID);
        $query = $this->db->get("danhmuc");
        return $query->num_rows();
    }  

    public function update_danhmuc($data,$DanhMucID=0){  
        $this->db->where("DanhMucID",$DanhMucID);
        $this->db->update("danhmuc",$data);
        return true;
    }  
     public function delete_danhmuc($TinTucID){
        $this->db->where('DanhMucID',$TinTucID);
        $this->db->delete("danhmuc");
        return true;
    }    
    public function delete_all_danhmuc(){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('danhmuc');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  
    public function get_chitiet_danhmuc_admin($TinTucID=0){ 
        $this->db->where('DanhMucID',$TinTucID);
        $query = $this->db->get('danhmuc');
        return $query->row_array();
    } 

    // ---------ADMIN------------
    public function get_danhmuc_admin($number,$offset){
        $query = $this->db->query("SELECT * FROM danhmuc ORDER BY thutu ASC LIMIT ".$number."
            OFFSET ".$offset."");
       
        return $query->result_array();
    }     


    public function get_all_danhmuc_admin(){
        $query = $this->db->get('danhmuc');
        return $query->result_array();
    } 
    public function get_danhmuc_on_loaihienthi($loaihienthi){
        $this->db->where('loaihienthi',$loaihienthi);
        $query = $this->db->get('danhmuc');
        return $query->result_array();
    }
    public function count_all_danhmuc_admin(){
        $query = $this->db->get('danhmuc');
        return $query->num_rows();
    }  


 

}
?>