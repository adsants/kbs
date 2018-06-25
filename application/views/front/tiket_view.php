
		<!--header-->
			<!--welcome-->
<div class="container" style="margin-top:10px">

	<div class="col-sm-12">


		<div class="panel panel-success">
			<div class="panel-heading">Daftar Pembelian Tiket Online</div>
			<div class="panel-body">
				<a href="<?=base_url();?>front/tiket/add"><span class="btn btn-success">Klik disini untuk Beli Tiket Online</span></a>
				<br>
				<br>
				<table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2" width="15%">No.</th>
                <th>No Order</th>
                <th>Tgl Order</th>
                <th width="45%">Status Bayar</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				?>
				<tr>
					<td align="center">
						
						<a href="http://localhost/kbs/front/tiket/add?id_order=<?php echo $showData->ID_T_ORDER; ?>"><span class="btn btn-warning"><i class="fa fa-eye"></i> Detail</span></a>
					</td>
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->NO_ORDER; ?></td>
					<td ><?php echo $showData->TGL_ORDER_INDO; ?></td>
					<td align='justify'>
						<?php 
						if( $showData->STATUS_BAYAR == 'Belum Bayar'){  
						?>
							<span onclick="showModalKOnfirmasiBayar(<?php echo $showData->ID_T_ORDER; ?>)" class="btn btn-success"><i class="fa fa-mooney"></i> Konfirmasi Pembayaran</span>
						<?php
						}
						elseif($showData->STATUS_BAYAR == 'Sudah Konfirmasi Bayar'){
							echo $showData->KETERANGAN_KONFIRMASI_BAYAR; 
						}
						else{
							echo $showData->STATUS_BAYAR; 
						}
						?>
					</td>
				</tr>
				<?php
				$no++;
				}
				if(!$this->showData){
					echo "<tr><td colspan='25' align='center'>Anda belum melakukan Pmbelian Tiket.</td></tr>";
				}
				?>
            </tbody>
        </table>
			</div>
		</div>
	</div>
	
	
</div>


<div class="modal fade" id="modalKonfirmasiBayar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">
						Form Konfirmasi Pembayaran
					</h4>
				</div>
				<div class="modal-body">					
					<form class="form-horizontal" id="form_konfirmasi">	
						<input type="hidden" id="ID_ORDER" name="ID_ORDER">
						<div class="form-group">
							<label class="control-label col-sm-4" >Jenis Bank :</label>
							<div class="col-sm-5">
								<select class="form-control " required name="JENIS_BANK">
									<option value="">Silahkan Pilih</option>
									<option value="BCA">BCA</option>
									<option value="BNI">BNI</option>
									<option value="BRI">BRI</option>
									<option value="MANDIRI">MANDIRI</option>
									<option value="Bank Lainnya">Bank Lainnya</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4" >Nomor Rekening :</label>
							<div class="col-sm-5">
								<input type="text" class="form-control " id="NO_REKENING" required name="NO_REKENING">
							</div>
						</div>			

						<div class="form-group">
							<label class="control-label col-sm-4" >Ke Bank Tujuan :</label>
							<div class="col-sm-7">
								<select class="form-control " required name="BANK_TUJUAN">
									<option value="">Silahkan Pilih</option>
									<option value="BCA (No. Rek: 731 025 2527)">BCA (No. Rek: 731 025 2527)</option>
									<option value="Mandiri (No. Rek: 0700 000 899 992)">Mandiri (No. Rek: 0700 000 899 992)</option>
									<option value="BNI (No. Rek: 023 827 2088)">BNI (No. Rek: 023 827 2088)</option>
									<option value="BRI (No. Rek: 034 101 000 743 303)">BRI (No. Rek: 034 101 000 743 303)</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-sm-4" >Pada Tanggal :</label>
							<div class="col-sm-4">
								<input type="input" class="form-control required" name="TGL_TRANSFER" id="datepicker"  data-date-format='yyyy-mm-dd' >
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
								<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
							</div>
						</div>			
						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-10">
								<button type="submit"  class="btn btn-success">Simpan</button>
							</div>
						</div>							
					</form>					
					
				</div>
			</div>
			</div>
		</div>
				