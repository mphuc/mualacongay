<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Binhluan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model');  
        $this->load->Model('danhmuc_model');  
        $this->load->Model('binhluan_model');  
        $this->load->Model('thongtin_model');  
        $this->load->Model('email_model');  
    }

	public function insert_binhluan(){   
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date= date("Y/m/d H:i:s"); 

        $data=array(
            "SanPhamID" => $_POST['SanPhamID'],
            "Ten" =>  $_POST['Ten'],
            "Email" => $_POST['Email'],
            "Phone" => $_POST['Phone'], 
            "Ngay" => $date, 
            "NoiDung" => filter_string($_POST['NoiDung']),   
        ); 
        $result = $this->binhluan_model->insert_binhluan($data);
        if(!is_nan($result)){
            echo $result;
        }else{
            echo 0;
        }
    }   

    public function insert_binhluan_sub(){   
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date= date("Y/m/d H:i:s"); 

        $data=array(
            "BinhLuanID" => $_POST['BinhLuanID'],
            "Ten" =>  $_POST['Ten'],
            "Email" => $_POST['Email'],
            "Phone" => $_POST['Phone'], 
            "Ngay" => $date, 
            "NoiDung" => filter_string($_POST['NoiDung']),   
        ); 
        $result = $this->binhluan_model->insert_binhluan_sub($data);
        if(!is_nan($result)){
            echo $result;
        }else{
            echo 0;
        }
    }   


    // --------------------------AMDIN------------------------

    public function echo_binhluan_admin($binhluan,$offset){ 
        $t = ''; 
        if(!empty($binhluan)){
            foreach ($binhluan as $item) {
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td class="text_center">
                            <span class="wrapper_label">
                                <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['BinhLuanID'].'" BinhLuanID = "'.$item['BinhLuanID'].'" >
                                <label for="check_sp_'.$item['BinhLuanID'].'"></label>
                            </span> 
                        </td>
                        <td>
                            <a class="link_product" href="'.base_url().'san-pham/'.url_title(removesign($item['TenSP'])).'_'.$item['SanPhamID'].'">'.$item['TenSP'].' - '.$item['MaSP'].'</a>
                            <textarea class="noidung_binhluan" rows="1" disabled>'.$item['NoiDung'].'</textarea>
                        </td>
                        <td class="">
                            <span class="fa fa-user"></span> '.$item['Ten'].'<br>
                            <i class="blue">
                                <span class="fa fa-envelope-o"></span><span class="email"> '.$item['Email'].' </span>
                                <span class="fa fa-phone"></span> '.$item['Phone'].'
                            </i>
                        </td>  
                        <td class="text_center"> 
                            <span class="wrapper_label">
                                <input type="checkbox" id="check_other_'.$item['BinhLuanID'].'" BinhLuanID="'.$item['BinhLuanID'].'"  class="check_hienthi"';
                                if($item['HienThi']==1) 
                                    $t.='checked';
                                $t.='/>';
                                $t.='<label for="check_other_'.$item['BinhLuanID'].'"></label>
                            </span>'; 
                        $t.='</td> 
                        <td class="">
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_binhluan" BinhLuanID = "'.$item['BinhLuanID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_binhluan dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_binhluan" value="Đồng ý" BinhLuanID = "'.$item['BinhLuanID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Trả lời qua email" class="btn btn-info send_mail_binhluan toggle_form_add_edit" BinhLuanID = "'.$item['BinhLuanID'].'" ><i class="fa fa-envelope-o"></i></button>
                        </td>
                    </tr>';
                    $traloi_binhluan = $this->binhluan_model->get_binhluan_sub_BinhLuanID_admin($item['BinhLuanID']);
                    foreach ($traloi_binhluan as $item_traloi) {
                        $t.='<tr class="item_traloi_binhluan"> 
                            <td colspan="2"></td>  
                            <td class="td_traloi_binhluan"><textarea rows="1" class="noidung_traloi_binhluan" name="" disabled>'.$item_traloi['NoiDung'].'</textarea></td>
                            <td class="">
                                <span class="fa fa-user"></span> '.$item_traloi['Ten'].'<br>
                                <i class="blue">
                                    <span class="fa fa-envelope-o"></span> '.$item_traloi['Email'].' </span>
                                    <span class="fa fa-phone"></span> '.$item_traloi['Phone'].' </span>
                                </i>
                            </td>  
                            <td class="text_center"> 
                                <span class="wrapper_label">
                                    <input type="checkbox" id="check_other_'.$item_traloi['TraLoi_BinhLuanID'].'" TraLoi_BinhLuanID="'.$item_traloi['TraLoi_BinhLuanID'].'"  class="check_hienthi_2"';
                                    if($item_traloi['HienThi']==1) 
                                        $t.='checked';
                                    $t.='/>';
                                    $t.='<label for="check_other_'.$item_traloi['TraLoi_BinhLuanID'].'"></label>
                                </span>'; 
                            $t.='</td> 
                            <td class="">
                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_traloi_binhluan" TraLoi_BinhLuanID = "'.$item_traloi['TraLoi_BinhLuanID'].'" ><i class="fa fa-pencil"></i></button>
                                <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_binhluan dropdown_togle" >
                                    <i class="fa fa-trash-o"></i> 
                                    <div class="dropdown_menu">
                                        <p class="dropdown_title">Bạn có muốn xóa?</p>
                                        <input type="button" class="btn btn-info ok_del_traloi_binhluan" value="Đồng ý" TraLoi_BinhLuanID = "'.$item_traloi['TraLoi_BinhLuanID'].'">
                                        <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                    </div>
                                </div>
                            </td>
                        </tr>';
                    }

            }
        }else{
            $t.='<tr><td colspan="8">Không có bình luận về sản phẩm!</td></tr>';
        }
        return $t;
    } 

// -----get binhluan----------- 
    public function get_binhluan_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->binhluan_model->get_binhluan_admin($number,$offset);        
        $list_sp = $this->echo_binhluan_admin($sp,$offset);
        $count = $this->binhluan_model->count_all_binhluan_admin();
        $result = array(
            'list_sp' => $list_sp,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_binhluan_admin(){
        echo $this->binhluan_model->count_all_binhluan_admin();
    }
// ---------------search------------------
    public function search_binhluan_admin(){
        $key = $_POST['key'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->binhluan_model->search_binhluan_admin($key,$number,$offset);
        $list_search = $this->echo_binhluan_admin($sp,$offset); 
        $count = $this->binhluan_model->count_search_binhluan_admin($key);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_search_binhluan_admin(){
        $key = $_POST['key'];
        echo $this->binhluan_model->count_search_binhluan_admin($key);
    }

// ---------------hien thi----------------
    public function update_hienthi_binhluan(){   
        $data = array( 
            'HienThi'=>$_POST['HienThi'],   
        );
        if($this->binhluan_model->update_binhluan($data,$_POST['BinhLuanID']))
            echo 1;
        else
            echo 0;
    }    
    public function update_hienthi_traloi_binhluan(){   
        $data = array( 
            'HienThi'=>$_POST['HienThi'],   
        );
        if($this->binhluan_model->update_traloi_binhluan($data,$_POST['TraLoi_BinhLuanID']))
            echo 1;
        else
            echo 0;
    }
// -----------------edit-----------
    public function edit_binhluan(){    
        $data = array( 
            'NoiDung'=> filter_string($_POST['NoiDung']),  
        );
        if($this->binhluan_model->update_binhluan($data,$_POST['BinhLuanID']))
            echo 1;
        else
            echo 0;
    }
    public function edit_traloi_binhluan(){    
        $data = array( 
            'NoiDung'=>filter_string($_POST['NoiDung']),   
        );
        if($this->binhluan_model->update_traloi_binhluan($data,$_POST['TraLoi_BinhLuanID']))
            echo 1;
        else
            echo 0;
    }
  
    // ----------------delete-------------
    public function delete_binhluan(){
        if( $this->binhluan_model->delete_binhluan($_POST['BinhLuanID']) ){
            $this->binhluan_model->delete_traloi_binhluan_on_BinhLuanID($_POST['BinhLuanID']);
            echo 1;
        }else{
            echo 0;
        }
    }

    public function delete_traloi_binhluan(){
        if( $this->binhluan_model->delete_traloi_binhluan($_POST['TraLoi_BinhLuanID']) ){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function delete_more_binhluan(){
        $arr_BinhLuanID = (array)$_POST['arr_BinhLuanID'];
        foreach($arr_BinhLuanID as $BinhLuanID){
            $this->binhluan_model->delete_binhluan($BinhLuanID);
            $this->binhluan_model->delete_traloi_binhluan_on_BinhLuanID($BinhLuanID);
        }
        echo 1;
    }
    // --------tra loi qua email-----------
    public function traloi_binhluan_email(){   
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
            
            if($result){
                // -----------insert host------------
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $date= date("Y/m/d H:i:s"); 
                $data=array(
                    "BinhLuanID" => $this->input->post('BinhLuanID'),
                    "Ten" => $this->session->userdata("username_admin"),  
                    "Email" => '(Quản trị viên)', 
                    "Ngay" => $date, 
                    "NoiDung" => filter_string($this->input->post('message')),   
                ); 
                $this->binhluan_model->insert_binhluan_sub($data);
            }
            echo $result;
        }else{
            echo -2;
        }
    }   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















