
<!-- Content Header (Page header) -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">		
				<div class="box-header">
					<h4><?php echo $this->template_view->nama_menu('nama_menu'); ?></h4>
					<h5><?php echo $this->template_view->nama_menu('judul_menu'); ?></h5>
					<hr>			
				</div>
				<div class="box-body">
					
					<input id="id_t_order" type="hidden">
					<form class="form-horizontal" id="form_kartu_kembali">					
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Kartu RFID :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required number" name="NOMOR_RFID" id="NOMOR_RFID" autofocus>								
								<input type="hidden" name="UANG_KEMBALI" id="UANG_KEMBALI">
							</div>
							
							<div class="col-sm-3">
								<span class="btn btn-success" onclick="showModalTerimaKartu()" id="btnTerimaKartu" style="display:none"> Terima Kartu</span>
							</div>		
							<div class="col-sm-4">
								<span class="btn btn-warning" onclick="link_tambah_beli()" id="btnLinkTambahBeli" style="display:none"> Top Up Uang</span>
							</div>	
						</div>						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
							</div>
						</div>			
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-10" id="pesanTiketMasuk">
								
							</div>
						</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->

<div class="modal fade" id="modal_terima_kartu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4>
			</div>
			<div class="modal-body">
				Pengembalian Uang sebesar
				<span id="divUangKembali"></span>
			</div>
			
			<div class="modal-footer">
				<div class="pull-left">
					<button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
				</div>
				
				<button type="button" class="btn btn-primary" onclick="terima_kartu()">Terima kartu</button>
			</div>
			
	</div>
	</div>
</div>
