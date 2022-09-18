$(document).ready(function () {
    init();
});

function init() {  
    if($('#struktur-anggaran').length != 0) {
        $('#thn_struktur').change();
        $('#thn_satker').change();
    } else {
        $('#div-daftar').show();
        $('#div-uraian').hide();
        $('#div-detail').hide();

        $('#thn_rb').change();
    }
}

function init2() {  
    $('#div-daftar').hide();
    $('#div-uraian').show();
    $('#div-detail').hide();
}

// struktur
function struktur(tahun) {
    $.ajax({
        // url: serverloc + '/json/struktur_anggaran_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/struktur_apbd/struktur/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.murni, function (j, field2) {
                        $('.apbd-murni-total-belanja').html(field2.total_belanja);
                        $('.apbd-murni-belanja-pengadaan').html(field2.belanja_pengadaan);
                        $('.apbd-murni-belanja-operasi-1').html(field2.belanja_operasi_1);
                        $('.apbd-murni-belanja-modal').html(field2.belanja_modal);
                        $('.apbd-murni-belanja-tidak-terduga-1').html(field2.belanja_tidak_terduga_1);
                        $('.apbd-murni-belanja-non-pengadaan').html(field2.belanja_non_pengadaan);
                        $('.apbd-murni-belanja-operasi-2').html(field2.belanja_operasi_2);
                        $('.apbd-murni-belanja-transfer').html(field2.belanja_transfer);
                        $('.apbd-murni-belanja-tidak-terduga-2').html(field2.belanja_tidak_terduga_2);
                        $('.apbd-murni-belanja-pengadaan').html(field2.belanja_pengadaan);
                    });

                    $.each(field.perubahan, function (k, field3) {
                        $('.apbd-perubahan-total-belanja').html(field3.total_belanja);
                        $('.apbd-perubahan-belanja-pengadaan').html(field3.belanja_pengadaan);
                        $('.apbd-perubahan-belanja-operasi-1').html(field3.belanja_operasi_1);
                        $('.apbd-perubahan-belanja-modal').html(field3.belanja_modal);
                        $('.apbd-perubahan-belanja-tidak-terduga-1').html(field3.belanja_tidak_terduga_1);
                        $('.apbd-perubahan-belanja-non-pengadaan').html(field3.belanja_non_pengadaan);
                        $('.apbd-perubahan-belanja-operasi-2').html(field3.belanja_operasi_2);
                        $('.apbd-perubahan-belanja-transfer').html(field3.belanja_transfer);
                        $('.apbd-perubahan-belanja-tidak-terduga-2').html(field3.belanja_tidak_terduga_2);
                        $('.apbd-perubahan-belanja-pengadaan').html(field3.belanja_pengadaan);
                    });
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#struktur .overlay').hide();
        }
    });
}

function satuan_kerja(tahun) {  
    let table_murni = $('#table_satker_murni').DataTable({
        "bProcessing": true,
        "bPaginate": false,
        "bLengthChange": false,
        "scrollX": false,
        "scrollCollapse": false,
        "fixedHeader": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        'retrieve': true,
        'columnDefs': [
            {
                "targets": 0, 
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": [2,3,4,5,6,7,8],
                "className": "text-right",
            }],
    });

    table_murni.clear().draw();

    $('#table_satker_murni tfoot').empty();

    let table_perubahan = $('#table_satker_perubahan').DataTable({
        "bProcessing": true,
        "bPaginate": false,
        "bLengthChange": false,
        "scrollX": false,
        "scrollCollapse": false,
        "fixedHeader": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        'retrieve': true,
        'columnDefs': [
            {
                "targets": 0, 
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": [2,3,4,5,6,7,8],
                "className": "text-right",
            }],
    });

    table_perubahan.clear().draw();

    $('#table_satker_perubahan tfoot').empty();

    $.ajax({
        // url: serverloc + '/json/tabel_anggaran_satker_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/struktur_apbd/satuan_kerja/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.murni, function (j, murni) {
                        $.each(murni.baris, function (j, baris) {
                            table_murni.row.add([
                                                baris.no,
                                                // baris.kode,
                                                baris.singkatan,
                                                baris.total_barang_jasa,
                                                baris.total_modal,
                                                baris.total_pegawai,
                                                baris.total_hibah,
                                                baris.total_bansos,
                                                baris.total_tidak_terduga,
                                                baris.total_dll,
                                                baris.total
                                            ]).draw(false);
                        });

                        $('#table_satker_murni tfoot').append('<tr>'+
                                                        '<th scope="col" colspan=2 class="text-right">Total</th>'+
                                                        '<th scope="col" class="total-1-1 text-right">'+murni.total_1+'</th>'+
                                                        '<th scope="col" class="total-2-1 text-right">'+murni.total_2+'</th>'+
                                                        '<th scope="col" class="total-3-1 text-right">'+murni.total_3+'</th>'+
                                                        '<th scope="col" class="total-4-1 text-right">'+murni.total_4+'</th>'+
                                                        '<th scope="col" class="total-5-1 text-right">'+murni.total_5+'</th>'+
                                                        '<th scope="col" class="total-6-1 text-right">'+murni.total_6+'</th>'+
                                                        '<th scope="col" class="total-7-1 text-right">'+murni.total_7+'</th>'+
                                                        '<th scope="col" class="total-8-1 text-right">'+murni.total_8+'</th>'+
                                                    '</tr>');
                    });

                    $.each(field.perubahan, function (k, perubahan) {
                        $.each(perubahan.baris, function (j, baris2) {
                            table_perubahan.row.add([
                                                    baris2.no,
                                                    // baris2.kode,
                                                    baris2.singkatan,
                                                    baris2.total_barang_jasa,
                                                    baris2.total_modal,
                                                    baris2.total_pegawai,
                                                    baris2.total_hibah,
                                                    baris2.total_bansos,
                                                    baris2.total_tidak_terduga,
                                                    baris2.total_dll,
                                                    baris2.total
                                                ]).draw(false);
                        });

                        $('#table_satker_perubahan tfoot').append('<tr>'+
                                                        '<th scope="col" colspan=2 class="text-right">Total</th>'+
                                                        '<th scope="col" class="total-1-1 text-right">'+perubahan.total_1+'</th>'+
                                                        '<th scope="col" class="total-2-1 text-right">'+perubahan.total_2+'</th>'+
                                                        '<th scope="col" class="total-3-1 text-right">'+perubahan.total_3+'</th>'+
                                                        '<th scope="col" class="total-4-1 text-right">'+perubahan.total_4+'</th>'+
                                                        '<th scope="col" class="total-5-1 text-right">'+perubahan.total_5+'</th>'+
                                                        '<th scope="col" class="total-6-1 text-right">'+perubahan.total_6+'</th>'+
                                                        '<th scope="col" class="total-7-1 text-right">'+perubahan.total_7+'</th>'+
                                                        '<th scope="col" class="total-8-1 text-right">'+perubahan.total_8+'</th>'+
                                                    '</tr>');
                    });
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#satuan_kerja .overlay').hide();
        }
    });
}

function rincian_belanja(tahun) {  
    let table_murni = $('#table_satker_murni').DataTable({
        "bProcessing": true,
        "bPaginate": false,
        "bLengthChange": false,
        "scrollX": false,
        "scrollCollapse": false,
        "fixedHeader": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        'retrieve': true,
        'columnDefs': [
            {
                "targets": [0,3],
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": [2,3],
                "className": "text-right",
            }],
    });

    table_murni.clear().draw();

    $('#table_satker_murni tfoot').empty();

    let table_perubahan = $('#table_satker_perubahan').DataTable({
        "bProcessing": true,
        "bPaginate": false,
        "bLengthChange": false,
        "scrollX": false,
        "scrollCollapse": false,
        "fixedHeader": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        'retrieve': true,
        'columnDefs': [
            {
                "targets": [0,3], 
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": [2],
                "className": "text-right",
            }],
    });

    table_perubahan.clear().draw();

    $('#table_satker_perubahan tfoot').empty();

    $.ajax({
        // url: serverloc + '/json/tabel_rincian_belanja_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/struktur_apbd/satker_rincian_belanja/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.baris, function (j, baris) {
                        table_murni.row.add([
                                            baris.no,
                                            baris.nama_satker,
                                            baris.total_anggaran_murni,
                                            baris.btn_uraian_murni
                                        ]).draw(false);

                        table_perubahan.row.add([
                                            baris.no,
                                            baris.nama_satker,
                                            baris.total_anggaran_perubahan,
                                            baris.btn_uraian_perubahan
                                        ]).draw(false);
                    });

                    $('#table_satker_murni tfoot').append('<tr>'+
                                                            '<th scope="col">&nbsp;</th>'+
                                                            '<th scope="col" class="text-right">Total</th>'+
                                                            '<th scope="col" class="total-murni text-right">'+field.total_murni+'</th>'+
                                                            '<th scope="col">&nbsp;</th>'+
                                                        '</tr>');

                    $('#table_satker_perubahan tfoot').append('<tr>'+
                                                                '<th scope="col">&nbsp;</th>'+
                                                                '<th scope="col" class="text-right">Total</th>'+
                                                                '<th scope="col" class="total-murni text-right">'+field.total_perubahan+'</th>'+
                                                                '<th scope="col">&nbsp;</th>'+
                                                            '</tr>');
                });
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#rb .overlay').hide();
        }
    });
}

function uraian(kode,kelompok) {  
    let thn = $('#thn_rb').val();

    $('#export_excel3').attr('href',serverloc + '/laporan/proses/16/'+thn+'/'+kode+'/'+kelompok);

    $('#div-daftar').hide();
    $('#div-uraian').show();
    $('#div-detail').hide();

    $('#table_uraian tbody').empty();   

    $('#uraian .overlay').show();

    $.ajax({
        url: serverloc + '/struktur_apbd/uraian/'+thn+'/'+kode+'/'+kelompok,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $('.uraian-title').html('<i class="fa fa-table"></i> Daftar Uraian Anggaran Belanja | '+field.kode_satker+' - '+field.nama_satker+' | Tahun '+thn);

                    $.each(field.baris, function (i, baris) {
                        $('#table_uraian tbody').append('<tr>'+
                                                            '<td scope="col" class="text-center '+baris.bg+'">'+baris.kode_1+'</td>'+
                                                            '<td scope="col" class="text-center '+baris.bg+'">'+baris.kode_2+'</td>'+
                                                            '<td scope="col" class="text-center '+baris.bg+'">'+baris.kode_3+'</td>'+
                                                            '<td scope="col" class="text-left '+baris.bg+'">'+baris.nama+'</td>'+
                                                            '<td scope="col" nowrap class="text-right '+baris.bg+'">'+baris.total+'</td>'+
                                                            '<td scope="col" nowrap class="text-center '+baris.bg+'">'+baris.btn+'</td>'+
                                                        '</tr>');
                    });
                });
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#uraian .overlay').hide();
        }
    });
}

function detail(kode,kelompok,satker) {
    let thn = $('#thn_rb').val();

    $('#export_excel4').attr('href',serverloc + '/laporan/proses/17/'+thn+'/'+satker+'/'+kelompok+'/'+kode);

    let table = $('#table_detail').DataTable({
        "bProcessing": true,
        "bPaginate": false,
        "bLengthChange": false,
        "scrollX": false,
        "scrollCollapse": false,
        "fixedHeader": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": false,
        'retrieve': true,
        'columnDefs': [
            {
                "targets": [0],
                "className": "text-center",
            },
            {
                "targets": [2],
                "className": "text-right",
            }],
    });

    table.clear().draw();

    $('#div-daftar').hide();
    $('#div-uraian').hide();
    $('#div-detail').show();

    $('#table_detail tbody').empty();  
    $('#table_detail tfoot').empty();  

    $('#detail .overlay').show();

    $.ajax({
        url: serverloc + '/struktur_apbd/detail/'+thn+'/'+kode+'/'+satker+'/'+kelompok,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $('.detail-title').html('<i class="fa fa-table"></i> Daftar Detail Belanja | '+field.kode_satker+' - '+field.nama_satker+' | Tahun '+thn);
                    $('#program').val(field.program);
                    $('#kegiatan').val(field.kegiatan);
                    $('#subkegiatan').val(field.subkegiatan);

                    $.each(field.baris, function (i, baris) {
                        table.row.add([
                                        baris.kode,
                                        baris.rincian,
                                        baris.pagu
                                    ]).draw(false);
                    });

                    $('#table_detail tfoot').append('<tr>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                        '<th scope="col" class="text-right">Total</th>'+
                                                        '<th scope="col" class="text-right">'+field.total+'</th>'+
                                                    '</tr>');
                });
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#detail .overlay').hide();
        }
    });
}

$('#thn_struktur').change(function(){
    let pilih = this.value;

    $('#struktur .overlay').show();

    struktur(pilih);
})

$('#thn_satker').change(function(){
    let pilih = this.value;

    $('#satuan_kerja .overlay').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/12/' + pilih);
    $('#export_excel2').attr('href',serverloc + '/laporan/proses/13/' + pilih);

    satuan_kerja(pilih);
})

$('#thn_rb').change(function(){
    let pilih = this.value;

    $('#rb .overlay').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/14/' + pilih);
    $('#export_excel2').attr('href',serverloc + '/laporan/proses/15/' + pilih);

    rincian_belanja(pilih);
})

