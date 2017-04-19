<?php
class cauhinh extends CI_Controller {
    private $date;
    public function __construct(){
        parent::__construct();  
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $this->date = date("Y/m/d H:i:s"); 

        $this->load->Model('cauhinh_model');   
        $this->load->Model('ngayupdate_model');   
    }  

    //-----------------------------ADMIN--------------------  
 
    public function edit_cauhinh(){    
        $data = array(  
            "hostname_webservice" => $this->input->post('hostname_webservice'),  
            "port_webservice" => $this->input->post('port_webservice'),
            "username_webservice" => $this->input->post('username_webservice'),
            "password_webservice" => $this->input->post('password_webservice'),
            
            "hostname_ftp" => $this->input->post('hostname_ftp'),  
            "port_ftp" => $this->input->post('port_ftp'),  
            "username_ftp" => $this->input->post('username_ftp'),  
            "password_ftp" => $this->input->post('password_ftp'),   
        );
        if($this->cauhinh_model->update_cauhinh($data,$this->input->post('CauHinhID') ))
            echo 1;
        else
            echo 0;
    }   

    public function test_ftp_server(){
        echo $this->main_lib->test_ftp_server();
    }

    public function test_webservice(){ 
        echo $this->main_lib->test_webservice();
    }
 
    public function change_connect_server(){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("H:i:s Y/m/d"); 

        // if( $this->main_lib->test_account_server() ){
            if( $this->input->post('connect_server') == 0 ){ //----kết nối hosting 
                $data = array( "connect_server" => 0);
                if($this->cauhinh_model->update_cauhinh($data,$this->input->post('CauHinhID') )){
                    $this->ngayupdate_model->update_ngayupdate(array('Connect' => $this->date, ));
                    $result = array( 
                        "now" => $date,
                    );
                    echo json_encode($result);
                } 
            }else if( $this->main_lib->test_webservice()){ //-----kết nối server 
                if( $this->input->post('connect_server') == 1 ){
                    $data = array( "connect_server" => 1);
                    if($this->cauhinh_model->update_cauhinh($data,$this->input->post('CauHinhID') )){
                        $this->ngayupdate_model->update_ngayupdate(array('Connect' => $this->date, ));
                        $result = array( 
                            "now" => $date,
                        );
                        echo json_encode($result);
                    }
                }else{
                    echo -1;
                }
            }else{
                echo -1;
            }
        // }else{
        //     echo -2;
        // }
    } 

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
















