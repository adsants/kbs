<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_bulan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		
	} 

	public function index(){			
		
		
			$this->load->library('rupiah');
			
			
			
		
		if($this->input->get('tgl')){
			
			
			
			$this->tableLaporan = "
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th>Tanggal</th>
						<th>Jumlah Uang</th>
					  </tr>
					</thead>
					
					<tbody>";
					
					
					$start = $this->input->get('tgl')."-01";

					$date = new DateTime($start);
					$date->modify('last day of this month');
					$end = $date->format('Y-m-d');

				

					$date = $start ;
					$end_date = $end;
					$jumlahSebulan = 0;

					while (strtotime($date) <= strtotime($end_date)) {
						//echo "$date\n";
						
						//echo date ("d-m-Y", strtotime($date));
						
						
						$queryJumlah =	$this->db->query("
							select sum(TOTAL_HARGA) - (select sum(UANG_KEMBALI) from t_order where t_order.tgl_order like '".$date."%') as TOTAL_HARGA 
							from 
								t_detail_order 
							where 
								id_t_order in ( select id_t_order from t_order where t_order.tgl_order like '".$date."%')
							 ");
						$dataJumlah	=	$queryJumlah->row();
						//echo $this->db->last_query();
						
						$queryJumlahKembali =	$this->db->query("select sum(UANG_KEMBALI) as UANG_KEMBALI from t_order where t_order.tgl_order like '".$date."%'");
						$dataJumlahKembali	=	$queryJumlahKembali->row();
						
						$jumlahTotal = $dataJumlah->TOTAL_HARGA - $dataJumlahKembali->UANG_KEMBALI;
						
						$this->tableLaporan .= "
						<tr>
							<td align='center'>".date ("d-m-Y", strtotime($date))."</td>
							<td align='center'>".$this->rupiah->to_rupiah($jumlahTotal)."</td>
						</tr> ";
						
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						
						$jumlahSebulan += $jumlahTotal;
					}
					
				$this->tableLaporan .= "
					<tr>
						<td align='right'><b>Total Penjualan</b></td>
						<td align='center'><b>".$this->rupiah->to_rupiah($jumlahSebulan)."</b></td>
					</tr>
				</tbody>
				</table>
			";
		}
		
		$this->template_view->load_view('laporan/lap_bulan_view');
		
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
						//$this->tableLaporan .= $this->db->last_query();
						
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
		
		$this->template_view->load_view('laporan/lap_bulan_tiket_view');
		
	}
	
}
