<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartu extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('kartu_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'NOMOR_RFID, ID_KARTU'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->kartu_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->kartu_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('kartu/kartu_view');
	}
	public function add(){
		$this->template_view->load_view('kartu/kartu_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NOMOR_RFID', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
		
			$whereCek = array('NOMOR_RFID' => $this->input->post('NOMOR_RFID'));
			$dataCek = $this->kartu_model->getData($whereCek);
		
			if($dataCek){
				$status = array('status' => false , 'pesan' => 'Kartu RFID telah terdaftar !');
			}
			else{
				$maxIDCustomer = $this->kartu_model->getPrimaryKeyMax();
				//var_dump($maxIDCustomer);
				$newId = $maxIDCustomer->MAX + 1;
			
				$data = array(			
					'ID_KARTU' => $newId,		
					'NOMOR_RFID' => $this->input->post('NOMOR_RFID')	
				);
				$query = $this->kartu_model->insert($data);							
				$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
			}
			
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('ID_KARTU' => $IdPrimaryKey);
		$this->oldData = $this->kartu_model->getData($where);		
		$this->template_view->load_view('kartu/kartu_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NOMOR_RFID', '', 'trim|required');		
		$this->form_validation->set_rules('ID_KARTU', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NOMOR_RFID' => $this->input->post('NOMOR_RFID')
			);
			
			$where = array('ID_KARTU' => $this->input->post('ID_KARTU'));
			$query = $this->kartu_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('ID_KARTU' => $IdPrimaryKey);
		$delete = $this->kartu_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_barang(){
		$like = array('NOMOR_RFID' => $this->input->get('term'));
		$dataKaryawan = $this->kartu_model->showData("",$like,"NOMOR_RFID");  
		echo '[';		
		$i=1;
		foreach($dataKaryawan as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NOMOR_RFID.'","ID_KARTU":"'.$data->ID_KARTU.'"} ';
			$i++;
		}
		echo ']';
	}
}
