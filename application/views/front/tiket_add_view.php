
<!--header-->
<!--welcome-->
<div class="container" style="margin-top:10px">

	<div class="col-sm-12">


		<div class="panel panel-success">
			<div class="panel-heading">Pembelian Tiket Online</div>
			<div class="panel-body">
			
			
				<?php
				if($this->input->get('id_order')){
					if($this->dataOrder->STATUS_BAYAR== 'Belum Bayar'){
				?>

				<form class="form-horizontal" id="form_tiket" >
					<input type="hidden" value="<?php echo $this->input->get('id_order');?>" class="form-control number" name="ID_ORDER" id="ID_ORDER" >
					<input type="hidden" value="<?php echo $_SESSION['id_customer'];?>" class="form-control number" name="ID_CUSTOMER" id="ID_CUSTOMER" >
					
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jenis Tiket :</label>
							<div class="col-sm-6">
								<select class="form-control required" onchange="cek_harga_tiket(this.value)" name="ID_BARANG" >
									<option value="" >Silahkan Pilih</option>
									<?php
									foreach($this->dataBarang as $data){
									?>
									<option value="<?php echo $data->ID_BARANG;?>" ><?php echo $data->NAMA_BARANG;?> <?php ?></option>
									
									<?php
									}
									?>
								</select>
							</div>
							
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email"></label>
							<div class="col-sm-3" id="divHarga">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email" id="labelHarga">Jumlah (Qty) :</label>
							<div class="col-sm-3">
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
							<div class="col-sm-offset-2 col-sm-6">
								<button type="submit" class="btn btn-success"><i class="fa fa-<?php	if($this->input->get('id_order')){ echo "plus" ;} else {echo "save";}?>"></i> <?php	if($this->input->get('id_order')){ echo "Tambah" ;} else {echo "Simpan";}?> </button>
								<a href="<?=base_url();?>front/tiket">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Batal</span>
								</a>
							</div>
							
							<?php
							if($this->input->get('id_order')){
								if($this->dataOrder->ID_KARTU == ''){
							?>
							<div class="col-sm-4">
								<span onclick="show_modal_transfer('<?php echo $_SESSION['email_customer'] ?>')" class="btn btn-success btn"><i class="fa fa-check"></i> Kilk disini jika Selesai</span>
							</div>
							<?php
								}
							}
							?>
						</div>
				</form> 
				<?php
					}
					else{
					?>
					<a href="<?=base_url();?>front/tiket">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Kembali</span>
								</a>
					<?php
					}
				}
				else{
				?>
				
				<form class="form-horizontal" id="form_tiket" >
					<input type="hidden" value="<?php echo $this->input->get('id_order');?>" class="form-control number" name="ID_ORDER" id="ID_ORDER" >
					<input type="hidden" value="<?php echo $_SESSION['id_customer'];?>" class="form-control number" name="ID_CUSTOMER" id="ID_CUSTOMER" >
					
						<div class="form-group">
							<label class="control-label col-sm-2" for="email">Jenis Tiket :</label>
							<div class="col-sm-6">
								<select class="form-control required" onchange="cek_harga_tiket(this.value)" name="ID_BARANG" >
									<option value="" >Silahkan Pilih</option>
									<?php
									foreach($this->dataBarang as $data){
									?>
									<option value="<?php echo $data->ID_BARANG;?>" ><?php echo $data->NAMA_BARANG;?> <?php ?></option>
									
									<?php
									}
									?>
								</select>
							</div>
							
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email"></label>
							<div class="col-sm-3" id="divHarga">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="email" id="labelHarga">Jumlah (Qty) :</label>
							<div class="col-sm-3">
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
							<div class="col-sm-offset-2 col-sm-6">
								<button type="submit" class="btn btn-success"><i class="fa fa-<?php	if($this->input->get('id_order')){ echo "plus" ;} else {echo "save";}?>"></i> <?php	if($this->input->get('id_order')){ echo "Tambah" ;} else {echo "Simpan";}?> </button>
								<a href="<?=base_url();?>front/tiket">
									<span class="btn btn-warning"><i class="fa fa-remove"></i> Batal</span>
								</a>
							</div>
							
							<?php
							if($this->input->get('id_order')){
								if($this->dataOrder->ID_KARTU == ''){
							?>
							<div class="col-sm-4">
								<span onclick="show_modal_transfer('<?php echo $_SESSION['email_customer'] ?>')" class="btn btn-success btn"><i class="fa fa-check"></i> Kilk disini jika Selesai</span>
							</div>
							<?php
								}
							}
							?>
						</div>
				</form> 
				
				<?php
				}
				?>
				
				
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
	
	
	<div class="modal fade" id="modalTransfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">
					Pesan Pemberitahuan
				</h4>
			</div>
			<div class="modal-body" style="text-align:justify">	
				Total Tagihan anda untuk pemesanan Tiket Kebun Binatang Surabaya sebesar <span id="DivJumlahRupiah"></span><br>
				Silahkan Transfer ke Rek berikut : <br><br>
				
				<b>
				BCA (No. Rek: 731 025 2527)<br>
				Mandiri (No. Rek: 0700 000 899 992)<br>
				BNI (No. Rek: 023 827 2088)<br>
				BRI (No. Rek: 034 101 000 743 303)<br>
				</b><br>
				Silahkan lihat kotak masuk di <span id="DivEmail"></span> untuk selengkapnya.<br>
				Jika telah melakukan Proses Transfer Uang, segera lakukan Proses Konfirmasi Pembayaran di Halaman Daftar Pembelian Tiket Online.
				
				<br>
				<br>
					
					<span class="btn btn-success" id="tunggu" onclick="send_email_bayar(<?php echo $this->input->get('id_order'); ?>)"> Oke</span>
				
			</div>
		</div>
		</div>
	</div>
	
</div>

		