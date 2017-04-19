<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Address extends CI_Controller {
    private $arr_loaihienthi = array();
    public function __construct(){ 
        parent::__construct();
        $this->load->Model('main_model'); 
        $this->load->Model('sanpham_model'); 
        $this->load->Model('loaisanpham_model');
        $this->load->Model('danhmuc_model');  
        $this->load->Model('hinhanh_model');  
        $this->load->Model('address_model');  
        $this->load->Model('member_model');  
        $this->load->Model('member_model');  
    }  
    // ------------INDEX------------
    public function get_quanhuyen(){ 
        $TinhTPID = $_POST['TinhTPID'];
 
        if( $this->session->userdata("id_member") ){
            $MemberID = $this->session->userdata("id_member");
        }else if( $this->session->userdata("id_khachonline") ){
            $MemberID = $this->session->userdata("id_khachonline");
        }else{
            $MemberID = 0;
        }

        if( $MemberID != 0){
            $chitiet_member = $this->member_model->chitiet_member($MemberID);
            $address = $this->address_model->get_address_on_xaphuong($chitiet_member['XaPhuongID']);
            $QuanHuyenID = $address['QuanHuyenID'];
        }else{
            $QuanHuyenID = 0;
        }

        $quanhuyen = $this->address_model->get_quanhuyen($TinhTPID);
        $t='<option value="">Quận-Huyện</option>';
        foreach ($quanhuyen as $item) { 
            $selected =  ( $item['QuanHuyenID'] == $QuanHuyenID ) ? ' selected ':'';
            $t.='<option value="'.$item['QuanHuyenID'].'" '.$selected.' >'.$item['TenQuanHuyen'].'</option>';
        }

        echo $t;
    }      

    public function get_xaphuong(){ 
        $QuanHuyenID = $_POST['QuanHuyenID'];
 
        if( $this->session->userdata("id_member") ){
            $MemberID = $this->session->userdata("id_member");
        }else if( $this->session->userdata("id_khachonline") ){
            $MemberID = $this->session->userdata("id_khachonline");
        }else{
            $MemberID = 0;
        }

        if($MemberID != 0){
            $chitiet_member = $this->member_model->chitiet_member($MemberID); 
            $XaPhuongID = $chitiet_member['XaPhuongID'];
        }else{
            $XaPhuongID = 0;
        }

        $quanhuyen = $this->address_model->get_xaphuong($QuanHuyenID);
        $t='<option value="">Xã-Phường</option>';
        foreach ($quanhuyen as $item) { 
            $selected =  ( $item['XaPhuongID'] == $XaPhuongID ) ? ' selected ':'';
            $t.='<option value="'.$item['XaPhuongID'].'" '.$selected.' >'.$item['TenXaPhuong'].'</option>';
        }        
        echo $t;
    }  

    public function get_chitiet_tinhtp(){
        $TinhTPID = $_POST['TinhTPID'];
        $TinhTP = $this->address_model->get_chitiet_tinhtp($TinhTPID);
        echo $TinhTP['GiaShip'];
    }

    // ================================ADMIN=========================
    public function get_address_tinhtp_admin(){
        $TinhTP = $this->address_model->get_tinhtp();
        $t='<ul>'; 
        foreach ($TinhTP as $item) {
            $QuanHuyen = $this->address_model->get_quanhuyen($item['TinhTPID']);
            $count_QuanHuyen = count($QuanHuyen);
            $t.='<li class="level0">
                    <div class="item_tinhtp">
                        <button TinhTPID="'.$item['TinhTPID'].'" class="tentinhtp btn_address" >
                            <i class="fa fa-chevron-down arrow"></i>
                            '.$item['TenTinhTP'].'
                        </button>
                        <i class="count">('.$count_QuanHuyen.' quận huyện)</i>
                        <p class="block_giaship">
                            <input type="text"readonly class="giaship priceFormat" value="'.number_format( $item['GiaShip'],'0',',','.').'"> VNĐ
                        </p>
                        <div class="left_item">
                            <button data-toggle="tooltip" data-placement="right" title="Chỉnh sửa" class="edit_tinhtp btn btn-primary" TinhTPID="'.$item['TinhTPID'].'" ><i class="fa fa-pencil"></i></button>

                            <!--<div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger delete_tinhtp dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_delete_tinhtp" value="Đồng ý" TinhTPID = "'.$item['TinhTPID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>-->

                        </div>
                        
                    </div>
                    <ul class="ul_level0"></ul>
                </li>';
        }
        $t.='</ul>';
 
        echo $t;
    }

    public function get_address_quanhuyen_admin(){
        $TinhTPID = $_POST['TinhTPID'];
        $QuanHuyen = $this->address_model->get_quanhuyen($TinhTPID);
        $t=''; 
        foreach ($QuanHuyen as $item) {
            $XaPhuong = $this->address_model->get_xaphuong($item['QuanHuyenID']);
            $count_XaPhuong = count($XaPhuong);
            $t.='<li class="level1">
                    <button class="tenquanhuyen btn_address" QuanHuyenID="'.$item['QuanHuyenID'].'">
                        <i class="fa fa-caret-down arrow"></i>
                        '.$item['TenQuanHuyen'].'
                    </button>
                    <i class="count">('.$count_XaPhuong.' xã phường)</i>
                <ul class="ul_level1"></ul>
            </li>';
        } 
 
        echo $t;
    }

    public function get_address_xaphuong_admin(){
        $QuanHuyenID = $_POST['QuanHuyenID'];
        $XaPhuong = $this->address_model->get_xaphuong($QuanHuyenID);
        $t=''; 
        foreach ($XaPhuong as $item) { 
            $t.='<li ><b>- </b>'.$item['TenXaPhuong'].'</li>';
        } 
 
        echo $t;
    }

    public function update_tinhtp(){    
        $data = array( 
            "GiaShip"=>$_POST['GiaShip'],  
        );
        if($this->address_model->update_tinhtp($data,$_POST['TinhTPID']))
            echo 1;
        else
            echo 0;
    }

    public function delete_tinhtp(){     
        if($this->address_model->delete_tinhtp($_POST['TinhTPID']))
            echo 1;
        else
            echo 0;
    }

}

