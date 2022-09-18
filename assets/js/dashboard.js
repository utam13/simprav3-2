$(document).ready(function () {
    $('#thn_info_total').change();
    $('#thn_belanja_pengadaan').change();
    $('#thn_rup').change();
    $('#thn_tender').change();
    $('#thn_nontender').change();
    $('#thn_rpp').change();
    $('#thn_mekanismelain').change();
});

// card
function info_total(tahun) {
    $.ajax({
        // url: serverloc + '/json/info_total_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/info_total/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $('#belanja_pengadaan').html(response[0]['belanja_pengadaan']);
                $('#total_pengadaan').html(response[0]['total_pengadaan']);
                $('#pengadaan_selesai').html(response[0]['pengadaan_selesai']);
                $('#optimalisasi').html(response[0]['optimalisasi']);
            }
        },
        complete: function(){
            $('#info_total .overlay').hide();
        }
    });
}

// tabel rpp
function rencana_paket_pengadaan(tahun) {
    let table = $('#table_rpp').DataTable({
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
                "targets": 0, // your case first column
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": [2,3,4,5,6,7,8,9,10,11,12,13,14,15],
                "className": "text-right",
            }],
    });

    table.clear().draw();

    $('#table_rpp tfoot').empty();

    $.ajax({
        // url: serverloc + '/json/tabel_rencana_paket_pengadaan_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/rencana_paket_pengadaan/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.baris, function (j, field2) {
                        table.row.add([
                                    field2.no,
                                    field2.jenis_pengadaan,
                                    field2.penyedia_200_paket,
                                    field2.penyedia_200_pagu,
                                    field2.penyedia_200_25_paket,
                                    field2.penyedia_200_25_pagu,
                                    field2.penyedia_25_50_paket,
                                    field2.penyedia_25_50_pagu,
                                    field2.penyedia_50_100_paket,
                                    field2.penyedia_50_100_pagu,
                                    field2.penyedia_100_paket,
                                    field2.penyedia_100_pagu,
                                    field2.swakelola_paket,
                                    field2.swakelola_pagu,
                                    field2.total_paket,
                                    field2.total_pagu
                                    ]).draw(false);
                    })
                    
                    $('#table_rpp tfoot').append('<tr>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                        '<th scope="col" nowrap class="text-right">Total</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_penyedia_200_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_penyedia_200_pagu+'</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_penyedia_200_25_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_penyedia_200_25_pagu+'</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_penyedia_25_50_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_penyedia_25_50_pagu+'</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_penyedia_50_100_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_penyedia_50_100_pagu+'</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_penyedia_100_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_penyedia_100_pagu+'</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_swakelola_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_swakelola_pagu+'</th>'+
                                                        '<th scope="col" nowrap class="total-2 text-right">'+field.total_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-1 text-right">'+field.total_pagu+'</th>'+
                                                '</tr>');
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#rpp .overlay').hide();
        }
    });
}

// tabel mekanisme lainnya
function mekanisme_lainnya(tahun) {
    let table = $('#table_mekanismelainnya').DataTable({
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
                "targets": [0,6],
                "className": "text-center",
                "width": "4%"
            },
            {
                "targets": [2,3,4,4],
                "className": "text-right",
            }],
    });

    table.clear().draw();

    $.ajax({
        // url: serverloc + '/json/tabel_mekanisme_lainnya_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/mekanisme_lainnya/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    table.row.add([
                                field.no,
                                field.mekanisme,
                                field.perencanaan_paket,
                                field.perencanaan_pagu,
                                field.realisasi_paket,
                                field.realisasi_pagu,
                                field.persentase
                            ]).draw(false);
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#mekanisme_lainnya .overlay').hide();
        }
    });
}

$('#thn_info_total').change(function(){
    let pilih = this.value;

    $('#info_total .overlay').show();

    info_total(pilih);
})

$('#thn_belanja_pengadaan').change(function(){
    let pilih = this.value;

    $('#grafik_belanja_pengadaan_apbd_kota_balikpapan .overlay').show();

    belanja_pengadaan(pilih);
})

$('#thn_rup').change(function(){
    let pilih = this.value;
    
    $('#rup .overlay').show();

    rup_penyedia(pilih);
    rup_swakelola(pilih);
})

$('#thn_tender').change(function(){
    let pilih = this.value;

    $('#tender .overlay').show();

    tender(pilih);
})

$('#thn_nontender').change(function(){
    let pilih = this.value;

    $('#nontender .overlay').show();

    nontender(pilih);
})

$('#thn_rpp').change(function(){
    let pilih = this.value;

    $('#rpp .overlay').show();

    rencana_paket_pengadaan(pilih);
})

$('#thn_mekanismelain').change(function(){
    let pilih = this.value;

    $('#mekanisme_lainnya .overlay').show();

    mekanisme_lainnya(pilih);
})