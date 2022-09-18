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
            <div class="col-md-12" id="div-daftar">
                <div class="row">
                    <div class="box box-primary box-solid" id="rb">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Rincian Belanja
                                <select class="box-header-select-year" id="thn_rb">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="tab-menu">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active">
                                        <a href="#apdb_murni" role="tab" data-toggle="tab">APBD Murni</a>
                                    </li>
                                    <li>
                                        <a href="#apdb_perubahan" role="tab" data-toggle="tab">APBD Perubahan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="apdb_murni">
                                    <div class="tab-inner">
                                        <div class="event-content" id="apdb_murni_body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive no-padding">
                                                    <a href="<?= base_url();?>laporan/proses/14/<?= date('Y');?>" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                    <table class="table-apdb-murni table table-striped table-hover table-bordered table-sm" id="table_satker_murni">
                                                        <thead class="bg-light-blue">
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">No</th>
                                                                <th scope="col" nowrap class="text-center">Nama SKPD / Instansi Sub Unit</th>
                                                                <th scope="col" nowrap class="text-center">Total Anggaran Program/Kegiatan</th>
                                                                <th scope="col" nowrap class="text-center">#</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        </tbody>
                                                        <tfoot class="bg-gray">

                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="apdb_perubahan">
                                    <div class="tab-inner">
                                        <div class="event-content" id="apdb_perubahan_body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive no-padding">
                                                    <a href="<?= base_url();?>laporan/proses/15/<?= date('Y');?>" id="export_excel2" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                    <table class="table-apdb-perubahan table table-striped table-hover table-bordered table-sm" id="table_satker_perubahan">
                                                        <thead class="bg-light-blue">
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">No</th>
                                                                <th scope="col" nowrap class="text-center">Nama SKPD / Instansi Sub Unit</th>
                                                                <th scope="col" nowrap class="text-center">Total Anggaran Program/Kegiatan</th>
                                                                <th scope="col" nowrap class="text-center">#</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot class="bg-gray">
                                                            
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="div-uraian">
                <div class="row">
                    <div class="box box-primary box-solid" id="uraian">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light uraian-title">
                                <i class="fa fa-table"></i> Daftar Uraian Anggaran Belanja Nama_SKPD tahun 2021
                            </h3>
                            <i class="close fa fa-times" onclick="init()"></i>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <a href="<?= base_url();?>laporan/proses/16/<?= date('Y');?>" id="export_excel3" target="_blank" class="btn btn-success btn-sm pull-right" style="margin-bottom:8px;"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                            <table class="table table-striped table-hover table-bordered table-sm" id="table_uraian">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th scope="col" nowrap class="text-center" colspan=3>Kode</th>
                                        <th scope="col" nowrap class="text-center">Nama Program/Kegiatan/Sub Kegiatan</th>
                                        <th scope="col" nowrap class="text-center">Anggaran</th>
                                        <th scope="col" nowrap class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12" id="div-detail">
                <div class="row">
                    <div class="box box-primary box-solid" id="detail">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light detail-title">
                                <i class="fa fa-table"></i> Daftar Detail Belanja Nama_SKPD tahun 2021
                            </h3>
                            <i class="close fa fa-times" onclick="init2()"></i>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Program</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" id="program" value="tes" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Kegiatan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" id="kegiatan" value="tes" readonly />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Sub Kegiatan</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control input-sm" id="subkegiatan" value="tes" readonly />
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-md-12 table-responsive no-padding">
                                <a href="<?= base_url();?>laporan/proses/17/<?= date('Y');?>" id="export_excel4" target="_blank" class="btn btn-success btn-sm pull-right" style="margin-bottom:8px;"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                    <table class="table-detail table table-striped table-hover table-bordered table-sm" id="table_detail">
                                        <thead class="bg-light-blue">
                                            <tr>
                                                <th scope="col" nowrap class="text-center">Kode Rekening</th>
                                                <th scope="col" nowrap class="text-center">Uraian</th>
                                                <th scope="col" nowrap class="text-center">Anggaran</th>
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
                        <!-- <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
