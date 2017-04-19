<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('user_model');  
    }

    public function login_user(){ 
        $Username = $_POST['Username'];
        $Password = $_POST['Password']; 

        $result_login = $this->user_model->login_user($Username,sha1($Password));

        if( !empty($result_login) ){ 
            $user = $result_login;
            $data2 = array(
                "username_admin" => $user['Username'],
                "id_admin" => $user['UserID'], 
                "pass_admin" => $user['Password'], 
                "quyen_admin" => $user['Quyen'], 
                "login_admin" => 1
            );
            $this->session->set_userdata($data2); 
            
            echo 1;
        }else{
            echo -1;
        } 
    }   

    public function logout_user(){
        $item = array(
            'login_admin' => 1, 
        );
        $this->session->unset_userdata($item); 

        redirect('admin'); 
    }   

    public function change_password(){
        $Old_password = sha1($_POST['Old_password']);
        $Password = sha1($_POST['Password']); 

        if($Old_password != $this->session->userdata("pass_admin")){
            echo -1;
        }else{ 
            $data = array(
                "Password" => $Password,
            ); 
            $result_update = $this->user_model->update_user($data,$this->session->userdata("id_admin"));

            if($result_update == 1){
                $data = array( 
                    "pass_admin" => $Password,  
                );
                $this->session->set_userdata($data); 

                echo 1;
            }else{
                echo 0;
            }
        }
    }

    //-----------------------------ADMIN--------------------  
    public function insert_user(){ 
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $NgayTao = date("Y/m/d H:i:s"); 
        $data = array(  
            "Username"=>$_POST['Username'],
            "Password"=>sha1('12345'), 
            "Quyen"=>$_POST['Quyen'], 
            "NgayTao"=>$NgayTao, 
        );
        $kq = $this->user_model->insert_user($data); 

        if($kq == 1){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function edit_user(){    
        $data = array(
            "Username"=>$_POST['Username'],
            "Quyen"=>$_POST['Quyen'],  
        );
        if($this->user_model->update_user($data,$_POST['UserID']))
            echo 1;
        else
            echo 0;
    }

    public function update_trangthai_user(){   
        $data = array( 
            'TrangThai'=>$_POST['TrangThai'],   
        );
        if($this->user_model->update_user($data,$_POST['UserID']))
            echo 1;
        else
            echo 0;
    }

    public function delete_user(){
        $UserID = $_POST['UserID'];
        if( $this->user_model->delete_user($UserID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function delete_more_user(){
        $arr_UserID = (array)$_POST['arr_UserID'];
        foreach($arr_UserID as $UserID){
            $this->user_model->delete_user($UserID);
        }
        echo 1;
    }

    public function get_chitiet_user_admin(){
        $UserID = $_POST['UserID'];
        echo json_encode($this->user_model->get_chitiet_user_admin($UserID) );
    }

    public function echo_user_admin($list_user,$offset){ 
        $t = ''; 
        foreach ($list_user as $item) {
            $offset++;                  
            $t.='<tr> 
                    <td>'.$offset.'</td> 
                    <td>';
                        if($this->session->userdata("id_admin") != $item['UserID'] && $item['Quyen'] !="ADMIN" ){
                            $t.='<span class="wrapper_label">
                                <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['UserID'].'" UserID = "'.$item['UserID'].'" >
                                <label for="check_sp_'.$item['UserID'].'"></label>
                            </span>';
                        }
                    $t.='</td>
                    <td>'.$item['Username'].'</td></td>   
                    <td>'.$item['Quyen'].'</td></td>   
                    <td class="text_center">';
                        if($this->session->userdata("id_admin") != $item['UserID'] && $item['Quyen'] !="ADMIN" ){
                            $t.='<span class="wrapper_label">
                                    <input type="checkbox" id="check_other_'.$item['UserID'].'" UserID="'.$item['UserID'].'"  class="check_trangthai"';
                                    if($item['TrangThai']==1) 
                                        $t.='checked';
                                    $t.='/>';
                                    $t.='<label for="check_other_'.$item['UserID'].'"></label>
                                </span>';
                                    if($item['TrangThai']==1) 
                                        $t.='<span class="hienthi_sort">1</span>'; 
                                    else
                                        $t.='<span class="hienthi_sort">0</span>'; 
                        }
                    $t.='</td> ';
                    $t.='<td class="text_center">';
                        if($this->session->userdata("id_admin") != $item['UserID'] && $item['Quyen'] !="ADMIN" ){
                            $NgayTao = date("H:i:s d/m/Y", strtotime($item['NgayTao']));
                            $t.= $NgayTao;
                        }
                    $t.='</td> ';
                    $t.='<td class="text_center">';
                        if($this->session->userdata("id_admin") != $item['UserID'] && $item['Quyen'] !="ADMIN" ){
                            $t.='<button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_user toggle_form_add_edit" UserID = "'.$item['UserID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_user dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_user" value="Đồng ý" UserID = "'.$item['UserID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>';
                        };
                    $t.='</td>
                </tr>';
        } 
        return $t;
    } 
 
// -----get sanpham-----------
    public function get_user_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $mangxahoi = $this->user_model->get_user_admin($number,$offset);        
        $list_user = $this->echo_user_admin($mangxahoi,$offset);
        $count = $this->user_model->count_all_user_admin();
        $result = array(
            'list_user' => $list_user,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_user_admin(){
        echo $this->user_model->count_all_user_admin();
    }
// -----get sanpham----------- 

    public function check_username(){
        $Username = $_POST['Username'];
        $old_Username = $_POST['old_Username'];
        if($Username != $old_Username){
            $result = $this->user_model->check_username($Username);
            echo $result;
        }else{
            echo 0;
        }
    }

}
