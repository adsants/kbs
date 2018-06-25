<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trans_tiket extends CI_Controller {
		
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
		$this->showData = $this->order_model->showData("",$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('trans_tiket/trans_tiket_view');
	}
	public function add(){
		$order_by 	= 'NAMA_BARANG';
		$this->dataBarang = $this->barang_model->showData('','',$order_by);
		$this->statusBayar = 'Belum Bayar' ;
		if($this->input->get('id_order')){
			
			$this->load->library('rupiah');
			
			$where =" id_t_order = '".$this->input->get('id_order')."'  ";
			$order_by = "id_detail_order";
			$this->dataDetail = $this->order_model->showDataDetail($where,'',$order_by);
			
			$where = array('id_t_order' => $this->input->get('id_order'));
			$this->dataOrder = $this->order_model->getData($where);
			
			$this->statusBayar = $this->dataOrder->STATUS_BAYAR;
			//echo $this->db->last_query();
			//echo $this->rupiah->to_rupiah('123131');
		}		
		
		$this->template_view->load_view('trans_tiket/trans_tiket_add_view');
	}
	
	
	private function generatePIN($digits = 4){
		$i = 0; //counter
		$pin = ""; //our default pin is blank.
		while($i < $digits){
			//generate a random number between 0 and 9.
			$pin .= mt_rand(0, 9);
			$i++;
		}
		return $pin;
	}
 

	public function add_data(){
		$this->form_validation->set_rules('ID_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('QTY_BARANG', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{					
			$where = array('ID_BARANG' => $this->input->post('ID_BARANG'));
			$dataBarang = $this->barang_model->getData($where);
			
			$totalHarga	=	$this->input->post('QTY_BARANG') * $dataBarang->HARGA ;
			
			if($this->input->post('ID_ORDER')!=''){		
				
				
			
				if($this->input->post('ID_BARANG') == 1){
					$data = array(				
						'ID_T_ORDER' 	=> $this->input->post('ID_ORDER')	,		
						'ID_BARANG' 	=> $this->input->post('ID_BARANG')	,	
						'QTY_BARANG' 	=> '1',
						'HARGA' 		=> $this->input->post('QTY_BARANG'),
						'TOTAL_HARGA' 	=> $this->input->post('QTY_BARANG')
					);
				}
				else{
					$data = array(				
						'ID_T_ORDER' => $this->input->post('ID_ORDER')	,		
						'ID_BARANG' => $this->input->post('ID_BARANG')	,	
						'QTY_BARANG' => $this->input->post('QTY_BARANG'),
						'HARGA' => $dataBarang->HARGA,
						'TOTAL_HARGA' => $totalHarga
					);
				}
				
				$query = $this->order_model->insertDetail($data);							
				$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1)."/add?id_order=".$this->input->post('ID_ORDER'),'id_order' => $this->input->post('ID_ORDER'));
			}
			else{
				
				
				$maxIDCustomer = $this->order_model->getPrimaryKeyMax();
				$newId = $maxIDCustomer->MAX + 1;
			
				$data = array(			
					'ID_T_ORDER' => $newId,		
					'NO_ORDER' => $this->generatePIN(),	
					'ID_CUSTOMER' => $this->input->post('ID_CUSTOMER')
				);
				$query = $this->order_model->insert($data);		
				
				if($this->input->post('ID_BARANG') == 1){
					$dataDetail = array(				
						'ID_T_ORDER' 	=> $newId	,	
						'ID_BARANG' 	=> $this->input->post('ID_BARANG')	,	
						'QTY_BARANG' 	=> '1',
						'HARGA' 		=> $this->input->post('QTY_BARANG'),
						'TOTAL_HARGA' 	=> $this->input->post('QTY_BARANG')
					);
				}
				else{
					$dataDetail = array(				
						'ID_T_ORDER' => $newId	,	
						'ID_BARANG' => $this->input->post('ID_BARANG')	,	
						'QTY_BARANG' => $this->input->post('QTY_BARANG'),
						'HARGA' => $dataBarang->HARGA,
						'TOTAL_HARGA' => $totalHarga
					);
				}
				
				$query = $this->order_model->insertDetail($dataDetail);			
				
				$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1)."/add?id_order=".$newId ,'id_order' =>$newId);
			}
		
			
		}
		
		echo(json_encode($status));
	}
	public function ambil_tiket(){		
		
		$where = array('nomor_rfid' => $this->input->post('nomor_rfid'));
		$this->dataKartu = $this->kartu_model->getData($where);
		//var_dump($this->db->last_query());
		if($this->dataKartu){
			
			$cek	=	$this->db->query("
			select t_order.id_kartu from m_kartu,t_order where
				m_kartu.id_kartu=t_order.id_kartu and
				m_kartu.nomor_rfid = '".$this->input->post('nomor_rfid')."' and 
				t_order.tgl_kartu_kembali is null
			");
			$dataCek = $cek->row();
			
			if($dataCek){
				
				$status = array('status' => false , 'pesan' => 'Kartu sedang Digunakan !');
			}
			else{
				$cek	=	$this->db->query("
				update t_order set STATUS_BAYAR='Lunas' , id_kartu = '".$this->dataKartu->ID_KARTU."' where id_t_order='".$this->input->post('id_order_ambil_kartu')."'
				");
				$status = array('status' => true);
			}
			
			//echo $this->db->last_query();
		}
		else{			
			$status = array('status' => false , 'pesan' => 'Kartu tidak Terdaftar !');
		}
		
		echo(json_encode($status));
		
		
		//redirect("trans_tiket");
	}
	
	
	
	public function edit($IdPrimaryKey){
		$where = array('ID_ORDER' => $IdPrimaryKey);
		$this->oldData = $this->order_model->getData($where);		
		$this->template_view->load_view('trans_tiket/trans_tiket_edit_view');
	}
	public function edit_data(){
		$this->form_validation->set_rules('NO_ORDER', '', 'trim|required');		
		$this->form_validation->set_rules('ID_ORDER', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
			$data = array(			
				'NO_ORDER' => $this->input->post('NO_ORDER')	,
				'KETERANGAN' => $this->input->post('KETERANGAN')	,	
				'HARGA' => $this->input->post('HARGA')
			);
			
			$where = array('ID_ORDER' => $this->input->post('ID_ORDER'));
			$query = $this->order_model->update($where,$data);							
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function delete($IdPrimaryKey){
		$where = array('ID_ORDER' => $IdPrimaryKey);
		$delete = $this->order_model->delete($where);		
		redirect(base_url()."".$this->uri->segment(1));
	}
	public function search_barang(){
		$like = array('NO_ORDER' => $this->input->get('term'));
		$dataKaryawan = $this->order_model->showData("",$like,"NO_ORDER");  
		echo '[';		
		$i=1;
		foreach($dataKaryawan as $data){			
			
			if($i > 1){echo ",";}
			echo '{ "label":"'.$data->NO_ORDER.'","ID_ORDER":"'.$data->ID_ORDER.'"} ';
			$i++;
		}
		echo ']';
	}
}
