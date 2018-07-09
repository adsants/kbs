<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registrasi extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();
		
		$this->load->model('m_customer_model');
		
	} 

	public function add_data(){
		$this->form_validation->set_rules('NAMA_CUSTOMER', '', 'trim|required');		
		$this->form_validation->set_rules('EMAIL_CUSTOMER', '', 'trim|required');	
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{		
		
			$whereEmail = array('EMAIL_CUSTOMER' => $this->input->post('EMAIL_CUSTOMER'));
			$this->cekEmail = $this->m_customer_model->getData($whereEmail);
			
			$whereHp = array('HP_CUSTOMER' => $this->input->post('HP_CUSTOMER'));
			$this->cekHp = $this->m_customer_model->getData($whereHp);
			
			if($this->cekEmail){
				$status = array('status' => false , 'pesan' => 'eMail telah terdaftar, silahkan cek email Anda untuk melihat Password.');
			}
			elseif($this->cekHp){
				$status = array('status' => false , 'pesan' => 'Nomor Handphone telah terdaftar, silahkan cek email Anda untuk melihat Password.');
			}
			else{
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
				$this->email->to($this->input->post('EMAIL_CUSTOMER'));   
				$this->email->subject('Registrasi User Kebun Binatang Surabaya');   
				$this->email->message('Terima kasih <b>'.$this->input->post('NAMA_CUSTOMER').'</b> Anda telah terdaftar sebagai User di Sistem Informasi Pembelian Tiket Online Kebun Binatang Surabaya.<br>Sebagai Pengingat anda bahwa password anda adalah sebagai berikut : <br><br> Password : <b>'.$this->input->post('PASSWORD').'</b><br><br><br><hr><sup>Kebun Binatang Surabaya</sup>');  
				if (!$this->email->send()) {  
					$status = array('status' => false , 'pesan' => 'Gagal Kirim eMail', 'warning' => show_error($this->email->print_debugger()));
				}else{  
					  
					$maxIDbarang = $this->m_customer_model->getPrimaryKeyMax();
					$newId = $maxIDbarang->MAX + 1;			
					
						$data = array(					
							'ID_CUSTOMER' => $newId,			
							'NAMA_CUSTOMER' => $this->input->post('NAMA_CUSTOMER'),			
							'ALAMAT_CUSTOMER' => $this->input->post('ALAMAT_CUSTOMER'),			
							'EMAIL_CUSTOMER' => $this->input->post('EMAIL_CUSTOMER'),			
							'HP_CUSTOMER' => $this->input->post('HP_CUSTOMER'),			
							'PASSWORD' => $this->input->post('PASSWORD'),
							'AKTIF'	=> 'Y'
						);
						$query = $this->m_customer_model->insert($data);	
						
				
						$status = array('status' => true , 'redirect_link' => base_url()."front/login" , 'pesan' => 'Proses Registrasi sukses, silahkan Login dengan eMail dan Password yang telah anda Inputkan.');
				}
			}
		}
		
		echo(json_encode($status));
	}
	
	public function send()  
	{  
		
	}  
	
	
}
