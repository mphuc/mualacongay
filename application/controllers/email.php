<?php
class email extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->Model('email_model');    
    } 
 
    //-----------------------------ADMIN--------------------  
    public function insert_email(){ 
        $data = array(  
            "protocol"=>$_POST['protocol'], 
            "smtp_host"=>$_POST['smtp_host'], 
            "smtp_port"=>$_POST['smtp_port'], 
            "smtp_user"=>$_POST['smtp_user'], 
            "smtp_pass"=>$_POST['smtp_pass'], 
        );
        $kq = $this->email_model->insert_email($data); 

        if($kq == 1){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function edit_email(){    
        $data = array(
            "protocol"=>$_POST['protocol'], 
            "smtp_host"=>$_POST['smtp_host'], 
            "smtp_port"=>$_POST['smtp_port'], 
            "smtp_user"=>$_POST['smtp_user'], 
            "smtp_pass"=>$_POST['smtp_pass'],  
        );
        if($this->email_model->update_email($data,$_POST['EmailID']))
            echo 1;
        else
            echo 0;
    }
    public function update_default_email(){   
        $this->email_model->update_all_email(array('default'=>0));
        if($this->email_model->update_email(array('default'=>1),$_POST['EmailID'])){
            echo 1;
        }else{
            echo 0;
        }
    }
    public function delete_email(){
        $EmailID = $_POST['EmailID'];
        if( $this->email_model->delete_email($EmailID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function delete_more_email(){
        $arr_EmailID = (array)$_POST['arr_EmailID'];
        foreach($arr_EmailID as $EmailID){
            $this->email_model->delete_email($EmailID);
        }
        echo 1;
    }

    public function get_chitiet_email_admin(){
        $EmailID = $_POST['EmailID'];
        echo json_encode($this->email_model->get_chitiet_email_admin($EmailID) );
    }

    public function echo_email_admin($list_email,$offset){ 
        $t = ''; 
        if(!empty($list_email)){
            foreach ($list_email as $item) {
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td class="text_center">
                            <span class="wrapper_label">
                                <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['EmailID'].'" EmailID = "'.$item['EmailID'].'" >
                                <label for="check_sp_'.$item['EmailID'].'"></label>
                            </span>
                        </td>
                        <td>'.$item['protocol'].'</td>  
                        <td>'.$item['smtp_host'].'</td>  
                        <td>'.$item['smtp_port'].'</td>  
                        <td>'.$item['smtp_user'].'</td>  

                        <td class="text_center"> 
                            <span class="wrapper_radio">
                                <input type="radio" name="radio_default" id="check_other_'.$item['EmailID'].'" EmailID="'.$item['EmailID'].'"  class="check_default"';
                                if($item['default']==1) 
                                    $t.='checked';
                                $t.='/>';
                                $t.='<label for="check_other_'.$item['EmailID'].'"></label>
                            </span>'; 
                        $t.='</td> 
                        <td class="text_center">
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_email toggle_form_add_edit" EmailID = "'.$item['EmailID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_email dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_email" value="Đồng ý" EmailID = "'.$item['EmailID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                        </td>
                    </tr>';
            }
        }else{
            $t.='<tr><td colspan="8">Không có email!</td></tr>';
        } 
        return $t;
    } 
 
// -----get sanpham-----------
    public function get_email_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $email = $this->email_model->get_email_admin($number,$offset);        
        $list_email = $this->echo_email_admin($email,$offset);
        $count = $this->email_model->count_all_email_admin();
        $result = array(
            'list_email' => $list_email,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_email_admin(){
        echo $this->email_model->count_all_email_admin();
    }
// -----get sanpham----------- 
    

    //-----------------------------THAY DOI EMAIL DEFAULT--------------------  
    public function get_all_email(){
        $email = $this->email_model->get_all_email();
        $stt=0;
        $t='<div class="wrapper_popup">
                <h2 class="title_popup">Tài khoản email</h2>
                <div class="content_popup">
                    <p>Chọn <b>tài khoản email </b>mà bạn muốn đặt làm mặc định:</p>
                    <table class="list_email">
                        <thead>
                            <td>STT</td>
                            <th>Protocol</th> 
                            <th>Smtp_host</th> 
                            <th>Smtp_port</th> 
                            <th>Smtp_user</th> 
                            <th>Mặc định</th> 
                        </thead>
                        <tbody>';
                        if(!empty($email)){ 
                            foreach ($email as $item) {
                                $t.='<tr>
                                    <td>'.$stt.'</td>
                                    <td>'.$item['protocol'].'</td>  
                                    <td>'.$item['smtp_host'].'</td>  
                                    <td>'.$item['smtp_port'].'</td>  
                                    <td class="smtp_user">'.$item['smtp_user'].'</td>  
                                    <td class="text_center"> 
                                        <span class="wrapper_radio">
                                            <input type="radio" name="radio_default" id="check_other_'.$item['EmailID'].'" value="'.$item['EmailID'].'"  class="check_default"';
                                            if($item['default']==1) 
                                                $t.='checked';
                                            $t.='/>';
                                            $t.='<label for="check_other_'.$item['EmailID'].'"></label>
                                        </span>
                                    </td>
                                </tr>';
                                $stt++;
                            }
                        }else{
                            $t.='<tr><td colspan="4">Không có tài khoản email!</td></tr>';
                        }  
                $t.='</tbody>
                </table>
             </div>
             <div class="wrapper_confim">
                <p class="alert_update_sanpham"></p>
                <button id="ok_update_email" disabled class="btn btn-info" >Đồng ý</button>
                <button id="cancel_update_email" class="btn btn-danger close_fancybox">Hủy</button>
            </div>
        </div>';

        echo $t;
    }
    //-----------------------------THAY DOI EMAIL DEFAULT--------------------  
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















