<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMPRA v3.2</title>
    <link href="<?= $file_logo; ?>" rel="shortcut icon" type="image/x-icon" />

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/skins/_all-skins.min.css">

    <style>
        .login-page {
            background: url("<?= base_url(); ?>assets/backend/img/bg.png") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            ;
        }
    </style>
    <? if ($pesan != "") { ?>
        <script>
            alert("<?= str_replace("%20", " ", $pesan); ?>");
        </script>
    <? } ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= $file_logo; ?>" width="40%" />
            <br>
            <span style="font-size:5rem;color:#3471F2;font-weight:800;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;-webkit-text-stroke: 2px #fff;">SIMPRA <small style="font-size:3rem;font-weight:bold;-webkit-text-stroke: 0;">v3.2</small></span>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Log In untuk memulai mengelola data</p>

            <form method="post" action="<?= base_url(); ?>login/proses" onsubmit="showloading()">
                <div class="form-group has-feedback">
                    <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username" required>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" placeholder="Password" required>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                        </span>
                    </div>
                    <span class="fa fa-key form-control-feedback" style="margin-right:40px;"></span>
                </div>
                <div class="form-group text-center captcha">
					<?= $captchaview;?>
				</div>
				<div class="form-group has-feedback">
					<div class="input-group">
						<input type="text" class="form-control" id="cekcaptcha" name="cekcaptcha" value="" placeholder="Ketikkan Kode CAPTCHA di atas" autocomplete="off" required >
						<div class="input-group-btn">
							<button type="button" class="btn btn-default" onclick="recaptcha()"><i class="fa fa-refresh"></i></button>
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-xs-4" style="float:right;">
						<button type="submit" id="btn-login" class="btn btn-primary btn-block btn-flat" id="btn-login" disabled>Log In</button>
					</div>
                    <!-- /.col -->
                </div>
            </form>
            <!--<a href="<?= base_url(); ?>">Kembali ke Portal</a>-->
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?= base_url(); ?>assets/backend/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url(); ?>assets/backend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custome JS -->
	<script src="<?= base_url(); ?>assets/backend/js/aksi.js"></script>

</body>

</html>