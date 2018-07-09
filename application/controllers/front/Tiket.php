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
		//var_dump($_SESSION);
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
	
	public function send_email_bayar(){
		
		$this->load->library('rupiah');
		
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
		
		$isiEmail =	"Terima Kasih, anda telah melakukan Pembelian Tiket Online Kebun Binatang Surabaya. Detail tagihan anda sebagai berikut :";
		$isiEmail .= '<hr>
					<table width="100%"  style="border-collapse: collapse;;border:1px solid #000;">
						
						  <tr>
							<th>No.</th>
							<th>Nama Barang</th>
							<th>Qty</th>
							<th>Harga</th>
							<th>Sub Harga</th>
						</tr>
						';
						$no=1;
						$jumlahHarga=0;
						foreach($this->dataDetail as $showData){
							$isiEmail .= '<tr>
								<td align=center>'. $no.'</td>
								<td>'. $showData->NAMA_BARANG.'</td>
								<td align=center>'. $showData->QTY_BARANG.'</td>
								<td>'.$this->rupiah->to_rupiah($showData->HARGA) .'</td>
								<td>'.$this->rupiah->to_rupiah($showData->TOTAL_HARGA) .'</td>
							</tr>
							';
							$jumlahHarga += $showData->TOTAL_HARGA;
							$no++;
						}
						
						$isiEmail .= '
						<tr>
							<td align=center colspan="4"><b>Total Harga</b></td>
							<td align=center><b>'. $this->rupiah->to_rupiah($jumlahHarga).'</b></td>
						</tr>
					</table><hr>';
					$isiEmail .= 'Total Tagihan anda untuk pemesanan Tiket Kebun Binatang Surabaya sebesar <b>'.$this->rupiah->to_rupiah($jumlahHarga).'</b><br>
				Silahkan Transfer ke Rek berikut : <br><br>
				
				<b>
				BCA (No. Rek: 731 025 2527)<br>
				Mandiri (No. Rek: 0700 000 899 992)<br>
				BNI (No. Rek: 023 827 2088)<br>
				BRI (No. Rek: 034 101 000 743 303)<br>
				</b><br>
				Silahkan lihat kotak masuk di <b>'.$this->session->userdata('email_customer').'</b> untuk selengkapnya.<br>
				Jika telah melakukan Proses Transfer Uang, segera lakukan Proses Konfirmasi Pembayaran di Halaman Daftar Pembelian Tiket Online.';
					
				ini_set("SMTP","ssl://smtp.gmail.com");
				ini_set("smtp_port","465");
			
				$config = Array(  
					'protocol' => 'smtp',  
					'smtp_host' => 'ssl://smtp.googlemail.com',  
					'smtp_port' => 465,  
					'smtp_user' => 'anisamfth@gmail.com',   
					'smtp_pass' => 'akuanisakonkatelapo',   
					'mailtype' => 'html',   
					'charset' => 'utf-8'  ,
					'wordwrap' => TRUE
				);  
				$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
				$this->email->set_header('Content-type', 'text/html');
				$this->load->library('email', $config);  
				$this->email->set_newline("\r\n");  
				$this->email->from('anisamfth@gmail.com', 'Kebun Binatang Surabaya');   
				$this->email->to($this->session->userdata('email_customer'));   
				$this->email->subject('Tagihan Tiket Online Kebun Binatang Surabaya');   
				$this->email->message($isiEmail);  
				if (!$this->email->send()) {  
					$status = array('status' => false , 'pesan' => 'Gagal Kirim Email');
				}
				else{
					$status = array('status' => true);
				}
			
		echo(json_encode($status));	
				
	}
	
}
