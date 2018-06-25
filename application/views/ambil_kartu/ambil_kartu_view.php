
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
                <th>Kartu</th>
              </tr>
            </thead>
            <tbody>
				<?php
				$no = $this->input->get('per_page')+ 1;
				foreach($this->showData as $showData ){
				?>
				<tr>
					<td align="center">
						<!--<?php 
						////// cara ambil Button Edit ( link edit )
						echo $this->template_view->getEditButton(base_url().$this->uri->segment(1)."/edit/".$showData->ID_T_ORDER); 
						?>
						&nbsp;
						<?php
						////// cara ambil Button Delete (pesan yang ingin ditampilkan, link Delete)
						echo $this->template_view->getDeleteButton($showData->NO_ORDER,base_url().$this->uri->segment(1)."/delete/".$showData->ID_T_ORDER); 
						?>	
						<a href="http://localhost/kbs/trans_tiket/add?id_order=<?php echo $showData->ID_T_ORDER; ?>"><span class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> Detail</span></a>
						-->
					</td>
					<td align="center"><?php echo $no; ?>.</td>
					<td ><?php echo $showData->NO_ORDER; ?></td>
					<td ><?php echo $showData->NAMA_CUSTOMER; ?></td>
					<td ><?php echo $showData->TGL_ORDER_INDO; ?></td>
					<td ><?php echo $showData->STATUS_BAYAR; ?></td>
					<td >
						
						<?php 
						if($showData->NOMOR_RFID){
							echo $showData->NOMOR_RFID; 
						}
						else{
							if($showData->ID_CUSTOMER == 1){
						?>
							<span onclick="ambil_kartu('<?php echo $showData->ID_T_ORDER; ?>')" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> Ambil Kartu</span>

						<?php
							}
							else{
								if($showData->STATUS_BAYAR == 'Lunas'){
						?>		
						
									<span onclick="ambil_kartu('<?php echo $showData->ID_T_ORDER; ?>')" class="btn btn-success btn-xs"><i class="fa fa-credit-card"></i> Ambil Kartu</span>
						
						<?php				
								}
								else{
									echo "Belum Lunas (Online)";
								}
							}
						}					
						?>
					</td>
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
					<label class="control-label col-sm-4" >Username :</label>
					<div class="col-sm-5">
						<input type="hidden" class="form-control " required name="id_order_ambil_kartu" id="id_order_ambil_kartu">
						<input type="input" class="form-control " required name="nomor_rfid" id="nomor_rfid">
					</div>
				</div>				
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<img src="<?php echo base_url();?>assets/img/loading.gif" id="loading" style="display:none">
						<p id="pesan_error" style="display:none" class="text-warning" style="display:none"></p>
					</div>
				</div>			
									
			</form>					
			
		</div>
	</div>
	</div>
</div>
<!-- /.content -->
  
