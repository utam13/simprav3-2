<div id="rincian_belanja" class="rincian_belanja-area area-padding">
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
                    <div class="box box-primary box-solid" id="rb">
                        <div class="box-header with-border">
                            <form method="post" action="<?= base_url();?>epurchasing">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar ePurchasing 
                                <select class="box-header-select-year" id="thn_epurchasing" name="thn_epurchasing" onchange="submit()">
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
                            <div class="row aligncenter">
                                <form method="post" action="<?= base_url();?>epurchasing/index/<?= "$thn";?>#rincian_belanja">
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
                                        <input type="text" class="form-control" id="cari" name="cari" placeholder="Satker" value="">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                            <a href="<?= base_url();?>laporan/proses/8/<?= "$thn/-/-/$getcari";?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                        </span>
                                    </div>
                                </div>
                                </form>

                                <div class="col-md-12 table-responsive no-padding">
                                    <table class="table table-striped table-hover table-bordered table-sm table-normal">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" nowrap class="text-center">No</th>
                                                <th scope="col" nowrap class="text-center">Kode RUP Paket</th>
                                                <th scope="col" nowrap class="text-center">Satker</th>
                                                <th scope="col" nowrap class="text-center">Kegiatan</th>
                                                <th scope="col" nowrap class="text-center">Nama Paket</th>
                                                <th scope="col" nowrap class="text-center">PPK</th>
                                                <th scope="col" nowrap class="text-center">Sumber Dana</th>
                                                <th scope="col" nowrap class="text-center">Pagu</th>
                                                <th scope="col" nowrap class="text-center">Nomor Paket</th>
                                                <th scope="col" nowrap class="text-center">Jenis Katalog</th>
                                                <th scope="col" nowrap class="text-center">Nama Komoditas</th>
                                                <th scope="col" nowrap class="text-center">Harga Satuan</th>
                                                <th scope="col" nowrap class="text-center">Kuantitas</th>
                                                <th scope="col" nowrap class="text-center">Ongkos Kirim</th>
                                                <th scope="col" nowrap class="text-center">Total Harga</th>
                                                <th scope="col" nowrap class="text-center">Nama Penyedia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $hasil = json_decode($daftar);
                                            foreach ($hasil as $d) {
                                            ?>
                                            <tr>
                                                <td scope="col" nowrap class="text-center"><?= $d->no;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                                                <td scope="col" nowrap class="text-left"><?= $d->satker;?></td>
                                                <td scope="col" nowrap class="text-left"><?= $d->kegiatan;?></td>
                                                <td scope="col" nowrap class="text-left"><?= $d->nama_paket;?></td>
                                                <td scope="col" nowrap class="text-left"><?= $d->ppk;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->sumber_dana;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->pagu;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->nomor_paket;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->jenis_katalog;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->nama_komoditas;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->harga_satuan;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->kuantitas;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->ongkos_kirim;?></td>
                                                <td scope="col" nowrap class="text-center"><?= $d->total_harga;?></td>
                                                <td scope="col" nowrap class="text-left"><?= $d->penyedia;?></td>
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
                                        <li class="page-item"><a href="<?= base_url(); ?>epurchasing/index/<?= "$thn/1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url(); ?>epurchasing/index/<?= "$thn/$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
                                        <?
                                            }

                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                if ($page == $i) {
                                                    $link_active = "";
                                                    $link_color = "class='page-item disabled'";
                                                } else {
                                                    $link_active = base_url() . "epurchasing/index/$thn/$i/$limit/$getcari";
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
                                        <li class="page-item"><a href="<?= base_url(); ?>epurchasing/index/<?= "$thn/$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url(); ?>epurchasing/index/<?= "$thn/$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
                                        <? } ?>
                                    </ul>
                                    <? } ?>
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