<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konfirmasi extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		$this->load->model('kartu_model');
		
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 't_order.ID_T_ORDER desc'; 
		$urlSearch 	= null;
		$where		= "t_order.id_customer != '1' and t_order.status_bayar='Sudah Konfirmasi Bayar'";
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->order_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->order_model->showData($where,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('konfirmasi/konfirmasi_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('id_order', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
		
			$data = array(			
				'STATUS_BAYAR' => 'Lunas',			
			);
			$where = array('ID_T_ORDER' => $this->input->post('id_order'));
			$query = $this->order_model->update($where,$data);					
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	
	
	
}
