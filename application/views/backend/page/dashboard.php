<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Message area -->
            <?
            extract($alert);
            if ($kode_alert != "") {
            ?>
                <div class="col-lg-12">
                    <div class="alert <?= $jenisbox ?>">
                        <?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
                    </div>
                </div>
            <? } ?>
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?= $jml_pegawai;?></h3>

                                <p>Total Pegawai</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-user-secret"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3><?= $jml_penyedia;?></h3>

                                <p>Total Penyedia</p>
                                </div>
                                <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Informasi Kantor
                        </h3>
                    </div>
                    <div class="box-body">
                        <strong style="font-size:12pt;"><?= $nama; ?></strong>
                        <br>
                        <span style="font-size:11pt;">Alamat:<br><?= $alamat; ?></span>
                        <br>
                        <span style="font-size:11pt;">Telp.: <?= $telp; ?></span>
                        <br>
                        <span style="font-size:11pt;">Email: <?= $email; ?></span>
                    </div>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Logo Aplikasi
                        </h3>
                    </div>
                    <div class="box-body box-profile text-center">
                        <img class="img-responsive center-block" src="<?= $file_logo; ?>" alt="Logo Aplikasi" style="cursor:pointer;width:60%;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>