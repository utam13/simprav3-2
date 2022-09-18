<div id="personil" class="personil-area area-padding">
    <div class="container body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline text-center">
                    <h2><?= $halaman;?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Detail Paket Personil <?= strtoupper($kelompok);?> (<?= "$nip - $nama";?>)
                            </h3>
                            <i class="close fa fa-times" onclick="location.href='<?= base_url();?>monitoring/personil/<?= $thn;?>'"></i>
                        </div>
                        <div class="box-body">
                        <div class="tab-menu">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li <?= $status == "aktif" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/aktif";?>#divider">Aktif</a>
                                    </li>
                                    <li <?= $status == "batal" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/batal";?>#divider">Batal</a>
                                    </li>
                                    <li <?= $status == "gagal" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/gagal";?>#divider">Gagal</a>
                                    </li>
                                    <li <?= $status == "selesai" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/selesai";?>#divider">Selesai</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="aktif">
                                    <div class="tab-inner">
                                        <div class="event-content" id="aktif_body">
                                            <div class="row aligncenter">
                                                <form method="post" action="<?= base_url();?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/$status";?>#divider">
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
                                                        <input type="text" class="form-control" id="cari" name="cari" placeholder="Nama Paket" value="">
                                                        <span class="input-group-btn">
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                            <a href="<?= base_url();?>laporan/proses/36/<?= "$thn/-/$status-$nip-$nama-$kelompok/$getcari";?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                </form>

                                                <div class="col-md-12 table-responsive no-padding">
                                                    <table class="table table-striped table-hover table-bordered table-sm table-normal">
                                                        <thead class="bg-light-blue">
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">No</th>
                                                                <th scope="col" nowrap class="text-center">Kode Paket</th>
                                                                <th scope="col" nowrap class="text-center">Satker</th>
                                                                <th scope="col" nowrap class="text-center">Nama Paket</th>
                                                                <th scope="col" nowrap class="text-center">Sumber Dana</th>
                                                                <th scope="col" nowrap class="text-center">Pagu</th>
                                                                <th scope="col" nowrap class="text-center">Nilai Kontrak</th>
                                                                <th scope="col" nowrap class="text-center">Penyedia</th>
                                                                <th scope="col" nowrap class="text-center">Status Pelaksanaan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?
                                                            $hasil = json_decode($detail);
                                                            foreach ($hasil as $d) {
                                                            ?>
                                                            <tr>
                                                                <td scope="col" class="text-center"><?= $d->no;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $d->kode_paket;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $d->singkatan;?></td>
                                                                <td scope="col" nowrap class="text-left">
                                                                    <?if($d->jml_teks > 150){ echo $d->nama_paket_cut;?>
                                                                    <button class="btn bg-light-blue btn-sm" onclick="alert('<?= $d->nama_paket;?>')">detail</button>
                                                                    <?}else{ echo $d->nama_paket;}?>
                                                                </td>
                                                                <td scope="col" nowrap class="text-center"><?= $d->sumber_dana;?></a></td>
                                                                <td scope="col" nowrap class="text-center"><?= $d->pagu;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $d->nilai_kontrak;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $d->penyedia;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $d->status_pelaksanaan;?></td>
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
                                                        <li class="page-item"><a href="<?= base_url(); ?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/$status/1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
                                                        <li class="page-item"><a href="<?= base_url(); ?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/$status/$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
                                                        <?
                                                            }

                                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                                if ($page == $i) {
                                                                    $link_active = "";
                                                                    $link_color = "class='page-item disabled'";
                                                                } else {
                                                                    $link_active = base_url() . "monitoring/paket_personil/$thn/$kelompok/$nip/$status/$i/$limit/$getcari";
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
                                                        <li class="page-item"><a href="<?= base_url(); ?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/$status/$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
                                                        <li class="page-item"><a href="<?= base_url(); ?>monitoring/paket_personil/<?= "$thn/$kelompok/$nip/$status/$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
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
        </div>
    </div>
</div>