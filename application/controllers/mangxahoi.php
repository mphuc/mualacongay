<?php
class Mangxahoi extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->Model('mangxahoi_model');    
    } 
 
    //-----------------------------ADMIN--------------------  
    public function insert_mangxahoi(){ 
        $data = array(  
            "Image"=>$_POST['Image'],
            "TieuDe"=>$_POST['TieuDe'],
            "Link"=>$_POST['Link'], 
        );
        $kq = $this->mangxahoi_model->insert_mangxahoi($data); 

        if($kq == 1){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function edit_mangxahoi(){    
        $data = array(
            "Image"=>$_POST['Image'],
            "TieuDe"=>$_POST['TieuDe'],
            "Link"=>$_POST['Link'],  
        );
        if($this->mangxahoi_model->update_mangxahoi($data,$_POST['MangXHID']))
            echo 1;
        else
            echo 0;
    }
    public function update_hienthi_mangxahoi(){   
        $data = array( 
            'HienThi'=>$_POST['HienThi'],   
        );
        if($this->mangxahoi_model->update_mangxahoi($data,$_POST['MangXHID']))
            echo 1;
        else
            echo 0;
    }
    public function delete_mangxahoi(){
        $MangXHID = $_POST['MangXHID'];
        if( $this->mangxahoi_model->delete_mangxahoi($MangXHID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function delete_more_mangxahoi(){
        $arr_MangXHID = (array)$_POST['arr_MangXHID'];
        foreach($arr_MangXHID as $MangXHID){
            $this->mangxahoi_model->delete_mangxahoi($MangXHID);
        }
        echo 1;
    }

    public function get_chitiet_mangxahoi_admin(){
        $MangXHID = $_POST['MangXHID'];
        echo json_encode($this->mangxahoi_model->get_chitiet_mangxahoi_admin($MangXHID) );
    }

    public function echo_mangxahoi_admin($list_mangxahoi,$offset){ 
        $t = ''; 
        foreach ($list_mangxahoi as $item) {
            $offset++;                  
            $t.='<tr> 
                    <td>'.$offset.'</td> 
                    <td class="text_center">
                        <span class="wrapper_label">
                            <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['MangXHID'].'" MangXHID = "'.$item['MangXHID'].'" >
                            <label for="check_sp_'.$item['MangXHID'].'"></label>
                        </span>
                    </td>
                    <td><img class="imgsp_wrapper" src="'.$item['Image'].'"  onerror="imgError(this)"  ></td>
                    <td>'.$item['TieuDe'].'</td>
                    <td><a target="blank" href="'.$item['Link'].'">'.$item['Link'].'</a>
                    </td>  
                    <td class="text_center"> 
                        <span class="wrapper_label">
                            <input type="checkbox" id="check_other_'.$item['MangXHID'].'" MangXHID="'.$item['MangXHID'].'"  class="check_hienthi"';
                            if($item['HienThi']==1) 
                                $t.='checked';
                            $t.='/>';
                            $t.='<label for="check_other_'.$item['MangXHID'].'"></label>
                        </span>';
                            if($item['HienThi']==1) 
                                $t.='<span class="hienthi_sort">1</span>'; 
                            else
                                $t.='<span class="hienthi_sort">0</span>'; 
                    $t.='</td> 
                    <td class="text_center">
                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_mangxahoi toggle_form_add_edit" MangXHID = "'.$item['MangXHID'].'" ><i class="fa fa-pencil"></i></button>
                        <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_mangxahoi dropdown_togle" >
                            <i class="fa fa-trash-o"></i> 
                            <div class="dropdown_menu">
                                <p class="dropdown_title">Bạn có muốn xóa?</p>
                                <input type="button" class="btn btn-info ok_del_mangxahoi" value="Đồng ý" MangXHID = "'.$item['MangXHID'].'">
                                <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                            </div>
                        </div>
                    </td>
                </tr>';
        } 
        return $t;
    } 
 
// -----get sanpham-----------
    public function get_mangxahoi_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $mangxahoi = $this->mangxahoi_model->get_mangxahoi_admin($number,$offset);        
        $list_mangxahoi = $this->echo_mangxahoi_admin($mangxahoi,$offset);
        $count = $this->mangxahoi_model->count_all_mangxahoi_admin();
        $result = array(
            'list_mangxahoi' => $list_mangxahoi,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_mangxahoi_admin(){
        echo $this->mangxahoi_model->count_all_mangxahoi_admin();
    }
// -----get sanpham----------- 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















