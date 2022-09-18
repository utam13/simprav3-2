<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div id="progress_div" class="col-lg-12" style="display:none;">
                <div class="progress progress-sm active">
                    <div id="progress_bar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Slide Dashboard
                        </h3>
                    </div>
                    <div class="box-body box-profile text-center">
                        <div class="row">
                            <div class="col-xs-6">
                                <img id="slide-1" class="img-responsive center-block" src="<?= $file_slide_1; ?>" alt="Slide 1" onclick="upload_slide(1)" style="cursor:pointer;width:60%;">
                                <br>
                                <p class="text-muted text-center"><i>klik untuk mengubah gambar slide 1, maksimal 6 Mb</i></p>
                                <input type="file" id="pilih-1" accept=".jpg,.jpeg,,.png,.gif,.bmp" style="display:none;">  
                            </div>
                            <div class="col-xs-6">
                                <img id="slide-2" class="img-responsive center-block" src="<?= $file_slide_2; ?>" alt="Slide 2" onclick="upload_slide(2)" style="cursor:pointer;width:60%;">
                                <br>
                                <p class="text-muted text-center"><i>klik untuk mengubah gambar slide 2, maksimal 6 Mb</i></p>
                                <input type="file" id="pilih-2" accept=".jpg,.jpeg,,.png,.gif,.bmp" style="display:none;">  
                            </div>
                            <div class="col-xs-12"><hr style="border:1px solid #000;"></div>
                            <div class="col-xs-6">
                                <img id="slide-3" class="img-responsive center-block" src="<?= $file_slide_3; ?>" alt="Slide 3" onclick="upload_slide(3)" style="cursor:pointer;width:60%;">
                                <br>
                                <p class="text-muted text-center"><i>klik untuk mengubah gambar slide 3, maksimal 6 Mb</i></p>
                                <input type="file" id="pilih-3" accept=".jpg,.jpeg,,.png,.gif,.bmp" style="display:none;">  
                            </div>
                            <div class="col-xs-6">
                                <img id="slide-4" class="img-responsive center-block" src="<?= $file_slide_4; ?>" alt="Slide 4" onclick="upload_slide(4)" style="cursor:pointer;width:60%;">
                                <br>
                                <p class="text-muted text-center"><i>klik untuk mengubah gambar slide 4, maksimal 6 Mb</i></p>
                                <input type="file" id="pilih-4" accept=".jpg,.jpeg,,.png,.gif,.bmp" style="display:none;">  
                            </div>
                        </div>                        
                    </div>                    
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>