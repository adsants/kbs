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
		
		echo(json_encode($status));
	}
	
	
	public function send_email(){
		
		$config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 465, //465,
        'smtp_user' => 'mail.adisantoso@gmail.com',
        'smtp_pass' => 'anakganteng',
        'smtp_crypto' => 'tls',
        'smtp_timeout' => '20',
        'mailtype'  => 'html', 
        'charset'   => 'iso-8859-1'
    );
    $config['newline'] = "\r\n";
    $config['crlf'] = "\r\n";
    $this->load->library('email', $config);
    $this->email->from('myself@gmx.com', 'Admin');
    $this->email->to('anisamfth@gmail.com');
    $this->email->subject('AKu Cinta Kamu');
    $this->email->message('AKu Cinta Kamu');

    //$this->email->send();
    if ( ! $this->email->send()) {
        return false;
    }
    return true;
	}
	
	
}
