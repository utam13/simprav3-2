
<div id="monitoring" class="monitoring-area area-padding">
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
                    <div class="box box-primary box-solid" id="provinsi">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Provinsi
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="row aligncenter">
                                <div class="col-md-12 table-responsive no-padding">
                                    <a href="<?= base_url();?>laporan/proses/29/-/provinsi" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_provinsi">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" nowrap class="text-center">No</th>
                                                <th scope="col" nowrap class="text-center">Provinsi</th>
                                                <th scope="col" nowrap class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>

                    <div class="box box-primary box-solid" id="kota">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light kota-title">
                                <i class="fa fa-table"></i> Daftar Kabupaten/Kota 
                            </h3>
                            <i class="close fa fa-times" onclick="init()"></i>
                        </div>
                        <div class="box-body">
                            <div class="row aligncenter">
                                <div class="col-md-12 table-responsive no-padding">
                                    <a href="<?= base_url();?>laporan/proses/30/-/-/kota" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_kota">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" nowrap class="text-center">No</th>
                                                <th scope="col" nowrap class="text-center">Kabupaten/Kota</th>
                                                <th scope="col" nowrap class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
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