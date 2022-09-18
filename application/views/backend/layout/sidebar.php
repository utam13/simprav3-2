<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li><a href=" <?= base_url(); ?>dashboard" onclick="showloading()"><i class="fa fa-reply"></i> <span>Kembali ke Front End</span></a></li>
            <!-- <li class="<?= $halaman=="Dashboard" ? "active":"";?>"><a href="<?= base_url(); ?>admin" onclick="showloading()"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li> -->
            <li class="header">KONTROL MENU</li>
            <li class="<?= $halaman=="Kantor" ? "active":"";?>"><a href="<?= base_url(); ?>kantor"><i class="fa fa-home"></i> <span>Kantor</span></a></li>
            <li class="<?= $halaman=="Slide Dashboard" ? "active":"";?>"><a href="<?= base_url(); ?>slide"><i class="fa fa-image"></i> <span>Slide Dashboard</span></a></li>
            <li class="<?= $halaman=="Link Aplikasi Pendukung" ? "active":"";?>"><a href="<?= base_url(); ?>linkapp"><i class="fa fa-chain"></i> <span>Link Aplikasi Pendukung</span></a></li>
            <li class="<?= $halaman=="Pegawai" ? "active":"";?>"><a href="<?= base_url(); ?>pegawai"><i class="fa fa-user-secret"></i> <span>Pegawai</span></a></li>
            <li class="<?= $halaman=="Penyedia" ? "active":"";?>"><a href="<?= base_url(); ?>penyedia"><i class="fa fa-users"></i> <span>Penyedia</span></a></li>
            <li class="<?= $halaman=="Satuan Kerja" ? "active":"";?>"><a href="<?= base_url(); ?>satker"><i class="fa fa-bank"></i> <span>Satuan Kerja</span></a></li>
            <!-- <li class="<?= $halaman=="Laporan" ? "active":"";?>"><a href="<?= base_url(); ?>laporan"><i class="fa fa-file-text"></i> <span>Laporan</span></a></li> -->
            <li class="<?= $halaman=="Count & Populate" ? "active":"";?>"><a href="<?= base_url(); ?>autocount"><i class="fa fa-calculator"></i> <span>Count & Populate</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>