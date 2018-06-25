<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kembali_kartu extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		$this->load->model('kartu_model');
		
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
				
				$where		=	array('ID_T_ORDER' =>	$dataCekOrder->ID_T_ORDER );
				$dataCek 	=	$this->order_model->showDataDetail($where);
				
				echo " 
				<table class='table table-bordered'>
					<thead>
					  <tr>
						<th width='15%'>No.</th>
						<th></th>
					  </tr>
					</thead>
					
					<tbody>";
					$i=1;
					foreach($dataCek  as $data){
						//var_dump($data);
						
						echo "<tr>
						<td>".$i."</td>
						<td>".$data->NAMA_BARANG."</td>
						<td>".$data->QTY_BARANG."</td>
						<td>".$this->rupiah->to_rupiah($data->HARGA)."</td>
						<td>".$this->rupiah->to_rupiah($data->TOTAL_HARGA)."</td>
						
						
						</tr>";
					$i++;
					}
					
				echo "
					</tbody>
				</table>
				";
			}	
			else{
				echo 'Kartu Tidak Aktif !';
			}
		}
		else{
			
			echo 'Kartu Tidak Aktif !';
		}
		
	}
	
	public function ssadd_data(){		
		$where		=	array('NOMOR_RFID' =>	$this->input->post('NOMOR_RFID'));
		$dataCek 	=	$this->kartu_model->getData($where);
		//$dataCek	=	$queryCek->row();
		
		if($dataCek){
			$whereOrder		=	"ID_KARTU  = '".$dataCek->ID_KARTU."' and status_bayar='Lunas' and tgl_kartu_kembali is null ";
			$dataCekOrder 	=	$this->order_model->getData($whereOrder);
			
			if($dataCekOrder){
				$this->db->query("update t_order set tgl_kartu_kembali=now() where id_t_order = '".$dataCekOrder
				."'");
				
				$status = array('status' => true );
			}
			else{
				$status = array('status' => false , 'pesan' => 'Kartu sudah dikembalikan !' );
			}
		}
		else{
			
			$status = array('status' => false , 'pesan' => 'Kartu Tidak Aktif !' );
		}
		
		echo(json_encode($status));
	}
}
