<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_customer_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'NAMA_CUSTOMER, ID_CUSTOMER'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->m_customer_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->m_customer_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('customer/customer_view');
	}
	
	public function edit($IdPrimaryKey){
		$where = array('ID_CUSTOMER' => $IdPrimaryKey);
		$this->oldData = $this->m_customer_model->getData($where);		
		$this->template_view->load_view('customer/customer_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NAMA_CUSTOMER', '', 'trim|required');		
		$this->form_validation->set_rules('ID_CUSTOMER', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_CUSTOMER' => $this->input->post('NAMA_CUSTOMER')	,
				'ALAMAT_CUSTOMER' => $this->input->post('ALAMAT_CUSTOMER')	,	
				'EMAIL_CUSTOMER' => $this->input->post('EMAIL_CUSTOMER')	,	
				'HP_CUSTOMER' => $this->input->post('HP_CUSTOMER')	,	
				'AKTIF' => $this->input->post('AKTIF')
			);
			
			$where = array('ID_CUSTOMER' => $this->input->post('ID_CUSTOMER'));
			$query = $this->m_customer_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	
}
