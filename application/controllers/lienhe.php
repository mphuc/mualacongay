<?php
class Lienhe extends CI_Controller {
    private $date;
    public function __construct(){
        parent::__construct(); 
        $this->load->Model('lienhe_model');    
        $this->load->Model('email_model');    
        $this->load->Model('thongtin_model');    

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->date = date("Y/m/d H:i:s"); 
    } 
 
    //-----------------------------ADMIN--------------------  
    public function insert_lienhe(){ 
        $data = array(  
            "Ten"=>$this->input->post('Ten'), 
            "Email"=>$this->input->post('Email'), 
            "Phone"=>$this->input->post('Phone'), 
            "NoiDung"=>$this->input->post('NoiDung'), 
            "Ngay"=>$this->date, 
        );
        if( $this->lienhe_model->insert_lienhe($data) ){
            echo 1;
        }else{
            echo -1;
        }
    }
  
    public function delete_lienhe(){
        $LienHeID = $_POST['LienHeID'];
        if( $this->lienhe_model->delete_lienhe($LienHeID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function delete_more_lienhe(){
        $arr_LienHeID = (array)$_POST['arr_LienHeID'];
        foreach($arr_LienHeID as $LienHeID){
            $this->lienhe_model->delete_lienhe($LienHeID);
        }
        echo 1;
    }
 
    public function echo_lienhe_admin($list_lienhe,$offset){ 
        $t = ''; 
        if(!empty($list_lienhe)){
            foreach ($list_lienhe as $item) {
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td class="text_center">
                            <span class="wrapper_label">
                                <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['LienHeID'].'" LienHeID = "'.$item['LienHeID'].'" >
                                <label for="check_sp_'.$item['LienHeID'].'"></label>
                            </span>
                        </td>
                        <td>'.$item['NoiDung'].'</td>
                        <td class="">
                            <span class="fa fa-user"></span> '.$item['Ten'].'<br>
                            <i class="blue">
                                <span class="fa fa-envelope-o"></span> '.$item['Email'].' </span><br>
                                <span class="fa fa-phone"></span> '.$item['Phone'].' </span><br>
                            </i>
                        </td> 
                        <td>'.date("H:i d/m/Y", strtotime($item['Ngay'])).'</a>   
                        </td>   
                        <td class="text_center"> 
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_lienhe dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_lienhe" value="Đồng ý" LienHeID = "'.$item['LienHeID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Trả lời qua email" class="btn btn-info send_mail_lienhe toggle_form_add_edit" Email = "'.$item['Email'].'" Ten = "'.$item['Ten'].'" ><i class="fa fa-envelope-o"></i></button>
                        </td>
                    </tr>';
            } 
        }else{
            $t.='<tr><td colspan="8">Không có liên hệ của khách hàng!</td></tr>';
        }
        return $t;
    } 
 
// -----get lien he-----------
    public function get_lienhe_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $lienhe = $this->lienhe_model->get_lienhe_admin($number,$offset);        
        $list_lienhe = $this->echo_lienhe_admin($lienhe,$offset);
        $count = $this->lienhe_model->count_all_lienhe_admin();
        $result = array(
            'list_lienhe' => $list_lienhe,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_lienhe_admin(){
        echo $this->lienhe_model->count_all_lienhe_admin();
    }


    // --------tra loi qua email-----------
    public function traloi_lienhe_email(){   
        $email_default = $this->email_model->get_email_default(); 
        if(!empty($email_default)){
            $thongtin = $this->thongtin_model->get_thongtin();
            // --------send mail CI----------- 
            $config['protocol'] = $email_default['protocol'];
            $config['smtp_host'] = $email_default['smtp_host'];
            $config['smtp_port'] = $email_default['smtp_port'];
            $config['smtp_user'] = $email_default['smtp_user']; 
            $config['smtp_pass'] = $email_default['smtp_pass'];
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";

            $this->load->library('email');
            $this->email->initialize($config); 
            $this->email->from( $email_default['smtp_user'], $this->session->userdata("username_admin"));
            $this->email->to( trim($this->input->post('email')) ); 
            $this->email->subject( $this->input->post('subject') );
            $this->email->message( $thongtin['TenCuaHang'].' '.$thongtin['Website'].'<br>'.$this->input->post('message') );
            $result = $this->email->send();
            // --------send mail CI-----------   

            echo $result;
        }else{
            echo -2;
        }
    }   


}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















