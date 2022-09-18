<div class="card shadow rounded-lg mb-2">
    <h5 class="card-header bg-light-blue text-light"><i class="fas fa-table"></i>
        Daftar Penyedia</h5>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn bg-light-blue btn-sm" data-toggle="modal" data-target="#formpenyedia" onclick="tambah_penyedia('<?= base_url();?>penyedia/proses/1')"><i class="fas fa-plus"></i> Tambah</button>

                    <div class="float-right">
                        <form class="form-inline" method="post" action="<?= base_url();?>penyedia">
                            <div class="form-group">
                                <label class="mx-sm-3" for="kategori">Pencarian:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="<?= base_url();?>penyedia" class="btn bg-light-blue btn-sm" onclick="showloading()"><i class="fas fa-sync"></i></a>
                                    </div>
                                    <select class="form-control form-control-sm" name="kategori" id="kategori">
                                        <option value="kd_penyedia" <? if ($getkategori == "kd_penyedia") { echo "selected='selected'" ; }; ?> >Kode</option>
                                        <option value="nama_penyedia" <? if ($getkategori == "nama_penyedia") { echo "selected='selected'" ; }; ?> >Nama</option>
                                        <option value="npwp_penyedia" <? if ($getkategori == "npwp_penyedia") { echo "selected='selected'" ; }; ?> >NPWP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mx-sm-3">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" name="cari" id="cari" placeholder="Cari..." value="<?= $getcari;?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn bg-light-blue btn-sm"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?
                    extract($alert);
                    if ($kode_alert != "") {
                        ?>
                        <div class="alert <?= $jenisbox ?> alert-dismissible mt-4"  role="alert">
                            <?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </div>
                    <? } ?>
                </div>
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-hover table-bordered table-sm table-normal">
                        <thead class="bg-light-blue">
                            <tr>
                                <th scope="col" nowrap class="text-center">No.</th>
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
                                <th scope="col" nowrap class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            $hasil = json_decode($daftar);
                            foreach ($hasil as $d) {
                            ?>
                            <tr>
                                <td scope="col" class="text-center"><?= $d->no;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->kd_penyedia;?></td>
                                <td scope="col" nowrap class="text-left"><?= $d->nama_penyedia;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->bentuk_usaha;?></td>
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
                                <td scope="col" nowrap class="text-center">
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#formpenyedia" onclick="ambil_penyedia('<?= base_url();?>penyedia/proses/2','<?= $d->kd_penyedia;?>','<?= $d->nama_penyedia;?>','<?= $d->bentuk_usaha;?>','<?= $d->user_lpse;?>','<?= $d->npwp_penyedia;?>','<?= $d->alamat_penyedia;?>','<?= $d->kabupaten_kota;?>','<?= $d->provinsi;?>','<?= $d->email;?>','<?= $d->no_telp;?>','<?= $d->no_pkp;?>','<?= $d->lpse_terdaftar;?>','<?= $d->status_aktif_agregasi;?>')"><i class="fas fa-pencil-alt"></i></button>
                                <a href="<?= base_url();?>penyedia/proses/3/<?= $d->kd_penyedia;?>" class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data penyedia:\n<?= $d->nama_penyedia;?>\nLanjutkan proses ?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            <?}?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 mt-2">
                    <? if ($jumlah_page > 0) { ?>
                        <ul class="pagination float-right">
                            <? if ($page == 1) { ?>
                            <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fas fa-fast-backward"></i></a></li>
                            <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fas fa-step-backward"></i></a></li>
                            <? } else {
                                    $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                            <li class="page-item"><a href="<?= base_url();?>penyedia/index/1/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-fast-backward"></i></a></li>
                            <li class="page-item"><a href="<?= base_url();?>penyedia/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-step-backward"></i></a></li>
                            <?
                                }

                                for ($i = $start_number; $i <= $end_number; $i++) {
                                    if ($page == $i) {
                                        $link_active = "";
                                        $link_color = "class='page-item disabled'";
                                    } else {
                                        $link_active = base_url() . "penyedia/index/$i/$limit/$getkategori/$getcari";
                                        $link_color = "class='page-item'";
                                    }
                                ?>
                            <li <?= $link_color; ?>><a href="<?= $link_active; ?>" class="page-link" onclick="showloading()"><?= $i; ?></a></li>
                            <? }

                                if ($page == $jumlah_page) {
                                ?>
                            <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fas fa-step-forward"></i></a></li>
                            <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fas fa-fast-forward"></i></a></li>
                            <? } else {
                                    $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                            <li class="page-item"><a href="<?= base_url();?>penyedia/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-step-forward"></i></a></li>
                            <li class="page-item"><a href="<?= base_url();?>penyedia/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-fast-forward"></i></a></li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formpenyedia" tabindex="-1" aria-labelledby="formpenyediaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formpenyediaLabel">Formulir Penyedia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmpenyedia" nama="frmpenyedia" method="POST" action="" onsubmit="showloading()">
                <input type="hidden" id="user_lpse" name="user_lpse">
                <input type="hidden" id="awal" name="awal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="kode" class="col-sm-4 col-form-label">Kode</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kd_penyedia" name="kd_penyedia" value="" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_penyedia" name="nama_penyedia" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bentukusaha" class="col-sm-4 col-form-label">Bentuk Usaha</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="bentuk_usaha" name="bentuk_usaha" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="npwp" class="col-sm-4 col-form-label">NPWP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="npwp_penyedia" name="npwp_penyedia" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="telp" class="col-sm-4 col-form-label">Telp</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_telp" name="no_telp" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" id="email" name="email" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nopkp" class="col-sm-4 col-form-label">No. PKP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="no_pkp" name="no_pkp" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lpseterdaftar" class="col-sm-4 col-form-label">LPSE Terdaftar</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="lpse_terdaftar" name="lpse_terdaftar" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <label for="tglterdaftar" class="col-sm-4 col-form-label">Tgl. Terdaftar</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="tgl_terdaftar" name="tgl_terdaftar" autocomplete="off" required>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="alamat_penyedia" name="alamat_penyedia" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="kabkota" class="col-sm-4 col-form-label">Kabupaten/Kota</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="propinsi" class="col-sm-4 col-form-label">Propinsi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" maxlength=255 autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="form-group row">
                                <label for="tglterdaftar" class="col-sm-4 col-form-label">Tgl. Verifikasi</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control" id="tgl_verifikasi" name="tgl_verifikasi" autocomplete="off" required>
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <label for="statussikap" class="col-sm-5 col-form-label">Status Aktif Agregasi</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="status_aktif_agregasi" name="status_aktif_agregasi" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-light-blue">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>