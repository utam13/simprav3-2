	<!-- Start Footer bottom Area -->
	<?extract($infoapp);?>
	<footer>
		<div class="footer-area">
			<div class="container">
				<div class="row">
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="footer-content">
						<div class="footer-head">
							<h4>aplikasi pendukung</h4>
							<div id="carouselExampleInterval" class="carousel slide w-100" data-ride="carousel"> 
								<div class="carousel-inner slide-link">
									<?
									$noslideapp = 1;
									foreach ($linkapp as $l) {
										$aktifslide = $noslideapp == 1 ? "active" : "";
										echo '<div class="item '.$aktifslide.' text-center" data-interval="2000">
												<img src="'.base_url().'upload/linkapp/'.$l->slide.'" class="center-block w-100" alt="'.$l->nama.'" />
											</div>';
										$noslideapp++;
									}?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- end single footer -->
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="footer-content">
						<div class="footer-head text-center">
							<h4>information</h4>
							<p style="width:300px;margin:auto;">
								<?= $namakantor;?>
							</p>
							<div class="footer-contacts" style="margin-top:20px;">
								<p>
									<?= $alamatkantor;?>
								</p>
							</div>
							<div class="footer-contacts">
								<p><span>Telp:</span> <?= $telpkantor;?></p>
								<p><span>Email:</span> <?= $emailkantor;?></p>
							</div>
						</div>
					</div>
				</div>
				<!-- end single footer -->
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="footer-content">
						<div class="footer-head text-right">
							<h4>Lokasi Kantor</h4>
							<iframe class="bg-secondary" src="<?= $googlemapkantor;?>" width="100%" height="220px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="footer-area-bottom">
			<div class="container">
				<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="copyright text-center">
					<p>
						&copy; Copyright <strong><?= $namakantor;?></strong>
						<br>
						SIMPRA ver. 3.2 | 2022
					</p>
					</div>
					<div class="credits">
					Designed by CV. DUTA AMANAH
					</div>
				</div>
				</div>
			</div>
		</div>
	</footer>

	<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

	<!-- JavaScript Libraries -->
	<script src="<?= base_url();?>assets/lib/jquery/jquery.min.js"></script>
	<script src="<?= base_url();?>assets/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?= base_url();?>assets/lib/owlcarousel/owl.carousel.min.js"></script>
	<script src="<?= base_url();?>assets/lib/venobox/venobox.min.js"></script>
	<script src="<?= base_url();?>assets/lib/knob/jquery.knob.js"></script>
	<script src="<?= base_url();?>assets/lib/wow/wow.min.js"></script>
	<script src="<?= base_url();?>assets/lib/parallax/parallax.js"></script>
	<script src="<?= base_url();?>assets/lib/easing/easing.min.js"></script>
	<script src="<?= base_url();?>assets/lib/nivo-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
	<script src="<?= base_url();?>assets/lib/appear/jquery.appear.js"></script>
	<script src="<?= base_url();?>assets/lib/isotope/isotope.pkgd.min.js"></script>

	<script src="<?= base_url();?>assets/js/main.js"></script>

	<!-- DataTables -->
	<script src="<?= base_url();?>assets/lib/DataTables_2/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/DataTables-1.10.24/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/Buttons-1.7.0/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/JSZip-2.5.0/jszip.min.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/pdfmake-0.1.36/pdfmake.min.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/pdfmake-0.1.36/vfs_fonts.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/Buttons-1.7.0/js/buttons.html5.min.js"></script>
	<script src="<?= base_url();?>assets/lib/DataTables_2/Buttons-1.7.0/js/buttons.print.min.js"></script>
	<script src="<?= base_url();?>assets/js/datatables.custome.js"></script>

	<!-- Highchart -->	
	<?if($halaman == "Dashboard" || $halaman=="Realisasi - Rekapitulasi" || $halaman=="Realisasi - Triwulan"){?>
		<script src="<?= base_url(); ?>assets/lib/highcharts/code/highcharts.js"></script>
		<script src="<?= base_url(); ?>assets/lib/highcharts/code/modules/exporting.js"></script>
		<script src="<?= base_url(); ?>assets/lib/highcharts/code/modules/export-data.js"></script>
		<script src="<?= base_url(); ?>assets/lib/highcharts/code/modules/accessibility.js"></script>
	<?}?>

	<script src="<?= base_url();?>assets/js/script.js"></script>

	<?if($main != ""){?>
		<script src="<?= base_url();?>assets/js/<?= $main;?>.js"></script>
	<?}?>

	<?if($grafik != ""){?>
		<script src="<?= base_url();?>assets/js/<?= $grafik;?>.js"></script>
	<?}?>

	<?if($halaman == "Monitoring - Penyedia"){?>
		<script src="<?= base_url(); ?>assets/lib/Highcharts-Maps-9.1.0/code/highmaps.js"></script>
		<script src="<?= base_url(); ?>assets/lib/Highcharts-Maps-9.1.0/code/modules/exporting.js"></script>

		<!-- <script src="<?= base_url();?>assets/js/map_provinsi.js"></script>
		<script src="<?= base_url();?>assets/js/map.js"></script> -->
	<?}?>
</body>

</html>