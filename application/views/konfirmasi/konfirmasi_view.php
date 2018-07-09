
<!-- Content Header (Page header) -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
		
        <div class="box-header">
			<h4><?php echo $this->template_view->nama_menu('nama_menu'); ?></h4>
			<h5><?php echo $this->template_view->nama_menu('judul_menu'); ?></h5>
			<hr>
			<div class="row">
				<div class="col-sm-2">
					<?php 
					//// cara ambil button Add
					echo $this->template_view->getAddButton(); 
					?>
				</div>
				<div class="col-sm-2">
				</div>
				<div class="col-sm-8">
					<div class="row">
						<form method="get">
						<div class="col-sm-4 col-md-offset-2">
							<select class="form-control" name="field">
								<option <?php if($this->input->get('field')=='NO_ORDER') echo "selected"; ?> value="NO_ORDER">Berdasarkan No Order</option>
								<option <?php if($this->input->get('field')=='NAMA_CUSTOMER') echo "selected"; ?> value="NAMA_CUSTOMER">Berdasarkan Nama Customer</option>
							</select>
						</div>
						<div class="col-sm-6">							
								<div class="input-group">
									<input type="text" class="form-control" name="keyword" placeholder="Masukkan Kata Kunci" value="<?php echo $this->input->get('keyword'); ?>">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit">
										<i class="glyphicon glyphicon-search"></i>
										</button>
										<?php if($this->input->get('field')){ ?>
										<a href="<?=base_url();?><?php echo $this->uri->segment(1);?>">
											<span class="btn btn-success"><i class="glyphicon glyphicon-refresh"></i></span>
										</a>
										<?php } ?>
									</div>
									
								</div>	
														
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
			
        <div class="box-body box-table">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th colspan="2" width="15%">No.</th>
                <th>NO Order</th>
                <th>Nama Customer</th>
                <th>Tgl Order</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				?>
				<tr>
					<td align="center">
						<span onclick="konfirmasi_pembayaran_online('<?php echo $showData->ID_T_ORDER; ?>','<?php echo $showData->KETERANGAN_KONFIRMASI_BAYAR; ?>')" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Konfirmasi</span>
					</td>
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->NO_ORDER; ?></td>
					<td ><?php echo $showData->NAMA_CUSTOMER; ?></td>
					<td ><?php echo $showData->TGL_ORDER_INDO; ?></td>
					<td ><?php echo $showData->STATUS_BAYAR; ?></td>
				</tr>
				<?php
				$no++;
				}
				if(!$this->showData){
					echo "<tr><td colspan='25' align='center'>Data tidak ada.</td></tr>";
				}
				?>
            </tbody>
        </table>
        <center>
			<?php echo $this->pagination->create_links();?>
			<br>
			<span class="btn btn-default">Jumlah Data : <b><?php echo $this->jumlahData;?></b></span>
		</center>
          
        </div>
    </div>
  </div>
</section>



<div class="modal fade" id="modal_konfirmasi_pembayaran_online" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">
				Form Konfirmasi Pembayaran Pembelian TIket Online
			</h4>
		</div>
		<div class="modal-body">					
			<form class="form-horizontal" id="form_konfirmasi">	
				
				<input type="hidden" class="form-control " required name="id_order" id="id_order">
				<div class="form-group">
					<div class="col-sm-12">
						<span id="pesanKonfirmasi"><span>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-12">
						<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
						<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
					</div>
				</div>			
				<div class="form-group">
					<div class="col-sm-12">
								<button type="submit"  class="btn btn-success" id="tunggu">Klik disini jika Proses Transfer Benar</button>
							</div>
						</div>							
			</form>					
			
		</div>
	</div>
	</div>
</div>
<!-- /.content -->
  
