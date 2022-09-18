<header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url(); ?>admin" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="<?= $file_logo;?>" alt="" width=30></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>SIMPRA v3.2 | Admin</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url(); ?>assets/backend/img/user.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= ucfirst($this->session->userdata('nama')); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="padding-top:3rem;">
                            <img src="<?= base_url(); ?>assets/backend/img/user.png" class="img-circle" alt="User Image">

                            <p>
                                <?= ucfirst($this->session->userdata('nama')); ?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="col-xs-12">
                                <a href="<?= base_url(); ?>login/logout" class="btn btn-danger btn-block btn-flat" style="color:#fff;">Keluar</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>