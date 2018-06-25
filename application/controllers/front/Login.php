<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_customer_model');
		
	} 

	public function index(){
		$this->template_view->load_front_view('front/login_view');
	}
	
	public function login_data(){
		$this->form_validation->set_rules('EMAIL_CUSTOMER', '', 'trim|required');		
		$this->form_validation->set_rules('PASSWORD', '', 'trim|required');
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal Login, pastikan telah mengisi semua inputan.');
		}
		else{								
			$data = array(			
				'EMAIL_CUSTOMER' => $this->input->post('EMAIL_CUSTOMER'),							
				'PASSWORD' => $this->input->post('PASSWORD')				
			);
			
			$dataUser = $this->m_customer_model->getData("EMAIL_CUSTOMER = '".$this->input->post('EMAIL_CUSTOMER') ."' and PASSWORD='".$this->input->post('PASSWORD')."'");
							
			if($dataUser){
				$sess_array = array(
					'nama_customer' => $dataUser->NAMA_CUSTOMER, 'id_customer' => $dataUser->ID_CUSTOMER, 'email_customer' => $dataUser->EMAIL_CUSTOMER
				);
				$this->session->set_userdata($sess_array);	
		
				$status = array('status' => true,'redirect_link' => base_url()."front/tiket");
			}
			else{
				$status = array('status' => false,'pesan' => 'Login gagal, pastikan Username dan Password anda benar.');
			}		
		}
		
		echo(json_encode($status));
	}
	
	
}
