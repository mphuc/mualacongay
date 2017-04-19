<?php
class Address_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->Webservice = $this->main_lib->Webservice('Module_Address');
    }

    public function get_tinhtp(){ 
        $query = $this->db->get('tinhtp');
        return $query->result_array();
    }        

    public function get_all_quanhuyen(){ 
        $query = $this->db->get('quanhuyen');
        return $query->result_array();
    }    

    public function get_quanhuyen($TinhTPID){ 
        $this->db->where('quanhuyen.TinhTPID',$TinhTPID);    
        $this->db->join('tinhtp', 'tinhtp.TinhTPID = quanhuyen.TinhTPID');
        $query = $this->db->get('quanhuyen');
        return $query->result_array();
    }      

    public function get_xaphuong($QuanHuyenID){ 
        $this->db->where('xaphuong.QuanHuyenID',$QuanHuyenID);    
        $this->db->join('quanhuyen', 'xaphuong.QuanHuyenID = quanhuyen.QuanHuyenID');
        $query = $this->db->get('xaphuong');
        return $query->result_array();
    }      

    public function get_address_on_xaphuong($XaPhuongID){ 
        $this->db->where('xaphuong.XaPhuongID',$XaPhuongID);    
        $this->db->join('quanhuyen', 'xaphuong.QuanHuyenID = quanhuyen.QuanHuyenID');
        $this->db->join('tinhtp', 'tinhtp.TinhTPID = quanhuyen.TinhTPID');
        $query = $this->db->get('xaphuong');
        return $query->row_array();
    }  

    public function get_chitiet_tinhtp($TinhTPID){ 
        $this->db->where('TinhTPID',$TinhTPID);     
        $query = $this->db->get('tinhtp');
        return $query->row_array();
    }   

    //    ------------------UPDATE DATA ADMIN----------------------
    public function all_tinhtp(){ 
        $result = $this->Webservice->call('All_TinhTP');
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(isset($result['All_TinhTPResult']))
                if(is_array($result['All_TinhTPResult'])){
                    return $result['All_TinhTPResult']['TinhTP'];
                }else{
                    return $result['All_TinhTPResult'];
                }
        }
    }     

    public function all_quanhuyen(){ 
        $result = $this->Webservice->call('All_QuanHuyen');
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(isset($result['All_QuanHuyenResult']))
                if(is_array($result['All_QuanHuyenResult'])){
                    return $result['All_QuanHuyenResult']['QuanHuyen'];
                }else{
                    return $result['All_QuanHuyenResult'];
                }
        }
    }     

    public function all_xaphuong(){ 
        $result = $this->Webservice->call('All_XaPhuong');
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(isset($result['All_XaPhuongResult']))
                if(is_array($result['All_XaPhuongResult'])){
                    return $result['All_XaPhuongResult']['XaPhuong'];
                }else{
                    return $result['All_XaPhuongResult'];
                }
        }
    } 

    public function all_quanhuyen_on_tinhtp($TinhTPID=0){ 
        $result = $this->Webservice->call('All_QuanHuyen_On_TinhTP',array(array("TinhTPID"=>$TinhTPID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(isset($result['All_QuanHuyen_On_TinhTPResult']))
                if(is_array($result['All_QuanHuyen_On_TinhTPResult'])){
                    return $result['All_QuanHuyen_On_TinhTPResult']['QuanHuyen'];
                }else{
                    return $result['All_QuanHuyen_On_TinhTPResult'];
                }
        }
    } 

    public function all_xaphuong_on_quanhuyen($QuanHuyenID=0){ 
        $result = $this->Webservice->call('All_XaPhuong_On_QuanHuyen',array(array("QuanHuyenID"=>$QuanHuyenID)));
        $err = $this->Webservice->getError();
        if ($err) { 
            return $err; 
        }else{  
            if(isset($result['All_XaPhuong_On_QuanHuyenResult']))
                if(is_array($result['All_XaPhuong_On_QuanHuyenResult'])){
                    return $result['All_XaPhuong_On_QuanHuyenResult']['XaPhuong'];
                }else{
                    return $result['All_XaPhuong_On_QuanHuyenResult'];
                }   
        }
    } 

    public  function insert_tinhtp($data){
        $this->db->insert('tinhtp',$data);
        return $this->db->insert_id();
    }      

    public  function insert_quanhuyen($data){
        $this->db->insert('quanhuyen',$data);
        return $this->db->insert_id();
    }      

    public  function insert_xaphuong($data){
        $this->db->insert('xaphuong',$data);
        return $this->db->insert_id();
    }    

    public function update_tinhtp($data,$TinhTPID){
        $this->db->where("TinhTPID",$TinhTPID);
        $this->db->update("tinhtp",$data);
        return true;
    } 
    public function delete_tinhtp($TinhTPID){
        $this->db->where('TinhTPID',$TinhTPID);
        $this->db->delete("tinhtp");
        return true;
    }  

    public function delete_all_tinhtp(){ 
        $this->db->from('tinhtp');
        $this->db->truncate();        
        return true;
    }  
}
?>