<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiket_masuk extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		$this->load->model('kartu_model');
		
	} 

	public function index(){		
		redirect('tiket_masuk/add');
	}
	public function add(){		
	
		if($_SESSION['id_kategori_karyawan']=='1'){
			
			$whereBarang ="1=1";
		}
		else{
			$whereBarang ="id_barang = '".$_SESSION['id_barang']."' ";
		}
		$orderBarang ="nama_barang";		
		
		$this->dataBarang = $this->barang_model->showData($whereBarang,"",$orderBarang);
		//var_dump($this->db->last_query());
	
		$this->template_view->load_view('tiket_masuk/tiket_masuk_add_view');
	}
	

	public function add_data(){
		$this->form_validation->set_rules('ID_BARANG', '', 'trim|required');		
		$this->form_validation->set_rules('NOMOR_RFID', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			echo '<div class="alert alert-warning" role="alert">Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.</div>';
		}
		else{					
			$where = array('NOMOR_RFID' => $this->input->post('NOMOR_RFID'));
			$dataKartu = $this->kartu_model->getData($where);
			
			$whereBarang = array('ID_BARANG' => $this->input->post('ID_BARANG'));
			$dataBarang	 = $this->barang_model->getData($whereBarang);
			
			if($dataKartu){				
			
				$where = "ID_KARTU = '".$dataKartu->ID_KARTU."' and  tgl_kartu_kembali is null and status_bayar='Lunas' ";
				$dataKartuOrder = $this->order_model->getData($where);
				
				if($dataKartuOrder){	
					/// cek 
					$queryJumlahDetail =	$this->db->query("
					select 
						QTY_BARANG,ID_DETAIL_ORDER
					from 
						t_detail_order 
					where 
						id_t_order='".$dataKartuOrder->ID_T_ORDER."' and 
						id_barang='".$this->input->post('ID_BARANG')."'
					");
					$dataJumlahDetail = $queryJumlahDetail->row();
					//var_dump($dataJumlahDetail);
					
					
					$queryJumlahTransDetail =	$this->db->query("
					select 
						count(*) as JUMLAH 
					from 
						t_pakai_kartu 
					where 
						ID_DETAIL_ORDER='".$dataJumlahDetail->ID_DETAIL_ORDER."' and 
						id_barang='".$this->input->post('ID_BARANG')."'
					");
					$dataJumlahTransDetail = $queryJumlahTransDetail->row();
					
					//var_dump($dataJumlahTransDetail->JUMLAH);
					//var_dump($dataJumlahDetail->QTY_BARANG);
					
					
					//// jika masih ada kuota sesuai barang
					if($dataJumlahTransDetail->JUMLAH < $dataJumlahDetail->QTY_BARANG){
						$this->db->query("
						insert into t_pakai_kartu 
						(
							ID_BARANG,
							ID_DETAIL_ORDER,
							ID_T_ORDER,
							HARGA
						)
						values
						(
							'".$this->input->post('ID_BARANG')."',
							'".$dataJumlahDetail->ID_DETAIL_ORDER."',
							'".$dataKartuOrder->ID_T_ORDER."',
							'".$dataBarang->HARGA."'					
						)
						");
						
						echo '<div class="alert alert-success" role="alert"><h4>Sukses menggunakan Kuota Tiket !</div>';
					}
					else{
						$queryJumlahTransUang =	$this->db->query("
						select 
							TOTAL_HARGA , ID_DETAIL_ORDER
						from 
							t_detail_order 
						where 
							ID_T_ORDER='".$dataKartuOrder->ID_T_ORDER."'  and 
							id_barang = '1'
						");
						$dataJumlahTransUang = $queryJumlahTransUang->row();
						
						if($dataJumlahTransUang){
							
							
						
						
							if($dataJumlahTransUang){							
								$jumlahUang = $dataJumlahTransUang->TOTAL_HARGA;
							}
							else{
								$jumlahUang =	0;
							}
							
							
							//var_dump($dataJumlahTransUang);
							
							$queryJumlahTransPakaiUang =	$this->db->query("
							select 
								sum(HARGA) As HARGA 
							from 
								t_pakai_kartu 
							where 
								ID_T_ORDER='".$dataKartuOrder->ID_T_ORDER."'  and 
								ID_DETAIL_ORDER = '".$dataJumlahTransUang->ID_DETAIL_ORDER."'
							");
							$dataJumlahTransPakaiUang = $queryJumlahTransPakaiUang->row();
							if($dataJumlahTransPakaiUang->HARGA){							
								$jumlahUangDIpakai = $dataJumlahTransPakaiUang->HARGA;
							}
							else{
								$jumlahUangDIpakai =	0;
							}
							
							
							$jumlahSaldoUangSekarang = $jumlahUang - $jumlahUangDIpakai;
							//var_dump($jumlahUangDIpakai);
							if( $jumlahSaldoUangSekarang >= $dataBarang->HARGA ){
								$this->db->query("
								insert into t_pakai_kartu 
								(
									ID_BARANG,
									ID_DETAIL_ORDER,
									ID_T_ORDER,
									HARGA
								)
								values
								(
									'".$this->input->post('ID_BARANG')."',
									'".$dataJumlahTransUang->ID_DETAIL_ORDER."',
									'".$dataKartuOrder->ID_T_ORDER."',
									'".$dataBarang->HARGA."'					
								)
								");
								
								echo '<div class="alert alert-success" role="alert"><h4>Sukses menggunakan Saldo Uang !</div>';
							}
							else{
								echo '<div class="alert alert-danger" role="alert"><h4>Saldo tidak mencukupi !</div>';
							}
						}
						else{
							echo '<div class="alert alert-danger" role="alert"><h4>Saldo tidak mencukupi !</div>';
						}
						
					}
				
				}
				else{
					echo '<div class="alert alert-danger" role="alert"><h4>Kartu tidak Aktif !</div>';
				}
			}
			else{
				echo '<div class="alert alert-danger" role="alert"><h4>Kartu tidak Terdaftar !</div>';
			}
			
		}
		
	}
	
}
