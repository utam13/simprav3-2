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
                            <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formpegawai" onclick="ambil_pegawai('<?= base_url();?>pegawai/proses/1','','','','','','','','','','','','','','','','')"><i class="fa fa-plus"></i> Tambah Pegawai</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>pegawai" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian:</label>
                                    <input type="text" class="form-control input-sm" name="cari" required autocomplete="off" value="" placeholder="NIP atau Nama Pegawai" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>pegawai" class="btn bg-purple btn-sm" onclick="showloading()">Segarkan</a>
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
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#formpegawai" onclick="ambil_pegawai('<?= base_url();?>pegawai/proses/2','<?= $d->kd_pegawai?>','<?= $d->nip_pegawai?>','<?= $d->nama_pegawai?>','<?= $d->jabatan?>','<?= $d->kd_satker;?>','<?= $d->email_ppk;?>','<?= $d->no_sk_pegawai;?>','<?= $d->no_sk_role;?>','<?= $d->tgl_awal;?>','<?= $d->tgl_akhir;?>','<?= $d->status_ppk;?>','<?= $d->status_pokja;?>','<?= $d->status_pejabatpengadaan;?>','<?= $d->kd_level;?>','<?= $d->username;?>','<?= $d->password;?>')"><i class="fa fa-pencil"></i></a>
                                        <a href="<?= base_url();?>pegawai/proses/3/<?= $d->kd_pegawai;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus data pegawai:\n<?= $d->nip_pegawai;?>\n<?= $d->nama_pegawai;?>\nLanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                    </td>
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
                                <li class="page-item"><a href="<?= base_url();?>pegawai/index/1/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>pegawai/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                <?
                                    }

                                    for ($i = $start_number; $i <= $end_number; $i++) {
                                        if ($page == $i) {
                                            $link_active = "";
                                            $link_color = "class='page-item disabled'";
                                        } else {
                                            $link_active = base_url() . "pegawai/index/$i/$limit/$getcari";
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
                                <li class="page-item"><a href="<?= base_url();?>pegawai/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>pegawai/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
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
    <div class="modal fade" id="formpegawai" tabindex="-1" aria-labelledby="formpegawaiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formpegawaiLabel">Formulir Pegawai</h4>
                </div>
                <form id="frmpegawai" name="frmpegawai" method="POST" action="" onsubmit="showloading()">
                    <input type="hidden" id="nip_awal" name="nip_awal">
                    <input type="hidden" id="username_awal" name="username_awal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group sr-only">
                                    <label>Kode</label>
                                    <input type="text" class="form-control" id="kode" name="kode" maxlength=150 autocomplete="off" required readonly />
                                </div>
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" maxlength=150 autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" maxlength=150 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control" id="jabatan" name="jabatan" maxlength=150 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Satker</label>
                                    <select class="form-control" name="satker" id="satker">
                                        <option value="">Pilih</option>
                                        <?foreach ($satker as $s) {
                                            echo "<option value='".$s->kd_satker."'>".$s->nama_satker."</option>";
                                        }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" id="email" name="email" maxlength=150 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>No. SK Pegawai</label>
                                    <input type="text" class="form-control" id="sk_pegawai" name="sk_pegawai" maxlength=150 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. SK Role</label>
                                    <input type="text" class="form-control" id="sk_role" name="sk_role" maxlength=150 autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Tgl. SK Role</label>
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input type="date" class="form-control" id="tgl_awal" name="tgl_awal" >
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="margin-right:25px;">Role</label>
                                    <label>
                                        <input type="checkbox" id="role_ppk" name="role_ppk" value="ya">
                                        PPK
                                    </label>
                                    <label>
                                        <input type="checkbox" id="role_pokja" name="role_pokja" value="ya">
                                        Pokja
                                    </label>
                                    <label>
                                        <input type="checkbox" id="role_pengadaan" name="role_pengadaan" value="ya">
                                        Pengadaan
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>Level Akses</label>
                                    <select class="form-control" name="levelakses" id="levelakses">
                                        <option value="0">User</option>
                                        <option value="1">Administrator</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" class="form-control" id="userakses" name="userakses" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="userpass" name="userpass" autocomplete="new-password" required>
                                </div>
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