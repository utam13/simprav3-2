<div id="dashboard" class="dashboard-area area-padding">
    <div class="container body">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline text-center">
                    <h2><?= $halaman;?></h2>

                    <div class="row">
                        <ol class="breadcrumb">
                            <li><a class="page-scroll" href="#info_total">Total Info</a></li>
                            <li><a class="page-scroll" href="#grafik_belanja_pengadaan_apbd_kota_balikpapan">Grafik Belanja Pengadaan APBD</a></li>
                            <li><a class="page-scroll" href="#rup">Grafik Rencana Umum Pengadaan</a></li>
                            <li><a class="page-scroll" href="#rpp">Rencana Paket Pengadaan</a></li>
                            <li><a class="page-scroll" href="#tender">Grafik Tender</a></li>
                            <li><a class="page-scroll" href="#nontender">Grafik Non Tender</a></li>
                            <li><a class="page-scroll" href="#mekanisme_lainnya">Mekanisme Lainnya</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="info_total">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-calculator"></i> Info Total
                                <select class="box-header-select-year" id="thn_info_total">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3 class="text-light"><strong id="belanja_pengadaan">0</strong> <sup style="font-size: 20px">milyar</sup></h3>

                                        <p class="text-light">Belanja Pengadaan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-clipboard"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-green">
                                    <div class="inner">
                                        <h3 class="text-light"><strong id="total_pengadaan">0</strong> <sup style="font-size: 20px">milyar</sup></h3>

                                        <p class="text-light">Total Pengadaan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-folder-open"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 class="text-light"><strong id="pengadaan_selesai">0</strong> <sup style="font-size: 20px">milyar</sup></h3>

                                        <p class="text-light">Pengadaan Selesai</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-check-square-o"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3 class="text-light"><strong id="optimalisasi">0</strong> <sup style="font-size: 20px">milyar</sup></h3>

                                        <p class="text-light">Optimalisasi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rocket"></i>
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

            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="grafik_belanja_pengadaan_apbd_kota_balikpapan">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-line-chart"></i> Grafik Belanja Pengadaan APBD Kota Balikpapan 
                                <select class="box-header-select-year" id="thn_belanja_pengadaan">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body"  id="grafik_belanja_pengadaan_apbd_kota_balikpapan_body">
                            The body of the box
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="rup">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-line-chart"></i> Grafik Rencana Umum Pengadaan
                                <select class="box-header-select-year" id="thn_rup">
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
                                        <a href="#rup_penyedia" role="tab" data-toggle="tab">Penyedia</a>
                                    </li>
                                    <li>
                                        <a href="#rup_swakelola" role="tab" data-toggle="tab">Swakelola</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="rup_penyedia">
                                    <div class="tab-inner">
                                        <div class="event-content" id="rup_penyedia_body">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="rup_swakelola">
                                    <div class="tab-inner">
                                        <div class="event-content" id="rup_swakelola_body">
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

            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="rpp">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Rencana Paket Pengadaan 
                                <select class="box-header-select-year" id="thn_rpp">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-striped table-hover table-bordered table-sm" id="table_rpp">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th scope="col" rowspan=3 nowrap class="text-center">No</th>
                                        <th scope="col" rowspan=3 nowrap class="text-center">Jenis<br>Pengadaan<br>Barang/Jasa</th>
                                        <th scope="col" colspan=10 nowrap class="text-center">Penyedia</th>
                                        <th scope="col" rowspan=2 colspan=2 nowrap class="text-center">Swakelola</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Total</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan=2 nowrap class="text-center"> <= Rp. 200juta</th>
                                        <th scope="col" colspan=2 nowrap class="text-center"> > Rp. 200jt<br><= Rp. 2,5 Milyar</th>
                                        <th scope="col" colspan=2 nowrap class="text-center"> > Rp. 2,5 Milyar<br><= Rp. 50 Milyar</th>
                                        <th scope="col" colspan=2 nowrap class="text-center"> > Rp. 50 Milyar<br><= Rp. 100 Milyar</th>
                                        <th scope="col" colspan=2 nowrap class="text-center"> > Rp. 100 Milyar</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Penyedia + Swakelola</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot class="bg-gray">
                                    
                                </tfoot>
                            </table>
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="tender">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-line-chart"></i> Grafik Tender 
                                <select class="box-header-select-year" id="thn_tender">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body" id="tender_body">
                            The body of the box
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="nontender">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-line-chart"></i> Grafik Non Tender 
                                <select class="box-header-select-year" id="thn_nontender">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body" id="nontender_body">
                            The body of the box
                        </div>
                        <div class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="box box-primary box-solid" id="mekanisme_lainnya">
                        <div class="box-header with-border">
                            <h3 class="box-title text-light">
                                <i class="fa fa-table"></i> Mekanisme Lainnya 
                                <select class="box-header-select-year" id="thn_mekanismelain">
                                    <?
                                    for ($i=date('Y'); $i >=  date('Y')-4; $i--) { 
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    ?>
                                </select>
                            </h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-striped table-hover table-bordered table-sm" id="table_mekanismelainnya">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th scope="col" rowspan=2 nowrap class="text-center">No</th>
                                        <th scope="col" rowspan=2 nowrap class="text-center">Mekanisme</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Perencanaan</th>
                                        <th scope="col" colspan=2 nowrap class="text-center">Realisasi</th>
                                        <th scope="col" rowspan=2 nowrap class="text-center">Persentase<br>Realisasi</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
                                        <th scope="col" class="text-center">Paket</th>
                                        <th scope="col" class="text-center">Pagu</th>
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
        </div>
    </div>
</div>
<!-- End Dashboard -->