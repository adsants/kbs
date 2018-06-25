
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
					<form class="form-horizontal" id="form_tiket">					
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Nama Barang :</label>
							<div class="col-sm-6">
								<select class="form-control required" name="ID_BARANG" >
									<option value="" >Silahkan Pilih</option>
									<?php
									foreach($this->dataBarang as $data){
									?>
									<option <?php if($_SESSION['id_barang'] == $data->ID_BARANG)  echo "selected";?> value="<?php echo $data->ID_BARANG;?>" ><?php echo $data->NAMA_BARANG;?></option>
									
									<?php
									}
									?>
								</select>
							</div>						
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Kartu RFID :</label>
							<div class="col-sm-3">
								<input type="input" class="form-control required number" name="NOMOR_RFID" id="NOMOR_RFID" autofocus>
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

