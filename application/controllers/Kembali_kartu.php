<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kembali_kartu extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		$this->load->model('kartu_model');
		$this->load->model('t_pakai_kartu_model');
		
	} 

	public function index(){		
		redirect("kembali_kartu/add");
	}
	
	public function add(){		
		$this->template_view->load_view('kembali_kartu/kembali_kartu_view');
	}
	public function add_data(){		
		$where		=	array('NOMOR_RFID' =>	$this->input->post('NOMOR_RFID'));
		$dataCek 	=	$this->kartu_model->getData($where);
		//$dataCek	=	$queryCek->row();
		
		if($dataCek){
			$whereOrder		=	"ID_KARTU  = '".$dataCek->ID_KARTU."' and status_bayar='Lunas' and tgl_kartu_kembali is null ";
			$dataCekOrder 	=	$this->order_model->getData($whereOrder);
			
			if($dataCekOrder){
				
				$this->load->library('rupiah');
				
				
				
				echo " 
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th width='5%'>No.</th>
						<th>Jenis Tiket</th>
						<th>Jumlah</th>
						<th>Harga</th>
						<th>Harga Total</th>
					  </tr>
					</thead>
					
					<tbody>";
					
					
					$where		=	array('ID_T_ORDER' =>	$dataCekOrder->ID_T_ORDER );
					$dataCek 	=	$this->order_model->showDataDetail($where);
					$i=1;
					
					$totalPakai=0;
					$totalUang=0;
					foreach($dataCek  as $data){
						//var_dump($data);
						
						echo "<tr style='background:#ecf0f5'>
						<td align=center>".$i.".</td>
						<td>".$data->NAMA_BARANG."</td>
						<td>".$data->QTY_BARANG."</td>
						<td>".$this->rupiah->to_rupiah($data->HARGA)."</td>
						<td >".$this->rupiah->to_rupiah($data->TOTAL_HARGA)."</td>
						
						
						</tr>";
						
						
						$wherePakai		=	array('ID_DETAIL_ORDER' =>	$data->ID_DETAIL_ORDER );
						$dataPakai 	=	$this->t_pakai_kartu_model->showData($wherePakai);
						
						$jumlahPakai = 0;
						foreach($dataPakai as $data_pakai){
							echo "<tr>
								<td align=center></td>
								<td colspan='2'>dipakai Untuk <b>".$data_pakai->NAMA_BARANG."</b></td>
								<td align=center>".$data_pakai->TGL_PAKAI_INDO."</td>
								<td align='right'>".$this->rupiah->to_rupiah($data_pakai->HARGA)."</td>
								<tr>
							";
							
							$jumlahPakai += $data_pakai->HARGA;
						}
						
							
							echo "<tr>
								<td align=center></td>
								<td align=center  colspan='3'>Jumlah Harga Pakai</td>
								<td>".$this->rupiah->to_rupiah($jumlahPakai)."</td>
								<tr>
							";
						
						$totalPakai += $jumlahPakai;
						$totalUang 	+= $data->TOTAL_HARGA;
					$i++;
					}
					
					$jumlahKembali	=	$totalUang - $totalPakai;
				echo "<tr>
						<td colspan='5'>&nbsp;</td>
						<tr>
					";
				echo "<tr>
						<td align=center></td>
						<td align=right  colspan='3'>Total Uang</td>
						<td>".$this->rupiah->to_rupiah($totalUang)."</td>
						<tr>
					";
				echo "<tr>
						<td align=center></td>
						<td align=right  colspan='3'>Total Harga Pakai</td>
						<td>".$this->rupiah->to_rupiah($totalPakai)."</td>
						<tr>
					";
				echo "<tr>
						<td align=center></td>
						<td align=right  colspan='3'><b>Total Uang Kembali</b></td>
						<td><b>".$this->rupiah->to_rupiah($jumlahKembali)."</b></td>
						<tr>
					";
					
				echo "
					</tbody>
				</table>
				";
			}	
			else{
				echo '<div class="alert alert-warning" role="alert">Kartu sudah dikembalikan !</div>';
			}
		}
		else{
			
			echo '<div class="alert alert-warning" role="alert">Kartu Tidak Aktif !</div>';
		}
		
	}
	
	public function uang_kembali(){
		$where		=	array('NOMOR_RFID' =>	$this->input->post('NOMOR_RFID'));
		$dataCek 	=	$this->kartu_model->getData($where);
		//$dataCek	=	$queryCek->row();
		
		if($dataCek){
			$whereOrder		=	"ID_KARTU  = '".$dataCek->ID_KARTU."' and status_bayar='Lunas' and tgl_kartu_kembali is null ";
			$dataCekOrder 	=	$this->order_model->getData($whereOrder);
			
			if($dataCekOrder){
				
				$this->load->library('rupiah');
				
					$where		=	array('ID_T_ORDER' =>	$dataCekOrder->ID_T_ORDER );
					$dataCek 	=	$this->order_model->showDataDetail($where);
					$i=1;
					
					$totalPakai=0;
					$totalUang=0;
					foreach($dataCek  as $data){
						
						$wherePakai		=	array('ID_DETAIL_ORDER' =>	$data->ID_DETAIL_ORDER );
						$dataPakai 	=	$this->t_pakai_kartu_model->showData($wherePakai);
						
						$jumlahPakai = 0;
						foreach($dataPakai as $data_pakai){
							
							
							$jumlahPakai += $data_pakai->HARGA;
						}
						
						$totalPakai += $jumlahPakai;
						$totalUang 	+= $data->TOTAL_HARGA;
					$i++;
					}
					
					$jumlahKembali	=	$totalUang - $totalPakai;
					
					
				$status = array('status' => true , 'uang_kembali' => $jumlahKembali,'id_order' => $dataCekOrder->ID_T_ORDER );	
			}		
			else{
				$status = array('status' => false , 'pesan' => '<div class="alert alert-warning" role="alert">Kartu sudah dikembalikan !</div>');	
			}
		}
		else{
			
			$status = array('status' => false , 'pesan' => '<div class="alert alert-warning" role="alert">Kartu Tidak Aktif !</div>');	
			
		}
		
		echo(json_encode($status));
	}
	
	public function kartu_kembali(){		
		$where		=	array('NOMOR_RFID' =>	$this->input->post('NOMOR_RFID'));
		$dataCek 	=	$this->kartu_model->getData($where);
		//$dataCek	=	$queryCek->row();
		
		if($dataCek){
			$whereOrder		=	"ID_KARTU  = '".$dataCek->ID_KARTU."' and status_bayar='Lunas' and tgl_kartu_kembali is null ";
			$dataCekOrder 	=	$this->order_model->getData($whereOrder);
			
			if($dataCekOrder){
				$this->db->query("
				update 
					t_order set tgl_kartu_kembali=now(),
					UANG_KEMBALI = '".$this->input->post('UANG_KEMBALI')."' 
				where 
					id_t_order = '".$dataCekOrder->ID_T_ORDER."'
				");
				
				//echo $this->db->last_query();
				
				$status = array('status' => true );
			}
			else{
				$status = array('status' => false , 'pesan' => '<div class="alert alert-warning" role="alert">Kartu sudah dikembalikan !</div>' );
			}
		}
		else{
			
			$status = array('status' => false , 'pesan' => '<div class="alert alert-warning" role="alert">Kartu Tidak Aktif !</div>' );
		}
		
		echo(json_encode($status));
	}
}
