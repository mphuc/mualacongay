<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_lib {  
    private $CI;
    public function __construct(){ 
        $this->CI =& get_instance(); 
        $this->CI->load->Model('cauhinh_model');  
        $this->CI->load->Model('ngayupdate_model');  
        // $this->connect_server();
    }   

    public function Server_name(){
        if($_SERVER['SERVER_NAME'] == 'localhost'){
            $arr = explode("/",base_url());
            return $arr[3];
        }else{
            return $_SERVER['SERVER_NAME'];
        }
    }

    public function Webservice($service)
    {
        $cauhinh = $this->CI->cauhinh_model->get_cauhinh();
        $hostname = $cauhinh['hostname_webservice'];
        $port = $cauhinh['port_webservice'];

        require_once(APPPATH.'libraries/nusoap/nusoap.php');
        if( trim($port) != ''){
            $client = new nusoap_client('http://'.$hostname.':'.$port.'/'.$service.'.asmx?WSDL', true);
        }else{
            $client = new nusoap_client('http://'.$hostname.'/'.$service.'.asmx?WSDL', true);
        }
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = false; 

        //$client->setCredentials($cauhinh['username_webservice'],$cauhinh['password_webservice'], "basic");
        // print_r($client);

        return $client;
    }

    public function test_webservice(){ //--- trạng thái kết nối cửa webservice 
        $cauhinh = $this->CI->cauhinh_model->get_cauhinh();
        $client = $this->Webservice('Module_Connect');
        $result = $client->call('Test_Connect');  

        if($result['Test_ConnectResult'] == 1){ 
            return 1;
        }else{
            return 0;
        }
    }

    public function connect_webservice(){ //--- trạng thái kết nối cửa webservice 
        if( $this->connect_server() == 1 ){
            $cauhinh = $this->CI->cauhinh_model->get_cauhinh();
            $client = $this->Webservice('Module_Connect');
            $result = $client->call('Test_Connect');  
            if($result['Test_ConnectResult'] == 1){ 
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }


    public function connect_server(){ //--- trạng thái kết nối thực của hệ thống
        // $cauhinh = $this->CI->cauhinh_model->get_cauhinh();
        // if( $cauhinh['connect_server'] == 0 ){  //--- nếu đã config = 0 thì ko kết nối đến server
        //     return 0;
        // }else{ 
        //     if( $this->test_webservice() ){
        //         return 1;
        //     }else{
        //         $this->CI->cauhinh_model->update_cauhinh(array("connect_server" => 0),$cauhinh['CauHinhID']);
        //         date_default_timezone_set("Asia/Ho_Chi_Minh");
        //         $date = date("Y/m/d H:i:s");
        //         $this->CI->ngayupdate_model->update_ngayupdate(array('Connect' => $date, ));
        //         return 0;
        //     } 
        // }
        return 0;
    }

    public function config_ftp(){
        $cauhinh = $this->CI->cauhinh_model->get_cauhinh();
        $config['hostname'] = $cauhinh['hostname_ftp'];
        if(trim($cauhinh['port_ftp'])){
            $config['port'] = $cauhinh['port_ftp'];
        }
        $config['username'] = $cauhinh['username_ftp'];
        $config['password'] = $cauhinh['password_ftp'];
        $config['passive']  = FALSE;
        $config['debug']    = FALSE;
        return $config;
    }

    public function test_ftp_server(){ 
        $config = $this->config_ftp();
        // echo( $this->CI->ftp->list_files()); 
        if($this->CI->ftp->connect($config)){
            return 1;
        }else{
            return 0;
        }
        $this->CI->ftp->close(); 
    }

    public function connect_ftp_server(){ 
        if( $this->connect_server() == 1 ){
            $config = $this->config_ftp();
            if($this->CI->ftp->connect($config)){
                return 1;
            }else{
                return 0;
            }
            $this->CI->ftp->close(); 
        }
    }

 
    public function get_data_index(){ //-- controler nào cũng có, gọi những dữ liệu giống nhau
        $this->CI->load->Model('loaisanpham_model'); 
        $this->CI->load->Model('sanpham_model'); 
        $this->CI->load->Model('loaisanpham_model');
        $this->CI->load->Model('danhmuc_model');  
        $this->CI->load->Model('hinhanh_model'); 
        $this->CI->load->Model('mangxahoi_model');  
        $this->CI->load->Model('tintuc_model');   
        $this->CI->load->Model('thongtin_model');
        $this->CI->load->Model('slide_model');  

        $data['thongtin'] = $this->CI->thongtin_model->get_thongtin();
        $data['slide_sanpham'] = $this->get_slide_sanpham(); 
        $data['connect_server'] = $this->connect_server();
        $data['mangxahoi'] = $this->CI->mangxahoi_model->get_mangxahoi();
        $data['slide'] = $this->CI->slide_model->get_slide();
        $data['tintuc_moinhat'] = $this->CI->tintuc_model->get_tintuc_limit(10,0);         
        return $data;
    }

    public function get_data_admin(){ //-- controler nào cũng có, gọi những dữ liệu giống nhau
        $this->CI->load->Model('cauhinh_model');   
        $this->CI->load->Model('thongtin_model');  
        $this->CI->load->Model('lienhe_model');  
        $cauhinh = $this->CI->cauhinh_model->get_cauhinh_admin();  

        $data['count_all_lienhe'] = $this->CI->lienhe_model->count_all_lienhe_admin();
        $data['thongtin'] = $this->CI->thongtin_model->get_thongtin();
        $data['cauhinh'] = $cauhinh;                

        if(trim($cauhinh['port_webservice']) == ''){
            $link_server = 'http://'.$cauhinh['hostname_webservice'];
        }else{
            $link_server = 'http://'.$cauhinh['hostname_webservice'].':'.$cauhinh['port_webservice'];
        }

        if(trim($cauhinh['port_ftp']) == ''){
            $link_server_ftp = 'ftp://'.$cauhinh['hostname_ftp'];
        }else{
            $link_server_ftp = 'ftp://'.$cauhinh['hostname_ftp'].':'.$cauhinh['port_ftp'];
        }

        $data['link_server'] = $link_server;   
        $data['link_server_ftp'] = $link_server_ftp;   

        $data['hoadononline_moinhat'] = $this->CI->hoadononline_moinhat(); //////$$$$$$$$$$$$$$??????????////////////
        $data['count_all_hoadononline_moinhat'] = $this->CI->hoadononline_model->count_all_hoadononline_moinhat();
        $data['count_all_hoadononline_now'] = $this->CI->hoadononline_model->count_all_hoadononline_now();

        return $data;
    }

    public function create_captcha(){
        $this->CI->load->helper("captcha");

        $vals = array( 
            'img_path' => 'application/data/captcha/',
            'img_url' => base_url().'application/data/captcha/',
            'font_path' => base_url().'application/data/font/SVN-Aaron Script.otp',
            'img_width' => '150',
            'img_height' => 40,
            'expiration' => 1800
            );
 
        $cap = create_captcha($vals);

        return $cap;
    }

    public function get_sidebar($menuActive_dm=0,$menuActive_lsp=0){  
        $this->CI->load->Model('danhmuc_model');
        $this->CI->load->Model('loaisanpham_model'); 
        
        $t='';
        $danhmuc = $this->CI->danhmuc_model->get_danhmuc(); 
        foreach ($danhmuc as $dm) {
           
            $t.='<li class="menu-item ">
                    <a href="'.base_url().'danh-muc/'.$dm['DanhMucID'].'/'.url_title(removesign($dm['TenDanhMuc'])).'.html">
                        <span '; 
                            if($menuActive_dm == $dm['DanhMucID']){
                                $t.=' class="menuActive_dm"';
                            }; 
                        $t.=' >'.$dm['TenDanhMuc'].'</span>
                    </a>';
                    $loaisp = $this->CI->loaisanpham_model->get_loaisp_on_danhmuc($dm['DanhMucID']); 
                    if (count($loaisp) > 0)
                    {


                    $t.='<ul class="sub-menu mega-menu">';
                    
                    foreach ($loaisp as $lsp) {
                        $t.='<li class="menu-item depth-2 ">
                                <a href="'.base_url().'loai/'.$lsp['LoaiSPID'].'/'.url_title(removesign($lsp['TenLoaiSP'])).'.html"> 
                                <span ';
                                if($menuActive_lsp == $lsp['LoaiSPID']){
                                    $t.=' class="menuActive_lsp"';
                                }; 
                                $t.='>'.$lsp['TenLoaiSP'].'</span>
                                </a> 
                            </li>';
                    } 
                    $t.='</ul>
                </li>';
                }
        } 
        return $t;
    }

    public function get_product_new()
    {
        $this->CI->load->Model('sanpham_model'); 
        $danhmuc = $this->CI->sanpham_model->get_sanPham_new();
        return  $danhmuc;
    }

    public function get_select_loaisp(){
        $this->CI->load->Model('danhmuc_model');  
        $this->CI->load->Model('loaisanpham_model'); 
         
        $t='';
        $danhmuc = $this->CI->danhmuc_model->get_danhmuc(); 
        foreach ($danhmuc as $dm) {
            $t.='<optgroup label="'.$dm['TenDanhMuc'].'">';
                    $loaisp = $this->CI->loaisanpham_model->get_loaisp_on_danhmuc($dm['DanhMucID']);
                    foreach ($loaisp as $lsp) {
                        $t.='<option value="'.$lsp['LoaiSPID'].'">'.$lsp['TenLoaiSP'].' - '.$lsp['MaLoaiSP'].'</option>';
                    }   
            $t.='</optgroup>';
        } 
        return $t;
    } 

    public function get_gia_sanpham($list_sanpham){
        $this->CI->load->Model('sanpham_model');
        $arr =array();
        foreach ($list_sanpham as $item) {
            $arr[] = $item['SanPhamID'];
        }
        $list = implode(',', $arr );
        $result = $this->CI->sanpham_model->get_gia_sanpham($list);
        return $result;
    }

    public function get_slide_sanpham(){
        $this->CI->load->Model('sanpham_model');
        $t="";
        $sanpham_slide = $this->CI->sanpham_model->get_slide_sanpham();

        $count = count($sanpham_slide); 
        for($i=0;$i<$count;$i+=3)
        {
            $t.='<div class="slide_box">';
            for($j=0;$j<3;$j++){
                $t.='<li class="os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.1s">';
                if( $i+$j < $count )
                { 
                    $t.='<p class="image_slide_sanpham" 
                            style="background-image: url('.$sanpham_slide[$i+$j]['images'].') , url('.base_url().'application/data/img/notFound.png)" 
                            alt="'.$sanpham_slide[$i+$j]['TenSP'].'">
                        </p>
                        <a href="'.base_url().'san-pham/'.url_title(removesign($sanpham_slide[$i+$j]['TenSP'])).'_'.$sanpham_slide[$i+$j]['SanPhamID'].'">
                            <h1><span>'.$sanpham_slide[$i+$j]['TenSP'].'</span></h1>
                        </a>';
                }
                $t.='</li>';
            }
            $t.='</div>';
        } 
        return $t;
    } 
  
}
?>