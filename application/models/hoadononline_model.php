<?php
class Hoadononline_model extends CI_Model{
    private $Webservice;
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->Webservice = $this->main_lib->Webservice('Module_HoaDonOnline'); 
    }

    public function insert_hoadononline_server($data){  
        $result = $this->Webservice->call('Insert_HoaDonOnline',array(array("HoaDonOnline"=>$data)));  
        $err = $this->Webservice->getError();
        if ($err) {  
            return $err; 
        }else{     
            return $result['Insert_HoaDonOnlineResult']; 
        } 
    }   


    public function insert_chitiethoadononline_server($data){   
        $result = $this->Webservice->call('Insert_ChiTietHoaDonOnline',array(array("ChiTietHoaDonOnline"=>$data)));  
        $err = $this->Webservice->getError();
        if ($err) {  
            return $err; 
        }else{     
            return $result['Insert_ChiTietHoaDonOnlineResult']; 
        } 
    }   
    public function delete_hoadon_chitiethoadon_error($HoaDonOnlineID){   
        $result = $this->Webservice->call('Delete_HoaDon_ChiTietHoaDon_Error',array(array("HoaDonOnlineID"=>$HoaDonOnlineID)));  
        $err = $this->Webservice->getError();
        if ($err) {  
            return $err; 
        }else{     
            return $result['Delete_HoaDon_ChiTietHoaDon_ErrorResult']; 
        } 
    }   
    public function delete_hoadononline_by_HoaDonOnlineID($HoaDonOnlineID){
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID);
        $this->db->delete("hoadononline");
        return true;
    } 
    //------HÓA ĐƠN TẠM----
    public function get_info_hoadon_temp($HoaDonOnlineID=0){ 
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID); 
        $query = $this->db->get('hoadononline');
        return $query->row_array();
    }   

    public function insert_hoadononline_temp($data){
        $this->db->insert('hoadononline',$data); 
        return $this->db->insert_id();
    }    

    public function insert_invoid($data){
        $this->db->insert('invoice_gdg',$data); 
        return $this->db->insert_id();
    } 

    public function get_invoid($cart_id){
        $this->db->where('cart_id',$cart_id); 
        $query = $this->db->get('invoice_gdg');
         return $query->row_array();
    }  

    public function get_invoid_by_payment_code($payment_code){
        $this->db->where('payment_code',$payment_code); 
        $query = $this->db->get('invoice_gdg');
         return $query->row_array();
    }   


    public function update_hoadononline_temp($data,$HoaDonOnlineID){
        $this->db->where("HoaDonOnlineID",$HoaDonOnlineID);
        $this->db->update("hoadononline",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    } 
    
    public function update_hoadononline_giaohang($data,$HoaDonOnlineID){
        $this->db->where("HoaDonOnlineID",$HoaDonOnlineID);
        $this->db->update("hoadononline",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    } 

    public function check_token($Token=0){ 
        $this->db->where('Is_HoaDon',0); 
        $this->db->where('Token',$Token); 
        $query = $this->db->get('hoadononline');
        return $query->row_array();
    }     
    public function delete_hoadononline_by_token($Token){
        $this->db->where('Token',$Token);
        $this->db->delete("hoadononline");
        return true;
    } 
    public function get_hoadononline_temp_on_member($MemberID){
        $this->db->where('MemberID',$MemberID); 
        $this->db->where('Is_HoaDon',0); 
        $this->db->order_by("Ngay DESC");
        $query = $this->db->get('hoadononline');
        return $query->result_array();
    }

    public function get_hoadononline_to_sync(){
        $this->db->where('Is_HoaDon',1); 
        $query = $this->db->get('hoadononline');
        return $query->result_array();
    }
    //------HÓA ĐƠN TẠM----

    //------CHI TIẾT HÓA ĐƠN TẠM----
    public function insert_chitiethoadononline_temp($data){
        $this->db->insert('chitiethoadononline',$data);
        return 1;
    }   
    public function update_chitiethoadononline_temp($data,$ChiTietOnlineID){
        $this->db->where("ChiTietOnlineID",$ChiTietOnlineID);
        $this->db->update("chitiethoadononline",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }   
    public function check_sp_chitiethoadon($HoaDonOnlineID=0,$SanPhamID=0){ 
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID); 
        $this->db->where('SanPhamID',$SanPhamID); 
        $query = $this->db->get('chitiethoadononline');
        return $query->row_array();
    } 
    public function delete_chitiethoadon_by_HoaDonOnlineID($HoaDonOnlineID){
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID);
        $this->db->delete("chitiethoadononline");
        return true;
    }     
    public function delete_chitiethoadon_by_ChiTietOnlineID($ChiTietOnlineID){
        $this->db->where('ChiTietOnlineID',$ChiTietOnlineID);
        $this->db->delete("chitiethoadononline");
        return true;
    } 
    public function delete_chitiethoadon($HoaDonOnlineID=0,$SanPhamID=0){
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID);
        $this->db->where('SanPhamID',$SanPhamID);
        $this->db->delete("chitiethoadononline");
        return true;
    } 
    public function get_chitiethoadon_temp($HoaDonOnlineID=0){
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID); 
        $this->db->join('SanPham','SanPham.SanPhamID = ChiTietHoaDonOnline.SanPhamID'); 
        $query = $this->db->get('chitiethoadononline');
        return $query->result_array();
    }

    public function get_chitiethoadon_to_sync($HoaDonOnlineID=0){
        $this->db->where('HoaDonOnlineID',$HoaDonOnlineID); 
        $query = $this->db->get('chitiethoadononline');
        return $query->result_array();
    }
    //------CHI TIẾT HÓA ĐƠN TẠM----

    public function get_hoadononline_on_member($MemberID){ 
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('All_HoaDonOnline_On_Member',array(array("MemberID"=>$MemberID)));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['All_HoaDonOnline_On_MemberResult'])){
                    if(!isset($result['All_HoaDonOnline_On_MemberResult']['HoaDonOnline'][0])){ 
                        return array_values($result['All_HoaDonOnline_On_MemberResult']);
                    }else{
                        return $result['All_HoaDonOnline_On_MemberResult']['HoaDonOnline'];
                    }
                }  
            }
        }else{
            $this->db->where('MemberID',$MemberID); 
            $this->db->where('Is_HoaDon',1); 
            $this->db->order_by("Ngay DESC");
            $query = $this->db->get('hoadononline');
            return $query->result_array();
        }
    }   

    public function get_chitiethoadon($HoaDonOnlineID=0){  
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('ChiTiet_On_HoaDonOnline',array(array("HoaDonOnlineID"=>$HoaDonOnlineID)));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{    
                if(!empty($result['ChiTiet_On_HoaDonOnlineResult'])){
                    if(!isset($result['ChiTiet_On_HoaDonOnlineResult']['ChiTietHoaDonOnline'][0])){ 
                        return array_values($result['ChiTiet_On_HoaDonOnlineResult']);
                    }else{
                        return $result['ChiTiet_On_HoaDonOnlineResult']['ChiTietHoaDonOnline'];
                    }
                }   
            }
        }else{
            $this->db->where('HoaDonOnlineID',$HoaDonOnlineID);  
            $this->db->join('sanpham','sanpham.SanPhamID = chitiethoadononline.SanPhamID');  
            $query = $this->db->get('chitiethoadononline');
            return $query->result_array();
        }
    }   

    public function get_info_hoadon($HoaDonOnlineID=0){  
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('Info_HoaDonOnline',array(array("HoaDonOnlineID"=>$HoaDonOnlineID)));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(isset($result['Info_HoaDonOnlineResult']))
                    return $result['Info_HoaDonOnlineResult']['HoaDonOnline'];
            }
        }else{
            $this->db->where('HoaDonOnlineID',$HoaDonOnlineID);  
            $query = $this->db->get('hoadononline');
            return $query->row_array();
        }
    }   

    public function hoadononline_moinhat_limit($number, $offset){  
        if($this->main_lib->connect_server()){
            $result = $this->Webservice->call('Limit_HoaDonOnline_New',array(array("number"=>$number,"offset"=>$offset,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['Limit_HoaDonOnline_NewResult'])){
                    if(!isset($result['Limit_HoaDonOnline_NewResult']['HoaDonOnline'][0])){ 
                        return array_values($result['Limit_HoaDonOnline_NewResult']);
                    }else{
                        return $result['Limit_HoaDonOnline_NewResult']['HoaDonOnline'];
                    }
                } 
            }
        }else{
            $this->db->limit($number,$offset);
            $this->db->where('TinhTrang',0);  
            $this->db->where('Is_HoaDon',1); 
            $this->db->order_by("Ngay DESC");
            $query = $this->db->get('hoadononline');
            return $query->result_array();
        }
    }  

    public function count_all_hoadononline_moinhat(){  
        if($this->main_lib->connect_server()){
            $result = $this->Webservice->call('Count_All_HoaDonOnline_New',array(array("Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['Count_All_HoaDonOnline_NewResult'])){ 
                    return $result['Count_All_HoaDonOnline_NewResult']; 
                }else{
                    return 0;
                }
            }
        }else{ 
            $this->db->where('TinhTrang',0);  
            $this->db->where('Is_HoaDon',1);  
            $query = $this->db->get('hoadononline');
            return $query->num_rows();
        }
    }  

    public function count_all_hoadononline_now(){  
        if($this->main_lib->connect_server()){
            $result = $this->Webservice->call('Count_All_HoaDonOnline_Now',array(array("Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['Count_All_HoaDonOnline_NowResult'])){ 
                    return $result['Count_All_HoaDonOnline_NowResult']; 
                }else{
                    return 0;
                }
            }
        }else{ 
            $this->db->where('TinhTrang',0);  
            $this->db->where('Is_HoaDon',1);  
            $query = $this->db->get('hoadononline');
            return $query->num_rows();
        }
    }  

    // ==================================ADMIN========================
    public function get_hoadononline_admin($number, $offset){  
        if($this->main_lib->connect_server()){
            $result = $this->Webservice->call('Limit_HoaDonOnline_Admin',array(array("number"=>$number,"offset"=>$offset,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['Limit_HoaDonOnline_AdminResult'])){
                    if(!isset($result['Limit_HoaDonOnline_AdminResult']['HoaDonOnline'][0])){ 
                        return array_values($result['Limit_HoaDonOnline_AdminResult']);
                    }else{
                        return $result['Limit_HoaDonOnline_AdminResult']['HoaDonOnline'];
                    }
                } 
            }
        }else{
            $this->db->limit($number,$offset);
            $this->db->where('Is_HoaDon',1); 
            $query = $this->db->get('hoadononline');
            return $query->result_array();
        }
    }   

    public function count_all_hoadononline(){  
        if($this->main_lib->connect_server()){
            $result = $this->Webservice->call('Count_All_HoaDonOnline',array(array("Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{       
                return $result['Count_All_HoaDonOnlineResult'];
            }
        }else{ 
            $this->db->where('Is_HoaDon',1); 
            $query = $this->db->get('hoadononline');
            return $query->num_rows();
        }
    } 

    public function count_all_hoadononline_host(){   
        $this->db->where('Is_HoaDon',1); 
        $query = $this->db->get('hoadononline');
        return $query->num_rows();
    } 
    // -------------------------search-----------------------
    public function search_hoadononline_admin($key,$number,$offset){  
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('Search_HoaDonOnline_Admin',array(array("key"=>$key,"number"=>$number,"offset"=>$offset,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{  
                if(!empty($result['Search_HoaDonOnline_AdminResult'])){
                    if(!isset($result['Search_HoaDonOnline_AdminResult']['HoaDonOnline'][0])){ 
                        return array_values($result['Search_HoaDonOnline_AdminResult']);
                    }else{
                        return $result['Search_HoaDonOnline_AdminResult']['HoaDonOnline'];
                    }
                }  
            }   
        }else{
            $this->db->join('member','member.MemberID = hoadononline.MemberID');
            $this->db->like('MaHoaDon',$key);
            $this->db->or_like('Ten',$key);
            $this->db->or_like('Phone',$key);
            $this->db->limit($number,$offset);
            $this->db->order_by("Ngay DESC");
            $this->db->where('Is_HoaDon',1); 
            $query = $this->db->get('hoadononline');
            return $query->result_array();
        }
    }   

    public function count_search_hoadononline_admin($key){  
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('Count_Search_HoaDonOnline_Admin',array(array("key"=>$key,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{       
                if(isset($result['Count_Search_HoaDonOnline_AdminResult'])) 
                    return $result['Count_Search_HoaDonOnline_AdminResult'];
            }
        }else{
            $this->db->join('member','member.MemberID = hoadononline.MemberID');
            $this->db->like('MaHoaDon',$key);
            $this->db->or_like('Ten',$key);
            $this->db->or_like('Phone',$key);
            $this->db->where('Is_HoaDon',1); 
            $query = $this->db->get('hoadononline');
            return $query->num_rows();
        }
    }   

        // -------------------------search-----------------------
    public function filter_hoadononline_admin($val,$number,$offset){ 
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('Filter_HoaDonOnline_Admin',array(array("val"=>$val,"number"=>$number,"offset"=>$offset,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['Filter_HoaDonOnline_AdminResult'])){
                    if(!isset($result['Filter_HoaDonOnline_AdminResult']['HoaDonOnline'][0])){ 
                        return array_values($result['Filter_HoaDonOnline_AdminResult']);
                    }else{
                        return $result['Filter_HoaDonOnline_AdminResult']['HoaDonOnline'];
                    }
                }  
            }
        }else{
            $this->db->where('TinhTrang',$val);  
            $this->db->limit($number,$offset);
            $this->db->where('Is_HoaDon',1); 
            $query = $this->db->get('hoadononline');
            return $query->result_array();
        }
    }   

    public function count_filter_hoadononline_admin($val){  
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('Count_Filter_HoaDonOnline_Admin',array(array("val"=>$val,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(isset($result['Count_Filter_HoaDonOnline_AdminResult']))
                    return $result['Count_Filter_HoaDonOnline_AdminResult'];
            }
        }else{
            $this->db->where('TinhTrang',$val);  
            $this->db->where('Is_HoaDon',1); 
            $query = $this->db->get('hoadononline');
            return $query->num_rows();
        }
    }   

    // -----------------------thong ke-----------------------------
    public function thongke_hoadononline($Nam){  
        if( $this->main_lib->connect_server() ){
            $result = $this->Webservice->call('ThongKe_HoaDonOnline',array(array("Nam"=>$Nam,"Website"=>$this->main_lib->Server_name())));  
            $err = $this->Webservice->getError(); 
            if ($err) {  
                return $err; 
            }else{      
                if(!empty($result['ThongKe_HoaDonOnlineResult'])){
                    if(!isset($result['ThongKe_HoaDonOnlineResult']['SP_ThongKe_HoaDonOnlineResult'][0])){ 
                        return array_values($result['ThongKe_HoaDonOnlineResult']);
                    }else{
                        return $result['ThongKe_HoaDonOnlineResult']['SP_ThongKe_HoaDonOnlineResult'];
                    }
                }
            }
        }else{
            $query = $this->db->query("
                SELECT CONCAT('Tháng ' , MONTH(hoadononline.ngay)) as thang,
                        sum(hoadononline.TongTien + hoadononline.GiaShip) as tong
                FROM hoadononline 
                WHERE TinhTrang = 2 and Is_HoaDon = 1 and YEAR(hoadononline.ngay) = ".$Nam."
                GROUP BY  MONTH(hoadononline.ngay)" );
            return $query->result_array();
        }
    }   

    public function update_tinhtrang($data,$HoaDonOnlineID){
        $this->db->where("HoaDonOnlineID",$HoaDonOnlineID);
        $this->db->update("hoadononline",$data);
        $this->db->trans_complete();
        return $this->db->trans_status(); 
    }

    public function delete_all_hoadononline(){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('hoadononline');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }      

    public function delete_all_chitiethoadononline(){ 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->from('chitiethoadononline');
        $this->db->truncate(); 
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return true;
    }  

}
?>