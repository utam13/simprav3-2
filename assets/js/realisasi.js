$(document).ready(function () {
    if($('#rekap').length != 0) {
        $('#thn_rekap').change();
    } else {
        $('#thn_triwulan').change();
    }
});

function status(kode, kelompok, status, nilai) {
    let namastatus;

    switch(status){
        case 'nama_status_pekerjaan' : namastatus = 'Status Pelaksanaan'; break;
        case 'status_paket_strategis' : namastatus = 'Status Strategis'; break;
    }

    $.ajax({
        url: serverloc + '/realisasi/status/' + kode + '/' + kelompok + '/' + status + '/' + nilai,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);
            $.each(response, function (i, field) {
                if (field.hasil == 'ok') {
                    alert(namastatus + ' diubah menjadi ' +  nilai);
                } else {
                    console.log("gagal");
                    alert(namastatus + ' gagal diubah menjadi ' +  nilai);
                }
            });
        }   
    })
}

function rekap(tahun) {  
    let table = $('#table_rekap').DataTable({
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
                "targets": [2,3,4,5,6,7,8,9],
                "className": "text-right",
            }],
    });

    table.clear().draw();

    $('#table_rekap tfoot').empty();

    $.ajax({
        url: serverloc + '/realisasi/rekap/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.baris, function (i, baris) {
                            table.row.add([
                                            baris.no,
                                            baris.singkatan,
                                            baris.belanja_pengadaan_paket,
                                            baris.belanja_pengadaan_anggaran,
                                            baris.realisasi_kontrak_paket,
                                            baris.realisasi_kontrak_anggaran,
                                            baris.realisasi_kontrak_persen,
                                            baris.paket_selesai_paket,
                                            baris.paket_selesai_anggaran,
                                            baris.paket_selesai_persen
                                        ]).draw(false);
                    });

                    $('#table_rekap tfoot').append('<tr>'+
                                                        '<th scope="col"">&nbsp;</th>'+
                                                        '<th scope="col" class="text-right">Total</th>'+
                                                        '<th scope="col" class="total-1-1 text-right">'+field.total_1+'</th>'+
                                                        '<th scope="col" class="total-2-1 text-right">'+field.total_2+'</th>'+
                                                        '<th scope="col" class="total-3-1 text-right">'+field.total_3+'</th>'+
                                                        '<th scope="col" class="total-4-1 text-right">'+field.total_4+'</th>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                        '<th scope="col" class="total-5-1 text-right">'+field.total_5+'</th>'+
                                                        '<th scope="col" class="total-6-1 text-right">'+field.total_6+'</th>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                    '</tr>');
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#rekap .overlay').hide();
        }
    });
}

function triwulan(tahun) {  
    let table = $('#table_triwulan').DataTable({
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
                "targets": [2,3,4,5,6,7,8,9,10,12,13],
                "className": "text-right",
            }],
    });

    table.clear().draw();

    $('#table_triwulan tfoot').empty();

    $.ajax({
        url: serverloc + '/realisasi/rekap_triwulan/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.baris, function (i, baris) {
                            table.row.add([
                                            baris.no,
                                            baris.singkatan,
                                            baris.belanja_pagu,
                                            baris.belanja_paket,
                                            baris.triwulan1_pagu,
                                            baris.triwulan1_paket,
                                            baris.triwulan2_pagu,
                                            baris.triwulan2_paket,
                                            baris.triwulan3_pagu,
                                            baris.triwulan3_paket,
                                            baris.triwulan4_pagu,
                                            baris.triwulan4_paket,
                                            baris.total_pagu,
                                            baris.total_paket,
                                        ]).draw(false);
                    });

                    $('#table_triwulan tfoot').append('<tr>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                        '<th scope="col" class="text-right">Total</th>'+
                                                        '<th scope="col" class="total-1 text-right">'+field.total_1+'</th>'+
                                                        '<th scope="col" class="total-2 text-right">'+field.total_2+'</th>'+
                                                        '<th scope="col" class="total-3 text-right">'+field.total_3+'</th>'+
                                                        '<th scope="col" class="total-4 text-right">'+field.total_4+'</th>'+
                                                        '<th scope="col" class="total-5 text-right">'+field.total_5+'</th>'+
                                                        '<th scope="col" class="total-6 text-right">'+field.total_6+'</th>'+
                                                        '<th scope="col" class="total-7 text-right">'+field.total_7+'</th>'+
                                                        '<th scope="col" class="total-8 text-right">'+field.total_8+'</th>'+
                                                        '<th scope="col" class="total-9 text-right">'+field.total_9+'</th>'+
                                                        '<th scope="col" class="total-10 text-right">'+field.total_10+'</th>'+
                                                        '<th scope="col" class="total-11 text-right">'+field.total_11+'</th>'+
                                                        '<th scope="col" class="total-12 text-right">'+field.total_12+'</th>'+
                                                    '</tr>');
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#triwulan .overlay').hide();
        }
    });
}

$('#thn_rekap').change(function(){
    let pilih = this.value;

    $('#rekap .overlay').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/24/' + pilih);

    rekap(pilih);
    grafik_rekap(pilih);
})

$('#thn_triwulan').change(function(){
    let pilih = this.value;

    $('#triwulan .overlay').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/26/' + pilih);

    triwulan(pilih);
    grafik_triwulan(pilih);
})