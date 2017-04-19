<?php
class Member_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->Webservice = $this->main_lib->Webservice('Module_MemBer');
    }

    public function insert_member_host($data){   
        $this->db->insert('member',$data);
        return $this->db->insert_id();
    }  

    public function insert_member_server($data){  
        $result = $this->Webservice->call('Insert_MemBer',array(array("Member"=>$data)));  
        $err = $this->Webservice->getError();
        if ($err) {  
            return $err; 
        }else{     
            return $result['Insert_MemBerResult']; 
        } 
    }

    public function check_username($Username='0'){   
        $this->db->where('Username',$Username);  
        $query = $this->db->get('member');
        return $query->num_rows();
    }  

    public function check_email($Email=''){   
        $this->db->where('Email',$Email);  
        $query = $this->db->get('member');
        return $query->num_rows();
    }  

    public function login_member($Username=0, $Password=0){   
        $this->db->where('Username',$Username); 
        $this->db->where('Password',$Password); 
        $this->db->or_where('Email',$Username); 
        $query = $this->db->get('member');
        return $query->row_array();
    }      

    public function chitiet_member($MemberID=0){   
        $this->db->where('MemberID',$MemberID);  
        $query = $this->db->get('member');
        return $query->row_array();
    }  

    public function chitiet_member_host($MemberID = 0){
        $this->db->where('MemberID',$MemberID);  
        $query = $this->db->get('member');
        return $query->row_array();
    }
    public function chitiet_member_host_on_MemberID_server($MemberID_server = 0){
        $this->db->where('MemberID_server',$MemberID_server);  
        $query = $this->db->get('member');
        return $query->row_array();
    } 

    public function get_token_reset($token_reset=0){   
        $this->db->where('token_reset',$token_reset);  
        $query = $this->db->get('member');
        return $query->row_array();
    }  
    public function get_email_reset($Email=0){   
        $this->db->where('Email',$Email);  
        $query = $this->db->get('member');
        return $query->row_array();
    }  

    public function delete_member($MemberID){
        $this->db->where('MemberID',$MemberID);
        $this->db->delete("member");
        return true;
    } 

    public function delete_all_member(){  
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('member');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

    //------------update member--------------
    public function update_member_server($Member,$MemberID=0){  
        $result = $this->Webservice->call('Update_MemBer',array(array("Member"=>$Member,"MemberID"=>$MemberID)));  
        $err = $this->Webservice->getError();
        if ($err) {  
            return $err; 
        }else{     
            return $result['Update_MemBerResult']; 
        }
    }

    public function update_member_host($Member,$MemberID=0){  
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->where("MemberID",$MemberID);
        $this->db->update("member",$Member);
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  
    //------------update member--------------

    // ---------update_pass-------------- 

    public function update_password_member_host($Password,$MemberID=0){  
        $this->db->where("MemberID",$MemberID);
        $this->db->update("member",array("Password" => $Password));
        return true;
    }

    public function update_password_member_server($Password,$MemberID_Server=0){  
        $result = $this->Webservice->call('Update_PassWord_MemBer',array(array("Password"=>$Password,"MemberID"=>$MemberID_Server)));  
        $err = $this->Webservice->getError();
        if ($err) {  
            return $err; 
        }else{     
            return $result['Update_PassWord_MemBerResult']; 
        }
    }  
    // ---------update_pass--------------

    public function get_member_new(){
        $this->db->where('New_Member',1);  
        $query = $this->db->get('member');
        return $query->result_array();
    }

    public function count_member_new(){
        $this->db->where('New_Member',1);  
        $query = $this->db->get('member');
        return $query->num_rows();
    }
 

 // =============ADMIN==============================

    public function get_member_admin($number, $offset){ 
        $this->db->limit($number,$offset); 
        $query = $this->db->get('member');
        return $query->result_array();
    } 
    public function count_all_member_admin(){  
        $query = $this->db->get('member');
        return $query->num_rows();
    }
    // ----------------------search------------------
    public function search_member_admin($key,$number, $offset){ 
        $this->db->like('Ten',$key); 
        $this->db->or_like('Email',$key); 
        $this->db->or_like('Phone',$key); 
        $query = $this->db->get('member',$number, $offset);
        return $query->result_array();
    }    
    public function count_search_member_admin($key){ 
        $this->db->like('Ten',$key); 
        $this->db->or_like('Email',$key); 
        $this->db->or_like('Phone',$key); 
        $query = $this->db->get('member');
        return $query->num_rows();
    }

    // ---------------------filter------------------
    public function filter_member_admin($val, $number, $offset){ 
        $this->db->where('Is_Member',$val);   
        $query = $this->db->get('member',$number, $offset);
        return $query->result_array();
    }    
    public function count_filter_member_admin($val){ 
        $this->db->where('Is_Member',$val);   
        $query = $this->db->get('member');
        return $query->num_rows();
    } 
}
?>