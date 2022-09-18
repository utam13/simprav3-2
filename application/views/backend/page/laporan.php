<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Laporan
                        </h3>
                    </div>
                    <form id="frm_laporan" name="frm_laporan" method="post" target="prosesdata" action="<?= base_url(); ?>laporan/proses">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Jenis Laporan</label>
                                <select class="form-control" name="jenis" id="jenis" required >
                                    <option value="">Pilih</option>
                                    <option value="1">Rekap Rencana Umum Pengadaan</option>
                                    <option value="2">Rekap Tender Per-Jenis/Metode</option>
                                    <option value="3">Rekap Tender Per-Satuan Kerja</option>
                                    <option value="4">Rincian Tender</option>
                                    <option value="5">Rekap Non Tender Per-Jenis/Metode</option>
                                    <option value="6">Rekap Non Tender Per-Satuan Kerja</option>
                                    <option value="7">Rincian Non Tender</option>
                                    <option value="8">Rincian ePurchasing</option>
                                    <option value="9">Rincian Pencatatan Non Tender</option>
                                    <option value="10">Rincian Pencatatan Swakelola</option>
                                    <option value="11">Rekapitulasi Pengadaan Barang/Jasa</option>
                                    <!-- <option value="12">Rincian Sumber Dana</option>
                                    <option value="13">Rincian Per-PPK</option>
                                    <option value="14">Rincian Per-Personil Pengadaan</option>
                                    <option value="15">Rincian Per-Kelompok Kerja</option> -->
                                </select>
                            </div>
                            <div class="form-group">
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
                            <div class="form-group sr-only">
                                <label>Hasil Laporan</label>
                                <select class="form-control" name="hasil" id="hasil" style="width:100px;">
                                    <option value="excel">Excel</option>
                                    <option value="pdf">PDF</option>
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