<div id="rup-rekapitulasi" class="rup-rekapitulasi-area area-padding">
    <div class="container body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline text-center">
                    <h2><?= $halaman;?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="div-daftar">
                <div class="row">
                    <div class="box box-primary box-solid" id="daftar">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light daftar-title">
                                <i class="fa fa-table"></i> Daftar Paket <?= ucwords($kelompok)." | $kode_satker - $nama_satker | Tahun $thn";?>
                            </h3>
                            <i class="close fa fa-times" onclick="location.href='<?= base_url();?>rup/rekapitulasi'"></i>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <div class="tab-menu">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li <?= $kelompok == "penyedia" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>rup/paket/<?= "$thn/$kode_satker/penyedia";?>#rup-rekapitulasi" >Penyedia</a>
                                    </li>
                                    <li <?= $kelompok == "swakelola" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>rup/paket/<?= "$thn/$kode_satker/swakelola";?>#rup-rekapitulasi" >Swakelola</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="tab-inner">
                                        <div class="event-content">
                                            <div class="row">
                                                    <form method="post" action="<?= base_url();?>rup/paket/<?= "$thn/$kode_satker/$kelompok";?>#rup-rekapitulasi">
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm search-group-row">
                                                            <select class="form-control" id="limitpage" name="limitpage" onchange="submit()">
                                                                <option value="20" <?= $limit == "20" ? "selected":"";?> >20</option>
                                                                <option value="40" <?= $limit == "40" ? "selected":"";?> >40</option>
                                                                <option value="60" <?= $limit == "60" ? "selected":"";?> >60</option>
                                                                <option value="80" <?= $limit == "80" ? "selected":"";?> >80</option>
                                                                <option value="100" <?= $limit == "100" ? "selected":"";?> >100</option>
                                                            </select>
                                                            <span class="input-group-addon">baris</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-sm search-group">
                                                            <span class="input-group-addon">Cari</span>
                                                            <input type="text" class="form-control" id="cari" name="cari" placeholder="Nama Kegiatan" value="">
                                                            <span class="input-group-btn">
                                                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                                <a href="<?= base_url();?>laporan/proses/18/<?= "$thn/$kode_satker/$kelompok/$getcari";?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="col-md-12 table-responsive no-padding">
                                                    <table class="table table-striped table-hover table-bordered table-sm table-normal">
                                                        <thead class="bg-light-blue">
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">No</th>
                                                                <th scope="col" nowrap class="text-center">#</th>
                                                                <th scope="col" nowrap class="text-center">Nama Paket</th>
                                                                <th scope="col" nowrap class="text-center">Nama Kegiatan</th>
                                                                <th scope="col" nowrap class="text-center">Pagu</th>
                                                                <?switch ($kelompok) {
                                                                    case 'penyedia':
                                                                ?>
                                                                <th scope="col" nowrap class="text-center">Metode Pemilihan Penyedia</th>
                                                                <th scope="col" nowrap class="text-center">Jenis Pengadaan</th>
                                                                <?
                                                                        break;
                                                                    case 'swakelola':
                                                                ?>
                                                                <th scope="col" nowrap class="text-center">Tipe Swakelola</th>
                                                                <?
                                                                        break;
                                                                }?>
                                                                <th scope="col" nowrap class="text-center">Sumber Dana</th>
                                                                <th scope="col" nowrap class="text-center">Kode RUP</th>
                                                                <th scope="col" nowrap class="text-center">Waktu Pemilihan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?
                                                            $hasil = json_decode($paket);
                                                            foreach ($hasil as $p) {
                                                            ?>
                                                            <tr>
                                                                <td scope="col" class="text-center"><?= $p->no;?></td>
                                                                <td scope="col" class="text-center"><?= $p->btn;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $p->nama_paket;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $p->nama_kegiatan;?></td>
                                                                <td scope="col" nowrap class="text-right"><?= $p->pagu;?></td>
                                                                <?switch ($kelompok) {
                                                                    case 'penyedia':
                                                                ?>
                                                                <td scope="col" nowrap class="text-center"><?= $p->metode_pemilihan;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $p->jenis_pengadaan;?></td>
                                                                <?
                                                                        break;
                                                                    case 'swakelola':
                                                                ?>
                                                                <td scope="col" nowrap class="text-center"><?= $p->tipe_swakelola;?></td>
                                                                <?
                                                                        break;
                                                                }?>
                                                                <td scope="col" nowrap class="text-center"><?= $p->sumber_dana;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $p->kode_rup;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $p->waktu;?></td>
                                                            </tr>
                                                            <?}?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12">
                                                    <? if ($jumlah_page > 0) { ?>
                                                    <ul class="pagination">
                                                        <? if ($page == 1) { ?>
                                                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                                                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                                                        <? } else {
                                                                $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                                        <li class="page-item"><a href="<?= base_url(); ?>rup/paket/<?= "$thn/$kode_satker/$kelompok/1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
                                                        <li class="page-item"><a href="<?= base_url(); ?>rup/paket/<?= "$thn/$kode_satker/$kelompok/$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
                                                        <?
                                                            }

                                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                                if ($page == $i) {
                                                                    $link_active = "";
                                                                    $link_color = "class='page-item disabled'";
                                                                } else {
                                                                    $link_active = base_url() . "rup/paket/$thn/$kode_satker/$kelompok/$i/$limit/$getcari";
                                                                    $link_color = "class='page-item'";
                                                                }
                                                            ?>
                                                        <li <?= $link_color; ?>><a href="<?= $link_active; ?>#divider" class="page-link"><?= $i; ?></a></li>
                                                        <? }

                                                            if ($page == $jumlah_page) {
                                                            ?>
                                                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-forward"></i></a></li>
                                                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-forward"></i></a></li>
                                                        <? } else {
                                                                $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                                                        <li class="page-item"><a href="<?= base_url(); ?>rup/paket/<?= "$thn/$kode_satker/$kelompok/$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
                                                        <li class="page-item"><a href="<?= base_url(); ?>rup/paket/<?= "$thn/$kode_satker/$kelompok/$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
                                                        <? } ?>
                                                    </ul>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="div-detail">
                <div class="row">
                    <div class="box box-primary box-solid" id="detail">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light detail-title">
                                <i class="fa fa-info-circle"></i> Informasi Detail Paket Rencana Umum Pengadaan <?= ucwords($kelompok)." | $kode_satker - $nama_satker | Tahun $thn";?>
                            </h3>
                            <i class="close fa fa-times" onclick="init()"></i>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <a href="#" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right" style="margin-bottom:8px;"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                            <table class="table table-sm table-striped" id="table_detail">
                                <tbody>
                                    <tr>
                                        <th scope="row text-bold" nowrap style="width:1px;">Kode RUP</th>
                                        <td id="kode_rup">tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Nama Paket</th>
                                        <td id="nama_paket">tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Nama KLPD</th>
                                        <td id="nama_klpd">tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Satuan Kerja</th>
                                        <td id="satuan_kerja">tes</td>
                                    </tr>

                                    <!-- khusus penyedia -->

                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Nama Program</th>
                                        <td id="nama_program">tes</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Nama Kegiatan</th>
                                        <td id="nama_kegiatan">tes</td>
                                    </tr>

                                    <!-- end -->
                                    <!-- khusus swakelola -->

                                    <tr class="row-swakelola">
                                        <th scope="row" nowrap>Tipe Swakelola</th>
                                        <td id="tipe_swakelola">tes</td>
                                    </tr>
                                    <tr class="row-swakelola">
                                        <th scope="row" nowrap>Penyelenggaran Swakelola</th>
                                        <td id="penyelenggara_swakelola">Tes</td>
                                    </tr>

                                    <!-- end -->

                                    <tr>
                                        <th scope="row" nowrap>Tahun Anggaran</th>
                                        <td id="tahun_anggaran">2021</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Provinsi</th>
                                        <td id="provinsi">Kalimantan Timur</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Kabupaten/Kota</th>
                                        <td id="kabupaten_kota">Balikpapan (Kota)</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Detail Lokasi</th>
                                        <td id="detail_lokasi">Tes</td>
                                    </tr>

                                    <!-- khusus penyedia -->

                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Volume Pekerjaan</th>
                                        <td id="volume_pekerjaan">Tes</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Uraian Pekerjaan</th>
                                        <td id="uraian_pekerjaan">Tes</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Spesifikasi Pekerjaan</th>
                                        <td id="spesifikasi_pekerjaan">Tes</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Usaha Kecil</th>
                                        <td id="usaha_kecil"><span class="badge badge-pill bg-green">Ya</span></td>
                                    </tr>

                                    <!-- end -->
                                    <!-- khusus swakelola -->

                                    <tr class="row-swakelola">
                                        <th scope="row" nowrap>Deskripsi</th>
                                        <td id="deskripsi">tes</td>
                                    </tr>

                                    <!-- end -->

                                    <tr>
                                        <th scope="row" nowrap>Sumber Dana</th>
                                        <td id="sumber_dana">tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>MAK</th>
                                        <td id="mak">1.01.011.01.01.2.01.07.5.1.02.01.01.0024</td>
                                    </tr>

                                    <!-- khusus penyedia -->

                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Jenis Pengadaan</th>
                                        <td id="jenis_pengadaan">tes</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Total Pagu</th>
                                        <td id="total_pagu">0</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Metode Pemilihan</th>
                                        <td id="metode_pemilihan">tes</td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Pemanfaatan Barang/Jasa</th>
                                        <td id="pemanfaatan">
                                            <span class="pr-5">Mulai: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Jadwal Pelaksanaan Kontrak</th>
                                        <td id="jadwal_kontrak">
                                            <span class="pr-5">Mulai: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Jadwal Pemilihan Penyedia</th>
                                        <td id="jadwal_penyedia">
                                            <span class="pr-5">Mulai: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>
                                    <tr class="row-penyedia">
                                        <th scope="row" nowrap>Tanggal Perbarui Paket</th>
                                        <td id="tanggal">tanggal</td>
                                    </tr>

                                    <!-- end -->
                                    <!-- khusus swakelola -->

                                    <tr class="row-swakelola">
                                        <th scope="row" nowrap>Pelaksanaan Pekerjaan</th>
                                        <td id="pelaksanaan">
                                            <span class="pr-5">Awal: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>

                                    <!-- end -->
                                </tbody>
                            </table>
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>