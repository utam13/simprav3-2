<?extract($infoapp);?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="max-age=1" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="1" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1900 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
	<title>SIMPRA v3.2</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="simpra" name="keywords">
	<meta content="simpra" name="description">

	<!-- Favicons -->
	<link href="<?= $file_logo;?>" rel="icon">
	<link href="<?= $file_logo;?>" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet">

	<!-- Bootstrap CSS File -->
	<link href="<?= base_url();?>assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Libraries CSS Files -->
	<link href="<?= base_url();?>assets/lib/nivo-slider/css/nivo-slider.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/owlcarousel/owl.carousel.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/owlcarousel/owl.transitions.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/animate/animate.min.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/venobox/venobox.css" rel="stylesheet">

	<!-- Nivo Slider Theme -->
	<link href="<?= base_url();?>assets/lib/nivo-slider/css/nivo-slider-theme.css" rel="stylesheet">

	<?if($halaman == "Monitoring - Penyedia"){?>
	<!-- mapbox -->
    <!-- <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" /> -->
	<?}?>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url();?>assets/lib/font-awesome/css/font-awesome.min.css">

	<!-- datatables -->
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/lib/DataTables_2/DataTables-1.10.24/css/dataTables.bootstrap4.min.css"/>

	<!-- Ionicons -->
	<link rel="stylesheet" href="<?= base_url();?>assets/lib/Ionicons/css/ionicons.min.css">

	<!-- Responsive Stylesheet File -->
	<link href="<?= base_url();?>assets/css/responsive.css" rel="stylesheet">

	<!-- tree diagram -->
    <link href="<?= base_url();?>assets/css/tree.diagram.css" rel="stylesheet" />

	<!-- Main Stylesheet File -->
	<link href="<?= base_url();?>assets/css/style.css" rel="stylesheet">

	<!-- Main Stylesheet File -->
	<link href="<?= base_url();?>assets/custome/style-custome.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/custome/color.css" rel="stylesheet">

	<!-- =======================================================
		Theme Name: eBusiness
		Theme URL: https://bootstrapmade.com/ebusiness-bootstrap-corporate-template/
		Author: BootstrapMade.com
		License: https://bootstrapmade.com/license/
	======================================================= -->
</head>

<body>

<div id="preloader"></div>

<?if($halaman == "Dashboard"){?>
<!-- Start Slider Area -->
<div id="home" class="slider-area">
    <div class="bend niceties preview-2">
        <div id="ensign-nivoslider" class="slides">
			<?
			$noslide = 1;
			foreach ($slide as $s) {
				$aktifslide = $noslide == 1 ? "active" : "";
				echo '<img src="'.base_url().'upload/slide/'.$s->gambar.'" alt="" title="#slider-direction-'.$noslide.'" />';
				$noslide++;
			}?>
        </div>
    </div>
</div>
<!-- End Slider Area -->
<?}else{?>
<div id="home" class="divider-area" id="divider">
    &nbsp;
</div>
<?}?>