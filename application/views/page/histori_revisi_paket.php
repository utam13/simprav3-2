<div id="rup_histori" class="rup_histori-area area-padding">
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
                            <form method="post" action="<?= base_url();?>rup/histori_revisi_paket">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Histori Revisi Paket 
                                <select class="box-header-select-year" id="thn_histori" name="thn_histori" onchange="submit()">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        $pilih = $thn == $i ? "selected" : "";
                                        echo "<option value='$i' $pilih >$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                            </form>
                        </div>
                        <div class="box-body">
                            <form action="<?= base_url();?>rup/histori_revisi_paket/<?= "$thn";?>#rup_histori" method="post">
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
                                    <input type="text" class="form-control" id="cari" name="cari" placeholder="Kode Paket Lama/Baru" value="">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        <a href="<?= base_url();?>laporan/proses/20/<?= "$thn/-/-/$getcari";?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    </span>
                                </div>
                            </div>
                            </form>

                            <div class="col-md-12 table-responsive no-padding">
                                <table class="table table-striped table-hover table-bordered table-sm table-normal">
                                    <thead class="bg-light-blue">
                                        <tr>
                                            <th scope="col" nowrap class="text-center">No</th>
                                            <th scope="col" nowrap class="text-center">OPD</th>
                                            <th scope="col" nowrap class="text-center">Kode Lama RUP</th>
                                            <th scope="col" nowrap class="text-center">Nama Lama RUP</th>
                                            <th scope="col" nowrap class="text-center">Kode Baru RUP</th>
                                            <th scope="col" nowrap class="text-center">Nama Baru RUP</th>
                                            <th scope="col" nowrap class="text-center">Alasan Perubahan</th>
                                            <th scope="col" nowrap class="text-center">Waktu Perubahan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $hasil = json_decode($histori_revisi);
                                        foreach ($hasil as $h) {
                                        ?>
                                        <tr>
                                            <td scope="col" class="text-center"><?= $h->no;?></td>
                                            <td scope="col" nowrap class="text-left"><?= $h->nama_satker;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $h->kode_paket_lama;?></td>
                                            <td scope="col" nowrap class="text-left"><?= $h->nama_lama;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $h->kode_paket_baru;?></td>
                                            <td scope="col" nowrap class="text-left"><?= $h->nama_baru;?></td>
                                            <td scope="col" nowrap class="text-left"><?= $h->alasan_kajiulang;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $h->waktu;?></td>
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
                                    <li class="page-item"><a href="<?= base_url(); ?>rup/histori_revisi_paket/<?= "$thn/1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
                                    <li class="page-item"><a href="<?= base_url(); ?>rup/histori_revisi_paket/<?= "$thn/$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
                                    <?
                                        }

                                        for ($i = $start_number; $i <= $end_number; $i++) {
                                            if ($page == $i) {
                                                $link_active = "";
                                                $link_color = "class='page-item disabled'";
                                            } else {
                                                $link_active = base_url() . "rup/histori_revisi_paket/$thn/$i/$limit/$getcari";
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
                                    <li class="page-item"><a href="<?= base_url(); ?>rup/histori_revisi_paket/<?= "$thn/$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
                                    <li class="page-item"><a href="<?= base_url(); ?>rup/histori_revisi_paket/<?= "$thn/$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
                                    <? } ?>
                                </ul>
                                <? } ?>
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
                            <h3 class="box-title text-light">
                                <i class="fa fa-info-circle"></i> Informasi Detail Paket Rencana Umum Pengadaan
                            </h3>
                            <i class="close fa fa-times" onclick="init()"></i>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <a href="#" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right" style="margin-bottom:8px;"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                            <table class="table table-sm table-striped" id="table_detail">
                                <tbody>
                                    <tr>
                                        <th scope="row" nowrap class="font-weight-bold" style="width:1px;">Kode RUP</th>
                                        <td class="font-weight-bold">tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Nama Paket</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Nama KLPD</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Satuan Kerja</th>
                                        <td>tes</td>
                                    </tr>

                                    <!-- khusus penyedia -->

                                    <tr>
                                        <th scope="row" nowrap>Nama Program</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Nama Kegiatan</th>
                                        <td>tes</td>
                                    </tr>

                                    <!-- end -->
                                    <!-- khusus swakelola -->

                                    <tr>
                                        <th scope="row" nowrap>Tipe Swakelola</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Penyelenggaran Swakelola</th>
                                        <td>Tes</td>
                                    </tr>

                                    <!-- end -->

                                    <tr>
                                        <th scope="row" nowrap>Tahun Anggaran</th>
                                        <td>2021</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Provinsi</th>
                                        <td>Kalimantan Timur</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Kabupaten/Kota</th>
                                        <td>Balikpapan (Kota)</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Detail Lokasi</th>
                                        <td>Tes</td>
                                    </tr>

                                    <!-- khusus penyedia -->

                                    <tr>
                                        <th scope="row" nowrap>Volume Pekerjaan</th>
                                        <td>Tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Uraian Pekerjaan</th>
                                        <td>Tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Spesifikasi Pekerjaan</th>
                                        <td>Tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Usaha Kecil</th>
                                        <td><span class="badge badge-pill bg-green">Ya</span></td>
                                    </tr>

                                    <!-- end -->
                                    <!-- khusus swakelola -->

                                    <tr>
                                        <th scope="row" nowrap>Deskripsi</th>
                                        <td>tes</td>
                                    </tr>

                                    <!-- end -->

                                    <tr>
                                        <th scope="row" nowrap>Sumber Dana</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>MAK</th>
                                        <td>1.01.011.01.01.2.01.07.5.1.02.01.01.0024</td>
                                    </tr>

                                    <!-- khusus penyedia -->

                                    <tr>
                                        <th scope="row" nowrap>Jenis Pengadaan</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Total Pagu</th>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Metode Pemilihan</th>
                                        <td>tes</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Pemanfaatan Barang/Jasa</th>
                                        <td>
                                            <span class="pr-5">Mulai: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Jadwal Pelaksanaan Kontrak</th>
                                        <td>
                                            <span class="pr-5">Mulai: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Jadwal Pemilihan Penyedia</th>
                                        <td>
                                        <span class="pr-5">Mulai: tanggal</span>  <span class="pl-5">Akhir: tanggal</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" nowrap>Tanggal Perbarui Paket</th>
                                        <td>tanggal</td>
                                    </tr>

                                    <!-- end -->
                                    <!-- khusus swakelola -->

                                    <tr>
                                        <th scope="row" nowrap>Pelaksanaan Pekerjaan</th>
                                        <td>
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