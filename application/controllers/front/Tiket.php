<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiket extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('barang_model');
		$this->load->model('order_model');
		
	} 

	public function index(){
		if( !$this->session->userdata('id_customer') ){
			redirect("front/login");
		}
		
		$where = "t_order.id_customer = '".$_SESSION['id_customer']."'";
		$order_by = "id_t_order desc";
		$this->showData = $this->order_model->showData($where,"",$order_by);
		
		$this->template_view->load_front_view('front/tiket_view');
	}
	
	public function add(){
		if( !$this->session->userdata('id_customer') ){
			redirect("front/login");
		}
		
		$this->load->library('rupiah');
		
		$order_by 	= 'NAMA_BARANG';
		$this->dataBarang = $this->barang_model->showData('','',$order_by);
		
		if($this->input->get('id_order')){
			
			
			
			$whereCek = array('id_customer' => $_SESSION['id_customer'],'id_t_order' => $this->input->get('id_order'));			
			$this->dataOrder = $this->order_model->getData($whereCek);
			
			if(!$this->dataOrder){
				redirect('front/tiket');
			}
			
			$where = array('id_t_order' => $this->input->get('id_order'));
			$order_by = "id_detail_order";
			$this->dataDetail = $this->order_model->showDataDetail($where,'',$order_by);
			
			$where = array('id_t_order' => $this->input->get('id_order'));
			$this->dataOrder = $this->order_model->getData($where);
			//echo $this->db->last_query();
			//echo $this->rupiah->to_rupiah('123131');
		}
		
		$this->template_view->load_front_view('front/tiket_add_view');
	}
	
	public function cek_total_harga_order(){
		
		$cekHarga = $this->db->query("select sum(TOTAL_HARGA) as TOTAL_HARGA from t_detail_order where id_t_order = '".$this->input->get('id_order')."'");
		$dataHarga	=	$cekHarga->row();
		
		if($dataHarga){
			$status = array('status' => true,'total_harga' => $dataHarga->TOTAL_HARGA );	
		}
		else{
			$status = array('status' => false,'pesan' => 'Login gagal, pastikan Username dan Password anda benar.');	
		}
		
		echo(json_encode($status));
	}
	
	public function konfirmasi(){
		
		$whereCek = array('id_customer' => $_SESSION['id_customer'], 'id_t_order' => $this->input->post('ID_ORDER'),'status_bayar' => 'Belum Bayar');			
		$this->dataOrder = $this->order_model->getData($whereCek);
		
		if($this->dataOrder){
			$cekHarga = $this->db->query("select sum(TOTAL_HARGA) as TOTAL_HARGA from t_detail_order where id_t_order = '".$this->input->post('ID_ORDER')."'");
			
			$dataHarga	=	$cekHarga->row();
			
			$this->load->library('rupiah');
			$keterangan = "Telah ditransfer uang sebesar <b>".$this->rupiah->to_rupiah($dataHarga->TOTAL_HARGA)."</b> dari Bank <b>".$this->input->post('JENIS_BANK')."</b> dengan Rekening <b>".$this->input->post('NO_REKENING')."</b> ke <b>".$this->input->post('BANK_TUJUAN')."</b> pada Tanggal <b>".$this->input->post('TGL_TRANSFER')."</b>";
			
			$this->db->query("
			update 
				t_order
			set 
				status_bayar = 'Sudah Konfirmasi Bayar',
				KETERANGAN_KONFIRMASI_BAYAR = '".$keterangan."',
				TGL_KONFIRMASI_BAYAR = '2018-06-23'
			where
				id_t_order = '".$this->input->post('ID_ORDER')."'
			
			");
			//echo $this->db->last_query();
			$status = array('status' => true);
		}
		else{
			$status = array('status' => false,'pesan' => 'Proses simpan Gagal, silahkan Reload Halaman ini !');
		}
		
		echo(json_encode($status));
	}
	
}
