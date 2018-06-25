<?php

class T_pakai_kartu_model extends CI_Model {
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
		
		
		
		$this->db->select("t_pakai_kartu.*");									
		$this->db->select('DATE_FORMAT(t_pakai_kartu.tgl_pakai, "%d-%m-%Y %H:%i") as TGL_PAKAI_INDO', FALSE);	
		$this->db->select("m_barang.NAMA_BARANG");			
		
		$this->db->join('m_barang', 'm_barang.id_barang = t_pakai_kartu.id_barang');
		
		return $this->db->get("t_pakai_kartu",$limit,$fromLimit)->result();
	}

	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		return $this->db->get("t_pakai_kartu",$limit,$fromLimit)->num_rows();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("t_pakai_kartu")->row();
	}
	
	
	function getPrimaryKeyMax(){
		$query = $this->db->query('select max(id_t_pakai_kartu) as MAX from t_pakai_kartu') ;
		return $query->row();		
	}
	
	function insert($data){
		$this->db->insert('t_pakai_kartu', $data);	
	}
	function insertDetail($data){
		$this->db->insert('t_detail_order', $data);	
	}
	function update($where,$data){		
		$this->db->where($where);		
		$this->db->update('t_pakai_kartu', $data);
	}
	function delete($where){
		$this->db->where($where);
		$this->db->delete('t_pakai_kartu');		
	}
}

?>
