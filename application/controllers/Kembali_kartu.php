<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kembali_kartu extends CI_Controller {
		
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
		$where		=	"t_order.id_customer!='1' and t_order.status_bayar='Lunas' and t_order.id_kartu is null";
		
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->order_model->getCount($where,$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;		
		
		$this->pagination->initialize($config);	
		$this->showData = $this->order_model->showData($where,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('ambil_kartu/ambil_kartu_view');
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
	

}
