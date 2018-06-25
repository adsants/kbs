<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('barang_model');
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 'NAMA_BARANG, ID_BARANG'; 
		$urlSearch 	= null;
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->barang_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->barang_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('barang/barang_view');
	}
	public function add(){
		$this->template_view->load_view('barang/barang_add_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('NAMA_BARANG', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$maxIDCustomer = $this->barang_model->getPrimaryKeyMax();
			//var_dump($maxIDCustomer);
			$newId = $maxIDCustomer->MAX + 1;
		
			$data = array(			
				'ID_BARANG' => $newId,		
				'NAMA_BARANG' => $this->input->post('NAMA_BARANG')	,	
				'KETERANGAN' => $this->input->post('KETERANGAN')	,	
				'HARGA' => $this->input->post('HARGA')
			);
			$query = $this->barang_model->insert($data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function edit($IdPrimaryKey){
		$where = array('ID_BARANG' => $IdPrimaryKey);
		$this->oldData = $this->barang_model->getData($where);		
		$this->template_view->load_view('barang/barang_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NAMA_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('ID_BARANG', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NAMA_BARANG' => $this->input->post('NAMA_BARANG')	,
				'KETERANGAN' => $this->input->post('KETERANGAN')	,	
				'HARGA' => $this->input->post('HARGA')
			);
			
			$where = array('ID_BARANG' => $this->input->post('ID_BARANG'));
			$query = $this->barang_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('ID_BARANG' => $IdPrimaryKey);
		$delete = $this->barang_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_barang(){
		$like = array('NAMA_BARANG' => $this->input->get('term'));
		$dataKaryawan = $this->barang_model->showData("",$like,"NAMA_BARANG");  
		echo '[';		
		$i=1;
		foreach($dataKaryawan as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NAMA_BARANG.'","ID_BARANG":"'.$data->ID_BARANG.'"} ';
			$i++;
		}
		echo ']';
	}
	
	
	public function cek_harga(){
		$where = array('ID_BARANG' => $this->input->post('id_barang'));
		$this->oldData = $this->barang_model->getData($where);		
		
		if($this->oldData){
			$status = array('status' => true , 'harga' => $this->oldData->HARGA);
		}
		else{
			
			$status = array('status' => false);
		}
		
		echo(json_encode($status));
		
	}
}
