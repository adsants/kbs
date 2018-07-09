<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Konfirmasi extends CI_Controller {
		
	public function __construct() {
		parent::__construct();
		
		$this->load->model('order_model');
		$this->load->model('barang_model');
		$this->load->model('kartu_model');
		$this->load->model('m_customer_model');
		
	} 

	public function index(){		
		$like 		= null;
		$order_by 	= 't_order.ID_T_ORDER desc'; 
		$urlSearch 	= null;
		$where		= "t_order.id_customer != '1' and t_order.status_bayar='Sudah Konfirmasi Bayar'";
		if($this->input->get('field')){
			$like = array($_GET['field'] => $_GET['keyword']);
			$urlSearch = "?field=".$_GET['field']."&keyword=".$_GET['keyword'];
		}		
		
		$this->load->library('pagination');	
		
		$config['base_url'] 	= base_url().''.$this->uri->segment(1).'/index'.$urlSearch;
		$this->jumlahData 		= $this->order_model->getCount("",$like);		
		$config['total_rows'] 	= $this->jumlahData;		
		$config['per_page'] 	= 10;	
		$this->pagination->initialize($config);	
		$this->showData = $this->order_model->showData($where,$like,$order_by,$config['per_page'],$this->input->get('per_page'));
		$this->pagination->initialize($config);
		
		$this->template_view->load_view('konfirmasi/konfirmasi_view');
	}
	public function add_data(){
		$this->form_validation->set_rules('id_order', '', 'trim|required');		
		
		if ($this->form_validation->run() == FALSE)	{
			$status = array('status' => FALSE, 'pesan' => 'Gagal menyimpan Data, pastikan telah mengisi semua inputan yang diwajibkan untuk diisi.', 'message' => validation_errors());
		}
		else{								
		
			$data = array(			
				'STATUS_BAYAR' => 'Lunas',			
			);
			$where = array('ID_T_ORDER' => $this->input->post('id_order'));
			$query = $this->order_model->update($where,$data);					
			$status = array('status' => true , 'redirect_link' => base_url()."".$this->uri->segment(1));
		}
		
		echo(json_encode($status));
	}
	public function send_email(){
		
		
		$where = array('id_t_order' => $this->input->get('id_order'));
		$this->dataOrder = $this->order_model->getData($where);
		
		$where2 = array('id_customer' => $this->dataOrder->ID_CUSTOMER);
		$this->dataCustomer = $this->m_customer_model->getData($where2);
		
		$isiEmail =	"Terima kasih ".$this->dataCustomer->NAMA_CUSTOMER.", pembayaran anda telah kami terima. <br>Silahkan anda berkunjung ke Kebun Binatang Surabaya dengan mengambil Kartu RFID.<br> Mohon tunjukkan Nomor Order : <b>".$this->dataOrder->NO_ORDER."</b> kepada Petugas pengambilan kartu RFID." ;
					
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
				$this->email->to($this->dataCustomer->EMAIL_CUSTOMER);   
				$this->email->subject('Pemberitahuan Status Bayar Tiket Online Kebun Binatang Surabaya');   
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
