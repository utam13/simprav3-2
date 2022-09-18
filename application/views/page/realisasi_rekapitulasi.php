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
                    <div class="box box-primary box-solid" id="rekap">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Rekapitulasi  
                                <select class="box-header-select-year" id="thn_rekap">
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
                                <div class="col-md-12">
                                    <div id="rekap_body" style="margin-top:20px;">
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top:20px;">
                                <div class="col-md-12 table-responsive no-padding">
                                    <a href="<?= base_url();?>laporan/proses/24/<?= date('Y');?>" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_rekap">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" rowspan=2 class="text-center">No.</th>
                                                <th scope="col" rowspan=2 class="text-center">Satuan Kerja</th>
                                                <th scope="col" colspan=2 class="text-center">Belanja Pengadaan</th>
                                                <th scope="col" colspan=3 class="text-center">Realisasi Kontrak</th>
                                                <th scope="col" colspan=3 class="text-center">Paket Selesai</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-center">Paket</th>
                                                <th scope="col" class="text-center">Anggaran</th>
                                                <th scope="col" class="text-center">Paket</th>
                                                <th scope="col" class="text-center">Anggaran</th>
                                                <th scope="col" class="text-center">Persentase</th>
                                                <th scope="col" class="text-center">Paket</th>
                                                <th scope="col" class="text-center">Anggaran</th>
                                                <th scope="col" class="text-center">Persentase</th>
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