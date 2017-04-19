<?php
class hinhanh_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database(); 
        $this->Webservice = $this->main_lib->Webservice('Module_HinhAnh');
    }

    public function get_hinhanh($SanPhamID){ 
        $this->db->where('SanPhamID',$SanPhamID);
        $query = $this->db->get('hinhanh');
        return $query->result_array();
    }        

    public  function insert_hinhanh($data){
        $this->db->insert('hinhanh',$data);
        return $this->db->insert_id();
    }    

    public function delete_all_hinhanh_on_SanPhamID($SanPhamID){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->where('SanPhamID',$SanPhamID); 
        $this->db->delete("hinhanh");
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

    public function delete_all_hinhanh(){  
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('hinhanh');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

    public function get_hinhanh_on_sanphamID($SanPhamID){ 
        $result = $this->Webservice->call('HinhAnh_On_SanPhamID',array(array('SanPhamID'=>$SanPhamID)));
        $err = $this->Webservice->getError(); 
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['HinhAnh_On_SanPhamIDResult'])){
                if(!isset($result['HinhAnh_On_SanPhamIDResult']['HinhAnh'][0])){ 
                    return array_values($result['HinhAnh_On_SanPhamIDResult']);
                }else{
                    return $result['HinhAnh_On_SanPhamIDResult']['HinhAnh'];
                }
            }  
        }
    }     
}
?>