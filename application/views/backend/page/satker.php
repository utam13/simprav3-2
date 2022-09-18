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
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formsatker" onclick="ambil_satker('<?= base_url();?>satker/proses/1','','','','','','','','','','','','','')"><i class="fa fa-plus"></i> Tambah Satker</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>satker" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian:</label>
                                    <input type="text" class="form-control input-sm" name="cari" required autocomplete="off" value="" placeholder="Kode/Nama Satker" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>satker" class="btn bg-purple btn-sm" onclick="showloading()">Segarkan</a>
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
                                    <!-- <th scope="col" nowrap class="text-center">Kode KLPD</th>
                                    <th scope="col" nowrap class="text-center">Nama KLPD</th>
                                    <th scope="col" nowrap class="text-center">Jenis KLPD</th>
                                    <th scope="col" nowrap class="text-center">Kode LPSE</th>
                                    <th scope="col" nowrap class="text-center">Nama LPSE</th> -->
                                    <th scope="col" nowrap class="text-center">Kode Satker</th>
                                    <th scope="col" nowrap class="text-center">Kode Unit</th>
                                    <th scope="col" nowrap class="text-center">Nama</th>
                                    <th scope="col" nowrap class="text-center">Singkatan</th>
                                    <th scope="col" nowrap class="text-center">NPWP</th>
                                    <th scope="col" nowrap class="text-center">Alamat</th>
                                    <th scope="col" nowrap class="text-center">No. Telp</th>
                                    <th scope="col" nowrap class="text-center">Email</th>
                                    <th scope="col" nowrap class="text-center">Kota</th>
                                    <th scope="col" nowrap class="text-center">Provinsi</th>
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
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#formsatker" onclick="ambil_satker('<?= base_url();?>satker/proses/2','<?= $d->kd_satker;?>','<?= $d->kdunit_satker;?>','<?= $d->nama_satker;?>','<?= $d->singkatan;?>','<?= $d->npwp_satker;?>','<?= $d->alamat_satker;?>','<?= $d->no_telp_satker;?>','<?= $d->email_satker;?>','<?= $d->kota;?>','<?= $d->provinsi;?>')"><i class="fa fa-pencil"></i></a>
                                        <a href="<?= base_url();?>satker/proses/3/<?= $d->kd_satker;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus data satker <?= $d->nama_satker;?>\nLanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <!-- <td scope="col" nowrap class="text-center"><?= $d->kd_klpd;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->nama_klpd;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->jenis_klpd;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->kd_lpse;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->nama_lpse;?></td> -->
                                    <td scope="col" nowrap class="text-center"><?= $d->kd_satker;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->kdunit_satker;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->nama_satker;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->singkatan;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->npwp_satker;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->alamat_satker;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->no_telp_satker;?></td>
                                    <td scope="col" nowrap class="text-left"><?= $d->email_satker;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->kota;?></td>
                                    <td scope="col" nowrap class="text-center"><?= $d->provinsi;?></td>
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
                                <li class="page-item"><a href="<?= base_url();?>satker/index/1/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>satker/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                <?
                                    }

                                    for ($i = $start_number; $i <= $end_number; $i++) {
                                        if ($page == $i) {
                                            $link_active = "";
                                            $link_color = "class='page-item disabled'";
                                        } else {
                                            $link_active = base_url() . "satker/index/$i/$limit/$getcari";
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
                                <li class="page-item"><a href="<?= base_url();?>satker/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>satker/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
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
    <div class="modal fade" id="formsatker" tabindex="-1" aria-labelledby="formsatkerLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formsatkerLabel">Formulir satker</h4>
                </div>
                <form id="frmsatker" nama="frmsatker" method="POST" action="" onsubmit="showloading()">
                    <input type="hidden" id="nama_awal" name="nama_awal">
                    <input type="hidden" id="singkatan_awal" name="singkatan_awal">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode Satker</label>
                            <input type="text" class="form-control" id="kd_satker" name="kd_satker" value="" maxlength=255 autocomplete="off" required >
                        </div>
                        <div class="form-group">
                            <label>Kode Unit Satker</label>
                            <input type="text" class="form-control" id="kdunit_satker" name="kdunit_satker" value="" maxlength=255 autocomplete="off" required >
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="nama_satker" name="nama_satker" maxlength=255 autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Singkatan</label>
                            <input type="text" class="form-control" id="singkatan" name="singkatan" maxlength=255 autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>NPWP</label>
                            <input type="text" class="form-control" id="npwp_satker" name="npwp_satker" maxlength=255 autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <input type="text" class="form-control" id="alamat_satker" name="alamat_satker" maxlength=255 autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>No. Telp</label>
                            <input type="text" class="form-control" id="telp" name="telp" maxlength=255 autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" maxlength=255 autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Kota</label>
                            <input type="text" class="form-control" id="kota" name="kota" maxlength=255 autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Propinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" maxlength=255 autocomplete="off" required>
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