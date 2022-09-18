<div id="rincian_paket" class="rincian_paket-area area-padding">
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
                    <div class="box box-primary box-solid" id="rincian">
                        <div class="box-header with-border">
                            <form method="post" action="<?= base_url();?>realisasi/rincian_paket">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Rincian Paket   
                                <select class="box-header-select-year" id="thn_rincian" name="thn_rincian" onchange="submit()">
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
                        <div class="tab-menu">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li <?= $kelompok == "tender" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>realisasi/rincian_paket/<?= "$thn/tender";?>#rincian_paket">Tender</a>
                                    </li>
                                    <li <?= $kelompok == "nontender" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>realisasi/rincian_paket/<?= "$thn/nontender";?>#rincian_paket">Non Tender</a>
                                    </li>
                                    <li <?= $kelompok == "pencatatan_nontender" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>realisasi/rincian_paket/<?= "$thn/pencatatan_nontender";?>#rincian_paket">Pencatatan Non Tender</a>
                                    </li>
                                    <li <?= $kelompok == "pencatatan_swakelola" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>realisasi/rincian_paket/<?= "$thn/pencatatan_swakelola";?>#rincian_paket">Pencatatan Swakelola</a>
                                    </li>
                                    <li <?= $kelompok == "epurchasing" ? "class='active'":"";?> >
                                        <a href="<?= base_url();?>realisasi/rincian_paket/<?= "$thn/epurchasing";?>#rincian_paket">ePurchasing</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <div class="tab-inner">
                                        <div class="event-content">
                                            <div class="row aligncenter">
                                                <form method="post" action="<?= base_url();?>realisasi/rincian_paket/<?= "$thn/$kelompok";?>#rincian_paket">
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
                                                            <a href="<?= base_url();?>laporan/proses/25/<?= "$thn/-/$kelompok/$getcari";?>" target="_blank" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                        </span>
                                                    </div>
                                                </div>
                                                </form>

                                                <div class="col-md-12 table-responsive no-padding">
                                                    <table class="table table-striped table-hover table-bordered table-sm table-normal">
                                                        <thead class="bg-light-blue">
                                                            <tr>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">No.</th>
                                                                <?if($kelompok == "tender"){?>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Kode Paket</th>
                                                                <?}?>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Kode RUP Paket</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Satker</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Kegiatan</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Nama Paket</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">PPK</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Pagu</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Nilai Kontrak</th>
                                                                <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                                                                <th scope="col" colspan=2 nowrap class="text-center">Realisasi Kontrak</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Penyedia</th>
                                                                <th scope="col" colspan=2 nowrap class="text-center">Sisa Kontrak</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center" style="width:300px;">Status Pelaksanaan</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center" style="width:300px;">Status Strategis</th>
                                                                <?}?>
                                                                
                                                                <?if(strpos($kelompok, "pencatatan") !== false){?>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Keterangan</th>
                                                                <?}?>
                                                            </tr>
                                                            <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">Rp</th>
                                                                <th scope="col" nowrap class="text-center">Persentase</th>
                                                                <th scope="col" nowrap class="text-center">Rp</th>
                                                                <th scope="col" nowrap class="text-center">Persentase</th>
                                                            </tr>
                                                            <?}?>
                                                        </thead>
                                                        <tbody>
                                                            <?
                                                            $hasil = json_decode($rincian);
                                                            foreach ($hasil as $r) {
                                                            ?>
                                                            <tr>
                                                                <td scope="col" class="text-center"><?= $r->no;?></td>
                                                                
                                                                <?if($kelompok == "tender"){?>
                                                                <td scope="col" nowrap class="text-center"><?= $r->kode_paket;?></td>
                                                                <?}?>
                                                                
                                                                <td scope="col" nowrap class="text-center"><?= $r->kode_rup_paket;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $r->nama_satker;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $r->kegiatan;?></td>
                                                                <td scope="col" nowrap class="text-left">
                                                                    <?if($r->jml_teks > 150){ echo $r->nama_paket_cut;?>
                                                                    <button class="btn bg-light-blue btn-sm" onclick="alert('<?= $r->nama_paket;?>')">detail</button>
                                                                    <?}else{ echo $r->nama_paket;}?>
                                                                </td>
                                                                <td scope="col" nowrap class="text-left"><?= $r->ppk;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $r->pagu;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $r->nilai_kontrak;?></td>
                                                                <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                                                                <td scope="col" nowrap class="text-center"><?= $r->realisasi_kontrak;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $r->realisasi_kontrak_persen;?></td>
                                                                <td scope="col" nowrap class="text-left"><?= $r->penyedia;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $r->sisa_kontrak;?></td>
                                                                <td scope="col" nowrap class="text-center"><?= $r->sisa_kontrak_persen;?></td>
                                                                <td scope="col" nowrap class="text-center">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="status_pelaksanaan[<?= $r->no;?>]" id="status_pelaksanaan_ya_<?= $r->no;?>" value="ya" <?= $r->status_pelaksanaan_ya;?> onclick="status('<?= $r->kode_utama;?>','<?= $kelompok;?>','nama_status_pekerjaan','ya')">
                                                                        <label class="form-check-label" for="status_pelaksanaan_ya_<?= $r->no;?>">Ya</label>
                                                                        <input class="form-check-input" type="radio" name="status_pelaksanaan[<?= $r->no;?>]" id="status_pelaksanaan_tidak_<?= $r->no;?>" value="tidak" <?= $r->status_pelaksanaan_tidak;?> onclick="status('<?= $r->kode_utama;?>','<?= $kelompok;?>','nama_status_pekerjaan','tidak')">
                                                                        <label class="form-check-label" for="status_pelaksanaan_tidak_<?= $r->no;?>">Tidak</label>
                                                                    </div>
                                                                </td>
                                                                <td scope="col" nowrap class="text-center">                                                                   
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="status_strategis[<?= $r->no;?>]" id="status_strategis_ya_<?= $r->no;?>" value="ya" <?= $r->status_strategis_ya;?> onclick="status('<?= $r->kode_utama;?>','<?= $kelompok;?>','status_paket_strategis','ya')">
                                                                        <label class="form-check-label" for="status_strategis_ya_<?= $r->no;?>">Ya</label>
                                                                        <input class="form-check-input" type="radio" name="status_strategis[<?= $r->no;?>]" id="status_strategis_tidak_<?= $r->no;?>" value="tidak" <?= $r->status_strategis_tidak;?>  onclick="status('<?= $r->kode_utama;?>','<?= $kelompok;?>','status_paket_strategis','tidak')">
                                                                        <label class="form-check-label" for="status_strategis_tidak_<?= $r->no;?>">Tidak</label>
                                                                    </div>
                                                                </td>
                                                                <?}?>

                                                                <?if(strpos($kelompok, "pencatatan") !== false){?>
                                                                <td scope="col" nowrap class="text-left"><?= $r->keterangan;?></td>
                                                                <?}?>
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
                                                        <li class="page-item"><a href="<?= base_url(); ?>realisasi/rincian_paket/<?= "$thn/$kelompok/1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
                                                        <li class="page-item"><a href="<?= base_url(); ?>realisasi/rincian_paket/<?= "$thn/$kelompok/$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
                                                        <?
                                                            }

                                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                                if ($page == $i) {
                                                                    $link_active = "";
                                                                    $link_color = "class='page-item disabled'";
                                                                } else {
                                                                    $link_active = base_url() . "realisasi/rincian_paket/$thn/$kelompok/$i/$limit/$getcari";
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
                                                        <li class="page-item"><a href="<?= base_url(); ?>realisasi/rincian_paket/<?= "$thn/$kelompok/$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
                                                        <li class="page-item"><a href="<?= base_url(); ?>realisasi/rincian_paket/<?= "$thn/$kelompok/$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
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