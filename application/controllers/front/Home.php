<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('karyawan_model');
		$this->load->model('kategori_user_model');
		
	} 

	public function index(){
		
		$this->template_view->load_front_view('front/home_view');
	}
	
	
	
}
