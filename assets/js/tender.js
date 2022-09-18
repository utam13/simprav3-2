$(document).ready(function () {
    $('#thn_tender').change();
});

function tender(tahun) {  
    let table1 = $('#table_tender_1').DataTable({
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
                "targets": [2,3,4,5,6,7,8,9,10],
                "className": "text-right",
            }],
    });

    table1.clear().draw();

    $('#table_tender_1 tfoot').empty();

    let table2 = $('#table_tender_2').DataTable({
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
                "targets": [2,3,4,5,6,7,8,9,10,11,12],
                "className": "text-right",
            }],
    });

    table2.clear().draw();

    $('#table_tender_2 tfoot').empty();

    let table3 = $('#table_tender_3').DataTable({
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
                "targets": [2,3,4,5,6,7,8],
                "className": "text-right",
            }]
    });

    table3.clear().draw();

    $('#table_tender_3 tfoot').empty();

    $.ajax({
        url: serverloc + '/tender/tender/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.metode, function (i, metode) {
                        $.each(metode.baris, function (i, baris) {
                            table1.row.add([
                                            baris.no,
                                            baris.metode,
                                            baris.rup_paket,
                                            baris.rup_anggaran,
                                            baris.proses_paket,
                                            baris.proses_anggaran,
                                            baris.selesai_paket,
                                            baris.selesai_anggaran,
                                            baris.selesai_nilai,
                                            baris.hemat_anggaran,
                                            baris.hemat_persen
                                        ]).draw(false);
                        });
                        $('#table_tender_1 tfoot').append('<tr>'+
                                                            '<th scope="col">&nbsp;</th>'+
                                                            '<th scope="col" class="text-right">Total</th>'+
                                                            '<th scope="col" class="total-1 text-right">'+metode.total_rup_paket+'</th>'+
                                                            '<th scope="col" class="total-2 text-right">'+metode.total_rup_anggaran+'</th>'+
                                                            '<th scope="col" class="total-3 text-right">'+metode.total_proses_paket+'</th>'+
                                                            '<th scope="col" class="total-4 text-right">'+metode.total_proses_anggaran+'</th>'+
                                                            '<th scope="col" class="total-5 text-right">'+metode.total_selesai_paket+'</th>'+
                                                            '<th scope="col" class="total-6 text-right">'+metode.total_selesai_anggaran+'</th>'+
                                                            '<th scope="col" class="total-7 text-right">'+metode.total_selesai_nilai+'</th>'+
                                                            '<th scope="col" class="total-8 text-right">'+metode.total_hemat_anggaran+'</th>'+
                                                            '<th scope="col">&nbsp;</th>'+
                                                        '</tr>');
                    });

                    $.each(field.jenis, function (i, jenis) {
                        $.each(jenis.baris, function (i, baris) {
                            table2.row.add([
                                            baris.no,
                                            baris.jenis,
                                            baris.total_paket,
                                            baris.paket_selesai,
                                            baris.paket_tayang,
                                            baris.paket_review,
                                            baris.paket_batal,
                                            baris.total_pagu_anggaran,
                                            baris.persen_pagu_anggaran,
                                            baris.pagu_anggaran_selesai,
                                            baris.harga_negosiasi,
                                            baris.hemat_optimalisasi,
                                            baris.hemat_persen
                                        ]).draw(false);
                        });
                        $('#table_tender_2 tfoot').append('<tr>'+
                                                                '<th scope="col">&nbsp;</th>'+
                                                                '<th scope="col" nowrap class="text-right">Total</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_total_paket+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_paket_selesai+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_paket_tayang+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_paket_review+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_paket_batal+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_total_pagu_anggaran+'</th>'+
                                                                '<th scope="col">&nbsp;</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_pagu_anggaran_selesai+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_harga_negosiasi+'</th>'+
                                                                '<th scope="col" nowrap class="text-right">'+jenis.total_hemat_optimalisasi+'</th>'+
                                                                '<th scope="col">&nbsp;</th>'+
                                                        '</tr>');
                    });

                    $.each(field.satker, function (i, satker) {
                        $.each(satker.baris, function (i, baris) {
                            table3.row.add([
                                            baris.no,
                                            baris.singkatan,
                                            baris.paket,
                                            baris.pengadaan_barang,
                                            baris.jasa_konsultasi,
                                            baris.jasa_lainnya,
                                            baris.pekerjaan_konstruksi,
                                            baris.total,
                                            baris.persen
                                        ]).draw(false);
                        });
                        $('#table_tender_3 tfoot').append('<tr>'+
                                                            '<th scope="col">&nbsp;</th>'+
                                                            '<th scope="col" class="text-right">Total</th>'+
                                                            '<th scope="col" class="text-right">'+satker.total_paket+'</th>'+
                                                            '<th scope="col" class="text-right">'+satker.total_pengadaan_barang+'</th>'+
                                                            '<th scope="col" class="text-right">'+satker.total_jasa_konsultasi+'></th>'+
                                                            '<th scope="col" class="text-right">'+satker.total_jasa_lainnya+'</th>'+
                                                            '<th scope="col" class="text-right">'+satker.total_pekerjaan_konstruksi+'</th>'+
                                                            '<th scope="col" class="text-right">'+satker.total+'</th>'+
                                                            '<th scope="col">&nbsp;</th>'+
                                                        '</tr>');
                    });
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#tender .overlay').hide();
        }
    });
}

$('#thn_tender').change(function(){
    let pilih = this.value;

    $('#tender .overlay').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/2/' + pilih);
    $('#export_excel2').attr('href',serverloc + '/laporan/proses/22/' + pilih);
    $('#export_excel3').attr('href',serverloc + '/laporan/proses/3/' + pilih);

    tender(pilih);
})