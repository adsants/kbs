<?php

class User_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_karyawan.*");		
		$this->db->select("m_kategori_user.NAMA_KATEGORI_USER");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_kategori_user', 'm_kategori_user.id_kategori_user = m_karyawan.id_kategori_user');
		return $this->db->get("m_karyawan",$limit,$fromLimit)->result();
	}
	
	function getCount($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}
		$this->db->join('m_kategori_user', 'm_kategori_user.id_kategori_user = m_karyawan.id_kategori_user');
		return $this->db->get("m_karyawan",$limit,$fromLimit)->num_rows();
	}
	

}

?>
