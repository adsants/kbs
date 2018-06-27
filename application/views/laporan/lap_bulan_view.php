<?php



?>
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
					<form class="form-horizontal" id="" method="get">					
						
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Bulan :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control "  id="datepickerBulan"  data-date-format='mm-yyyy' required name="tgl" value="<?=$this->input->get('tgl');?>">								
							</div>				
						</div>	
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary"><i class="fa fa-eye"></i> Lihat Laporan</button>
								<a href="<?=base_url()."".$this->uri->segment(1);?>">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Batal</span>
								</a>
							</div>
						</div>
					</form>
					
					<?php
					if($this->input->get('tgl')){
					?>
					<hr>
					<ul class="nav nav-tabs">
						  <li class="active"><a href="#">Uang</a></li>
						  <li><a href="<?=base_url();?>lap_bulan/tiket?tgl=<?php echo $this->input->get('tgl');?>">Jenis Tiket</a></li>
					</ul>
					<br>
					<?php
					echo $this->tableLaporan;
					}
					?>
					
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
