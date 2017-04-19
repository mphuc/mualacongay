<?php
class binhluan_model extends CI_Model{ 
    public function __construct(){
        parent::__construct();
        $this->load->database(); 
    }

    public function get_binhluan_SanPhamID($SanPhamID=0,$number=5,$offset=0){
        $this->db->limit($number,$offset);   
        $this->db->where('HienThi',1);
        $this->db->where('SanPhamID',$SanPhamID);
        $this->db->order_by('Ngay desc');
        $query = $this->db->get('binhluan');
        return $query->result_array();
    } 

    public function count_binhluan_SanPhamID($SanPhamID=0){ 
        $this->db->where('HienThi',1);
        $this->db->where('SanPhamID',$SanPhamID);
        $query = $this->db->get("binhluan");
        return $query->num_rows();
    }   

    public function get_binhluan_sub_BinhLuanID($BinhLuanID=0){
        $this->db->where('HienThi',1);
        $this->db->where('BinhLuanID',$BinhLuanID);
        $this->db->order_by('Ngay asc');
        $query = $this->db->get('traloi_binhluan');
        return $query->result_array();
    } 

    public  function insert_binhluan($data){
        $this->db->insert('binhluan',$data);
        return $this->db->insert_id();
    }        

    public  function insert_binhluan_sub($data){
        $this->db->insert('traloi_binhluan',$data);
        return $this->db->insert_id();
    }    

    public function update_binhluan($data,$BinhLuanID){
        $this->db->where("BinhLuanID",$BinhLuanID);
        $this->db->update("binhluan",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }
    public function update_traloi_binhluan($data,$TraLoi_BinhLuanID){
        $this->db->where("TraLoi_BinhLuanID",$TraLoi_BinhLuanID);
        $this->db->update("traloi_binhluan",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }

    public function delete_binhluan($BinhLuanID){
        $this->db->where('BinhLuanID',$BinhLuanID);
        $this->db->delete("binhluan");
        return true;
    }      
    public function delete_traloi_binhluan($TraLoi_BinhLuanID){
        $this->db->where('TraLoi_BinhLuanID',$TraLoi_BinhLuanID);
        $this->db->delete("traloi_binhluan");
        return true;
    }  
    public function delete_traloi_binhluan_on_BinhLuanID($BinhLuanID){
        $this->db->where('BinhLuanID',$BinhLuanID);
        $this->db->delete("traloi_binhluan");
        return true;
    } 

    // ------------ ADMIN ----------
    public function get_binhluan_admin($number,$offset){
        $this->db->join('sanpham','sanpham.SanPhamID = binhluan.SanPhamID');   
        $this->db->limit($number,$offset);   
        $this->db->order_by('Ngay desc');
        $query = $this->db->get('binhluan');
        return $query->result_array();
    } 
    public function count_all_binhluan_admin(){
        $query = $this->db->get('binhluan');
        return $query->num_rows();
    }   
    public function get_binhluan_sub_BinhLuanID_admin($BinhLuanID=0){
        $this->db->where('BinhLuanID',$BinhLuanID);
        $this->db->order_by('Ngay desc');
        $query = $this->db->get('traloi_binhluan');
        return $query->result_array();
    } 

    // ----------------------search------------------
    public function search_binhluan_admin($key,$number, $offset){ 
        $this->db->query('select * from traloi_binhluan','traloi_binhluan.BinhLuanID = binhluan.BinhLuanID','left outer');
        $this->db->like('binhluan.Email',$key);
        $this->db->limit($number,$offset);
        $this->db->order_by("left outer.Ngay DESC");
        $query = $this->db->get();
        return $query->result_array();
    }    
    public function count_search_binhluan_admin($key){ 
        $this->db->like('Email',$key);         
        $query = $this->db->get('binhluan');
        return $query->num_rows();
    }
 

    public function delete_all_binhluan(){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('binhluan');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

    public function delete_all_traloi_binhluan(){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('traloi_binhluan');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  
}
?>