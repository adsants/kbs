<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lap_penjualan extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		
	} 

	public function index(){			
		
		
			$this->load->library('rupiah');
		
		if($this->input->get('mulai')){
			$where = "(t_order.tgl_order BETWEEN '".$this->input->get('mulai')."' AND '".$this->input->get('akhir')."')";
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
						<th>Jumlah Tagihan</th>
						<th>Status Bayar</th>
					  </tr>
					</thead>
					
					<tbody>";
					
					
					$i=1;
					
					$totalPakai=0;
					$totalUang=0;
					
					foreach($dataLaporan as $data){
						//var_dump($data);
						
						$queryJumlah =	$this->db->query("select sum(TOTAL_HARGA) as TOTAL_HARGA from t_detail_order where id_t_order = '".$data->ID_T_ORDER."'");
						$dataJumlah	=	$queryJumlah->row();
						
						$this->tableLaporan .= " <tr>
						<td align=center>".$i.".</td>
						<td>".$data->NO_ORDER."</td>
						<td>".$data->NAMA_CUSTOMER."</td>
						<td>".$data->TGL_ORDER_INDO."</td>
						<td>".$this->rupiah->to_rupiah($dataJumlah->TOTAL_HARGA)."</td>
						<td >".$data->STATUS_BAYAR."</td>
						
						
						</tr>";
			
					
					$i++;
				
					}
			$this->tableLaporan .= "
				</tbody>
				</table>
			";
		}
		
		$this->template_view->load_view('laporan/lap_penjualan_view');
		
	}
	
	
}
