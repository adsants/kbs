		<div class="specials-section">
			<div class="container">
				<div class="specials-grids">
					<div class="col-md-3 specials1">
						<h3>Fedding Time & Keeper Talk</h3>
							
							<p>Binturong &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 10.00 - 11.00</p>
							<p>Harimau Benggala &nbsp; 10.30 - 11.00</p>
							<p>Pelikan &nbsp; &nbsp; &emsp; &emsp; &emsp; &emsp; 11.30 - 11.00</p>
							<p>Pecuk Padi Hitam &emsp; 11.30 - 11.00</p>
							<p>Buaya &nbsp; &nbsp; &nbsp; &emsp; &emsp; &emsp; &emsp; 12.00 - 13.00</p>
							<p>Beruang Madu  &emsp; &emsp; 13.00 - 13.30</p>
							<p>Komodo &nbsp; &emsp; &emsp; &emsp; &emsp; 13.30 - 14.30</p>
							<p>Diselenggarakan setiap Hari Minggu & Hari Besar Nasional</p>
					</div>
					<div class="col-md-3 specials1">
						<h3>Gallery</h3>
						<ul>
							<li><a href="aves.php">Aves</a></li>
							<li><a href="mamalia.php">Mamalia</a></li>
							<li><a href="reptil.php">Reptil</a></li>
							<li><a href="pisces.php">Pisces</a></li>
						</ul>
					</div>
					<div class="col-md-3 specials1">
						<h3>Kontak</h3>
						<address>
						<p><span class="fa fa-map-marker"></span>  Addres: Jl. Setail No. 1, Darmo,</p>
						<p>&nbsp; &nbsp; Wonokromo, Surabaya</p>
						<p><span class="fa fa-phone"></span> Phone: (031) 5678703</p>
						<p><span class="fa fa-fax"></span> Fax: (031) 5677868</p>
						<p><span class="fa fa-inbox"></span> Email: pdtskbs@gmail.com</p>
						</address>
					</div>
					<div class="col-md-3 specials1">
						<h3>sosial</h3>
						<ul>
						<p><span class="fa fa-facebook"></span><a href="https://www.facebook.com/profile.php?id=100016964654721"> Facebook</p></p>
						<p><span class="fa fa-twitter"></span><a href="https://twitter.com/search?q=pdtskbs&src=typd"> Twitter</a></p>
						<p><span class="fa fa-instagram"></span><a href="https://www.instagram.com/kebunbinatangsurabaya/?hl=id"> Instagram</a></p>
						<p><span class="fa fa-youtube"></span><a href="https://www.youtube.com/channel/UCbF6xcAoPLYvYiONEgcLJ6Q"> Youtube</a></p>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>



	<!--footer-->
	<div class="footer-section">
	<div class="container">
		<div class="footer-top">
			<p>&copy; PD. Taman Satwa Kebun Binatang Surabaya 2017. All rights reserved | Design by<a href="http://w3layouts.com">W3layouts</a></p>
			<p>Supported by<a href="http://www.untag-sby.ac.id">Universitas 17 Agustus Surabaya</a>&<a href="http://bsiuntag-sby.com">Badan Sistem Informasi</a></p>
		</div>
	</div>
	</div>
	
		<script src="<?=base_url();?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?=base_url();?>assets/js/jquery-ui.min.js"></script>
		
			
	<script src="<?=base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=base_url();?>assets/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- datepicker -->
	<script src="<?=base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script>	
		var base_url = "<?php echo base_url();?>";
		var uri_1 = "<?php echo $this->uri->segment(1); ?>";
		var uri_2 = "<?php echo $this->uri->segment(2); ?>";
		var uri_3 = "<?php echo $this->uri->segment(3); ?>";
		var uri_4 = "<?php echo $this->uri->segment(4); ?>";			
		$.widget.bridge('uibutton', $.ui.button);
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover(); 
		});
		
		$('#datepicker').datepicker({
				autoclose: true,
				
			});
			
			$('#datepicker2').datepicker({
				autoclose: true,
				
			});
	</script>
	

	<script src="<?php echo base_url();?>assets/js/validate.js"></script>		
	<script src="<?php echo base_url();?>assets/js/jquery-upload.js"></script>	
	<script src="<?=base_url();?>assets/front/js/module.js"></script>		
</body>
</html>
