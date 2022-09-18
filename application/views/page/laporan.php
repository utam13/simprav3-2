<div class="row">
    <div class="col-md-5">
        <div class="card shadow rounded-lg">
            <div class="card-header bg-light-blue">
                <h5 class="text-light">
                    <i class="fas fa-paste"></i> Laporan <small>(<?= $laporan;?>)</small>
                </h5>
            </div>
            <form>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="thn" class="col-sm-4 col-form-label">Tahun Anggaran</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" id="thn" value="2021" max=2021 >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="hasil" class="col-sm-4 col-form-label">Hasil Laporan</label>
                        <div class="col-sm-8 pt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hasil" id="hasil1" value="excel">
                                <label class="form-check-label" for="hasil1">Excel</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hasil" id="hasil2" value="pdf">
                                <label class="form-check-label" for="hasil2">PDF</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>