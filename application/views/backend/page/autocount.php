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
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Count & Populate
                        </h3>
                    </div>
                    <form id="frm_autocount" name="frm_autocount" method="post" action="<?= base_url(); ?>autocount/proses" onsubmit="showloading()">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Jenis Data</label>
                                <select class="form-control" name="jenis" id="jeniscount" required >
                                    <option value="">Pilih</option>
                                    <option value="grafik_belanja_pengadaan">Grafik Belanja Pengadaan</option> <!-- hanya tahun -->
                                    <option value="grafik_nontender">Grafik Non Tender</option> <!-- hanya tahun -->
                                    <option value="grafik_rup_penyedia">Grafik RUP Penyedia</option> <!-- hanya tahun -->
                                    <option value="grafik_rup_swakelola">Grafik RUP Swakelola</option> <!-- hanya tahun -->
                                    <option value="grafik_tender">Grafik Tender</option> <!-- hanya tahun -->
                                    <option value="mekanisme_lainnya">Mekanisme Lainnya</option> <!-- hanya tahun -->
                                    <option value="monitoring_penyedia">Monitoring Penyedia</option> <!-- kelompok(tender/nontender/pctnontender/pctswakelola/epurchasing) & tahun -->
                                    <option value="monitoring_personil">Monitoring Personil</option> <!-- kelompok(pokja/pp) & tahun -->
                                    <option value="monitoring_ppk">Monitoring PPK</option> <!-- kelompok(tender/nontender/pctnontender/pctswakelola/epurchasing) & tahun -->
                                    <option value="nontender_rekapitulasi">Non Tender Rekapitulasi</option> <!-- kelompok(metode/jenis/satker) & tahun -->
                                    <option value="realisasi_rekapitulasi">Realisasi Rekapitulasi</option> <!-- hanya tahun -->
                                    <option value="realisasi_triwulan">Realisasi Triwulan</option> <!-- hanya tahun -->
                                    <option value="rencana_paket_pengadaan">Rencana Paket Pengadaan</option> <!-- hanya tahun -->
                                    <option value="rincian_struktur_apbd">Rincian Struktur APBD</option> <!-- kelompok(murni/perubahan) & tahun -->
                                    <option value="rup_rekapitulasi">RUP Rekapitulasi</option> <!-- hanya tahun -->
                                    <option value="struktur_apbd">Struktur APBD</option>  <!-- kelompok(murni/perubahan) & tahun -->
                                    <option value="tender_rekapitulasi">Tender Rekapitulasi</option> <!-- kelompok(metode/jenis/satker) & tahun -->
                                </select>
                            </div>
                            <div class="form-group div-kelompok">
                                <label>Kelompok</label>
                                <select class="form-control" name="kelompok" id="kelompok" style="width:200px;" required >
                                    <option value="">Pilih</option>
                                    <option value="murni">Murni</option>
                                    <option value="perubahan">Perubahan</option>
                                </select>
                            </div>
                            <div class="form-group div-thn">
                                <label>Tahun Anggaran</label>
                                <select class="form-control" name="thn" id="thn" style="width:80px;" required >
                                    <option value="">Pilih</option>
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i' >$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>