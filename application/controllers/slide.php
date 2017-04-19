<?php
class slide extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->Model('slide_model');    
    } 
 
    //-----------------------------ADMIN--------------------  
    public function insert_slide(){ 
        $data = array(  
            "Image"=>$_POST['Image'],
            "TieuDe"=>$_POST['TieuDe'],
            "Link"=>$_POST['Link'], 
        );
        $kq = $this->slide_model->insert_slide($data); 

        if($kq == 1){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function edit_slide(){    
        $data = array(
            "Image"=>$_POST['Image'],
            "TieuDe"=>$_POST['TieuDe'],
            "Link"=>$_POST['Link'],  
        );
        if($this->slide_model->update_slide($data,$_POST['SlideID']))
            echo 1;
        else
            echo 0;
    }
    public function update_hienthi_slide(){   
        $data = array( 
            'HienThi'=>$_POST['HienThi'],   
        );
        if($this->slide_model->update_slide($data,$_POST['SlideID']))
            echo 1;
        else
            echo 0;
    }
    public function delete_slide(){
        $SlideID = $_POST['SlideID'];
        if( $this->slide_model->delete_slide($SlideID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function delete_more_slide(){
        $arr_SlideID = (array)$_POST['arr_SlideID'];
        foreach($arr_SlideID as $SlideID){
            $this->slide_model->delete_slide($SlideID);
        }
        echo 1;
    }

    public function get_chitiet_slide_admin(){
        $SlideID = $_POST['SlideID'];
        echo json_encode($this->slide_model->get_chitiet_slide_admin($SlideID) );
    }

    public function echo_slide_admin($list_slide,$offset){ 
        $t = ''; 
        foreach ($list_slide as $item) {
            $offset++;                  
            $t.='<tr> 
                    <td>'.$offset.'</td> 
                    <td class="text_center">
                        <span class="wrapper_label">
                            <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['SlideID'].'" SlideID = "'.$item['SlideID'].'" >
                            <label for="check_sp_'.$item['SlideID'].'"></label>
                        </span>
                    </td>
                    <td><img class="imgsp_wrapper" src="'.$item['Image'].'"  onerror="imgError(this)"  ></td>
                    <td>'.$item['TieuDe'].'</td>
                    <td><a target="blank" href="'.$item['Link'].'">'.$item['Link'].'</a>
                    </td>  
                    <td class="text_center"> 
                        <span class="wrapper_label">
                            <input type="checkbox" id="check_other_'.$item['SlideID'].'" SlideID="'.$item['SlideID'].'"  class="check_hienthi"';
                            if($item['HienThi']==1) 
                                $t.='checked';
                            $t.='/>';
                            $t.='<label for="check_other_'.$item['SlideID'].'"></label>
                        </span>';
                            if($item['HienThi']==1) 
                                $t.='<span class="hienthi_sort">1</span>'; 
                            else
                                $t.='<span class="hienthi_sort">0</span>'; 
                    $t.='</td> 
                    <td class="text_center">
                        <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_slide toggle_form_add_edit" SlideID = "'.$item['SlideID'].'" ><i class="fa fa-pencil"></i></button>
                        <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_slide dropdown_togle" >
                            <i class="fa fa-trash-o"></i> 
                            <div class="dropdown_menu">
                                <p class="dropdown_title">Bạn có muốn xóa?</p>
                                <input type="button" class="btn btn-info ok_del_slide" value="Đồng ý" SlideID = "'.$item['SlideID'].'">
                                <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                            </div>
                        </div>
                    </td>
                </tr>';
        } 
        return $t;
    } 
 
// -----get sanpham-----------
    public function get_slide_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $slide = $this->slide_model->get_slide_admin($number,$offset);        
        $list_slide = $this->echo_slide_admin($slide,$offset);
        $count = $this->slide_model->count_all_slide_admin();
        $result = array(
            'list_slide' => $list_slide,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_slide_admin(){
        echo $this->slide_model->count_all_slide_admin();
    }
// -----get sanpham----------- 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















