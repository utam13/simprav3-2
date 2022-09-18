<?
$namafile = str_replace('/',' dan ',str_replace(',','',$judul));
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$namafile.xls");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul;?></title>

    <link rel="stylesheet" href="<?= base_url();?>assets/backend/css/excel.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/backend/css/color.css">
</head>
<body> 
    <h4><?= $thn != "-" ? "$judul - Tahun Anggaran $thn" : "$judul";?></h4>
    <?
    switch ($laporan) {
        case 1:
    ?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No</th>
                        <th rowspan=2 nowrap class="text-center">Satuan Kerja</th>
                        <th rowspan=2 nowrap class="text-center">Belanja Pengadaan</th>
                        <th colspan=2 nowrap class="text-center">Penyedia</th>
                        <th colspan=2 nowrap class="text-center">Swakelola</th>
                        <th colspan=2 nowrap class="text-center">Penyedia dalam Swakelola</th>
                        <th colspan=2 nowrap class="text-center">Total</th>
                        <th rowspan=2 nowrap class="text-center">Presentase</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->belanja_pengadaan;?></td>
                        <td nowrap class="text-right"><?= $d->penyedia_paket;?></td>
                        <td nowrap class="text-right"><?= $d->penyedia_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->swakelola_paket;?></td>
                        <td nowrap class="text-right"><?= $d->swakelola_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->penyedia_dalam_swakelola_paket;?></td>
                        <td nowrap class="text-right"><?= $d->penyedia_dalam_swakelola_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->paket;?></td>
                        <td nowrap class="text-right"><?= $d->anggaran;?></td>
                        <td nowrap class="text-center"><?= $d->persentase;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th nowrap class="text-right"><?= $total_belanja_pengadaan;?></th>
                        <th nowrap class="text-right"><?= $total_penyedia_paket;?></th>
                        <th nowrap class="text-right"><?= $total_penyedia_anggaran;?></th>
                        <th nowrap class="text-right"><?= $total_swakelola_paket;?></th>
                        <th nowrap class="text-right"><?= $total_swakelola_anggaran;?></th>
                        <th nowrap class="text-right"><?= $total_penyedia_dalam_swakelola_paket;?></th>
                        <th nowrap class="text-right"><?= $total_penyedia_dalam_swakelola_anggaran;?></th>
                        <th nowrap class="text-right"><?= $total_paket;?></th>
                        <th nowrap class="text-right"><?= $total_anggaran;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 2:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No.</th>
                        <th rowspan=2 class="text-center">Metode Pemilihan<br>Penyedia</th>
                        <th colspan=2 class="text-center">Rencana Umum Pengadaan</th>
                        <th colspan=2 class="text-center">Proses Pemilihan Penyedia</th>
                        <th colspan=3 class="text-center">Selesai Proses Pengadaan</th>
                        <th colspan=2 class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu Anggaran</th>
                        <th class="text-center">Nilai Hasil Tender</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->metode;?></td>
                        <td nowrap class="text-right"><?= $d->rup_paket;?></td>
                        <td nowrap class="text-right"><?= $d->rup_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->proses_paket;?></td>
                        <td nowrap class="text-right"><?= $d->proses_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_paket;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_nilai;?></td>
                        <td nowrap class="text-right"><?= $d->hemat_anggaran;?></td>
                        <td nowrap class="text-center"><?= $d->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_rup_paket;?></th>
                        <th class="text-right"><?= $total_rup_anggaran;?></th>
                        <th class="text-right"><?= $total_proses_paket;?></th>
                        <th class="text-right"><?= $total_proses_anggaran;?></th>
                        <th class="text-right"><?= $total_selesai_paket;?></th>
                        <th class="text-right"><?= $total_selesai_anggaran;?></th>
                        <th class="text-right"><?= $total_selesai_nilai;?></th>
                        <th class="text-right"><?= $total_hemat_anggaran;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 3:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">#</th>
                        <th rowspan=2 nowrap class="text-center">OPD</th>
                        <th rowspan=2 nowrap class="text-center">Paket</th>
                        <th colspan=4 nowrap class="text-center">Total Pagu Anggaran</th>
                        <th rowspan=2 nowrap class="text-center">Total</th>
                        <th rowspan=2 nowrap class="text-center">%</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Pengadaan<br>Barang</th>
                        <th nowrap class="text-center">Jasa<br>Konsultasi</th>
                        <th nowrap class="text-center">Jasa<br>Lainnya</th>
                        <th nowrap class="text-center">Pekerjaan<br>Konstruksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->paket;?></td>
                        <td nowrap class="text-right"><?= $d->pengadaan_barang;?></td>
                        <td nowrap class="text-right"><?= $d->jasa_konsultasi;?></td>
                        <td nowrap class="text-right"><?= $d->jasa_lainnya;?></td>
                        <td nowrap class="text-right"><?= $d->pekerjaan_konstruksi;?></td>
                        <td nowrap class="text-right"><?= $d->total;?></td>
                        <td nowrap class="text-right"><?= $d->persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_paket;?></th>
                        <th class="text-right"><?= $total_pengadaan_barang;?></th>
                        <th class="text-right"><?= $total_jasa_konsultasi;?></th>
                        <th class="text-right"><?= $total_jasa_lainnya;?></th>
                        <th class="text-right"><?= $total_pekerjaan_konstruksi;?></th>
                        <th class="text-right"><?= $total;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 4:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th <?= $rowspan;?> nowrap class="text-center">No</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Kode Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Kode RUP Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Satker</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Kegiatan</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nama Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">PPK</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Sumber Dana</th>
                        <?
                        switch($kelompok){
                            case "berjalan" :
                        ?>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Pembuatan<br>Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Pengumuman<br>Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Penetapan<br>Pemenang</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Tanda Tangan<br>Kontrak</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Pagu</th>
                        <th <?= $rowspan;?> nowrap class="text-center">HPS</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Tahapan</th>
                        <?
                                break;
                            case "total":
                            case "selesai":
                        ?>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Pengumuman<br>Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Pagu</th>
                        <th <?= $rowspan;?> nowrap class="text-center">HPS</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nilai Hasil Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nilai Kontrak</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Penyedia</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Domisili</th>
                        <?
                                break;
                            case "batal":
                        ?>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Pengumuman<br>Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Pagu</th>
                        <th <?= $rowspan;?> nowrap class="text-center">HPS</th>
                        <th nowrap class="text-center">Alasan Batal</th>
                        <?
                                break;
                        }
                        ?>
                    </tr>
                    <?if($kelompok == "total" || $kelompok == "selesai"){?>
                    <tr>
                        <th nowrap class="text-center">Rp.</th>
                        <th nowrap class="text-center">%</th>
                    </tr>
                    <?}?>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_paket;?></td>
                        <td nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td nowrap class="text-left"><?= $d->satker;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <?
                        switch($kelompok){
                            case "berjalan":
                        ?>
                        <td nowrap class="text-center"><?= $d->tanggal_pembuatan;?></td>
                        <td nowrap class="text-center"><?= $d->tanggal_pengumuman_tender;?></td>
                        <td nowrap class="text-center"><?= $d->tanggal_penetapan_pemenang;?></td>
                        <td nowrap class="text-center"><?= $d->tanggal_ttd_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->hps;?></td>
                        <td nowrap class="text-center"><?= $d->tahapan;?></td>
                        <?
                                break;
                            case "total":
                            case "selesai":
                        ?>
                        <td nowrap class="text-center"><?= $d->tanggal_pengumuman_tender;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->hps;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_hasil_tender;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_optimalisasi;?></td>
                        <td nowrap class="text-center"><?= $d->persen_optimalisasi;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->domisili;?></td>
                        <?
                                break;
                            case "batal":
                        ?>
                        <td nowrap class="text-center"><?= $d->tanggal_pengumuman_tender;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->hps;?></td>
                        <td nowrap class="text-left"><?= $d->alasan_batal;?></td>
                        <?
                                break;
                        }
                        ?>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 5:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No.</th>
                        <th rowspan=2 class="text-center">Metode Pemilihan<br>Penyedia</th>
                        <th colspan=2 class="text-center">Rencana Umum Pengadaan</th>
                        <th colspan=2 class="text-center">Proses Pemilihan Penyedia</th>
                        <th colspan=3 class="text-center">Selesai Proses Pengadaan</th>
                        <th colspan=2 class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu Anggaran</th>
                        <th class="text-center">Nilai Hasil Tender</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->metode;?></td>
                        <td nowrap class="text-right"><?= $d->rup_paket;?></td>
                        <td nowrap class="text-right"><?= $d->rup_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->proses_paket;?></td>
                        <td nowrap class="text-right"><?= $d->proses_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_paket;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_nilai;?></td>
                        <td nowrap class="text-right"><?= $d->hemat_anggaran;?></td>
                        <td nowrap class="text-center"><?= $d->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_rup_paket;?></th>
                        <th class="text-right"><?= $total_rup_anggaran;?></th>
                        <th class="text-right"><?= $total_proses_paket;?></th>
                        <th class="text-right"><?= $total_proses_anggaran;?></th>
                        <th class="text-right"><?= $total_selesai_paket;?></th>
                        <th class="text-right"><?= $total_selesai_anggaran;?></th>
                        <th class="text-right"><?= $total_selesai_nilai;?></th>
                        <th class="text-right"><?= $total_hemat_anggaran;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 6:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">#</th>
                        <th rowspan=2 nowrap class="text-center">OPD</th>
                        <th rowspan=2 nowrap class="text-center">Paket</th>
                        <th colspan=4 nowrap class="text-center">Total Pagu Anggaran</th>
                        <th rowspan=2 nowrap class="text-center">Total</th>
                        <th rowspan=2 nowrap class="text-center">%</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Pengadaan<br>Barang</th>
                        <th nowrap class="text-center">Jasa<br>Konsultasi</th>
                        <th nowrap class="text-center">Jasa<br>Lainnya</th>
                        <th nowrap class="text-center">Pekerjaan<br>Konstruksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->paket;?></td>
                        <td nowrap class="text-right"><?= $d->pengadaan_barang;?></td>
                        <td nowrap class="text-right"><?= $d->jasa_konsultasi;?></td>
                        <td nowrap class="text-right"><?= $d->jasa_lainnya;?></td>
                        <td nowrap class="text-right"><?= $d->pekerjaan_konstruksi;?></td>
                        <td nowrap class="text-right"><?= $d->total;?></td>
                        <td nowrap class="text-right"><?= $d->persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_paket;?></th>
                        <th class="text-right"><?= $total_pengadaan_barang;?></th>
                        <th class="text-right"><?= $total_jasa_konsultasi;?></th>
                        <th class="text-right"><?= $total_jasa_lainnya;?></th>
                        <th class="text-right"><?= $total_pekerjaan_konstruksi;?></th>
                        <th class="text-right"><?= $total;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 7:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th <?= $rowspan;?> nowrap class="text-center">No</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Kode RUP Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Satker</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Kegiatan</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nama Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">PPK</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Sumber Dana</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Tanggal<br>Pengumuman<br>Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Pagu</th>
                        <th <?= $rowspan;?> nowrap class="text-center">HPS</th>
                        <?
                        switch($kelompok){
                            case "total":
                            case "selesai":
                        ?>
                        <th <?= $rowspan;?> nowrap class="text-center">Nilai Hasil Tender</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nilai Kontrak</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Penyedia</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Domisili</th>
                        <?
                                break;
                            case "batal":
                        ?>
                        <th nowrap class="text-center">Alasan Batal</th>
                        <?
                                break;
                        }
                        ?>
                    </tr>
                    <?if($kelompok == "total" || $kelompok == "selesai"){?>
                    <tr>
                        <th nowrap class="text-center">Rp.</th>
                        <th nowrap class="text-center">%</th>
                    </tr>
                    <?}?>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td nowrap class="text-left"><?= $d->satker;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->tanggal_pengumuman_tender;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->hps;?></td>
                        <?
                        switch($kelompok){
                            case "total":
                            case "selesai":
                        ?>
                        <td nowrap class="text-center"><?= $d->nilai_hasil_tender;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_optimalisasi;?></td>
                        <td nowrap class="text-center"><?= $d->persen_optimalisasi;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->domisili;?></td>
                        <?
                                break;
                            case "batal":
                        ?>
                        <td nowrap class="text-left"><?= $d->alasan_batal;?></td>
                        <?
                                break;
                        }
                        ?>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 8:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Kode RUP Paket</th>
                        <th nowrap class="text-center">Satker</th>
                        <th nowrap class="text-center">Kegiatan</th>
                        <th nowrap class="text-center">Nama Paket</th>
                        <th nowrap class="text-center">PPK</th>
                        <th nowrap class="text-center">Sumber Dana</th>
                        <th nowrap class="text-center">Pagu</th>
                        <th nowrap class="text-center">Nomor Paket</th>
                        <th nowrap class="text-center">Jenis Katalog</th>
                        <th nowrap class="text-center">Nama Komoditas</th>
                        <th nowrap class="text-center">Harga Satuan</th>
                        <th nowrap class="text-center">Kuantitas</th>
                        <th nowrap class="text-center">Ongkos Kirim</th>
                        <th nowrap class="text-center">Total Harga</th>
                        <th nowrap class="text-center">Nama Penyedia</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td nowrap class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td nowrap class="text-left"><?= $d->satker;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->nomor_paket;?></td>
                        <td nowrap class="text-center"><?= $d->jenis_katalog;?></td>
                        <td nowrap class="text-center"><?= $d->nama_komoditas;?></td>
                        <td nowrap class="text-center"><?= $d->harga_satuan;?></td>
                        <td nowrap class="text-center"><?= $d->kuantitas;?></td>
                        <td nowrap class="text-center"><?= $d->ongkos_kirim;?></td>
                        <td nowrap class="text-center"><?= $d->total_harga;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 9:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">Kode RUP Paket</th>
                        <th rowspan=2 nowrap class="text-center">Satker</th>
                        <th rowspan=2 nowrap class="text-center">Kegiatan</th>
                        <th rowspan=2 nowrap class="text-center">Nama Paket</th>
                        <th rowspan=2 nowrap class="text-center">PPK</th>
                        <th rowspan=2 nowrap class="text-center">Sumber Dana</th>
                        <th colspan=2 nowrap class="text-center">Waktu Pelaksanaan</th>
                        <th rowspan=2 nowrap class="text-center">Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Realisasi</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <th rowspan=2 nowrap class="text-center">Penyedia</th>
                        <th rowspan=2 nowrap class="text-center">Domisili</th>
                        <th rowspan=2 nowrap class="text-center">Uraian Pekerjaan</th>
                        <th rowspan=2 nowrap class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Tgl. Mulai</th>
                        <th nowrap class="text-center">Tgl. Selesai</th>
                        <th nowrap class="text-center">Rp.</th>
                        <th nowrap class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td nowrap class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td nowrap class="text-left"><?= $d->satker;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->tgl_mulai;?></td>
                        <td nowrap class="text-center"><?= $d->tgl_selesai;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->realisasi;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi;?></td>
                        <td nowrap class="text-center"><?= $d->persen;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->domisili;?></td>
                        <td nowrap class="text-left"><?= $d->uraian;?></td>
                        <td nowrap class="text-left"><?= $d->keterangan;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 10:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No</th>
                        <th rowspan=2 nowrap class="text-center">Kode RUP Paket</th>
                        <th rowspan=2 nowrap class="text-center">Satker</th>
                        <th rowspan=2 nowrap class="text-center">Kegiatan</th>
                        <th rowspan=2 nowrap class="text-center">Nama Paket</th>
                        <th rowspan=2 nowrap class="text-center">PPK</th>
                        <th rowspan=2 nowrap class="text-center">Sumber Dana</th>
                        <th colspan=2 nowrap class="text-center">Waktu Pelaksanaan</th>
                        <th rowspan=2 nowrap class="text-center">Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Realisasi</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <th rowspan=2 nowrap class="text-center">Penyedia</th>
                        <th rowspan=2 nowrap class="text-center">Domisili</th>
                        <th rowspan=2 nowrap class="text-center">Uraian Pekerjaan</th>
                        <th rowspan=2 nowrap class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Tgl. Mulai</th>
                        <th nowrap class="text-center">Tgl. Selesai</th>
                        <th nowrap class="text-center">Rp.</th>
                        <th nowrap class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td nowrap class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td nowrap class="text-left"><?= $d->satker;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->tgl_mulai;?></td>
                        <td nowrap class="text-center"><?= $d->tgl_selesai;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->realisasi;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi;?></td>
                        <td nowrap class="text-center"><?= $d->persen;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->domisili;?></td>
                        <td nowrap class="text-left"><?= $d->uraian;?></td>
                        <td nowrap class="text-left"><?= $d->keterangan;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 11:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th colspan=11 class="text-left">
                            A. Menggunakan Mekanisme Tender Melalui Aplikasi SPSE
                        </th>
                    </tr>
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No</th>
                        <th rowspan=2 nowrap class="text-center">Metode Pemilihan Penyedia</th>
                        <th colspan=2 nowrap class="text-center">Rencana Umum Pengadaan</th>
                        <th colspan=2 nowrap class="text-center">Proses Pemilihan Penyedia</th>
                        <th colspan=3 nowrap class="text-center">Selesai Proses Pengadaan</th>
                        <th colspan=2 nowrap class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Pagu Anggaran</th>
                        <th nowrap class="text-center">Nilai Hasil Tender</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Persentase</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">1</th>
                        <th nowrap class="text-center">2</th>
                        <th nowrap class="text-center">3</th>
                        <th nowrap class="text-center">4</th>
                        <th nowrap class="text-center">5</th>
                        <th nowrap class="text-center">6</th>
                        <th nowrap class="text-center">7</th>
                        <th nowrap class="text-center">8</th>
                        <th nowrap class="text-center">9</th>
                        <th nowrap class="text-center">10</th>
                        <th nowrap class="text-center">11</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->metode;?></td>
                        <td nowrap class="text-right"><?= $d->rup_paket;?></td>
                        <td nowrap class="text-right"><?= $d->rup_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->proses_paket;?></td>
                        <td nowrap class="text-right"><?= $d->proses_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_paket;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->selesai_nilai;?></td>
                        <td nowrap class="text-right"><?= $d->hemat_anggaran;?></td>
                        <td nowrap class="text-center"><?= $d->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_rup_paket;?></th>
                        <th class="text-right"><?= $total_rup_anggaran;?></th>
                        <th class="text-right"><?= $total_proses_paket;?></th>
                        <th class="text-right"><?= $total_proses_anggaran;?></th>
                        <th class="text-right"><?= $total_selesai_paket;?></th>
                        <th class="text-right"><?= $total_selesai_anggaran;?></th>
                        <th class="text-right"><?= $total_selesai_nilai;?></th>
                        <th class="text-right"><?= $total_hemat_anggaran;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <br>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th colspan=11 class="text-left">
                            B. Menggunakan Mekanisme Non Tender Transaksional Melalui Aplikasi SPSE
                        </th>
                    </tr>
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No</th>
                        <th rowspan=2 nowrap class="text-center">Metode Pemilihan Penyedia</th>
                        <th colspan=2 nowrap class="text-center">Rencana Umum Pengadaan</th>
                        <th colspan=2 nowrap class="text-center">Proses Pemilihan Penyedia</th>
                        <th colspan=3 nowrap class="text-center">Selesai Proses Pengadaan</th>
                        <th colspan=2 nowrap class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Paket</th>
                        <th nowrap class="text-center">Pagu Anggaran</th>
                        <th nowrap class="text-center">Nilai Hasil Tender</th>
                        <th nowrap class="text-center">Anggaran</th>
                        <th nowrap class="text-center">Persentase</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">1</th>
                        <th nowrap class="text-center">2</th>
                        <th nowrap class="text-center">3</th>
                        <th nowrap class="text-center">4</th>
                        <th nowrap class="text-center">5</th>
                        <th nowrap class="text-center">6</th>
                        <th nowrap class="text-center">7</th>
                        <th nowrap class="text-center">8</th>
                        <th nowrap class="text-center">9</th>
                        <th nowrap class="text-center">10</th>
                        <th nowrap class="text-center">11</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data2);
                    foreach ($hasil as $d2) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d2->no;?></td>
                        <td nowrap class="text-left"><?= $d2->metode;?></td>
                        <td nowrap class="text-right"><?= $d2->rup_paket;?></td>
                        <td nowrap class="text-right"><?= $d2->rup_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d2->proses_paket;?></td>
                        <td nowrap class="text-right"><?= $d2->proses_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d2->selesai_paket;?></td>
                        <td nowrap class="text-right"><?= $d2->selesai_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d2->selesai_nilai;?></td>
                        <td nowrap class="text-right"><?= $d2->hemat_anggaran;?></td>
                        <td nowrap class="text-center"><?= $d2->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_rup_paket2;?></th>
                        <th class="text-right"><?= $total_rup_anggaran2;?></th>
                        <th class="text-right"><?= $total_proses_paket2;?></th>
                        <th class="text-right"><?= $total_proses_anggaran2;?></th>
                        <th class="text-right"><?= $total_selesai_paket2;?></th>
                        <th class="text-right"><?= $total_selesai_anggaran2;?></th>
                        <th class="text-right"><?= $total_selesai_nilai2;?></th>
                        <th class="text-right"><?= $total_hemat_anggaran2;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 12:?>
    <? case 13:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No</th>
                        <th rowspan=2 nowrap class="text-center">Satuan Kerja</th>
                        <th colspan=2 nowrap class="text-center">Pengadaan</th>
                        <th colspan=5 nowrap class="text-center">Non Pengadaan</th>
                        <th rowspan=2 class="text-center">Total</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Barang & Jasa</th>
                        <th nowrap class="text-center">Modal</th>
                        <th nowrap class="text-center">Pegawai</th>
                        <th nowrap class="text-center">Hibah</th>
                        <th nowrap class="text-center">Bansos</th>
                        <th nowrap class="text-center">BTT *</th>
                        <th nowrap class="text-center">Subsidi</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->total_barang_jasa;?></td>
                        <td nowrap class="text-right"><?= $d->total_modal;?></td>
                        <td nowrap class="text-right"><?= $d->total_pegawai;?></td>
                        <td nowrap class="text-right"><?= $d->total_hibah;?></td>
                        <td nowrap class="text-right"><?= $d->total_bansos;?></td>
                        <td nowrap class="text-right"><?= $d->total_tidak_terduga;?></td>
                        <td nowrap class="text-right"><?= $d->total_dll;?></td>
                        <td nowrap class="text-right"><?= $d->total;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th>&nbsp;</th>
                        <th class="text-right">Total</th>
                        <th class="text-right"><?= $total_1;?></th>
                        <th class="text-right"><?= $total_2;?></th>
                        <th class="text-right"><?= $total_3;?></th>
                        <th class="text-right"><?= $total_4;?></th>
                        <th class="text-right"><?= $total_5;?></th>
                        <th class="text-right"><?= $total_6;?></th>
                        <th class="text-right"><?= $total_7;?></th>
                        <th class="text-right"><?= $total_8;?></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 14:?>
    <? case 15:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Nama SKPD / Instansi Sub Unit</th>
                        <th nowrap class="text-center">Total Anggaran Program/Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->total;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th>&nbsp;</th>
                        <th class="text-right">Total</th>
                        <th class="text-right"><?= $total;?></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 16:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center" colspan=3>Kode</th>
                        <th nowrap class="text-center">Nama Program/Kegiatan/Sub Kegiatan</th>
                        <th nowrap class="text-center">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr class="<?= $d->bg;?>">
                        <td class="text-center"><?= $d->kode_1;?></td>
                        <td class="text-center"><?= $d->kode_2;?></td>
                        <td class="text-center"><?= $d->kode_3;?></td>
                        <td nowrap class="text-left"><?= $d->nama;?></td>
                        <td nowrap class="text-right"><?= $d->total;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 17:?>
            <table>
                <tr>
                    <th class="text-right">Program</th>
                    <td nowrap><?= $program;?></td>
                </tr>
                <tr>
                    <th class="text-right">Kegiatan</th>
                    <td nowrap><?= $kegiatan;?></td>
                </tr>
                <tr>
                    <th class="text-right">Sub Kegiatan</th>
                    <td nowrap><?= $subkegiatan;?></td>
                </tr>
            </table>
            <br>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">Kode Rekening</th>
                        <th nowrap class="text-center">Uraian</th>
                        <th nowrap class="text-center">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->kode;?></td>
                        <td nowrap class="text-left"><?= $d->rincian;?></td>
                        <td nowrap class="text-right"><?= $d->pagu;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th>&nbsp;</th>
                        <th class="text-right">Total</th>
                        <th class="text-right"><?= $total;?></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 18:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Nama Paket</th>
                        <th nowrap class="text-center">Nama Kegiatan</th>
                        <th nowrap class="text-center">Pagu</th>
                        <?switch ($kelompok) {
                            case 'penyedia':
                        ?>
                        <th nowrap class="text-center">Metode Pemilihan Penyedia</th>
                        <th nowrap class="text-center">Jenis Pengadaan</th>
                        <?
                                break;
                            case 'swakelola':
                        ?>
                        <th nowrap class="text-center">Tipe Swakelola</th>
                        <?
                                break;
                        }?>
                        <th nowrap class="text-center">Sumber Dana</th>
                        <th nowrap class="text-center">Kode RUP</th>
                        <th nowrap class="text-center">Waktu Pemilihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->nama_kegiatan;?></td>
                        <td nowrap class="text-right"><?= $d->pagu;?></td>
                        <?switch ($kelompok) {
                            case 'penyedia':
                        ?>
                        <td nowrap class="text-center"><?= $d->metode_pemilihan;?></td>
                        <td nowrap class="text-center"><?= $d->jenis_pengadaan;?></td>
                        <?
                                break;
                            case 'swakelola':
                        ?>
                        <td nowrap class="text-center"><?= $d->tipe_swakelola;?></td>
                        <?
                                break;
                        }?>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->kode_rup;?></td>
                        <td nowrap class="text-center"><?= $d->waktu;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 19:?>
            <table class="record">
                <tbody>
                    <tr>
                        <td nowrap style="width:200px;">Kode RUP</td>
                        <td id="kode_rup"><?= $kode_rup;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Nama Paket</td>
                        <td id="nama_paket"><?= $nama_paket;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Nama KLPD</td>
                        <td id="nama_klpd"><?= $nama_klpd;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Satuan Kerja</td>
                        <td id="satuan_kerja"><?= $satuan_kerja;?></td>
                    </tr>

                    <!-- khusus penyedia -->
                    <?if($kelompok == "penyedia"){?>
                    <tr>
                        <td nowrap>Nama Program</td>
                        <td id="nama_program"><?= $nama_program;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Nama Kegiatan</td>
                        <td id="nama_kegiatan"><?= $nama_kegiatan;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->
                    <!-- khusus swakelola -->
                    <?if($kelompok == "swakelola"){?>
                    <tr>
                        <td nowrap>Tipe Swakelola</td>
                        <td id="tipe_swakelola"><?= $tipe_swakelola;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Penyelenggaran Swakelola</td>
                        <td id="penyelenggara_swakelola"><?= $penyelenggara_swakelola;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->

                    <tr>
                        <td nowrap>Tahun Anggaran</td>
                        <td id="tahun_anggaran"><?= $tahun_anggaran;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Provinsi</td>
                        <td id="provinsi"><?= $provinsi;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Kabupaten/Kota</td>
                        <td id="kabupaten_kota"><?= $kabupaten_kota;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Detail Lokasi</td>
                        <td id="detail_lokasi"><?= $detail_lokasi;?></td>
                    </tr>

                    <!-- khusus penyedia -->
                    <?if($kelompok == "penyedia"){?>
                    <tr>
                        <td nowrap>Volume Pekerjaan</td>
                        <td id="volume_pekerjaan"><?= $volume_pekerjaan;?></td>
                    </tr>
                    <tr >
                        <td nowrap>Uraian Pekerjaan</td>
                        <td id="uraian_pekerjaan"><?= $uraian_pekerjaan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Spesifikasi Pekerjaan</td>
                        <td id="spesifikasi_pekerjaan"><?= $spesifikasi_pekerjaan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Usaha Kecil</td>
                        <td id="usaha_kecil"><?= $usaha_kecil;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->
                    <!-- khusus swakelola -->
                    <?if($kelompok == "swakelola"){?>
                    <tr>
                        <td nowrap>Deskripsi</td>
                        <td id="deskripsi"><?= $deskripsi;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->

                    <tr>
                        <td nowrap>Sumber Dana</td>
                        <td id="sumber_dana"><?= $sumber_dana;?></td>
                    </tr>
                    <tr>
                        <td nowrap>MAK</td>
                        <td id="mak"><?= $mak;?></td>
                    </tr>

                    <!-- khusus penyedia -->
                    <?if($kelompok == "penyedia"){?>
                    <tr>
                        <td nowrap>Jenis Pengadaan</td>
                        <td id="jenis_pengadaan"><?= $jenis_pengadaan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Total Pagu</td>
                        <td id="total_pagu"><?= $total_pagu;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Metode Pemilihan</td>
                        <td id="metode_pemilihan"><?= $metode_pemilihan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Pemanfaatan Barang/Jasa</td>
                        <td id="pemanfaatan">
                            <span class="pr-5">Mulai: <?= $pemanfaatan_barangjasa_mulai;?></span>  <span class="pl-5">Akhir: <?= $pemanfaatan_barangjasa_akhir;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>Jadwal Pelaksanaan Kontrak</td>
                        <td id="jadwal_kontrak">
                            <span class="pr-5">Mulai: <?= $jadwal_pelaksanaan_kontrak_mulai;?></span>  <span class="pl-5">Akhir: <?= $jadwal_pelaksanaan_kontrak_akhir;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>Jadwal Pemilihan Penyedia</td>
                        <td id="jadwal_penyedia">
                            <span class="pr-5">Mulai: <?= $jadwal_pemilihan_penyedia_mulai;?></span>  <span class="pl-5">Akhir: <?= $jadwal_pemilihan_penyedia_akhir;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>Tanggal Perbarui Paket</td>
                        <td id="tanggal"><?= $tanggal_perbarui_paket;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->
                    <!-- khusus swakelola -->
                    <?if($kelompok == "swakelola"){?>
                    <tr>
                        <td nowrap>Pelaksanaan Pekerjaan</td>
                        <td id="pelaksanaan">
                            <span class="pr-5">Awal: <?= $pelaksanaan_pekerjaan_awal;?></span>  <span class="pl-5">Akhir: <?= $pelaksanaan_pekerjaan_akhir;?></span>
                        </td>
                    </tr>
                    <?}?>
                    <!-- end -->
                </tbody>
            </table>
    <?      break;?>
    <? case 20:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">OPD</th>
                        <th nowrap class="text-center">Kode Lama RUP</th>
                        <th nowrap class="text-center">Nama Lama RUP</th>
                        <th nowrap class="text-center">Kode Baru RUP</th>
                        <th nowrap class="text-center">Nama Baru RUP</th>
                        <th nowrap class="text-center">Alasan Perubahan</th>
                        <th nowrap class="text-center">Waktu Perubahan</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->nama_satker;?></td>
                        <td nowrap class="text-center"><?= $d->kode_paket_lama;?></td>
                        <td nowrap class="text-left"><?= $d->nama_lama;?></td>
                        <td nowrap class="text-center"><?= $d->kode_paket_baru;?></td>
                        <td nowrap class="text-left"><?= $d->nama_baru;?></td>
                        <td nowrap class="text-left"><?= $d->alasan_kajiulang;?></td>
                        <td nowrap class="text-center"><?= $d->waktu;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 21:?>
            <table class="record">
                <tbody>
                    <tr>
                        <td nowrap style="width:200px;">Kode RUP</td>
                        <td id="kode_rup"><?= $kode_rup;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Nama Paket</td>
                        <td id="nama_paket"><?= $nama_paket;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Nama KLPD</td>
                        <td id="nama_klpd"><?= $nama_klpd;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Satuan Kerja</td>
                        <td id="satuan_kerja"><?= $satuan_kerja;?></td>
                    </tr>

                    <!-- khusus penyedia -->
                    <?if($kelompok == "PENYEDIA"){?>
                    <tr>
                        <td nowrap>Nama Program</td>
                        <td id="nama_program"><?= $nama_program;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Nama Kegiatan</td>
                        <td id="nama_kegiatan"><?= $nama_kegiatan;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->
                    <!-- khusus swakelola -->
                    <?if($kelompok == "SWAKELOLA"){?>
                    <tr>
                        <td nowrap>Tipe Swakelola</td>
                        <td id="tipe_swakelola"><?= $tipe_swakelola;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Penyelenggaran Swakelola</td>
                        <td id="penyelenggara_swakelola"><?= $penyelenggara_swakelola;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->

                    <tr>
                        <td nowrap>Tahun Anggaran</td>
                        <td id="tahun_anggaran"><?= $tahun_anggaran;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Provinsi</td>
                        <td id="provinsi"><?= $provinsi;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Kabupaten/Kota</td>
                        <td id="kabupaten_kota"><?= $kabupaten_kota;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Detail Lokasi</td>
                        <td id="detail_lokasi"><?= $detail_lokasi;?></td>
                    </tr>

                    <!-- khusus penyedia -->
                    <?if($kelompok == "PENYEDIA"){?>
                    <tr>
                        <td nowrap>Volume Pekerjaan</td>
                        <td id="volume_pekerjaan"><?= $volume_pekerjaan;?></td>
                    </tr>
                    <tr >
                        <td nowrap>Uraian Pekerjaan</td>
                        <td id="uraian_pekerjaan"><?= $uraian_pekerjaan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Spesifikasi Pekerjaan</td>
                        <td id="spesifikasi_pekerjaan"><?= $spesifikasi_pekerjaan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Usaha Kecil</td>
                        <td id="usaha_kecil"><?= $usaha_kecil;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->
                    <!-- khusus swakelola -->
                    <?if($kelompok == "SWAKELOLA"){?>
                    <tr>
                        <td nowrap>Deskripsi</td>
                        <td id="deskripsi"><?= $deskripsi;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->

                    <tr>
                        <td nowrap>Sumber Dana</td>
                        <td id="sumber_dana"><?= $sumber_dana;?></td>
                    </tr>
                    <tr>
                        <td nowrap>MAK</td>
                        <td id="mak"><?= $mak;?></td>
                    </tr>

                    <!-- khusus penyedia -->
                    <?if($kelompok == "PENYEDIA"){?>
                    <tr>
                        <td nowrap>Jenis Pengadaan</td>
                        <td id="jenis_pengadaan"><?= $jenis_pengadaan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Total Pagu</td>
                        <td id="total_pagu"><?= $total_pagu;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Metode Pemilihan</td>
                        <td id="metode_pemilihan"><?= $metode_pemilihan;?></td>
                    </tr>
                    <tr>
                        <td nowrap>Pemanfaatan Barang/Jasa</td>
                        <td id="pemanfaatan">
                            <span class="pr-5">Mulai: <?= $pemanfaatan_barangjasa_mulai;?></span>  <span class="pl-5">Akhir: <?= $pemanfaatan_barangjasa_akhir;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>Jadwal Pelaksanaan Kontrak</td>
                        <td id="jadwal_kontrak">
                            <span class="pr-5">Mulai: <?= $jadwal_pelaksanaan_kontrak_mulai;?></span>  <span class="pl-5">Akhir: <?= $jadwal_pelaksanaan_kontrak_akhir;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>Jadwal Pemilihan Penyedia</td>
                        <td id="jadwal_penyedia">
                            <span class="pr-5">Mulai: <?= $jadwal_pemilihan_penyedia_mulai;?></span>  <span class="pl-5">Akhir: <?= $jadwal_pemilihan_penyedia_akhir;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap>Tanggal Perbarui Paket</td>
                        <td id="tanggal"><?= $tanggal_perbarui_paket;?></td>
                    </tr>
                    <?}?>
                    <!-- end -->
                    <!-- khusus swakelola -->
                    <?if($kelompok == "SWAKELOLA"){?>
                    <tr>
                        <td nowrap>Pelaksanaan Pekerjaan</td>
                        <td id="pelaksanaan">
                            <span class="pr-5">Awal: <?= $pelaksanaan_pekerjaan_awal;?></span>  <span class="pl-5">Akhir: <?= $pelaksanaan_pekerjaan_akhir;?></span>
                        </td>
                    </tr>
                    <?}?>
                    <!-- end -->
                </tbody>
            </table>
    <?      break;?>
    <? case 22:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">Jenis Pekerjaan</th>
                        <th rowspan=2 nowrap class="text-center">Total<br>Paket</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Selesai</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Tayang</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Review</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Batal</th>
                        <th rowspan=2 nowrap class="text-center">Total<br>Pagu<br>Anggaran</th>
                        <th rowspan=2 nowrap class="text-center">%</th>
                        <th rowspan=2 nowrap class="text-center">Pagu<br>Anggaran<br>Selesai</th>
                        <th rowspan=2 nowrap class="text-center">Harga<br>Negosiasi</th>
                        <th colspan=2 nowrap class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Optimalisasi</th>
                        <th nowrap class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data2);
                    foreach ($hasil as $d2) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d2->no;?></td>
                        <td class="text-left"><?= $d2->jenis;?></td>
                        <td nowrap class="text-right"><?= $d2->total_paket;?></td>
                        <td nowrap class="text-right"><?= $d2->paket_selesai;?></td>
                        <td nowrap class="text-right"><?= $d2->paket_tayang;?></td>
                        <td nowrap class="text-right"><?= $d2->paket_review;?></td>
                        <td nowrap class="text-right"><?= $d2->paket_batal;?></td>
                        <td nowrap class="text-right"><?= $d2->total_pagu_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d2->persen_pagu_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d2->pagu_anggaran_selesai;?></td>
                        <td nowrap class="text-right"><?= $d2->harga_negosiasi;?></td>
                        <td nowrap class="text-right"><?= $d2->hemat_optimalisasi;?></td>
                        <td nowrap class="text-right"><?= $d2->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th nowrap class="text-right"><?= $total_total_paket;?></th>
                        <th nowrap class="text-right"><?= $total_paket_selesai;?></th>
                        <th nowrap class="text-right"><?= $total_paket_tayang;?></th>
                        <th nowrap class="text-right"><?= $total_paket_review;?></th>
                        <th nowrap class="text-right"><?= $total_paket_batal;?></th>
                        <th nowrap class="text-right"><?= $total_total_pagu_anggaran;?></th>
                        <th></th>
                        <th nowrap class="text-right"><?= $total_pagu_anggaran_selesai;?></th>
                        <th nowrap class="text-right"><?= $total_harga_negosiasi;?></th>
                        <th nowrap class="text-right"><?= $total_hemat_optimalisasi;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 23:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">Jenis Pekerjaan</th>
                        <th rowspan=2 nowrap class="text-center">Total<br>Paket</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Selesai</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Tayang</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Review</th>
                        <th rowspan=2 nowrap class="text-center">Paket<br>Batal</th>
                        <th rowspan=2 nowrap class="text-center">Total<br>Pagu<br>Anggaran</th>
                        <th rowspan=2 nowrap class="text-center">%</th>
                        <th rowspan=2 nowrap class="text-center">Pagu<br>Anggaran<br>Selesai</th>
                        <th rowspan=2 nowrap class="text-center">Harga<br>Negosiasi</th>
                        <th colspan=2 nowrap class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Optimalisasi</th>
                        <th nowrap class="text-center">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->jenis;?></td>
                        <td nowrap class="text-right"><?= $d->total_paket;?></td>
                        <td nowrap class="text-right"><?= $d->paket_selesai;?></td>
                        <td nowrap class="text-right"><?= $d->paket_tayang;?></td>
                        <td nowrap class="text-right"><?= $d->paket_review;?></td>
                        <td nowrap class="text-right"><?= $d->paket_batal;?></td>
                        <td nowrap class="text-right"><?= $d->total_pagu_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->persen_pagu_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->pagu_anggaran_selesai;?></td>
                        <td nowrap class="text-right"><?= $d->harga_negosiasi;?></td>
                        <td nowrap class="text-right"><?= $d->hemat_optimalisasi;?></td>
                        <td nowrap class="text-right"><?= $d->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 nowrap class="text-right">Total</th>
                        <th nowrap class="text-right"><?= $total_total_paket;?></th>
                        <th nowrap class="text-right"><?= $total_paket_selesai;?></th>
                        <th nowrap class="text-right"><?= $total_paket_tayang;?></th>
                        <th nowrap class="text-right"><?= $total_paket_review;?></th>
                        <th nowrap class="text-right"><?= $total_paket_batal;?></th>
                        <th nowrap class="text-right"><?= $total_total_pagu_anggaran;?></th>
                        <th></th>
                        <th nowrap class="text-right"><?= $total_pagu_anggaran_selesai;?></th>
                        <th nowrap class="text-right"><?= $total_harga_negosiasi;?></th>
                        <th nowrap class="text-right"><?= $total_hemat_optimalisasi;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 24:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No.</th>
                        <th rowspan=2 class="text-center">Satuan Kerja</th>
                        <th colspan=2 class="text-center">Belanja Pengadaan</th>
                        <th colspan=3 class="text-center">Realisasi Kontrak</th>
                        <th colspan=3 class="text-center">Paket Selesai</th>
                    </tr>
                    <tr>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Persentase</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->belanja_pengadaan_paket;?></td>
                        <td nowrap class="text-right"><?= $d->belanja_pengadaan_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->realisasi_kontrak_paket;?></td>
                        <td nowrap class="text-right"><?= $d->realisasi_kontrak_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->realisasi_kontrak_persen;?></td>
                        <td nowrap class="text-right"><?= $d->paket_selesai_paket;?></td>
                        <td nowrap class="text-right"><?= $d->paket_selesai_anggaran;?></td>
                        <td nowrap class="text-right"><?= $d->paket_selesai_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 nowrap class="text-right">Total</th>
                        <th nowrap class="text-right"><?= $total_1;?></th>
                        <th nowrap class="text-right"><?= $total_2;?></th>
                        <th nowrap class="text-right"><?= $total_3;?></th>
                        <th nowrap class="text-right"><?= $total_4;?></th>
                        <th>&nbsp;</th>
                        <th nowrap class="text-right"><?= $total_5;?></th>
                        <th nowrap class="text-right"><?= $total_6;?></th>
                        <th>&nbsp;</th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 25:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th <?= $rowspan;?> nowrap class="text-center">No.</th>
                        <?if($kelompok == "tender"){?>
                        <th <?= $rowspan;?> nowrap class="text-center">Kode Paket</th>
                        <?}?>
                        <th <?= $rowspan;?> nowrap class="text-center">Kode RUP Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Satker</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Kegiatan</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nama Paket</th>
                        <th <?= $rowspan;?> nowrap class="text-center">PPK</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Pagu</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Nilai Kontrak</th>
                        
                        <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                        <th colspan=2 nowrap class="text-center">Realisasi Kontrak</th>
                        <th <?= $rowspan;?> nowrap class="text-center">Penyedia</th>
                        <th colspan=2 nowrap class="text-center">Sisa Kontrak</th>
                        <th <?= $rowspan;?> nowrap class="text-center" style="width:300px;">Status Pelaksanaan</th>
                        <th <?= $rowspan;?> nowrap class="text-center" style="width:300px;">Status Strategis</th>
                        <?}?>
                        
                        <?if(strpos($kelompok, "pencatatan") !== false){?>
                        <th <?= $rowspan;?> nowrap class="text-center">Keterangan</th>
                        <?}?>
                    </tr>
                    <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                    <tr>
                        <th nowrap class="text-center">Rp</th>
                        <th nowrap class="text-center">Persentase</th>
                        <th nowrap class="text-center">Rp</th>
                        <th nowrap class="text-center">Persentase</th>
                    </tr>
                    <?}?>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        
                        <?if($kelompok == "tender"){?>
                        <td nowrap class="text-center"><?= $d->kode_paket;?></td>
                        <?}?>
                        
                        <td nowrap class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td nowrap class="text-left"><?= $d->nama_satker;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_kontrak;?></td>

                        <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                        <td nowrap class="text-center"><?= $d->realisasi_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->realisasi_kontrak_persen;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->sisa_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->sisa_kontrak_persen;?></td>
                        <td nowrap class="text-center"><?= $d->nama_status_pekerjaan;?></td>
                        <td nowrap class="text-center"><?= $d->status_paket_strategis;?></td>                                                                   
                        <?}?>

                        <?if(strpos($kelompok, "pencatatan") !== false){?>
                        <td nowrap class="text-left"><?= $d->keterangan;?></td>
                        <?}?>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 26:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=3 class="text-center">No.</th>
                        <th rowspan=3 class="text-center">Satuan Kerja</th>
                        <th rowspan=2 colspan=2 class="text-center">Belanja Pengadaan</th>
                        <th colspan=8 class="text-center">Realisasi</th>
                        <th rowspan=2 colspan=2 class="text-center">Total Realisasi Belanja Pengadaan</th>
                    </tr>
                    <tr>
                        <th colspan=2 class="text-center">Triwulan I</th>
                        <th colspan=2 class="text-center">Triwulan II</th>
                        <th colspan=2 class="text-center">Triwulan III</th>
                        <th colspan=2 class="text-center">Triwulan IV</th>
                    </tr>
                    <tr>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Paket</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-right"><?= $d->belanja_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->belanja_paket;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan1_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan1_paket;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan2_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan2_paket;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan3_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan3_paket;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan4_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->triwulan4_paket;?></td>
                        <td nowrap class="text-right"><?= $d->total_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->total_paket;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 nowrap class="text-right">Total</th>
                        <th nowrap class="text-right"><?= $total_1;?></th>
                        <th nowrap class="text-right"><?= $total_2;?></th>
                        <th nowrap class="text-right"><?= $total_3;?></th>
                        <th nowrap class="text-right"><?= $total_4;?></th>
                        <th nowrap class="text-right"><?= $total_5;?></th>
                        <th nowrap class="text-right"><?= $total_6;?></th>
                        <th nowrap class="text-right"><?= $total_7;?></th>
                        <th nowrap class="text-right"><?= $total_8;?></th>
                        <th nowrap class="text-right"><?= $total_9;?></th>
                        <th nowrap class="text-right"><?= $total_10;?></th>
                        <th nowrap class="text-right"><?= $total_11;?></th>
                        <th nowrap class="text-right"><?= $total_12;?></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 27:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">Satker</th>
                        <th rowspan=2 nowrap class="text-center">Program</th>
                        <th rowspan=2 nowrap class="text-center">Kegiatan</th>
                        <th rowspan=2 nowrap class="text-center">Nama Paket</th>
                        <th rowspan=2 nowrap class="text-center">PPK</th>
                        <th rowspan=2 nowrap class="text-center">Sumber Dana</th>
                        <th rowspan=2 nowrap class="text-center">Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Nilai Kontrak</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <th rowspan=2 nowrap class="text-center">Penyedia</th>
                        <th rowspan=2 nowrap class="text-center">Status<br>Pelaksanaan</th>
                        <th rowspan=2 nowrap class="text-center">Status<br>Strategis</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Rp</th>
                        <th nowrap class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->nama_satker;?></td>
                        <td nowrap class="text-left"><?= $d->program;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi_nilai;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi_persen;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->status_pelaksanaan;?></td>
                        <td nowrap class="text-center"><?= $d->status_strategis;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 28:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">#</th>
                        <th rowspan=2 nowrap class="text-center">Satker</th>
                        <th rowspan=2 nowrap class="text-center">Program</th>
                        <th rowspan=2 nowrap class="text-center">Kegiatan</th>
                        <th rowspan=2 nowrap class="text-center">Nama Paket</th>
                        <th rowspan=2 nowrap class="text-center">PPK</th>
                        <th rowspan=2 nowrap class="text-center">Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Nilai Kontrak</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <?if(strpos($kelompok, "tender") !== false){?>
                        <th rowspan=2 nowrap class="text-center">Penyedia</th>
                        <?}?>
                        <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                        <th rowspan=2 nowrap class="text-center">Status<br>Paket</th>
                        <th rowspan=2 nowrap class="text-center">Status<br>Pelaksanaan</th>
                        <?}?>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Rp</th>
                        <th nowrap class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->nama_satker;?></td>
                        <td nowrap class="text-left"><?= $d->program;?></td>
                        <td nowrap class="text-left"><?= $d->kegiatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-left"><?= $d->ppk;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi_nilai;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi_persen;?></td>
                        <?if(strpos($kelompok, "tender") !== false){?>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <?}?>
                        <?if($kelompok == "tender" || $kelompok == "nontender"){?>
                        <td nowrap class="text-center"><?= $d->status_paket;?></td>
                        <td nowrap class="text-center"><?= $d->status_pelaksanaan;?></td>
                        <?}?>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 29:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Provinsi</th>
                        <th nowrap class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->provinsi;?></td>
                        <td class="text-center"><?= $d->total;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 30:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Kabupaten/Kota</th>
                        <th nowrap class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-left"><?= $d->kabupaten_kota;?></td>
                        <td class="text-center"><?= $d->total;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 31:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">Kode</th>
                        <th rowspan=2 nowrap class="text-center">Nama</th>
                        <th colspan=4 nowrap class="text-center">Jumlah Paket <?= $nama_kelompok;?></th>
                        <th rowspan=2 nowrap class="text-center">Total Paket</th>
                        <th rowspan=2 nowrap class="text-center">Total Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Total Kontrak</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Aktif</th>
                        <th nowrap class="text-center">Batal</th>
                        <th nowrap class="text-center">Gagal</th>
                        <th nowrap class="text-center">Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kd_penyedia;?></td>
                        <td nowrap class="text-left"><?= $d->nama_penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->aktif;?></a></td>
                        <td nowrap class="text-center"><?= $d->batal;?></td>
                        <td nowrap class="text-center"><?= $d->gagal;?></td>
                        <td nowrap class="text-center"><?= $d->selesai;?></td>
                        <td nowrap class="text-right"><?= $d->total_paket;?></td>
                        <td nowrap class="text-right"><?= $d->total_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->total_kontrak;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 32:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Kode Paket</th>
                        <th nowrap class="text-center">Satker</th>
                        <th nowrap class="text-center">Nama Paket</th>
                        <th nowrap class="text-center">Sumber Dana</th>
                        <th nowrap class="text-center">Pagu</th>
                        <th nowrap class="text-center">Nilai Kontrak</th>
                        <!-- <th nowrap class="text-center">Penyedia</th> -->
                        <?if($namakel == "tender" || $namakel == "nontender"){?>
                        <th nowrap class="text-center">Status Pelaksanaan</th>
                        <?}?>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_paket;?></td>
                        <td nowrap class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></a></td>
                        <td nowrap class="text-right"><?= $d->pagu;?></td>
                        <td nowrap class="text-right"><?= $d->nilai_kontrak;?></td>
                        <!-- <td nowrap class="text-left"><?= $d->penyedia;?></td> -->
                        <?if($namakel == "tender" || $namakel == "nontender"){?>
                        <td nowrap class="text-center"><?= $d->status_pelaksanaan;?></td>
                        <?}?>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 33:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">NIP</th>
                        <th rowspan=2 nowrap class="text-center">Nama</th>
                        <th colspan=4 nowrap class="text-center">Jumlah Paket</th>
                        <th rowspan=2 nowrap class="text-center">Total Paket</th>
                        <th rowspan=2 nowrap class="text-center">Total Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Total Kontrak</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Aktif</th>
                        <th nowrap class="text-center">Batal</th>
                        <th nowrap class="text-center">Gagal</th>
                        <th nowrap class="text-center">Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->nip_pegawai;?></td>
                        <td nowrap class="text-left"><?= $d->nama_pegawai;?></td>
                        <td nowrap class="text-center"><?= $d->aktif;?></a></td>
                        <td nowrap class="text-center"><?= $d->batal;?></td>
                        <td nowrap class="text-center"><?= $d->gagal;?></td>
                        <td nowrap class="text-center"><?= $d->selesai;?></td>
                        <td nowrap class="text-right"><?= $d->total_paket;?></td>
                        <td nowrap class="text-right"><?= $d->total_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->total_kontrak;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 34:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Kode Paket</th>
                        <th nowrap class="text-center">Satker</th>
                        <th nowrap class="text-center">Nama Paket</th>
                        <th nowrap class="text-center">Sumber Dana</th>
                        <th nowrap class="text-center">Pagu</th>
                        <th nowrap class="text-center">Nilai Kontrak</th>
                        <th nowrap class="text-center">Penyedia</th>
                        <?if($namakel == "tender" || $namakel == "nontender"){?>
                        <th nowrap class="text-center">Status Pelaksanaan</th>
                        <?}?>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_paket;?></td>
                        <td nowrap class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></a></td>
                        <td nowrap class="text-right"><?= $d->pagu;?></td>
                        <td nowrap class="text-right"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <?if($namakel == "tender" || $namakel == "nontender"){?>
                        <td nowrap class="text-center"><?= $d->status_pelaksanaan;?></td>
                        <?}?>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 35:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">No.</th>
                        <th rowspan=2 nowrap class="text-center">NIP</th>
                        <th rowspan=2 nowrap class="text-center">Nama</th>
                        <th colspan=4 nowrap class="text-center">Jumlah Paket</th>
                        <th rowspan=2 nowrap class="text-center">Total Paket</th>
                        <th rowspan=2 nowrap class="text-center">Total Pagu</th>
                        <th rowspan=2 nowrap class="text-center">Total Kontrak</th>
                    </tr>
                    <tr>
                        <th nowrap class="text-center">Aktif</th>
                        <th nowrap class="text-center">Batal</th>
                        <th nowrap class="text-center">Gagal</th>
                        <th nowrap class="text-center">Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->nip_pegawai;?></td>
                        <td nowrap class="text-left"><?= $d->nama_pegawai;?></td>
                        <td nowrap class="text-center"><?= $d->aktif;?></a></td>
                        <td nowrap class="text-center"><?= $d->batal;?></td>
                        <td nowrap class="text-center"><?= $d->gagal;?></td>
                        <td nowrap class="text-center"><?= $d->selesai;?></td>
                        <td nowrap class="text-right"><?= $d->total_paket;?></td>
                        <td nowrap class="text-right"><?= $d->total_pagu;?></td>
                        <td nowrap class="text-right"><?= $d->total_kontrak;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 36:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th nowrap class="text-center">No</th>
                        <th nowrap class="text-center">Kode Paket</th>
                        <th nowrap class="text-center">Satker</th>
                        <th nowrap class="text-center">Nama Paket</th>
                        <th nowrap class="text-center">Sumber Dana</th>
                        <th nowrap class="text-center">Pagu</th>
                        <th nowrap class="text-center">Nilai Kontrak</th>
                        <th nowrap class="text-center">Penyedia</th>
                        <th nowrap class="text-center">Status Pelaksanaan</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_paket;?></td>
                        <td nowrap class="text-left"><?= $d->singkatan;?></td>
                        <td nowrap class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></a></td>
                        <td nowrap class="text-right"><?= $d->pagu;?></td>
                        <td nowrap class="text-right"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                        <td nowrap class="text-center"><?= $d->status_pelaksanaan;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 37:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 nowrap class="text-center">#</th>
                        <th rowspan=2 nowrap class="text-center">Kode Pokja</th>
                        <th rowspan=2 nowrap class="text-center">Nama Pokja</th>
                        <th rowspan=2 nowrap class="text-center">Anggota</th>
                        <th rowspan=2 nowrap class="text-center">Satker</th>
                        <th rowspan=2 nowrap class="text-center">Nama Paket</th>
                        <th rowspan=2 nowrap class="text-center">Sumber Dana</th>
                        <th rowspan=2 nowrap class="text-center">Pagu</th>
                        <th rowspan=2 nowrap class="text-center">HPS</th>
                        <th rowspan=2 nowrap class="text-center">Nilai Hasil Tender</th>
                        <th colspan=2 nowrap class="text-center">Optimalisasi</th>
                        <th rowspan=2 nowrap class="text-center">Penyedia</th>
                    </tr>
                    <tr>
                        <th>Rp</th>
                        <th>Persen</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td nowrap class="text-center"><?= $d->kode_pokja;?></td>
                        <td class="text-left"><?= $d->nama_pokja;?></td>
                        <td nowrap class="text-left"><?= $d->anggota;?></td>
                        <td nowrap class="text-left"><?= $d->nama_satker;?></td>
                        <td class="text-left"><?= $d->nama_paket;?></td>
                        <td nowrap class="text-center"><?= $d->sumber_dana;?></td>
                        <td nowrap class="text-center"><?= $d->pagu;?></td>
                        <td nowrap class="text-center"><?= $d->hps;?></td>
                        <td nowrap class="text-center"><?= $d->nilai_kontrak;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi_nilai;?></td>
                        <td nowrap class="text-center"><?= $d->optimalisasi_persen;?></td>
                        <td nowrap class="text-left"><?= $d->penyedia;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <?}?>
</body>
</html>