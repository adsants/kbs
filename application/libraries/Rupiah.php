<?php
class Rupiah extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
    
   
    function to_rupiah($angka){
	
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	 
	}
 

}
