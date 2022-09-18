<div class="card shadow rounded-lg mb-2">
    <h5 class="card-header bg-light-blue text-light"><i class="fas fa-table"></i>
        Daftar Pegawai</h5>
    <div class="card-body">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <button class="btn bg-light-blue btn-sm" data-toggle="modal" data-target="#formpegawai" onclick="ambil_pegawai('<?= base_url();?>pegawai/proses/1','','','','','','','','','','','','','','','','')"><i class="fas fa-plus"></i> Tambah</button>

                    <div class="float-right">
                        <form class="form-inline" method="post" action="<?= base_url();?>pegawai" onsubmit="showloading()">
                            <div class="form-group">
                                <label class="mx-sm-3">Pencarian:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="<?= base_url();?>pegawai" class="btn bg-light-blue btn-sm" onclick="showloading()"><i class="fas fa-sync"></i></a>
                                    </div>
                                    <select class="form-control form-control-sm" name="kategori" id="kategori">
                                        <option value="nip_pegawai" <? if ($getkategori == "nip") { echo "selected='selected'" ; }; ?> >NIP</option>
                                        <option value="nama_pegawai" <? if ($getkategori == "nama") { echo "selected='selected'" ; }; ?> >Nama</option>
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
                            <div class="form-group">
                                <div class="input-group input-group-sm flex-nowrap">
                                    <select class="form-control" id="limitpage" name="limitpage" onchange="submit()">
                                        <option value="20" <? if ($limit==20) { echo "selected='selected'" ; }; ?> >20
                                        </option>
                                        <option value="40" <? if ($limit==40) { echo "selected='selected'" ; }; ?> >40
                                        </option>
                                        <option value="60" <? if ($limit==60) { echo "selected='selected'" ; }; ?> >60
                                        </option>
                                        <option value="80" <? if ($limit==80) { echo "selected='selected'" ; }; ?> >80
                                        </option>
                                        <option value="100" <? if ($limit==100) { echo "selected='selected'" ; }; ?> >100
                                        </option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="addon-wrapping">baris</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?
                    extract($alert);
                    if ($kode_alert != "") {
                    ?>                
                        <div class="alert <?= $jenisbox ?> alert-dismissible mt-3"  role="alert">
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
                                <th scope="col" nowrap class="text-center">NIP</th>
                                <th scope="col" nowrap class="text-center">Nama</th>
                                <th scope="col" nowrap class="text-center">Jabatan</th>
                                <th scope="col" nowrap class="text-center">Satker</th>
                                <th scope="col" nowrap class="text-center">Email</th>
                                <th scope="col" nowrap class="text-center">No. SK Pegawai</th>
                                <th scope="col" nowrap class="text-center">No. SK Role</th>
                                <th scope="col" nowrap class="text-center">Tgl. SK Role</th>
                                <th scope="col" nowrap class="text-center">Role</th>
                                <th scope="col" nowrap class="text-center">Level Akses</th>
                                <th scope="col" nowrap class="text-center">User Name</th>
                                <th scope="col" nowrap class="text-center">Password</th>
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
                                <td scope="col" nowrap class="text-center"><?= $d->kd_pegawai;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->nip_pegawai;?></td>
                                <td scope="col" nowrap class="text-left"><?= $d->nama_pegawai;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->jabatan;?></td>
                                <td scope="col" nowrap class="text-left"><?= $d->nama_satker;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->email_ppk;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->no_sk_pegawai;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->no_sk_role;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->tgl_sk_role;?></td>
                                <td scope="col" nowrap class="text-left"><?= $d->role;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->level;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->username;?></td>
                                <td scope="col" nowrap class="text-center"><?= $d->password;?></td>
                                <td scope="col" nowrap class="text-center">
                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#formpegawai" onclick="ambil_pegawai('<?= base_url();?>pegawai/proses/2','<?= $d->kd_pegawai?>','<?= $d->nip_pegawai?>','<?= $d->nama_pegawai?>','<?= $d->jabatan?>','<?= $d->kd_satker;?>','<?= $d->email_ppk;?>','<?= $d->no_sk_pegawai;?>','<?= $d->no_sk_role;?>','<?= $d->tgl_awal;?>','<?= $d->tgl_akhir;?>','<?= $d->status_ppk;?>','<?= $d->status_pokja;?>','<?= $d->status_pejabatpengadaan;?>','<?= $d->kd_level;?>','<?= $d->username;?>','<?= $d->password;?>')"><i class="fas fa-pencil-alt"></i></button>
                                <a href="<?= base_url();?>pegawai/proses/3/<?= $d->kd_pegawai;?>" class="btn btn-danger btn-sm" onclick="return confirm('Menghapus data pegawai:\n<?= $d->nip_pegawai;?>\n<?= $d->nama_pegawai;?>\nLanjutkan proses ?')"><i class="fas fa-trash"></i></a>
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
                            <li class="page-item"><a href="<?= base_url();?>pegawai/index/1/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-fast-backward"></i></a></li>
                            <li class="page-item"><a href="<?= base_url();?>pegawai/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-step-backward"></i></a></li>
                            <?
                                }

                                for ($i = $start_number; $i <= $end_number; $i++) {
                                    if ($page == $i) {
                                        $link_active = "";
                                        $link_color = "class='page-item disabled'";
                                    } else {
                                        $link_active = base_url() . "pegawai/index/$i/$limit/$getkategori/$getcari";
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
                            <li class="page-item"><a href="<?= base_url();?>pegawai/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-step-forward"></i></a></li>
                            <li class="page-item"><a href="<?= base_url();?>pegawai/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fas fa-fast-forward"></i></a></li>
                            <? } ?>
                        </ul>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formpegawai" tabindex="-1" aria-labelledby="formpegawaiLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formpegawaiLabel">Formulir Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmpegawai" name="frmpegawai" method="POST" action="" onsubmit="showloading()">
                <input type="hidden" id="awal" name="awal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nip" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="kode" name="kode" maxlength=150 autocomplete="off" required readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nip" class="col-sm-3 col-form-label">NIP</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nip" name="nip" maxlength=150 autocomplete="off" required readonly />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" maxlength=150 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" maxlength=150 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="satker" class="col-sm-3 col-form-label">Satker</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="satker" id="satker">
                                        <option value="">Pilih</option>
                                        <?foreach ($satker as $s) {
                                            echo "<option value='".$s->kd_satker."'>".$s->nama_satker."</option>";
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" maxlength=150 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">No. SK Pegawai</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sk_pegawai" name="sk_pegawai" maxlength=150 autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nosk" class="col-sm-3 col-form-label">No. SK Role</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sk_role" name="sk_role" maxlength=150 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tglsk" class="col-sm-3 col-form-label">Tgl. SK Role</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9 mt-1">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_ppk" name="role_ppk" value="ya">
                                        <label class="form-check-label" for="role_ppk">PPK</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_pokja" name="role_pokja" value="ya">
                                        <label class="form-check-label" for="role_pokja">Pokja</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="role_pengadaan" name="role_pengadaan" value="ya">
                                        <label class="form-check-label" for="role_pengadaan">Pengadaan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="levelakses" class="col-sm-3 col-form-label">Level Akses</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="levelakses" id="levelakses">
                                        <option value="">User</option>
                                        <option value="1">Administrator</option>
                                        <option value="2">Supervisor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">User Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="userakses" name="userakses" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control" id="userpass" name="userpass" autocomplete="new-password" required>
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