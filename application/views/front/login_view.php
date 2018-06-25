
		<!--header-->
			<!--welcome-->
			<div class="container" style="margin-top:10px">
				
					<div class="col-sm-5">
				
				
						<div class="panel panel-success">
							<div class="panel-heading">Form Login</div>
							<div class="panel-body">
							
							

				
						<form class="form-horizontal" id="form_login" action="<?=base_url();?>front/login/login_data">
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Email :</label>
								<div class="col-sm-8">
								<input type="email" name="EMAIL_CUSTOMER" class="form-control" id="email" placeholder="Enter email">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="pwd">Password :</label>
								<div class="col-sm-8">
								<input type="password" name="PASSWORD" class="form-control" id="pwd" placeholder="Enter password">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="pwd"></label>
								<div class="col-sm-8" id="pesan_error_login">
									
								</div>
							</div>
							<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
								<button type="submit" class="btn btn-success">Login</button>  <img src="<?=base_url();?>assets/img/loading.gif" id="loading_login" style="display:none"> 
							</div>
							</div>
						</form> 
				
						</div>
						</div>
					</div>
					
					<div class="col-sm-7">
				
				
						<div class="panel panel-success">
							<div class="panel-heading">Form Registrasi</div>
							<div class="panel-body">
							
							

				
						<form class="form-horizontal" id="form_standar" action="<?=base_url();?>front/registrasi/add_data">
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Nama :</label>
								<div class="col-sm-6">
								<input type="input" name="NAMA_CUSTOMER" class="form-control required" id="NAMA_CUSTOMER">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Alamat :</label>
								<div class="col-sm-8">
								<textarea class="form-control required" name="ALAMAT_CUSTOMER" id="ALAMAT_CUSTOMER" ></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Nomor Handphone :</label>
								<div class="col-sm-4">
								<input type="input" name="HP_CUSTOMER" class="form-control number required" id="HP_CUSTOMER" minlength="10">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="email">Email :</label>
								<div class="col-sm-8">
								<input type="input" name="EMAIL_CUSTOMER" class="form-control required email" id="EMAIL_CUSTOMER" >
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="pwd">Password :</label>
								<div class="col-sm-4">
								<input type="password" name="PASSWORD" class="form-control required" id="PASSWORD" >
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-4" for="pwd"></label>
								<div class="col-sm-8" id="pesan_error">
									
								</div>
							</div>
							<div class="form-group">
							<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-success">Registrasi</button>  <img src="<?=base_url();?>assets/img/loading.gif" id="loading" style="display:none"> 
							</div>
							</div>
						</form> 
				
						</div>
						</div>
				</div>
		</div>
				