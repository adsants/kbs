
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
					
					<form class="form-horizontal" id="form_standar">
					<?php
					
					if($this->statusBayar == 'Belum Bayar'){
					?>
						<input type="hidden" value="1" class="form-control number" name="ID_CUSTOMER" id="ID_CUSTOMER" >
						<input type="hidden" value="<?php echo $this->input->get('id_order');?>" class="form-control number" name="ID_ORDER" id="ID_ORDER" >
					
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jenis Tiket :</label>
							<div class="col-sm-6">
								<select class="form-control required" name="ID_BARANG" id="ID_BARANG" onchange="beliUang(this.value)">
									<option value="" >Silahkan Pilih</option>
									<?php
									foreach($this->dataBarang as $data){
									?>
									<option value="<?php echo $data->ID_BARANG;?>" ><?php echo $data->NAMA_BARANG;?></option>
									
									<?php
									}
									?>
								</select>
							</div>
							
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email" id='divJumlah'>Jumlah :</label>
							<div class="col-sm-2">
								<input type="input" class="form-control required number" name="QTY_BARANG" id="QTY_BARANG" >
							</div>
							</div>
						
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
							</div>
						</div>			
						<div class="form-group">        
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php if($this->input->get('id_order')) echo "Tambah Data";  else echo "Simpan";?></button>
								<a href="<?=base_url()."".$this->uri->segment(1);?>">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Batal</span>
								</a>
							</div>
						</div>
					
					<?php
					}
					else{
					?>
						<div class="form-group">        
							<div class=" col-sm-10">
								<a href="<?=base_url()."".$this->uri->segment(1);?>">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Kembali</span>
								</a>
							</div>
						</div>
					<?php
					}
					?>
					</form>
					<form class="form-horizontal" >
					<?php
					if($this->input->get('id_order')){
						if($this->dataOrder->ID_KARTU == ''){
					?>
					<div class="form-group">   
					<div class="col-sm-offset-2 col-sm-10">
						<span onclick="ambil_kartu('<?php echo $this->input->get('id_order'); ?>')" class="btn btn-success btn"><i class="fa fa-credit-card"></i> Ambil Kartu</span>
					</div>
					</div>
					<?php
						}
					}
					?>
					</form>
					<?php
					
					if($this->input->get('id_order')){
					?>
					
					<hr>
					<table class="table table-bordered">
						<thead>
						  <tr>
							<th>No.</th>
							<th>Nama Barang</th>
							<th>Qty</th>
							<th>Harga</th>
							<th>Sub Harga</th>
						</tr>
						</thead>
						<tbody>
						<?php
						$no=1;
						$jumlahHarga=0;
						foreach($this->dataDetail as $showData){
						?>
						<tr>
							<td align=center><?php echo $no; ?>.</td>
							<td><?php echo $showData->NAMA_BARANG; ?></td>
							<td align=center><?php echo $showData->QTY_BARANG; ?></td>
							<td><?php echo $this->rupiah->to_rupiah($showData->HARGA) ; ?></td>
							<td><?php echo $this->rupiah->to_rupiah($showData->TOTAL_HARGA) ; ?></td>
						</tr>
						<?php
						$jumlahHarga += $showData->TOTAL_HARGA;
						$no++;
						}
						?>
						<tr>
							<td align=center colspan='4'><b>Total Harga</b></td>
							<td align=center><b><?php echo $this->rupiah->to_rupiah($jumlahHarga); ?></b></td>
						</tr>
						</tbody>
					</table>
					
					
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- /.content -->



<div class="modal fade" id="modal_ambil_kartu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">
				Silahkan Tempelkan Kartu RFID
			</h4>
		</div>
		<div class="modal-body">					
			<form class="form-horizontal" id="form_ambil_kartu">						
				<div class="form-group">
					<label class="control-label col-sm-4" >Tempelkan Kartu :</label>
					<div class="col-sm-5">
						<input type="hidden" class="form-control " required name="id_order_ambil_kartu" id="id_order_ambil_kartu">
						<input type="input" class="form-control " required name="nomor_rfid" id="nomor_rfid">
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading_login" style="display:none">
						<p id="pesan_error_login" style="display:none" class="text-warning" style="display:none"></p>
					</div>
				</div>			
									
			</form>					
			
		</div>
	</div>
	</div>
</div>
<!-- /.content -->
  
