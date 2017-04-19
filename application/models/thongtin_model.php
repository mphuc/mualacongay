<?php
class thongtin_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database();  
        $this->Webservice = $this->main_lib->Webservice('Module_ThongTinCuaHang');
    } 
    
    public function get_thongtin(){   
        $query = $this->db->get('thongtin');
        return $query->row_array();
    }   
     
    public function update_thongtin($data){ 
        $this->db->update("thongtin",$data);
        return true;
    } 
// ----------------------------ADMIN---------------------------------- 
    public function get_thongtin_admin(){
        $query = $this->db->get('thongtin');
        return $query->row_array();
    }  

    public function get_thongtincuahang(){ 
        $result = $this->Webservice->call('Get_ThongTinCuaHang');
        $err = $this->Webservice->getError(); 
        if ($err) { 
            return $err; 
        }else{  
            if(!empty($result['Get_ThongTinCuaHangResult'])){
                if(!isset($result['Get_ThongTinCuaHangResult']['ThongTinCuaHang'][0])){ 
                    return array_values($result['Get_ThongTinCuaHangResult']);
                }else{
                    return $result['Get_ThongTinCuaHangResult']['ThongTinCuaHang'];
                }
            }    
        }
    }   

    public function get_1_thongtincuahang($ThongTinID){ 
        $this->db->where('ThongTinID',$ThongTinID);
        $query = $this->db->get('thongtin');
        return $query->row_array();
    }  
}












