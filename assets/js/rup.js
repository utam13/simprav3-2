$(document).ready(function () {
    init();
});

function init() {
    if($('#div-satker').length != 0) {
        $('#thn_rup').change();
    } else {
        $('#div-daftar').show();
        $('#div-detail').hide();
    }
}

function satuan_kerja(tahun) {
    let table = $('#table_satker').DataTable({
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
                "targets": [0,11,12], 
                "className": "text-center",
            },
            {
                "targets": [2,3,4,5,6,7,8,9,10],
                "className": "text-right",
            }],
    });

    table.clear().draw();

    $('#table_satker tfoot').empty();

    $.ajax({
        url: serverloc + '/rup/satuan_kerja/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ""){
                $.each(response, function (i, field) {
                    $.each(field.baris, function (j, baris) {
                        let trDOM = table.row.add([
                                                    baris.no,
                                                    baris.singkatan,
                                                    baris.belanja_pengadaan,
                                                    baris.penyedia_paket,
                                                    baris.penyedia_anggaran,
                                                    baris.swakelola_paket,
                                                    baris.swakelola_anggaran,
                                                    baris.penyedia_dalam_swakelola_paket,
                                                    baris.penyedia_dalam_swakelola_anggaran,
                                                    baris.paket,
                                                    baris.anggaran,
                                                    baris.persentase,
                                                    baris.btn
                                                ]).draw(false).node();

                        $(trDOM).addClass(baris.warna);
                    });
                    $('#table_satker tfoot').append('<tr>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                        '<th scope="col" class="text-right">Total</th>'+
                                                        '<th scope="col" nowrap class="total-belanja-pengadaan text-right">'+field.total_belanja_pengadaan+'</th>'+
                                                        '<th scope="col" nowrap class="total-penyedia-paket text-right">'+field.total_penyedia_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-penyedia-anggaran text-right">'+field.total_penyedia_anggaran+'</th>'+
                                                        '<th scope="col" nowrap class="total-swakelola-paket text-right">'+field.total_swakelola_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-swakelola-anggaran text-right">'+field.total_swakelola_anggaran+'</th>'+
                                                        '<th scope="col" nowrap class="total-penyedia-dalam-swakelola-paket text-right">'+field.total_penyedia_dalam_swakelola_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-penyedia-dalam-swakelola-anggaran text-right">'+field.total_penyedia_dalam_swakelola_anggaran+'</th>'+
                                                        '<th scope="col" nowrap class="total-paket text-right">'+field.total_paket+'</th>'+
                                                        '<th scope="col" nowrap class="total-anggaran text-right">'+field.total_anggaran+'</th>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                        '<th scope="col">&nbsp;</th>'+
                                                    '</tr>');
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#rup .overlay').hide();
        }
    });
}

function info(thn,satker,kelompok,kode) {
    $('#div-daftar').hide();
    $('#div-detail').show();

    $('#detail .overlay').show();

    $('#table_detail tbody').empty();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/19/'+thn+'/'+satker+'/'+kelompok+'/'+kode);

    $.ajax({
        url: serverloc + '/rup/info/'+kelompok+'/'+kode,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ''){
                $.each(response, function (i, field) {
                    switch(kelompok){
                        case 'penyedia' : 
                                $('#table_detail tbody').append('<tr>'+
                                                                    '<th scope="row text-bold" nowrap style="width:1px;">Kode RUP</th>'+
                                                                    '<td id="kode_rup">'+field.kode_rup+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Paket</th>'+
                                                                    '<td id="nama_paket">'+field.nama_paket+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama KLPD</th>'+
                                                                    '<td id="nama_klpd">'+field.nama_klpd+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Satuan Kerja</th>'+
                                                                    '<td id="satuan_kerja">'+field.satuan_kerja+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Program</th>'+
                                                                    '<td id="nama_program">'+field.nama_program+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Kegiatan</th>'+
                                                                    '<td id="nama_kegiatan">'+field.nama_kegiatan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tahun Anggaran</th>'+
                                                                    '<td id="tahun_anggaran">'+field.tahun_anggaran+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Provinsi</th>'+
                                                                    '<td id="provinsi">'+field.provinsi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Kabupaten/Kota</th>'+
                                                                    '<td id="kabupaten_kota">'+field.kabupaten_kota+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Detail Lokasi</th>'+
                                                                    '<td id="detail_lokasi">'+field.detail_lokasi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Volume Pekerjaan</th>'+
                                                                    '<td id="volume_pekerjaan">'+field.volume_pekerjaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Uraian Pekerjaan</th>'+
                                                                    '<td id="uraian_pekerjaan">'+field.uraian_pekerjaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Spesifikasi Pekerjaan</th>'+
                                                                    '<td id="spesifikasi_pekerjaan">'+field.spesifikasi_pekerjaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Usaha Kecil</th>'+
                                                                    '<td id="usaha_kecil"><span class="badge badge-pill '+field.warna_badge+'">'+field.usaha_kecil+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Sumber Dana</th>'+
                                                                    '<td id="sumber_dana">'+field.sumber_dana+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>MAK</th>'+
                                                                    '<td id="mak">'+field.mak+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Jenis Pengadaan</th>'+
                                                                    '<td id="jenis_pengadaan">'+field.jenis_pengadaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Total Pagu</th>'+
                                                                    '<td id="total_pagu">'+field.total_pagu+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Metode Pemilihan</th>'+
                                                                    '<td id="metode_pemilihan">'+field.metode_pemilihan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Pemanfaatan Barang/Jasa</th>'+
                                                                    '<td id="pemanfaatan"><span class="pr-5">Mulai: '+field.pemanfaatan_barangjasa_mulai+'</span>  <span class="pl-5">Akhir: '+field.pemanfaatan_barangjasa_akhir+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Jadwal Pelaksanaan Kontrak</th>'+
                                                                    '<td id="jadwal_kontrak"><span class="pr-5">Mulai: '+field.jadwal_pelaksanaan_kontrak_mulai+'</span>  <span class="pl-5">Akhir: '+field.jadwal_pelaksanaan_kontrak_akhir+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Jadwal Pemilihan Penyedia</th>'+
                                                                    '<td id="jadwal_penyedia"><span class="pr-5">Mulai: '+field.jadwal_pemilihan_penyedia_mulai+'</span>  <span class="pl-5">Akhir: '+field.jadwal_pemilihan_penyedia_akhir+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tanggal Perbarui Paket</th>'+
                                                                    '<td id="tanggal">'+field.tanggal_perbarui_paket+'</td>'+
                                                                '</tr>');
                            break;
                        case 'swakelola' :
                                $('#table_detail tbody').append('<tr>'+
                                                                    '<th scope="row text-bold" nowrap style="width:1px;">Kode RUP</th>'+
                                                                    '<td id="kode_rup">'+field.kode_rup+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Paket</th>'+
                                                                    '<td id="nama_paket">'+field.nama_paket+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama KLPD</th>'+
                                                                    '<td id="nama_klpd">'+field.nama_klpd+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Satuan Kerja</th>'+
                                                                    '<td id="satuan_kerja">'+field.satuan_kerja+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tipe Swakelola</th>'+
                                                                    '<td id="tipe_swakelola">'+field.tipe_swakelola+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Penyelenggaran Swakelola</th>'+
                                                                    '<td id="penyelenggara_swakelola">'+field.penyelenggara_swakelola+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tahun Anggaran</th>'+
                                                                    '<td id="tahun_anggaran">'+field.tahun_anggaran+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Provinsi</th>'+
                                                                    '<td id="provinsi">'+field.provinsi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Kabupaten/Kota</th>'+
                                                                    '<td id="kabupaten_kota">'+field.kabupaten_kota+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Detail Lokasi</th>'+
                                                                    '<td id="detail_lokasi">'+field.detail_lokasi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Deskripsi</th>'+
                                                                    '<td id="deskripsi">'+field.deskripsi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Sumber Dana</th>'+
                                                                    '<td id="sumber_dana">'+field.sumber_dana+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>MAK</th>'+
                                                                    '<td id="mak">'+field.mak+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Pelaksanaan Pekerjaan</th>'+
                                                                    '<td id="pelaksanaan"><span class="pr-5">Awal: '+field.pelaksanaan_pekerjaan_awal+'</span>  <span class="pl-5">Akhir: '+field.pelaksanaan_pekerjaan_akhir+'</span></td>'+
                                                                '</tr>');
                            break;
                    }

                    $('#kode_rup').html(field.kode_rup);
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#detail .overlay').hide();
        }
    });
}

function info_histori(thn,kelompok,kode) {
    $('#div-daftar').hide();
    $('#div-detail').show();

    $('#detail .overlay').show();

    $('#table_detail tbody').empty();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/21/'+thn+'/-/'+kelompok+'/'+kode);

    $.ajax({
        url: serverloc + '/rup/info_histori/'+kelompok+'/'+kode,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            if(response != ''){
                $.each(response, function (i, field) {
                    switch(kelompok.toLowerCase()){
                        case 'penyedia' : 
                                $('#table_detail tbody').append('<tr>'+
                                                                    '<th scope="row text-bold" nowrap style="width:1px;">Kode RUP</th>'+
                                                                    '<td id="kode_rup">'+field.kode_rup+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Paket</th>'+
                                                                    '<td id="nama_paket">'+field.nama_paket+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama KLPD</th>'+
                                                                    '<td id="nama_klpd">'+field.nama_klpd+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Satuan Kerja</th>'+
                                                                    '<td id="satuan_kerja">'+field.satuan_kerja+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Program</th>'+
                                                                    '<td id="nama_program">'+field.nama_program+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Kegiatan</th>'+
                                                                    '<td id="nama_kegiatan">'+field.nama_kegiatan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tahun Anggaran</th>'+
                                                                    '<td id="tahun_anggaran">'+field.tahun_anggaran+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Provinsi</th>'+
                                                                    '<td id="provinsi">'+field.provinsi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Kabupaten/Kota</th>'+
                                                                    '<td id="kabupaten_kota">'+field.kabupaten_kota+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Detail Lokasi</th>'+
                                                                    '<td id="detail_lokasi">'+field.detail_lokasi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Volume Pekerjaan</th>'+
                                                                    '<td id="volume_pekerjaan">'+field.volume_pekerjaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Uraian Pekerjaan</th>'+
                                                                    '<td id="uraian_pekerjaan">'+field.uraian_pekerjaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Spesifikasi Pekerjaan</th>'+
                                                                    '<td id="spesifikasi_pekerjaan">'+field.spesifikasi_pekerjaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Usaha Kecil</th>'+
                                                                    '<td id="usaha_kecil"><span class="badge badge-pill '+field.warna_badge+'">'+field.usaha_kecil+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Sumber Dana</th>'+
                                                                    '<td id="sumber_dana">'+field.sumber_dana+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>MAK</th>'+
                                                                    '<td id="mak">'+field.mak+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Jenis Pengadaan</th>'+
                                                                    '<td id="jenis_pengadaan">'+field.jenis_pengadaan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Total Pagu</th>'+
                                                                    '<td id="total_pagu">'+field.total_pagu+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Metode Pemilihan</th>'+
                                                                    '<td id="metode_pemilihan">'+field.metode_pemilihan+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Pemanfaatan Barang/Jasa</th>'+
                                                                    '<td id="pemanfaatan"><span class="pr-5">Mulai: '+field.pemanfaatan_barangjasa_mulai+'</span>  <span class="pl-5">Akhir: '+field.pemanfaatan_barangjasa_akhir+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Jadwal Pelaksanaan Kontrak</th>'+
                                                                    '<td id="jadwal_kontrak"><span class="pr-5">Mulai: '+field.jadwal_pelaksanaan_kontrak_mulai+'</span>  <span class="pl-5">Akhir: '+field.jadwal_pelaksanaan_kontrak_akhir+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Jadwal Pemilihan Penyedia</th>'+
                                                                    '<td id="jadwal_penyedia"><span class="pr-5">Mulai: '+field.jadwal_pemilihan_penyedia_mulai+'</span>  <span class="pl-5">Akhir: '+field.jadwal_pemilihan_penyedia_akhir+'</span></td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tanggal Perbarui Paket</th>'+
                                                                    '<td id="tanggal">'+field.tanggal_perbarui_paket+'</td>'+
                                                                '</tr>');
                            break;
                        case 'swakelola' :
                                $('#table_detail tbody').append('<tr>'+
                                                                    '<th scope="row text-bold" nowrap style="width:1px;">Kode RUP</th>'+
                                                                    '<td id="kode_rup">'+field.kode_rup+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama Paket</th>'+
                                                                    '<td id="nama_paket">'+field.nama_paket+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Nama KLPD</th>'+
                                                                    '<td id="nama_klpd">'+field.nama_klpd+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Satuan Kerja</th>'+
                                                                    '<td id="satuan_kerja">'+field.satuan_kerja+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tipe Swakelola</th>'+
                                                                    '<td id="tipe_swakelola">'+field.tipe_swakelola+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Penyelenggaran Swakelola</th>'+
                                                                    '<td id="penyelenggara_swakelola">'+field.penyelenggara_swakelola+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Tahun Anggaran</th>'+
                                                                    '<td id="tahun_anggaran">'+field.tahun_anggaran+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Provinsi</th>'+
                                                                    '<td id="provinsi">'+field.provinsi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Kabupaten/Kota</th>'+
                                                                    '<td id="kabupaten_kota">'+field.kabupaten_kota+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Detail Lokasi</th>'+
                                                                    '<td id="detail_lokasi">'+field.detail_lokasi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Deskripsi</th>'+
                                                                    '<td id="deskripsi">'+field.deskripsi+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Sumber Dana</th>'+
                                                                    '<td id="sumber_dana">'+field.sumber_dana+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>MAK</th>'+
                                                                    '<td id="mak">'+field.mak+'</td>'+
                                                                '</tr>'+
                                                                '<tr>'+
                                                                    '<th scope="row" nowrap>Pelaksanaan Pekerjaan</th>'+
                                                                    '<td id="pelaksanaan"><span class="pr-5">Awal: '+field.pelaksanaan_pekerjaan_awal+'</span>  <span class="pl-5">Akhir: '+field.pelaksanaan_pekerjaan_akhir+'</span></td>'+
                                                                '</tr>');
                            break;
                    }

                    $('#kode_rup').html(field.kode_rup);
                })
            } else {
                // do nothing
            }
        },
        complete: function(){
            $('#detail .overlay').hide();
        }
    });
}

$('#thn_rup').change(function(){
    let pilih = this.value;

    $('#rup .overlay').show();

    $('#export_excel').attr('href',serverloc + '/laporan/proses/1/' + pilih);

    satuan_kerja(pilih);
})