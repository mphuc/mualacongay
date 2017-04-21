<?php
class loaisanpham_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->Webservice = $this->main_lib->Webservice('Module_LoaiSanPham');
    }

    public function get_loaisp_on_danhmuc($DanhMucID=0){ 
        $this->db->where('DanhMucID',$DanhMucID);
        $query = $this->db->get("loaisanpham");
        return $query->result_array();
    } 

    public function get_danhmuc($id_dm){ 
        $query = $this->db->query("SELECT * FROM danhmuc where DanhMucID = '".$id_dm."'");
       
        return $query->row_array();
    } 

    public function get_chitiet_loaisp($LoaiSPID=0){ 
        $this->db->where('loaisanpham.LoaiSPID',$LoaiSPID);
        $this->db->join('danhmuc','loaisanpham.DanhMucID = danhmuc.DanhMucID');
        $query = $this->db->get("loaisanpham");
        return $query->row_array();
    }  

    //    ------------------UPDATE DATA ADMIN----------------------
    public function loaisanpham_on_DanhMucID($DanhMucID){ 
        $result = $this->Webservice->call('LoaiSanPham_On_DanhMucID',array(array("DanhMucID"=>$DanhMucID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['LoaiSanPham_On_DanhMucIDResult'])){
                if(!isset($result['LoaiSanPham_On_DanhMucIDResult']['LoaiSanPham'][0])){ 
                    return array_values($result['LoaiSanPham_On_DanhMucIDResult']);
                }else{
                    return $result['LoaiSanPham_On_DanhMucIDResult']['LoaiSanPham'];
                }
            }    
        }
    } 

    public function chitiet_loaisanpham_server($LoaiSPID){ 
        $result = $this->Webservice->call('Chitiet_LoaiSanPham',array(array("LoaiSPID"=>$LoaiSPID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['Chitiet_LoaiSanPhamResult'])){
                if(!isset($result['Chitiet_LoaiSanPhamResult']['LoaiSanPham'][0])){ 
                    return array_values($result['Chitiet_LoaiSanPhamResult']);
                }else{
                    return $result['Chitiet_LoaiSanPhamResult']['LoaiSanPham'];
                }
            }    
        }
    } 
    public function chitiet_loaisanpham_admin($LoaiSPID){ 
        $this->db->where('LoaiSPID',$LoaiSPID);
        $query = $this->db->get("loaisanpham");
        return $query->row_array();
    } 
    public  function insert_loaisanpham($data){
        $this->db->insert('loaisanpham',$data);
        return $this->db->insert_id();
    }    

    public function update_loaisanpham($data,$LoaiSPID){
        $this->db->where("LoaiSPID",$LoaiSPID);
        $this->db->update("loaisanpham",$data);
        return true;
    }
 
    public function delete_all_loaisanpham(){  
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('loaisanpham');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

    public function delete_loaisanpham_danhmuc($DanhMucID){
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->where('DanhMucID',$DanhMucID);
        $this->db->delete("loaisanpham");
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  
    public function delete_loaisanpham($TinTucID){
        $this->db->where('LoaiSPID',$TinTucID);
        $this->db->delete("loaisanpham");
        return true;
    }   

    public function check_loaisanpham($LoaiSPID = 0){ 
        $this->db->where('LoaiSPID',$LoaiSPID);
        $query = $this->db->get("loaisanpham");
        return $query->num_rows();
    }  

    // ------------ ADMIN ----------
    public function get_loaisp_admin($number,$offset){
        $this->db->limit($number,$offset);   
        $this->db->order_by('LoaiSPID asc');
        $query = $this->db->get('loaisanpham');
        return $query->result_array();
    } 
    public function count_all_loaisp_admin(){
        $query = $this->db->get('loaisanpham');
        return $query->num_rows();
    }    


    public function count_all_loaisp_on_danhmuc_admin($IDdanhmuc){
        $this->db->where('IDdanhmuc',$IDdanhmuc);
        $query = $this->db->get('loaisanpham');
        return $query->num_rows();
    }

}
?>