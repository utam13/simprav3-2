<header>
	<!-- header-area start -->
	<div id="sticker" class="header-area">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">

					<!-- Navigation -->
					<nav class="navbar navbar-default">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
												<span class="sr-only">Toggle navigation</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</button>
						<!-- Brand -->
						<a class="navbar-brand page-scroll sticky-logo" href="#">
						<?extract($infoapp);?>
						<h1><img src="<?= $file_logo;?>" alt="" title="" width="15%"> SIMPRA</h1>
						<!-- Uncomment below if you prefer to use an image logo -->
						</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
						<ul class="nav navbar-nav navbar-right">
							<?if($this->session->userdata('stat_log') != "login"){?>
								<li>
									<a class="page-scroll" href="<?= base_url();?>">Silakan Log In terlebih dahulu</a>
								</li>	
							<?}else{?>
								<li <?= $halaman=="Dashboard" ? 'class="active"':'';?> >
									<a class="page-scroll" href="<?= base_url();?>dashboard">Dashboard</a>
								</li>
								<li class="dropdown <?= $halaman=="Struktur APBD - Struktur Anggaran" || $halaman=="Struktur APBD - Rincian Belanja" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Struktur APBD<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>struktur_apbd/struktur_anggaran">Struktur Anggaran</a></li>
									<li><a href="<?= base_url();?>struktur_apbd/rincian_belanja">Rincian Belanja</a></li>
									</ul>
								</li>
								<li class="dropdown <?= $halaman=="RUP - Rekapitulasi" || $halaman=="RUP - Histori Revisi Paket" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">RUP<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>rup/rekapitulasi">Rekapitulasi</a></li>
									<li><a href="<?= base_url();?>rup/histori_revisi_paket">Histori Revisi Paket</a></li>
									</ul>
								</li>
								<li class="dropdown <?= $halaman=="Tender - Rekapitulasi" || $halaman=="Tender - Rincian Paket" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tender<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>tender/rekapitulasi">Rekapitulasi</a></li>
									<li><a href="<?= base_url();?>tender/rincian_paket">Rincian Paket</a></li>
									</ul>
								</li>
								<li class="dropdown <?= $halaman=="Non Tender - Rekapitulasi" || $halaman=="Non Tender - Rincian Paket" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Non Tender<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>nontender/rekapitulasi">Rekapitulasi</a></li>
									<li><a href="<?= base_url();?>nontender/rincian_paket">Rincian Paket</a></li>
									</ul>
								</li>
								<li class="dropdown <?= $halaman=="Pencatatan - Non Tender" || $halaman=="Pencatatan - Swakelola" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pencatatan<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>pencatatan/nontender">Non Tender</a></li>
									<li><a href="<?= base_url();?>pencatatan/swakelola">Swakelola</a></li>
									</ul>
								</li>
								<li <?= $halaman=="e-Purchasing" ? 'class="active"':'';?> >
									<a class="page-scroll" href="<?= base_url();?>epurchasing">ePurchasing</a>
								</li>
								<li class="dropdown <?= $halaman=="Realisasi - Rekapitulasi" || $halaman=="Realisasi - Rincian Paket" || $halaman=="Realisasi - Triwulan" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Realisasi<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>realisasi/rekapitulasi">Rekapitulasi</a></li>
									<li><a href="<?= base_url();?>realisasi/rincian_paket">Rincian Paket</a></li>
									<li><a href="<?= base_url();?>realisasi/triwulan">Triwulan</a></li>
									</ul>
								</li>
								<li class="dropdown <?= $halaman=="Monitoring - Paket Strategis" || $halaman=="Monitoring - Sumber Dana" 
														|| $halaman=="Monitoring - Penyedia" || $halaman=="Monitoring - PPK" 
														|| $halaman=="Monitoring - Personil" || $halaman=="Monitoring - Kelompok Kerja" ? 'active':'';?> ">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Monitoring<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
									<li><a href="<?= base_url();?>monitoring/paket_strategis">Paket Strategis</a></li>
									<li><a href="<?= base_url();?>monitoring/sumber_dana">Sumber Dana</a></li>
									<li><a href="<?= base_url();?>monitoring/penyedia">Penyedia</a></li>
									<li><a href="<?= base_url();?>monitoring/ppk">PPK</a></li>
									<li><a href="<?= base_url();?>monitoring/personil">Personil</a></li>
									<li><a href="<?= base_url();?>monitoring/kelompok_kerja">Kelompok Kerja</a></li>
									</ul>
								</li>
									<?if($this->session->userdata('level') == "Administrator"){?>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<span class="caret"></span></a>
											<ul class="dropdown-menu" role="menu">
												<li><a href="<?= base_url();?>admin">Administrator Area</a></li>
												<li><a href="<?= base_url();?>login/logout">Log Out</a></li>
											</ul>
										</li>
									<?}else{?>
										<li>
											<a class="page-scroll" href="<?= base_url();?>login/logout">Log Out</a>
										</li>
									<?}?>
							<?}?>
						</ul>
					</div>
					<!-- navbar-collapse -->
					</nav>
					<!-- END: Navigation -->
				</div>
			</div>
		</div>
	</div>
	<!-- header-area end -->
</header>
<!-- header end -->