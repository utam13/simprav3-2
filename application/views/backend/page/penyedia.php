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
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formpenyedia" onclick="ambil_penyedia('<?= base_url();?>penyedia/proses/1','','','','','','','','','','','','','')"><i class="fa fa-plus"></i> Tambah Penyedia</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>penyedia" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian:</label>
                                    <input type="text" class="form-control input-sm" name="cari" required autocomplete="off" value="" placeholder="Kode/Nama/NPWP Penyedia" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>penyedia" class="btn bg-purple btn-sm" onclick="showloading()">Segarkan</a>
                                </div>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="limitpage" name="limitpage" onchange="submit()">
                                        <option value="20" <? if ($limit==20) { echo "selected='selected'" ; }; ?> >20</option>
                                        <option value="40" <? if ($limit==40) { echo "selected='selected'" ; }; ?> >40</option>
                                        <option value="60" <? if ($limit==60) { echo "selected='selected'" ; }; ?> >60</option>
                                        <option value="80" <? if ($limit==80) { echo "selected='selected'" ; }; ?> >80</option>
                                        <option value="100" <? if ($limit==100) { echo "selected='selected'" ; }; ?> >100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <table class="table table-striped table-hover table-bordered table-sm table-normal">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th scope="col" nowrap class="text-center">No.</th>
                                    <th scope="col" nowrap class="text-center">#</th>
                                    <th scope="col" nowrap class="text-center">Kode</th>
                                    <th scope="col" nowrap class="text-center">Nama</th>
                                    <th scope="col" nowrap class="text-center">Bentuk Usaha</th>
                                    <th scope="col" nowrap class="text-center">NPWP</th>
                                    <th scope="col" nowrap class="text-center">Alamat</th>
                                    <th scope="col" nowrap class="text-center">Kabupaten/Kota</th>
                                    <th scope="col" nowrap class="text-center">Propinsi</th>
                                    <th scope="col" nowrap class="text-center">Email</th>
                                    <th scope="col" nowrap class="text-center">Telp</th>
                                    <th scope="col" nowrap class="text-center">No. PKP</th>
                                    <th scope="col" nowrap class="text-center">LPSE Terdaftar</th>
                                    <!-- <th scope="col" nowrap class="text-center">Tgl. Terdaftar</th>
                                    <th scope="col" nowrap class="text-center">Tgl. Verfikasi</th> -->
                                    <th scope="col" nowrap class="text-center">Status Aktif Agregasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $hasil = json_decode($daftar);
                                foreach ($hasil as $d) {
                                ?>
                                <tr>
                                    <td scope="col" class="text-center"><?= $d->no;?></td>
                                    <td scope="col" nowrap class="text-center">
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#formpenyedia" onclick="ambil_penyedia('<?= base_url();?>penyedia/proses/2','<?= $d->kd_penyedia;?>','<?= $d->nama_penyedia;?>','<?= $d->bentuk_usaha;?>','<?= $d->user_lpse;?>','<?= $d->npwp_penyedia;?>','<?= $d->alamat_penyedia;?>','<?= $d->kabupaten_kota;?>','<?= $d->provinsi;?>','<?= $d->email;?>','<?= $d->no_telp;?>','<?= $d->no_pkp;?>','<?= $d->lpse_terdaftar;?>','<?= $d->status_aktif_agregasi;?>')"><i class="fa fa-pencil"></i></a>
                                        <a href="<?= base_url();?>penyedia/proses/3/<?= $d->kd_penyedia;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus data penyedia:\n<?= $d->nama_penyedia;?>\nLanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <td scope="col" nowrap class="text-center"><?= $d->kd_penyedia;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->nama_penyedia;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->bentuk_usaha;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->npwp_penyedia;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->alamat_penyedia;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->kabupaten_kota;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->provinsi;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->email;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->no_telp;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->no_pkp;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->lpse_terdaftar;?></td>
                                    <!-- <td scope="col" nowrap class="text-center"><?= $d->tgl_terdaftar;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->tgl_verifikasi;?></td> -->
                                    <td scope="col" nowrap class="text-center"><?= $d->status_aktif_agregasi;?></td>
                                </tr>
                                <?}?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <? if ($jumlah_page > 0) { ?>
                            <ul class="pagination pull-right">
                                <? if ($page == 1) { ?>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                                <? } else {
                                        $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                <li class="page-item"><a href="<?= base_url();?>penyedia/index/1/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>penyedia/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                <?
                                    }

                                    for ($i = $start_number; $i <= $end_number; $i++) {
                                        if ($page == $i) {
                                            $link_active = "";
                                            $link_color = "class='page-item disabled'";
                                        } else {
                                            $link_active = base_url() . "penyedia/index/$i/$limit/$getcari";
                                            $link_color = "class='page-item'";
                                        }
                                    ?>
                                <li <?= $link_color; ?>><a href="<?= $link_active; ?>" class="page-link" onclick="showloading()"><?= $i; ?></a></li>
                                <? }

                                    if ($page == $jumlah_page) {
                                    ?>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-forward"></i></a></li>
                                <? } else {
                                        $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                                <li class="page-item"><a href="<?= base_url();?>penyedia/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>penyedia/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
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
    <div class="modal fade" id="formpenyedia" tabindex="-1" aria-labelledby="formpenyediaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formpenyediaLabel">Formulir Penyedia</h4>
                </div>
                <form id="frmpenyedia" nama="frmpenyedia" method="POST" action="" onsubmit="showloading()">
                    <input type="hidden" id="user_lpse" name="user_lpse">
                    <input type="hidden" id="kode_awal" name="kode_awal">
                    <input type="hidden" id="nama_awal" name="nama_awal">
                    <input type="hidden" id="npwp_awal" name="npwp_awal">
                    <input type="hidden" id="email_awal" name="email_awal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" id="kd_penyedia" name="kd_penyedia" value="" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="nama_penyedia" name="nama_penyedia" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Bentuk Usaha</label>
                                    <input type="text" class="form-control" id="bentuk_usaha" name="bentuk_usaha" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" id="npwp_penyedia" name="npwp_penyedia" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" id="alamat_penyedia" name="alamat_penyedia" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" maxlength=255 autocomplete="off" required>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Propinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Telp</label>
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>No. PKP</label>
                                    <input type="text" class="form-control" id="no_pkp" name="no_pkp" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>LPSE Terdaftar</label>
                                    <input type="text" class="form-control" id="lpse_terdaftar" name="lpse_terdaftar" maxlength=255 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Status Aktif Agregasi</label>
                                    <input type="text" class="form-control" id="status_aktif_agregasi" name="status_aktif_agregasi" autocomplete="off" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label>Tgl. Terdaftar</label>
                                    <input type="date" class="form-control" id="tgl_terdaftar" name="tgl_terdaftar" autocomplete="off" required>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label>Tgl. Verifikasi</label>
                                    <input type="date" class="form-control" id="tgl_verifikasi" name="tgl_verifikasi" autocomplete="off" required>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Tutup</button>
                        <button type="submit" class="btn bg-light-blue">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>