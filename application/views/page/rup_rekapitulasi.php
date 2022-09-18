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
            <div class="col-md-12" id="div-satker">
                <div class="row">
                    <div class="box box-primary box-solid" id="rup">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar RUP Satuan Kerja 
                                <select class="box-header-select-year" id="thn_rup">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <a href="<?= base_url();?>laporan/proses/1/<?= date('Y');?>" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                            <table class="rup-satker table table-striped table-hover table-bordered table-sm" id="table_satker">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th scope="col" rowspan=2 nowrap class="text-center">No</th>
                                        <th scope="col" rowspan=2 nowrap class="text-center">Satuan Kerja</th>
                                        <th scope="col" rowspan=2 nowrap class="text-center">Belanja Pengadaan</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Penyedia</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Swakelola</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Penyedia dalam Swakelola</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Total</th>
                                        <th scope="col" rowspan=2 nowrap class="text-center">Presentase</th>
                                        <th scope="col" rowspan=2 nowrap class="text-center">#</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" nowrap class="text-center">Paket</th>
                                        <th scope="col" nowrap class="text-center">Anggaran</th>
                                        <th scope="col" nowrap class="text-center">Paket</th>
                                        <th scope="col" nowrap class="text-center">Anggaran</th>
                                        <th scope="col" nowrap class="text-center">Paket</th>
                                        <th scope="col" nowrap class="text-center">Anggaran</th>
                                        <th scope="col" nowrap class="text-center">Paket</th>
                                        <th scope="col" nowrap class="text-center">Anggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot class="bg-gray text-light">
                                    
                                </tfoot>
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