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
                    <div class="box box-primary box-solid" id="tender">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Rekapitulasi  
                                <select class="box-header-select-year" id="thn_tender">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive no-padding">
                                    <a href="<?= base_url();?>laporan/proses/2/<?= date('Y');?>" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table nowrap table-striped table-hover table-bordered table-sm" id="table_tender_1">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" rowspan=2 class="text-center">No.</th>
                                                <th scope="col" rowspan=2 class="text-center">Metode Pemilihan<br>Penyedia</th>
                                                <th scope="col" colspan=2 class="text-center">Rencana Umum Pengadaan</th>
                                                <th scope="col" colspan=2 class="text-center">Proses Pemilihan Penyedia</th>
                                                <th scope="col" colspan=3 class="text-center">Selesai Proses Pengadaan</th>
                                                <th scope="col" colspan=2 class="text-center">Penghematan</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col" class="text-center">Paket</th>
                                                    <th scope="col" class="text-center">Anggaran</th>
                                                    <th scope="col" class="text-center">Paket</th>
                                                    <th scope="col" class="text-center">Anggaran</th>
                                                    <th scope="col" class="text-center">Paket</th>
                                                    <th scope="col" class="text-center">Pagu Anggaran</th>
                                                    <th scope="col" class="text-center">Nilai Hasil Tender</th>
                                                    <th scope="col" class="text-center">Anggaran</th>
                                                    <th scope="col" class="text-center">%</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot class="bg-gray text-light">

                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-md-12 table-responsive no-padding">
                                    <a href="<?= base_url();?>laporan/proses/22/<?= date('Y');?>" id="export_excel2" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_tender_2">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" rowspan=2 nowrap class="text-center">No.</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Jenis Pekerjaan</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Total<br>Paket</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Paket<br>Selesai</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Paket<br>Tayang</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Paket<br>Review</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Paket<br>Batal</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Total<br>Pagu<br>Anggaran</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">%</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Pagu<br>Anggaran<br>Selesai</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Harga<br>Negosiasi</th>
                                                <th scope="col" colspan=2 nowrap class="text-center">Penghematan</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" nowrap class="text-center">Optimalisasi</th>
                                                <th scope="col" nowrap class="text-center">%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                        <tfoot class="bg-gray text-light">
                                            
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-md-12 table-responsive no-padding">
                                    <a href="<?= base_url();?>laporan/proses/3/<?= date('Y');?>" id="export_excel3" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_tender_3">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" rowspan=2 nowrap class="text-center">#</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">OPD</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Paket</th>
                                                <th scope="col" colspan=4 nowrap class="text-center">Total Pagu Anggaran</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">Total</th>
                                                <th scope="col" rowspan=2 nowrap class="text-center">%</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" nowrap class="text-center">Pengadaan<br>Barang</th>
                                                <th scope="col" nowrap class="text-center">Jasa<br>Konsultasi</th>
                                                <th scope="col" nowrap class="text-center">Jasa<br>Lainnya</th>
                                                <th scope="col" nowrap class="text-center">Pekerjaan<br>Konstruksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot class="bg-gray text-light">
                                            
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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