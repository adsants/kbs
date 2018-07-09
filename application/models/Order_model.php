<?php

class Order_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
			
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		
		
		$this->db->select("t_order.*");									
		$this->db->select('DATE_FORMAT(t_order.tgl_order, "%d-%m-%Y %H:%i") as TGL_ORDER_INDO', FALSE);	
		$this->db->select("m_customer.NAMA_CUSTOMER");			
		$this->db->select("m_kartu.NOMOR_RFID");			
		
		$this->db->join('m_customer', 't_order.id_customer = m_customer.id_customer');	
		$this->db->join('m_kartu', 'm_kartu.id_kartu = t_order.id_kartu' , 'left');	
		
		return $this->db->get("t_order",$limit,$fromLimit)->result();
	}
	
	function showDataDetail($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
			
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		
		
		$this->db->select("t_detail_order.*");									
		$this->db->select('DATE_FORMAT(t_detail_order.TGL_DETAIL_ORDER, "%d-%m-%Y %H:%i") as TGL_DETAIL_ORDER_INDO', FALSE);	
		$this->db->select("m_barang.NAMA_BARANG");			
		
		$this->db->join('m_barang', 't_detail_order.id_barang = m_barang.id_barang');	
		
		return $this->db->get("t_detail_order",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		
		$this->db->join('m_kartu', 'm_kartu.id_kartu = t_order.id_kartu' , 'left');	
		return $this->db->get("t_order",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("t_order")->row();
	}
	function getDataDetail($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("t_detail_order")->row();
	}
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_t_order) as MAX from t_order') ;
		return $query->row();		
	}
	
	function insert($data){
		$this->db->insert('t_order', $data);	
	}
	function insertDetail($data){
		$this->db->insert('t_detail_order', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_order', $data);
	}
	function updateDetail($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_detail_order', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_order');		
	}
}

?>
