<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
<head>
	<title>Kebun Binatang Surabaya</title>
	<link rel="shortcut icon" href="images/bar.png"/>
	
	
	
	<link rel="stylesheet" href="<?=base_url();?>assets/bootstrap/css/bootstrap.min.css">
	
	<link href="<?=base_url();?>assets/front/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="<?=base_url();?>assets/font-awesome-4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Ubuntu" />
		
	<!-- Daterange picker -->
	
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?=base_url();?>assets/plugins/daterangepicker/daterangepicker.css">
</head>

<body>
		<!--header-->
			<div class="header" style="border-bottom:3px solid #008000">
				<div class="container">
					<div class="header-top">
						<nav class="navbar navbar-default">
							<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
									  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
											<span class="sr-only">Toggle navigation</span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
									  </button>
									<div class="navbar-brand">
										<h1><a href="index.php">Kebun Binatang Surabaya</a></h1> 
									</div>
								</div>

    <!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							  <ul class="nav navbar-nav">
									<li class="<?php if($this->uri->segment(2) == 'home') echo "active";?>"><a href="<?=base_url();?>front/home">Home<span class="sr-only">(current)</span></a></li>
									<li><a href="#">Tentang Kami</a></li>
									<li><a href="#">Rekreasi</a></li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gallery <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="#">Aves</a></li>
											<li><a href="#">Mamalia</a></li>
											<li><a href="#">Reptil</a></li>
											<li><a href="#">Pisces</a></li>
										</ul>
									</li>
									<!--<li><a href="codes.php">Codes</a></li>-->
									<li><a href="#">Kontak</a></li>
									
									
									<?php 

									if($this->session->userdata('nama_customer')){
									?>
									<li class="dropdown <?php if($this->uri->segment(2) == 'tiket' || $this->uri->segment(2) == 'password' || $this->uri->segment(2) == 'login') echo "active";?>">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo  $this->session->userdata('nama_customer'); ?> <span class="caret"></span></a>
										<ul class="dropdown-menu">
											<li><a href="<?=base_url();?>front/tiket">Pembelian Tiket Saya</a></li>
											<!--<li><a href="<?=base_url();?>front/password">Ganti Password</a></li>-->
											<li><a href="<?=base_url();?>front/logout">LogOut</a></li>
										</ul>
									</li>
									<?php
									}
									else{
									?>
									<li class="dropdown <?php if($this->uri->segment(2) == 'tiket' || $this->uri->segment(2) == 'password' || $this->uri->segment(2) == 'login') echo "active";?>"><a href="<?=base_url();?>front/tiket">Tiket Online</a></li>
									<?php
									}
									?>
								</ul>
							  
							</div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
						</nav>

					</div>
				</div>
			</div>