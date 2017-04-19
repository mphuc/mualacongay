<?php  

class MY_form_validation extends CI_Form_validation { 

	//-------------- trả kết quả thành mảng lỗi khi validate form------
	public function error_array()
    {
        return $this->_error_array;
    }
} 