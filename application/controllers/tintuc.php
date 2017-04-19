<?php
class Tintuc extends CI_Controller {
    public function __construct(){
        parent::__construct(); 
        $this->load->Model('mangxahoi_model');  
        $this->load->Model('tintuc_model');   
    } 

    // ================================== INDEX ===============================
    public function index($TinTucID)
    { 
        $data['chitiet_tintuc'] = $this->tintuc_model->get_chitiet_tintuc($TinTucID);
        if(!empty($data['chitiet_tintuc'])){ 
            $data['title'] = $data['chitiet_tintuc']['TieuDe'].' || Mua là có ngay';
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['menuActive'] = 'tintuc';
            $data['more_tintuc'] = $this->tintuc_model->get_tintuc_limit(6,0);
            $data['path_1'] = '<a href="'.base_url().'tin-tuc/trang-1.html">Tin tức</a>';

            $data = array_merge($this->main_lib->get_data_index() , $data);
            $data['product_new'] = $this->main_lib->get_product_new();
            $this->load->view('header',$data); 
            $this->load->view('aside',$data); 
            $this->load->view('tintuc/chitiet',$data);
            $this->load->view('footer',$data); 
        }else{ 
            $data['sidebar'] = $this->main_lib->get_sidebar();
            $data['title'] = 'Page Not Found - Mua là có ngay';
            $data = array_merge($this->main_lib->get_data_index() , $data);
            $data['product_new'] = $this->main_lib->get_product_new();
            $this->load->view('header',$data);
            $this->load->view('aside',$data); 
            $this->load->view('error/404',$data);
            $this->load->view('footer',$data);
        }
    }

    public function phantrang($page=0){ 
        $history=1;
        if(isset($_POST['history'])){
            $history = $_POST['history']; 
        }    

        $number = ($this->session->userdata("per_page")) ? $this->session->userdata("per_page") : PER_PAGE;
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 

        $data['list_tintuc'] = $this->tintuc_model->get_tintuc_limit($number,$offset);
        
        $count_all_tintuc = $this->tintuc_model->count_all_tintuc();
        $data['all_page'] = ceil($count_all_tintuc/$number);
        $data['cur_page'] = $page; 

        $count_list = count($data['list_tintuc']);
        $from = ($count_list == 0) ? 0 : (($offset == 1) ? $offset : $offset+1);
        $to = $offset+$number;
        $to = ($count_all_tintuc > $to) ? $to : $count_all_tintuc; 
        $data['from'] = $from; 
        $data['to'] = $to; 
        $data['all'] = $count_all_tintuc; 

        if($history == 0){
            define('data_url', base_url().'application/data/');
        } 
        $data['sidebar'] = $this->main_lib->get_sidebar();
        $data['title'] = 'Tin tức- Trang '.$page.' || Mua là có ngay';
        $data['menuActive'] = 'tintuc';
        $data = array_merge($this->main_lib->get_data_index() , $data);
        $data['product_new'] = $this->main_lib->get_product_new();
        ($history == 1) ? $this->load->view('header',$data):0;
        ($history == 1) ? $this->load->view('aside',$data):0;
        $this->load->view('tintuc/index',$data);
        ($history == 1) ? $this->load->view('footer',$data):0;
    } 

    public function page_search_tintuc($key,$page=0){
        $key = str_replace('-',' ',$key);

        $history=1;
        if(isset($_POST['history'])){
            $history = $_POST['history']; 
        }    

        $number = PER_PAGE;
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page != 1) ? ($page-1)*$number : 0; 
 
        $data['list_search_tintuc'] = $this->tintuc_model->search_all_tintuc($key,$number,$offset);

        $count_all_search_tintuc = $this->tintuc_model->count_all_search_tintuc($key);
        $data['all_page'] = ceil($count_all_search_tintuc/$number);
        $data['cur_page'] = $page; 

        $count_list = count($data['list_search_tintuc']);
        $from = ($count_list == 0) ? 0 : (($offset == 1) ? $offset : $offset+1);
        $to = $offset+$number;
        $to = ($count_all_search_tintuc > $to) ? $to : $count_all_search_tintuc; 
        $data['from'] = $from; 
        $data['to'] = $to; 
        $data['all'] = $count_all_search_tintuc; 

        if($history == 0){
            define('data_url', base_url().'application/data/');
        }
        $data['key'] = $key;        
        $data['sidebar'] = $this->main_lib->get_sidebar();
        $data['title'] = 'Tìm kiếm - Trang '.$page.' || Mua là có ngay';
        $data = array_merge($this->main_lib->get_data_index() , $data);
        
        ($history == 1) ? $this->load->view('header',$data):0;
        ($history == 1) ? $this->load->view('aside',$data):0;
        $this->load->view('tintuc/search',$data);
        ($history == 1) ? $this->load->view('footer',$data):0;
        
    }

    //-----------------------------ADMIN--------------------  
    public function insert_tintuc(){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date= date("Y/m/d H:i:s"); 

        if($_POST['images']){
            $src = $_POST['images'];
        }else{
            $src = base_url().'application/data/img/notFound.png';
        }
        $data = array( 
            "Image"=>$src,
            "TieuDe"=>$_POST['TieuDe'],
            "MoTa"=>$_POST['MoTa'],
            "NoiDung"=>$_POST['NoiDung'], 
            'Ngay'=>$date,
        );
        $kq = $this->tintuc_model->insert_tintuc($data); 

        if($kq == 1){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function edit_tintuc(){    
        // preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i',  $_POST['NoiDung'], $matches);

        if($_POST['images']){
            $src = $_POST['images'];
        }else{
            $src = base_url().'application/data/img/notFound.png';
        }
      
        $data = array(
            "Image"=>$src,
            'TieuDe'=>$_POST['TieuDe'],
            'MoTa'=>$_POST['MoTa'], 
            'NoiDung'=>$_POST['NoiDung'],  
        );
        if($this->tintuc_model->update_tintuc($data,$_POST['TinTucID']))
            echo 1;
        else
            echo 0;
    }
    public function update_hienthi_tintuc(){   
        $data = array( 
            'HienThi'=>$_POST['HienThi'],   
        );
        if($this->tintuc_model->update_tintuc($data,$_POST['TinTucID']))
            echo 1;
        else
            echo 0;
    }
    public function delete_tintuc(){
        $TinTucID = $_POST['TinTucID'];
        if( $this->tintuc_model->delete_tintuc($TinTucID) ){
            echo 1;
        }else{
            echo -1;
        }
    }

    public function delete_more_tintuc(){
        $arr_TinTucID = (array)$_POST['arr_TinTucID'];
        foreach($arr_TinTucID as $TinTucID){
            $this->tintuc_model->delete_tintuc($TinTucID);
        }
        echo 1;
    }

    public function get_chitiet_tintuc_admin(){
        $TinTucID = $_POST['TinTucID'];
        echo json_encode($this->tintuc_model->get_chitiet_tintuc_admin($TinTucID) );
    }

    public function echo_tintuc_admin($tintuc,$offset){ 
        $t = ''; 
        if(!empty($tintuc)){
            foreach ($tintuc as $item) {
                $offset++;                  
                $t.='<tr> 
                        <td>'.$offset.'</td> 
                        <td class="text_center">
                            <span class="wrapper_label">
                                <input type="checkbox" class="checkbox_item" id="check_sp_'.$item['TinTucID'].'" TinTucID = "'.$item['TinTucID'].'" >
                                <label for="check_sp_'.$item['TinTucID'].'"></label>
                            </span>
                        </td>
                        <td><img class="imgsp_wrapper" src="'.$item['Image'].'" onerror="imgError(this)" ></td>
                        <td><a target="blank" href="'.base_url().'tin-tuc/'.url_title(removesign($item['TieuDe'])).'_'.$item['TinTucID'].'">'.$item['TieuDe'].'</a>
                        </td>  
                        <td class="text_center"> 
                            <span class="wrapper_label">
                                <input type="checkbox" id="check_other_'.$item['TinTucID'].'" TinTucID="'.$item['TinTucID'].'"  class="check_hienthi"';
                                if($item['HienThi']==1) 
                                    $t.='checked';
                                $t.='/>';
                                $t.='<label for="check_other_'.$item['TinTucID'].'"></label>
                            </span>';
                                if($item['HienThi']==1) 
                                    $t.='<span class="hienthi_sort">1</span>'; 
                                else
                                    $t.='<span class="hienthi_sort">0</span>'; 
                        $t.='</td> 
                        <td class="text_center">
                            <button type="submit" data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary edit_tintuc toggle_form_add_edit" TinTucID = "'.$item['TinTucID'].'" ><i class="fa fa-pencil"></i></button>
                            <div data-toggle="tooltip" data-placement="top" title="Xóa" class="btn btn-danger del_tintuc dropdown_togle" >
                                <i class="fa fa-trash-o"></i> 
                                <div class="dropdown_menu">
                                    <p class="dropdown_title">Bạn có muốn xóa?</p>
                                    <input type="button" class="btn btn-info ok_del_tintuc" value="Đồng ý" TinTucID = "'.$item['TinTucID'].'">
                                    <input type="button" class="btn btn-default dropdown_close" value="Hủy">
                                </div>
                            </div>
                        </td>
                    </tr>';
            }
        }else{
            $t.='<tr><td colspan="8">Không có tin tức!</td></tr>';
        }
        return $t;
    } 
 
// -----get sanpham-----------
    public function init_tintuc_admin(){
        $sp = $this->tintuc_model->get_tintuc_admin(10,0);        
        $list = $this->echo_tintuc_admin($sp,0);
        return $list;
    }

    public function get_tintuc_admin(){
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->tintuc_model->get_tintuc_admin($number,$offset);        
        $list_sp = $this->echo_tintuc_admin($sp,$offset);
        $count = $this->tintuc_model->count_all_tintuc_admin();
        $result = array(
            'list_sp' => $list_sp,
            'count' => $count
        );
        echo json_encode($result);
    }

    public function count_all_tintuc_admin(){
        echo $this->tintuc_model->count_all_tintuc_admin();
    }
// -----get sanpham-----------

// ---------------search------------------
    public function search_tintuc_admin(){
        $key = $_POST['key'];
        $number = $_POST['number'];
        $offset = $_POST['offset'];
        $sp = $this->tintuc_model->search_tintuc_admin($key,$number,$offset);
        $list_search = $this->echo_tintuc_admin($sp,$offset); 
        $count = $this->tintuc_model->count_search_tintuc_admin($key);
        $result = array(
            'list_search' => $list_search,
            'count' => $count
        );
        echo json_encode($result);
    }
    public function count_search_tintuc_admin(){
        $key = $_POST['key'];
        echo $this->tintuc_model->count_search_tintuc_admin($key);
    }
// ---------------search------------------
 
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















