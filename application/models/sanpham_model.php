<?php
class SanPham_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database(); 
        $this->Webservice = $this->main_lib->Webservice('Module_SanPham');
    }

    public function get_SanPham(){     
        $query = $this->db->get('sanpham');
        return $query->result_array();
    }     

    public function get_chitiet_SanPham($SanPhamID=0){ 
        $this->db->where('SanPhamID',$SanPhamID);
        $query = $this->db->get('sanpham');
        return $query->row_array();
    }     

    public function get_sanPham_cungloai($SanPhamID=0,$LoaiSPID=0){ 
        $this->db->where('LoaiSPID',$LoaiSPID); 
        $this->db->where('SanPhamID <> '.$SanPhamID,NULL);
        $this->db->order_by("NgayTao DESC");
        $this->db->limit(8,0);
        $query = $this->db->get('sanpham');
        return $query->result_array();
    } 

    public function get_sanPham_new(){ 
        $this->db->order_by("NgayTao DESC");
        $this->db->limit(6,0);
        $query = $this->db->get('sanpham');
        return $query->result_array();
    } 

    public function update_sanpham($data,$SanPhamID){
        $this->db->where("SanPhamID",$SanPhamID);
        $this->db->update("sanpham",$data);
        return true;
    }
    

    

    public function delete_sanpham($TinTucID){
        $this->db->where('SanPhamID',$TinTucID);
        $this->db->delete("sanpham");
        return true;
    }    

    // -----------------search index---------------
    public function search_sanpham($key){ 
        $this->db->like('TenSP',$key);
        $this->db->or_like('MaSP',$key);
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get('sanpham',5, 0);
        return $query->result_array();
    }    

    public function search_all_sanpham($key,$number,$offset){ 
        $this->db->like('TenSP',$key);
        $this->db->order_by("NgayTao DESC");
        $this->db->limit($number,$offset);
        $query = $this->db->get('sanpham');
        return $query->result_array();
    }

    public function count_all_search_sanpham($key){ 
        $this->db->like('TenSP',$key); 
        $query = $this->db->get('sanpham');
        return $query->num_rows();
    }

    // --------------lay tat ca san pham + phan trang-------------
    public function get_sanpham_limit($number,$offset){ 
        $this->db->limit($number,$offset);
        $this->db->order_by("SanPhamID DESC");
        $query = $this->db->get('sanpham');
        return $query->result_array();
    }   
    
    public function count_all_sp(){    
        $query = $this->db->get('sanpham');
        return $query->num_rows();
    }     

    public function get_slide_sanpham(){   
        $this->db->limit(9,0);
        $this->db->order_by("SanPhamID DESC");
        // $this->db->order_by("LuotXem DESC");
        $query = $this->db->get('sanpham');
        return $query->result_array();
    }   
    //----------- lay san pham theo loai san pham--------
    public function all_sanpham_loaisanpham_host($LoaiSPID=0){ 
        $this->db->where('LoaiSPID',$LoaiSPID);
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get("sanpham");
        return $query->result_array();
    } 

    // -----------lay san pham theo loai + phan trang---------
    public function get_sanpham_on_loai($LoaiSPID=0,$number,$offset){ 
        $this->db->limit($number,$offset);
        $this->db->where('LoaiSPID',$LoaiSPID);
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get("sanpham");
        return $query->result_array();
    } 
    public function count_sanpham_on_loai($LoaiSPID=0){ 
        $this->db->where('LoaiSPID',$LoaiSPID);
        $query = $this->db->get("sanpham");
        return $query->num_rows();
    } 

    // -----------lay san pham theo danh muc + phan trang---------
    public function get_sanpham_on_danhmuc_index($DanhMucID=0,$number,$offset){ 
        $this->db->where('danhmuc.DanhMucID',$DanhMucID);
       // $this->db->join('loaisanpham', 'loaisanpham.LoaiSPID = sanpham.LoaiSPID');
        $this->db->join('danhmuc', 'danhmuc.DanhMucID = sanpham.LoaiSPID');
        $this->db->limit($number,$offset);
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get("sanpham");
        return $query->result_array();
    } 
    public function count_sanpham_on_danhmuc_index($DanhMucID=0){ 
        $this->db->where('danhmuc.DanhMucID',$DanhMucID);
        $this->db->join('loaisanpham', 'loaisanpham.LoaiSPID = sanpham.LoaiSPID');
        $this->db->join('danhmuc', 'danhmuc.DanhMucID = loaisanpham.DanhMucID');
        $query = $this->db->get("sanpham");
        return $query->num_rows();
    } 


    // --------------------- WEBSERVICE--------------------

    public function get_SanPham_on_danhmuc($DanhMucID=0){ 
        $result = $this->Webservice->call('SanPham_TheoDanhMuc',array(array("DanhMucID"=>$DanhMucID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['SanPham_TheoDanhMucResult'])){
                if(!isset($result['SanPham_TheoDanhMucResult']['SanPham'][0])){ 
                    return array_values($result['SanPham_TheoDanhMucResult']);
                }else{
                    return $result['SanPham_TheoDanhMucResult']['SanPham'];
                }
            }   
        }
    } 
        //-----------------giá mới + giá cũ -----------------
    public function get_gia_sanpham($data){ 
        $result = $this->Webservice->call('All_Gia_SanPham',array(array("arr_SanPhamID"=>$data)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['All_Gia_SanPhamResult'])){
                if(!isset($result['All_Gia_SanPhamResult']['SP_Lay_Gia_SanPhamResult'][0])){ 
                    return array_values($result['All_Gia_SanPhamResult']);
                }else{
                    return $result['All_Gia_SanPhamResult']['SP_Lay_Gia_SanPhamResult'];
                }
            }  
        }
    } 
        // ----------giá 1 san pham----------
    public function get_gia_1_sanpham($SanPhamID){ 
        $result = $this->Webservice->call('Get_Gia_1_SanPham',array(array("SanPhamID"=>$SanPhamID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(isset($result['Get_Gia_1_SanPhamResult'])) 
                return $result['Get_Gia_1_SanPhamResult'];
        }
    }  
 
    public function all_sanpham_loaisanpham_server($LoaiSPID){ 
        $result = $this->Webservice->call('All_SanPham_LoaiSanPham',array(array("LoaiSPID"=>$LoaiSPID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['All_SanPham_LoaiSanPhamResult'])){
                if(!isset($result['All_SanPham_LoaiSanPhamResult']['SanPham'][0])){ 
                    return array_values($result['All_SanPham_LoaiSanPhamResult']);
                }else{
                    return $result['All_SanPham_LoaiSanPhamResult']['SanPham'];
                }
            }    
        }
    } 

    public function Chitiet_SanPham_server($SanPhamID){ 
        $result = $this->Webservice->call('Chitiet_SanPham',array(array("SanPhamID"=>$SanPhamID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['Chitiet_SanPhamResult'])){
                if(!isset($result['Chitiet_SanPhamResult']['SanPham'][0])){ 
                    return array_values($result['Chitiet_SanPhamResult']);
                }else{
                    return $result['Chitiet_SanPhamResult']['SanPham'];
                }
            }   
        }
    } 

    public  function insert_sanpham($data){
        $this->db->insert('sanpham',$data);
        return $this->db->insert_id();
    }    
 
    public function delete_all_sanpham(){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('sanpham');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true; 
    }  

    public function delete_sanpham_loaisanpham($LoaiSPID){
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->where('LoaiSPID',$LoaiSPID);
        $this->db->delete("sanpham");
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

    public function check_sanpham($SanPhamID=0){ 
        $this->db->where('SanPhamID',$SanPhamID);
        $query = $this->db->get("sanpham");
        return $query->num_rows();
    }  

    // public function delete_all_sanpham_on_DanhMucID($DanhMucID){  
    //     $sql = '
    //     DELETE sanpham.* FROM sanpham
    //     INNER JOIN loaisanpham ON sanpham.LoaiSPID = loaisanpham.LoaiSPID 
    //     WHERE loaisanpham.DanhMucID = '.$DanhMucID;

    //     $this->db->query($sql);
    // }  
// ----------------------------ADMIN----------------------------------
    public function get_chitiet_SanPham_admin($SanPhamID=0){ 
        $this->db->where('SanPhamID',$SanPhamID);
        $query = $this->db->get('sanpham');
        return $query->row_array();
    }     

    public function get_sp_admin($number, $offset){
        $this->db->select('sanpham.*'); 
        
        $this->db->join('danhmuc', 'sanpham.LoaiSPID = danhmuc.DanhMucID');
        $this->db->limit($number,$offset); 
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get('sanpham');
        return $query->result_array();
    } 
    public function count_all_sp_admin(){ 
        $this->db->join('loaisanpham', 'loaisanpham.LoaiSPID = sanpham.LoaiSPID');
        $this->db->join('danhmuc', 'loaisanpham.DanhMucID = danhmuc.DanhMucID');
        $query = $this->db->get('sanpham');
        return $query->num_rows();
    }
    // ----------------------search------------------
    public function search_sp_admin($key,$number, $offset, $type){
        $this->db->select('sanpham.*');
        if($type != null){
            foreach ((array)$type as $item ) {
                $this->db->or_like($item,$key);
            }
        }  
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get('sanpham',$number, $offset);
        return $query->result_array();
    }    
    public function count_search_sp_admin($key,$type){
        if($type != null){
            foreach ((array)$type as $item ) {
                $this->db->or_like($item,$key);
            }
        }  
        $this->db->join('loaisanpham', 'loaisanpham.LoaiSPID = sanpham.LoaiSPID');
        $this->db->join('danhmuc', 'loaisanpham.DanhMucID = danhmuc.DanhMucID');
        $query = $this->db->get('sanpham');
        return $query->num_rows();
    }

    // ---------------------filter------------------
    public function filter_sp_admin($key, $val, $number, $offset){
        $this->db->select('sanpham.*');
        $this->db->where($key,$val);  
        $this->db->join('loaisanpham', 'loaisanpham.LoaiSPID = sanpham.LoaiSPID');
        $this->db->join('danhmuc', 'loaisanpham.DanhMucID = danhmuc.DanhMucID');
        $this->db->order_by("NgayTao DESC");
        $query = $this->db->get('sanpham',$number, $offset);
        return $query->result_array();
    }    
    public function count_filter_sp_admin($key,$val){ 
        $this->db->where($key,$val);  
        $this->db->join('loaisanpham', 'loaisanpham.LoaiSPID = sanpham.LoaiSPID');
        $this->db->join('danhmuc', 'loaisanpham.DanhMucID = danhmuc.DanhMucID');
        $query = $this->db->get('sanpham');
        return $query->num_rows();
    }  
}












