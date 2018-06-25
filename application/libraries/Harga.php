<?php
class Harga extends CI_Controller {
    protected $_ci;
    
    function __construct(){
        $this->_ci = &get_instance();

    }
	
	
	///// jumlah tagihan wo belummmmmm dikurangi diskon
	function jumlah_harga_barang($id_order){
		
			$queryBarang = $this->_ci->db->query("
			select 
				sum(total_harga) as jumlah
			from
				v_barang_order
			where
				id_order='".$id_order."'
			");						
			$dataBarang = $queryBarang->row();
			
			return $dataBarang->jumlah;			
    }
	
	
	///// jumlah tagihan wo sudah dikurangi diskon
	function jumlah_tagihan_wo($id_order){
		
		$queryBarang = $this->_ci->db->query("
		select 
			sum(total_harga) as jumlah
		from
			v_barang_order
		where
			id_order='".$id_order."'
		");						
		$dataBarang = $queryBarang->row();
		
		
		$queryOrder = $this->_ci->db->query("
		select 
			discount
		from
			t_order
		where
			id_order='".$id_order."'
		");						
		$dataOrder = $queryOrder->row();		
		
		$jumlah =  $dataBarang->jumlah - $dataOrder->discount ;		
		if($jumlah < 0){
			$jumlah = 0;
		}
		return $jumlah;			
	}
	
	
	///// jumlah pembayaran customer
	function jumlah_bayar($id_order){
		
		$queryBayar = $this->_ci->db->query("
		select 
			sum(jumlah_kas) as jumlah
		from
			v_bayar
		where
			id_order='".$id_order."'
		");						
		$dataBayar = $queryBayar->row();			
			
		return $dataBayar->jumlah;			
    }
	function cekJumlahBayar($id_order){
		
		
		
		$queryBayar = $this->_ci->db->query("
		select 
			count(*) as jumlah
		from
			v_bayar
		where
			id_order='".$id_order."'
		");						
		$dataBayar = $queryBayar->row();	

	
			return $dataBayar->jumlah;
	
						
    }
	function jumlah_kurang_bayar($id_order){
		
		
		
		$queryBayar = $this->_ci->db->query("
		select 
			sum(jumlah_kas) as jumlah
		from
			v_bayar
		where
			id_order='".$id_order."'
		");						
		$dataBayar = $queryBayar->row();	

		
		$queryBarang = $this->_ci->db->query("
		select 
			sum(total_harga) as jumlah
		from
			v_barang_order
		where
			id_order='".$id_order."'
		");						
		$dataBarang = $queryBarang->row();
		
		
		$queryOrder = $this->_ci->db->query("
		select 
			discount
		from
			t_order
		where
			id_order='".$id_order."'
		");						
		$dataOrder = $queryOrder->row();		
		
		$jumlah =  $dataBarang->jumlah - $dataOrder->discount ;			

		$jumlahKurang = $jumlah - $dataBayar->jumlah;
		
		if($jumlahKurang < 0){
			$jumlahKurang = 0;
		}
			
		return $jumlahKurang;			
    }
	
	function jumlah_lebih_bayar($id_order){
		
		
		
		$queryBayar = $this->_ci->db->query("
		select 
			sum(jumlah_kas) as jumlah
		from
			v_bayar
		where
			id_order='".$id_order."'
		");						
		$dataBayar = $queryBayar->row();	

		
		$queryBarang = $this->_ci->db->query("
		select 
			sum(total_harga) as jumlah
		from
			v_barang_order
		where
			id_order='".$id_order."'
		");						
		$dataBarang = $queryBarang->row();
		
		
		$queryOrder = $this->_ci->db->query("
		select 
			discount
		from
			t_order
		where
			id_order='".$id_order."'
		");						
		$dataOrder = $queryOrder->row();		
		
	//	echo "jumlah barang : ".$dataBarang->jumlah."<br>";
	//	echo "jumlah bayar : ".$dataBayar->jumlah."<br>";
	//	echo "jumlah discount : ".$dataOrder->discount."<br>";
		
		$jumlah =  $dataBarang->jumlah - $dataOrder->discount ;	

		if($jumlah < 0){
			$jumlah =	 0;
		}
		
	//echo "jumlah bayar : ".$jumlah."<br>";
		$jumlahLebih = $dataBayar->jumlah - $jumlah  ;
	//echo "jumlah lebih : ".$jumlahLebih."<br>";
		if($jumlahLebih < 0){
			$jumlahLebih = 0;
		}
		return $jumlahLebih;			
    }
	
	
	function status_lunas($id_order){
		
		$queryJumlahBayar = $this->_ci->db->query("
		select 
			count(*) as jumlah
		from
			t_bayar_order
		where
			id_order='".$id_order."'
		");						
		$dataJumlahBayar = $queryJumlahBayar->row();
		
		if($dataJumlahBayar->jumlah == 0){
			return "BB";
		}
		else{
		
			$queryBayar = $this->_ci->db->query("
			select 
				sum(jumlah_kas) as jumlah
			from
				v_bayar
			where
				id_order='".$id_order."'
			");						
			$dataBayar = $queryBayar->row();	

			
			$queryBarang = $this->_ci->db->query("
			select 
				sum(total_harga) as jumlah
			from
				v_barang_order
			where
				id_order='".$id_order."'
			");						
			$dataBarang = $queryBarang->row();
			
			
			$queryOrder = $this->_ci->db->query("
			select 
				discount
			from
				t_order
			where
				id_order='".$id_order."'
			");						
			$dataOrder = $queryOrder->row();		
			
			$jumlahTagihan =  $dataBarang->jumlah - $dataOrder->discount ;	
			
			if($jumlahTagihan <= $dataBayar->jumlah){
				return "L";
			}
			else{
				return "BL";
			}
		}
						
    }
	
	function laporan_kas($idTutupKas){
	
		$idMulai = $idTutupKas - 1;
		$queryCekMulai = $this->_ci->db->query("
		select
			tgl_tutup_kas
		from
			t_tutup_kas
		where
			t_tutup_kas.id_tutup_kas='".$idMulai."'
		");
		$dataCekMulai = $queryCekMulai ->row();
		
		if($dataCekMulai){
			$tglMulai = $dataCekMulai->tgl_tutup_kas;
		}
		else{
			$tglMulai = "2018-01-01 01:01:01";
		}
		
		$queryCekAkhir = $this->_ci->db->query("
		select
			tgl_tutup_kas
		from
			t_tutup_kas
		where
			t_tutup_kas.id_tutup_kas='".$idTutupKas."'
		");
		$dataCekMulaiAkhir = $queryCekAkhir ->row();
		
		$queryCancelBarang	= $this->_ci->db->query("select sum(TOTAL_HARGA) as JUMLAH from v_barang_order_cancel where tgl_cancel between  '".$tglMulai."'  and   '".$dataCekMulaiAkhir->tgl_tutup_kas."' and status_bayar_cancel='L'");	
		
		//echo $this->_ci->db->last_query();
		$this->DataCancelBarang = $queryCancelBarang->row();
		
		if($this->DataCancelBarang){
			$jumlahCancel = $this->DataCancelBarang->JUMLAH;
		}
		else{
			$jumlahCancel = 0;
		}		
		
		$queryCekTutupKas 	= $this->_ci->db->query("select * from t_tutup_kas where id_tutup_kas='".$idTutupKas."'");
		$this->dataTutupKas = $queryCekTutupKas->row();
		
		$awal 	= $this->dataTutupKas->ID_T_BAYAR_ORDER_MULAI;
		$akhir 	= $this->dataTutupKas->ID_T_BAYAR_ORDER_AKHIR;
		
		
		$queryJumlahKas 		=$this->_ci->db->query("select sum(JUMLAH_KAS) as JUM from v_bayar where  id_t_bayar_order BETWEEN   '".$awal."'  and '".$akhir."' ");
		

		$this->dataJumlahKas 	= $queryJumlahKas->row();
		
		$hasil	=	$this->dataJumlahKas->JUM - $jumlahCancel;
		return  $hasil;
    }

}
