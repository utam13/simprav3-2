<div id="struktur-anggaran" class="struktur-anggaran-area area-padding">
    <div class="container body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline text-center">
                    <h2><?= $halaman;?></h2>

                    <div class="row">
                        <ol class="breadcrumb">
                            <li><a class="page-scroll" href="#diagram">Diagram</a></li>
                            <li><a class="page-scroll" href="#satuan_kerja">Satuan Kerja</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="struktur">
                <div class="row">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-sitemap"></i> Struktur Anggaran 
                                <select class="box-header-select-year" id="thn_struktur">
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
                                                <div class="col-md-12 tree">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                Total Belanja
                                                                <br>
                                                                <b class="apbd-murni-total-belanja">0</b>
                                                            </a>
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        Belanja Pengadaan
                                                                        <br>
                                                                        <b class="apbd-murni-belanja-pengadaan">0</b>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                            Belanja Operasi
                                                                            <br>
                                                                            <b class="apbd-murni-belanja-operasi-1">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Modal
                                                                                <br>
                                                                                <b class="apbd-murni-belanja-modal">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Tidak Terduga
                                                                                <br>
                                                                                <b class="apbd-murni-belanja-tidak-terduga-1">0</b>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        Belanja Non Pengadaan
                                                                        <br>
                                                                        <b class="apbd-murni-belanja-non-pengadaan">0</b>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Operasi
                                                                                <br>
                                                                                <b class="apbd-murni-belanja-operasi-2">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Transfer
                                                                                <br>
                                                                                <b class="apbd-murni-belanja-transfer">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Tidak Terduga
                                                                                <br>
                                                                                <b class="apbd-murni-belanja-tidak-terduga-2">0</b>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="apdb_perubahan">
                                    <div class="tab-inner">
                                        <div class="event-content" id="apdb_perubahan_body">
                                        <div class="row">
                                                <div class="col-md-12 tree">
                                                    <ul>
                                                        <li>
                                                            <a href="#">
                                                                Total Belanja
                                                                <br>
                                                                <b class="apbd-perubahan-total-belanja">0</b>
                                                            </a>
                                                            <ul>
                                                                <li>
                                                                    <a href="#">
                                                                        Belanja Pengadaan
                                                                        <br>
                                                                        <b class="apbd-perubahan-belanja-pengadaan">0</b>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                            Belanja Operasi
                                                                            <br>
                                                                            <b class="apbd-perubahan-belanja-operasi-1">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Modal
                                                                                <br>
                                                                                <b class="apbd-perubahan-belanja-modal">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Tidak Terduga
                                                                                <br>
                                                                                <b class="apbd-perubahan-belanja-tidak-terduga-1">0</b>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li>
                                                                    <a href="#">
                                                                        Belanja Non Pengadaan
                                                                        <br>
                                                                        <b class="apbd-perubahan-belanja-non-pengadaan">0</b>
                                                                    </a>
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Operasi
                                                                                <br>
                                                                                <b class="apbd-perubahan-belanja-operasi-2">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Transfer
                                                                                <br>
                                                                                <b class="apbd-perubahan-belanja-transfer">0</b>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">
                                                                                Belanja Tidak Terduga
                                                                                <br>
                                                                                <b class="apbd-perubahan-belanja-tidak-terduga-2">0</b>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
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

            <div class="col-md-12" id="satuan_kerja">
                <div class="row">
                    <div class="box box-primary box-solid" id="rpp">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Daftar Satuan Kerja
                                <select class="box-header-select-year" id="thn_satker">
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
                                        <a href="#satker_murni" role="tab" data-toggle="tab">APBD Murni</a>
                                    </li>
                                    <li>
                                        <a href="#satker_perubahan" role="tab" data-toggle="tab">APBD Perubahan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="satker_murni">
                                    <div class="tab-inner">
                                        <div class="event-content" id="satker_murni_body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive no-padding">
                                                    <a href="<?= base_url();?>laporan/proses/12/<?= date('Y');?>" id="export_excel" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_satker_murni">
                                                        <thead class="bg-light-blue text-center">
                                                            <tr>
                                                                <th scope="col" rowspan=2 class="text-center">No</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Satuan Kerja</th>
                                                                <th scope="col" colspan=2 nowrap class="text-center">Pengadaan</th>
                                                                <th scope="col" colspan=5 nowrap class="text-center">Non Pengadaan</th>
                                                                <th scope="col" rowspan=2 class="text-center">Total</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">Barang & Jasa</th>
                                                                <th scope="col" nowrap class="text-center">Modal</th>
                                                                <th scope="col" nowrap class="text-center">Pegawai</th>
                                                                <th scope="col" nowrap class="text-center">Hibah</th>
                                                                <th scope="col" nowrap class="text-center">Bansos</th>
                                                                <th scope="col" nowrap class="text-center">BTT *</th>
                                                                <th scope="col" nowrap class="text-center">Subsidi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="col" class="text-center">1</td>
                                                                <td scope="col" nowrap class="text-left">tes</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot class="bg-gray">
                                                            <tr>
                                                                <th scope="col">&nbsp;</th>
                                                                <th scope="col" class="text-right">Total</th>
                                                                <th scope="col" class="total-1-1 text-right">0</th>
                                                                <th scope="col" class="total-2-1 text-right">0</th>
                                                                <th scope="col" class="total-3-1 text-right">0</th>
                                                                <th scope="col" class="total-4-1 text-right">0</th>
                                                                <th scope="col" class="total-5-1 text-right">0</th>
                                                                <th scope="col" class="total-6-1 text-right">0</th>
                                                                <th scope="col" class="total-7-1 text-right">0</th>
                                                                <th scope="col" class="total-8-1 text-right">0</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="satker_perubahan">
                                    <div class="tab-inner">
                                        <div class="event-content" id="satker_perubahan_body">
                                            <div class="row">
                                                <div class="col-md-12 table-responsive no-padding">
                                                <a href="<?= base_url();?>laporan/proses/13/<?= date('Y');?>" id="export_excel2" target="_blank" class="btn btn-success btn-sm pull-right"><i class="fa fa-file-excel-o"></i> Download Excel</a>
                                                    <table class="table table-striped table-hover table-bordered table-sm" id="table_satker_perubahan">
                                                        <thead class="bg-light-blue text-center">
                                                            <tr>
                                                                <th scope="col" rowspan=2 class="text-center">No</th>
                                                                <th scope="col" rowspan=2 nowrap class="text-center">Satuan Kerja</th>
                                                                <th scope="col" colspan=2 nowrap class="text-center">Pengadaan</th>
                                                                <th scope="col" colspan=5 nowrap class="text-center">Non Pengadaan</th>
                                                                <th scope="col" rowspan=2 class="text-center">Total</th>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col" nowrap class="text-center">Barang & Jasa</th>
                                                                <th scope="col" nowrap class="text-center">Modal</th>
                                                                <th scope="col" nowrap class="text-center">Pegawai</th>
                                                                <th scope="col" nowrap class="text-center">Hibah</th>
                                                                <th scope="col" nowrap class="text-center">Bansos</th>
                                                                <th scope="col" nowrap class="text-center">BTT *</th>
                                                                <th scope="col" nowrap class="text-center">Subsidi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td scope="col" class="text-center">1</td>
                                                                <td scope="col" nowrap class="text-left">tes</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                                <td scope="col" nowrap class="text-right">0</td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot class="bg-gray">
                                                            <tr>
                                                                <th scope="col">&nbsp;</th>
                                                                <th scope="col" class="text-right">Total</th>
                                                                <th scope="col" class="total-1-1 text-right">0</th>
                                                                <th scope="col" class="total-2-1 text-right">0</th>
                                                                <th scope="col" class="total-3-1 text-right">0</th>
                                                                <th scope="col" class="total-4-1 text-right">0</th>
                                                                <th scope="col" class="total-5-1 text-right">0</th>
                                                                <th scope="col" class="total-6-1 text-right">0</th>
                                                                <th scope="col" class="total-7-1 text-right">0</th>
                                                                <th scope="col" class="total-8-1 text-right">0</th>
                                                            </tr>
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
        </div>
    </div>
</div>