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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_linkapp" onclick="ambil_linkapp('<?= base_url(); ?>linkapp/proses/1','','','','','','upload/no-image.png','upload/no-image.png')"><i class="fa fa-plus"></i> Tambah Link App</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>linkapp" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian:</label>
                                    <input type="text" class="form-control input-sm" name="cari" required autocomplete="off" value="" placeholder="Nama App" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>linkapp" class="btn bg-purple btn-sm" onclick="showloading()">Segarkan</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead>
                                <tr>
                                    <th style="width:5%;">No.</th>
                                    <th style="width:25%;">#</th>
                                    <th style="width:20%;">Nama App</th>
                                    <th style="width:50%;">URL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $hasil = json_decode($linkapp);
                                foreach ($hasil as $l) {
                                ?>
                                    <tr>
                                        <td align="center"><?= $l->no; ?></td>
                                        <td>
                                            <a href="<?= base_url() . $l->file_slide; ?>" target="_blank" class="btn btn-default btn-xs">Gambar Slide App</a>
                                            <a href="<?= base_url() . $l->file_iconapp; ?>" target="_blank" class="btn btn-default btn-xs">Icon App</a>
                                            <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#form_linkapp" onclick="ambil_linkapp('<?= base_url(); ?>linkapp/proses/2','<?= $l->kode; ?>','<?= $l->nama; ?>','<?= $l->url; ?>','<?= $l->slide; ?>','<?= $l->iconapp; ?>','<?= $l->file_slide; ?>','<?= $l->file_iconapp; ?>')"><i class="fa fa-pencil"></i></a>
                                            <a href="<?= base_url(); ?>linkapp/proses/3/<?= $l->kode; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus link app <?= $l->nama; ?> ?')"><i class="fa fa-trash"></i></a>
                                        </td>
                                        <td><?= $l->nama;?></td>
                                        <td><?= $l->url;?></td>
                                    </tr>
                                <? $no++;
                                } ?>
                            </tbody>

                        </table>
                    </div>
                    <div class="box-footer with-border">
                        <? if ($jumlah_page > 0) { ?>
                            <ul class="pagination" style="float:right;">
                                <? if ($page == 1) { ?>
                                    <li class="disabled"><a href="#"><span class="fa fa-fast-backward"></a></li>
                                    <li class="disabled"><a href="#"><span class="fa fa-step-backward"></a></li>
                                <? } else {
                                    $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                    <li><a href="<?= base_url(); ?>linkapp/index/1/<?= $cari; ?>"><span class="fa fa-fast-backward"></a></li>
                                    <li><a href="<?= base_url(); ?>linkapp/index/<?= $link_prev; ?>/<?= $cari; ?>"><span class="fa fa-step-backward"></a></li>
                                <?
                                }

                                for ($i = $start_number; $i <= $end_number; $i++) {
                                    if ($page == $i) {
                                        $link_active = "";
                                        $link_color = "class='disabled'";
                                    } else {
                                        $link_active = base_url() . "linkapp/index/$i/$cari";
                                        $link_color = "";
                                    }
                                ?>
                                    <li <?= $link_color; ?>><a href="<?= $link_active; ?>"><?= $i; ?></a></li>
                                <? }

                                if ($page == $jumlah_page) {
                                ?>
                                    <li class="disabled"><a href="#"><span class="fa fa-step-forward"></a></li>
                                    <li class="disabled"><a href="#"><span class="fa fa-fast-forward"></a></li>
                                <? } else {
                                    $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                                    <li><a href="<?= base_url(); ?>linkapp/index/<?= $link_next; ?>/<?= $cari; ?>"><span class="fa fa-step-forward"></a></li>
                                    <li><a href="<?= base_url(); ?>linkapp/index/<?= $jumlah_page; ?>/<?= $cari; ?>"><span class="fa fa-fast-forward"></a></li>
                                <? } ?>
                            </ul>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

    <!-- Modal -->
    <!--Formulir-->
    <div class="modal fade" id="form_linkapp" tabindex="-1" role="dialog" aria-labelledby="form_linkapp" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="form_linkapp_label">Formulir Link App Pendukung</h4>
                </div>
                <form id="frm_linkapp" name="frm_linkapp" method="post" action="">
                    <input type="hidden" class="form-control" name="kode" id="kode" value="" />
                    <input type="hidden" class="form-control" name="nama_awal" id="nama_awal" value="" />
                    <input type="hidden" class="form-control" name="url_awal" id="url_awal" value="" />
                    <input type="hidden" id="kontrol" value="linkapp">
                    <input type="hidden" id="lokasi" value="<?= base_url(); ?>">
                    <input type="file" id="pilih-slide" accept=".jpg,.png,.gif,.bmp" style="display:none;">
                    <input type="hidden" class="form-control" name="slide" id="slide" value="" />
                    <input type="file" id="pilih-icon" accept=".png,.gif" style="display:none;">
                    <input type="hidden" class="form-control" name="icon" id="icon" value="" />
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Nama App</label>
                                    <input type="text" class="form-control" name="nama" id="nama" value="" maxlength=250 autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="text" class="form-control" name="urlapp" id="urlapp" value="" autocomplete="off" required />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <img id="slide-app" class="img-responsive center-block" src="" alt="Slide App" onclick="upload_link('slide')" style="cursor:pointer;width:100%;">
                                <br>
                                <p class="text-muted text-center"><i>slide aplikasi maksimal 6 Mb</i></p>
                            </div>
                            <div class="col-xs-6">
                                <img id="icon-app" class="img-responsive center-block" src="" alt="Icon App" onclick="upload_link('icon')" style="cursor:pointer;width:100%;">
                                <br>
                                <p class="text-muted text-center"><i>icon aplikasi maksimal 6 Mb</i></p>
                            </div>
                            <div id="progress_div" class="col-xs-12" style="display:none;">
                                <div class="progress progress-sm active">
                                    <div id="progress_bar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="savebtn" class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>