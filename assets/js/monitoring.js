$(document).ready(function () {
    init();
});

function init() {
    if($('#provinsi').length != 0) {
        $('#provinsi').show();
        $('#kota').hide();

        provinsi();
    } else {
        $('#provinsi').hide();
        $('#kota').show();
    }
}

function provinsi() {  
    let table = $('#table_provinsi').DataTable({
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
                "width": "4%",
            },
            {
                "targets": [2], 
                "className": "text-center",
                "width": "15%",
            }],
    });

    table.clear().draw();

    $('#provinsi .overlay').show();

    $.ajax({
        url: serverloc + '/monitoring/penyedia_prov',
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    table.row.add([
                                    field.no,
                                    field.provinsi,
                                    field.total
                                ]).draw(false);
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#provinsi .overlay').hide();
        }
    });
}

function kota(provinsi) {  
    let table = $('#table_kota').DataTable({
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
                "width": "4%",
            },
            {
                "targets": [2], 
                "className": "text-center",
                "width": "15%",
            }],
    });

    table.clear().draw();

    $('#kota .overlay').show();

    $('.kota-title').html('<i class="fa fa-table"></i> Daftar Kabupaten/Kota | '+provinsi);

    $('#provinsi').hide();
    $('#kota').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/30/-/-/kota/' + provinsi);

    console.log(provinsi);

    $.ajax({
        url: serverloc + '/monitoring/penyedia_kota/'+provinsi,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    table.row.add([
                                    field.no,
                                    field.kabupaten_kota,
                                    field.total
                                ]).draw(false);
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#kota .overlay').hide();
        }
    });
}