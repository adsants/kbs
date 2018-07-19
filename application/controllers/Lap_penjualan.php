<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_penjualan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		
	} 

	public function index(){			
		
		
			$this->load->library('rupiah');
		
		if($this->input->get('tgl')){
			$where = "t_order.tgl_order like '".$this->input->get('tgl')."%'";
			$order= "id_t_order";
			$dataLaporan = $this->order_model->showData($where,"",$order);
			//echo $this->db->last_query();
			$this->tableLaporan = "
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th width='5%'>No.</th>
						<th>No Order</th>
						<th>Customer</th>
						<th>Tanggal Order</th>
						<th>Jumlah Uang</th>
						<th>Uang Kembali</th>
						<th>Total Pembelian</th>
					  </tr>
					</thead>
					
					<tbody>";
					
					
					$i=1;
					
					$totalPakai=0;
					$totalUang=0;
					$jumlahJualSehari = 0;
					foreach($dataLaporan as $data){
						//var_dump($data);
						
						$queryJumlah =	$this->db->query("select sum(TOTAL_HARGA) as TOTAL_HARGA from t_detail_order where id_t_order = '".$data->ID_T_ORDER."'");
						$dataJumlah	=	$queryJumlah->row();
						
						$jumlahJual	=	$dataJumlah->TOTAL_HARGA - $data->UANG_KEMBALI;
						
						$this->tableLaporan .= " <tr>
						<td align=center>".$i.".</td>
						<td>".$data->NO_ORDER."</td>
						<td>".$data->NAMA_CUSTOMER."</td>
						<td>".$data->TGL_ORDER_INDO."</td>
						<td>".$this->rupiah->to_rupiah($dataJumlah->TOTAL_HARGA)."</td>
						<td>".$this->rupiah->to_rupiah($data->UANG_KEMBALI)."</td>
						<td>".$this->rupiah->to_rupiah($jumlahJual)."</td>
						
						
						</tr>";
			
					
					$i++;
					$jumlahJualSehari += $jumlahJual;
					}
					
				$this->tableLaporan .= "
					<tr>
						<td align='right' colspan='6'><b>Total Penjualan</b></td>
						<td align='center'><b>".$this->rupiah->to_rupiah($jumlahJualSehari)."</b></td>
					</tr>
				</tbody>
				</table>
			";
		}
		
		$this->template_view->load_view('laporan/lap_penjualan_view');
		
	}
	public function tiket(){			
		
		
		$this->load->library('rupiah');
		
		if($this->input->get('tgl')){
			$order= "NAMA_BARANG";
			$where = "id_barang !='1'";
			$dataLaporan = $this->barang_model->showData($where,"",$order);
			//echo $this->db->last_query();
			$this->tableLaporan = "
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th width='5%'>No.</th>
						<th>Jenis Tiket</th>
						<th>Jumlah Tiket</th>
						<th>Jumlah Uang</th>
					  </tr>
					</thead>
					
					<tbody>";
					
					
					$i=1;
					
					foreach($dataLaporan as $data){
						//var_dump($data);
						
						$queryJumlah =	$this->db->query("
						select 
							count(*) as TOTAL 
						from 
							t_pakai_kartu 
						where 
							id_t_order in (
											select 
												id_t_order 
											from 
												t_order 
											where 
												t_order.tgl_order like '".$this->input->get('tgl')."%'
											)
							and id_barang = '".$data->ID_BARANG."'
							
							");
						$dataJumlah	=	$queryJumlah->row();
						
						
						
						$queryJumlahUang =	$this->db->query("
						select 
							sum(HARGA) as TOTAL 
						from 
							t_pakai_kartu 
						where 
							id_t_order in (
											select 
												id_t_order 
											from 
												t_order 
											where 
												t_order.tgl_order like '".$this->input->get('tgl')."%'
											)
							and id_barang = '".$data->ID_BARANG."'
							
							");
						$dataJumlahUang	=	$queryJumlahUang->row();
						
						$this->tableLaporan .= " <tr>
						<td align=center>".$i.".</td>
						<td>".$data->NAMA_BARANG."</td>
						<td>".$dataJumlah->TOTAL."</td>
						<td>".$this->rupiah->to_rupiah($dataJumlahUang->TOTAL)."</td>
						
						
						
						
						</tr>";
			
					
					$i++;
					}
					
				$this->tableLaporan .= "
				
				</tbody>
				</table>
			";
		}
		
		$this->template_view->load_view('laporan/lap_penjualan_tiket_view');
		
	}
	
}
