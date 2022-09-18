<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $judul;?></title>

    <style>
        .judul, .record{
            border-collapse: collapse;
            width: 100%;
            font-family: 'times';
            font-size: 9pt;
        }

        .w-judul{
            width: 70%;
        }

        .w-tahun{
            width: 30%;
        }

        .record th, .record td{
            border-left: 1px solid #000;
            border-top: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <?= $judul;?></th>, Tahun Anggaran <?= $thn;?>
    <?
    switch ($laporan) {
        case 1:
    ?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No</th>
                        <th rowspan=2 class="text-center">Satuan Kerja</th>
                        <th rowspan=2 class="text-center">Belanja Pengadaan</th>
                        <th colspan=2 class="text-center">Penyedia</th>
                        <th colspan=2 class="text-center">Swakelola</th>
                        <th colspan=2 class="text-center">Penyedia dalam Swakelola</th>
                        <th colspan=2 class="text-center">Total</th>
                        <th rowspan=2 class="text-center">Presentase</th>
                    </tr>
                    <tr>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                        <th class="text-center">Paket</th>
                        <th class="text-center">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr class="<?= $d->warna;?>">
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-left"><?= $d->singkatan;?></td>
                        <td class="text-right"><?= $d->belanja_pengadaan;?></td>
                        <td class="text-right"><?= $d->penyedia_paket;?></td>
                        <td class="text-right"><?= $d->penyedia_anggaran;?></td>
                        <td class="text-right"><?= $d->swakelola_paket;?></td>
                        <td class="text-right"><?= $d->swakelola_anggaran;?></td>
                        <td class="text-right"><?= $d->penyedia_dalam_swakelola_paket;?></td>
                        <td class="text-right"><?= $d->penyedia_dalam_swakelola_anggaran;?></td>
                        <td class="text-right"><?= $d->paket;?></td>
                        <td class="text-right"><?= $d->anggaran;?></td>
                        <td class="text-center"><?= $d->persentase;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_belanja_pengadaan;?></th>
                        <th class="text-right"><?= $total_penyedia_paket;?></th>
                        <th class="text-right"><?= $total_penyedia_anggaran;?></th>
                        <th class="text-right"><?= $total_swakelola_paket;?></th>
                        <th class="text-right"><?= $total_swakelola_anggaran;?></th>
                        <th class="text-right"><?= $total_penyedia_dalam_swakelola_paket;?></th>
                        <th class="text-right"><?= $total_penyedia_dalam_swakelola_anggaran;?></th>
                        <th class="text-right"><?= $total_paket;?></th>
                        <th class="text-right"><?= $total_anggaran;?></th>
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
                        <td class="text-right"><?= $d->rup_paket;?></td>
                        <td class="text-right"><?= $d->rup_anggaran;?></td>
                        <td class="text-right"><?= $d->proses_paket;?></td>
                        <td class="text-right"><?= $d->proses_anggaran;?></td>
                        <td class="text-right"><?= $d->selesai_paket;?></td>
                        <td class="text-right"><?= $d->selesai_anggaran;?></td>
                        <td class="text-right"><?= $d->selesai_nilai;?></td>
                        <td class="text-right"><?= $d->hemat_anggaran;?></td>
                        <td class="text-center"><?= $d->hemat_persen;?></td>
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
                        <th rowspan=2 class="text-center">No.</th>
                        <th rowspan=2 class="text-center">Jenis Pekerjaan</th>
                        <th rowspan=2 class="text-center">Total<br>Paket</th>
                        <th rowspan=2 class="text-center">Paket<br>Selesai</th>
                        <th rowspan=2 class="text-center">Paket<br>Tayang</th>
                        <th rowspan=2 class="text-center">Paket<br>Review</th>
                        <th rowspan=2 class="text-center">Paket<br>Batal</th>
                        <th rowspan=2 class="text-center">Total<br>Pagu<br>Anggaran</th>
                        <th rowspan=2 class="text-center">%</th>
                        <th rowspan=2 class="text-center">Pagu<br>Anggaran<br>Selesai</th>
                        <th rowspan=2 class="text-center">Harga<br>Negosiasi</th>
                        <th colspan=2 class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th class="text-center">Optimalisasi</th>
                        <th class="text-center">%</th>
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
                        <td class="text-right"><?= $d2->total_paket;?></td>
                        <td class="text-right"><?= $d2->paket_selesai;?></td>
                        <td class="text-right"><?= $d2->paket_tayang;?></td>
                        <td class="text-right"><?= $d2->paket_review;?></td>
                        <td class="text-right"><?= $d2->paket_batal;?></td>
                        <td class="text-right"><?= $d2->total_pagu_anggaran;?></td>
                        <td class="text-right"><?= $d2->persen_pagu_anggaran;?></td>
                        <td class="text-right"><?= $d2->pagu_anggaran_selesai;?></td>
                        <td class="text-right"><?= $d2->harga_negosiasi;?></td>
                        <td class="text-right"><?= $d2->hemat_optimalisasi;?></td>
                        <td class="text-right"><?= $d2->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_total_paket;?></th>
                        <th class="text-right"><?= $total_paket_selesai;?></th>
                        <th class="text-right"><?= $total_paket_tayang;?></th>
                        <th class="text-right"><?= $total_paket_review;?></th>
                        <th class="text-right"><?= $total_paket_batal;?></th>
                        <th class="text-right"><?= $total_total_pagu_anggaran;?></th>
                        <th></th>
                        <th class="text-right"><?= $total_pagu_anggaran_selesai;?></th>
                        <th class="text-right"><?= $total_harga_negosiasi;?></th>
                        <th class="text-right"><?= $total_hemat_optimalisasi;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 3:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">#</th>
                        <th rowspan=2 class="text-center">OPD</th>
                        <th rowspan=2 class="text-center">Paket</th>
                        <th colspan=4 class="text-center">Total Pagu Anggaran</th>
                        <th rowspan=2 class="text-center">Total</th>
                        <th rowspan=2 class="text-center">%</th>
                    </tr>
                    <tr>
                        <th class="text-center">Pengadaan<br>Barang</th>
                        <th class="text-center">Jasa<br>Konsultasi</th>
                        <th class="text-center">Jasa<br>Lainnya</th>
                        <th class="text-center">Pekerjaan<br>Konstruksi</th>
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
                        <td class="text-right"><?= $d->paket;?></td>
                        <td class="text-right"><?= $d->pengadaan_barang;?></td>
                        <td class="text-right"><?= $d->jasa_konsultasi;?></td>
                        <td class="text-right"><?= $d->jasa_lainnya;?></td>
                        <td class="text-right"><?= $d->pekerjaan_konstruksi;?></td>
                        <td class="text-right"><?= $d->total;?></td>
                        <td class="text-right"><?= $d->persen;?></td>
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
                        <th rowspan=2 class="text-center">#</th>
                        <th rowspan=2 class="text-center">OPD</th>
                        <th rowspan=2 class="text-center">Kegiatan</th>
                        <th rowspan=2 class="text-center">Nama Paket</th>
                        <th rowspan=2 class="text-center">Tgl. Pengumuman</th>
                        <th rowspan=2 class="text-center">Pagu</th>
                        <th rowspan=2 class="text-center">HPS</th>
                        <th rowspan=2 class="text-center">Nilai Hasil Tender</th>
                        <th colspan=2 class="text-center">Optimalisasi</th>
                        <th rowspan=2 class="text-center">Rekanan</th>
                        <th rowspan=2 class="text-center">Domisili</th>
                    </tr>
                    <tr>
                        <th class="text-center">Rp</th>
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
                        <td class="text-left"><?= $d->satker;?></td>
                        <td class="text-left"><?= $d->kegiatan;?></td>
                        <td class="text-left"><?= $d->nama_paket;?></td>
                        <td class="text-center"><?= $d->tgl_pengumuman;?></td>
                        <td class="text-right"><?= $d->pagu;?></td>
                        <td class="text-right"><?= $d->hps;?></td>
                        <td class="text-right"><?= $d->nilai_hasil_tender;?></td>
                        <td class="text-right"><?= $d->nilai_optimalisasi;?></td>
                        <td class="text-center"><?= $d->persen_optimalisasi;?></td>
                        <td class="text-left"><?= $d->penyedia;?></td>
                        <td class="text-center"><?= $d->domisili;?></td>
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
                        <td class="text-right"><?= $d->rup_paket;?></td>
                        <td class="text-right"><?= $d->rup_anggaran;?></td>
                        <td class="text-right"><?= $d->proses_paket;?></td>
                        <td class="text-right"><?= $d->proses_anggaran;?></td>
                        <td class="text-right"><?= $d->selesai_paket;?></td>
                        <td class="text-right"><?= $d->selesai_anggaran;?></td>
                        <td class="text-right"><?= $d->selesai_nilai;?></td>
                        <td class="text-right"><?= $d->hemat_anggaran;?></td>
                        <td class="text-center"><?= $d->hemat_persen;?></td>
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
                        <th rowspan=2 class="text-center">No.</th>
                        <th rowspan=2 class="text-center">Jenis Pekerjaan</th>
                        <th rowspan=2 class="text-center">Total<br>Paket</th>
                        <th rowspan=2 class="text-center">Paket<br>Selesai</th>
                        <th rowspan=2 class="text-center">Paket<br>Tayang</th>
                        <th rowspan=2 class="text-center">Paket<br>Review</th>
                        <th rowspan=2 class="text-center">Paket<br>Batal</th>
                        <th rowspan=2 class="text-center">Total<br>Pagu<br>Anggaran</th>
                        <th rowspan=2 class="text-center">%</th>
                        <th rowspan=2 class="text-center">Pagu<br>Anggaran<br>Selesai</th>
                        <th rowspan=2 class="text-center">Harga<br>Negosiasi</th>
                        <th colspan=2 class="text-center">Penghematan</th>
                    </tr>
                    <tr>
                        <th class="text-center">Optimalisasi</th>
                        <th class="text-center">%</th>
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
                        <td class="text-right"><?= $d2->total_paket;?></td>
                        <td class="text-right"><?= $d2->paket_selesai;?></td>
                        <td class="text-right"><?= $d2->paket_tayang;?></td>
                        <td class="text-right"><?= $d2->paket_review;?></td>
                        <td class="text-right"><?= $d2->paket_batal;?></td>
                        <td class="text-right"><?= $d2->total_pagu_anggaran;?></td>
                        <td class="text-right"><?= $d2->persen_pagu_anggaran;?></td>
                        <td class="text-right"><?= $d2->pagu_anggaran_selesai;?></td>
                        <td class="text-right"><?= $d2->harga_negosiasi;?></td>
                        <td class="text-right"><?= $d2->hemat_optimalisasi;?></td>
                        <td class="text-right"><?= $d2->hemat_persen;?></td>
                    </tr>
                    <?}?>
                </tbody>
                <tfoot class="bg-gray">
                    <tr>
                        <th colspan=2 class="text-right">Total</th>
                        <th class="text-right"><?= $total_total_paket;?></th>
                        <th class="text-right"><?= $total_paket_selesai;?></th>
                        <th class="text-right"><?= $total_paket_tayang;?></th>
                        <th class="text-right"><?= $total_paket_review;?></th>
                        <th class="text-right"><?= $total_paket_batal;?></th>
                        <th class="text-right"><?= $total_total_pagu_anggaran;?></th>
                        <th></th>
                        <th class="text-right"><?= $total_pagu_anggaran_selesai;?></th>
                        <th class="text-right"><?= $total_harga_negosiasi;?></th>
                        <th class="text-right"><?= $total_hemat_optimalisasi;?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
    <?      break;?>
    <? case 6:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">#</th>
                        <th rowspan=2 class="text-center">OPD</th>
                        <th rowspan=2 class="text-center">Paket</th>
                        <th colspan=4 class="text-center">Total Pagu Anggaran</th>
                        <th rowspan=2 class="text-center">Total</th>
                        <th rowspan=2 class="text-center">%</th>
                    </tr>
                    <tr>
                        <th class="text-center">Pengadaan<br>Barang</th>
                        <th class="text-center">Jasa<br>Konsultasi</th>
                        <th class="text-center">Jasa<br>Lainnya</th>
                        <th class="text-center">Pekerjaan<br>Konstruksi</th>
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
                        <td class="text-right"><?= $d->paket;?></td>
                        <td class="text-right"><?= $d->pengadaan_barang;?></td>
                        <td class="text-right"><?= $d->jasa_konsultasi;?></td>
                        <td class="text-right"><?= $d->jasa_lainnya;?></td>
                        <td class="text-right"><?= $d->pekerjaan_konstruksi;?></td>
                        <td class="text-right"><?= $d->total;?></td>
                        <td class="text-right"><?= $d->persen;?></td>
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
                        <th rowspan=2 class="text-center">#</th>
                        <th rowspan=2 class="text-center">OPD</th>
                        <th rowspan=2 class="text-center">Kegiatan</th>
                        <th rowspan=2 class="text-center">Nama Paket</th>
                        <th rowspan=2 class="text-center">Tgl. Pengumuman</th>
                        <th rowspan=2 class="text-center">Pagu</th>
                        <th rowspan=2 class="text-center">HPS</th>
                        <th rowspan=2 class="text-center">Nilai Hasil Tender</th>
                        <th colspan=2 class="text-center">Optimalisasi</th>
                        <th rowspan=2 class="text-center">Rekanan</th>
                        <th rowspan=2 class="text-center">Domisili</th>
                    </tr>
                    <tr>
                        <th class="text-center">Rp</th>
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
                        <td class="text-left"><?= $d->satker;?></td>
                        <td class="text-left"><?= $d->kegiatan;?></td>
                        <td class="text-left"><?= $d->nama_paket;?></td>
                        <td class="text-center"><?= $d->tgl_pengumuman;?></td>
                        <td class="text-right"><?= $d->pagu;?></td>
                        <td class="text-right"><?= $d->hps;?></td>
                        <td class="text-right"><?= $d->nilai_hasil_tender;?></td>
                        <td class="text-right"><?= $d->nilai_optimalisasi;?></td>
                        <td class="text-center"><?= $d->persen_optimalisasi;?></td>
                        <td class="text-left"><?= $d->penyedia;?></td>
                        <td class="text-center"><?= $d->domisili;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 8:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode RUP Paket</th>
                        <th class="text-center">Satker</th>
                        <th class="text-center">Kegiatan</th>
                        <th class="text-center">Nama Paket</th>
                        <th class="text-center">PPK</th>
                        <th class="text-center">Sumber Dana</th>
                        <th class="text-center">Pagu</th>
                        <th class="text-center">Nomor Paket</th>
                        <th class="text-center">Jenis Katalog</th>
                        <th class="text-center">Nama Komoditas</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Kuantitas</th>
                        <th class="text-center">Ongkos Kirim</th>
                        <th class="text-center">Total Harga</th>
                        <th class="text-center">Nama Penyedia</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data);
                    foreach ($hasil as $d) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d->no;?></td>
                        <td class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td class="text-left"><?= $d->satker;?></td>
                        <td class="text-left"><?= $d->kegiatan;?></td>
                        <td class="text-left"><?= $d->nama_paket;?></td>
                        <td class="text-left"><?= $d->ppk;?></td>
                        <td class="text-center"><?= $d->sumber_dana;?></td>
                        <td class="text-center"><?= $d->pagu;?></td>
                        <td class="text-center"><?= $d->nomor_paket;?></td>
                        <td class="text-center"><?= $d->jenis_katalog;?></td>
                        <td class="text-center"><?= $d->nama_komoditas;?></td>
                        <td class="text-center"><?= $d->harga_satuan;?></td>
                        <td class="text-center"><?= $d->kuantitas;?></td>
                        <td class="text-center"><?= $d->ongkos_kirim;?></td>
                        <td class="text-center"><?= $d->total_harga;?></td>
                        <td class="text-left"><?= $d->penyedia;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 9:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No.</th>
                        <th rowspan=2 class="text-center">Kode RUP Paket</th>
                        <th rowspan=2 class="text-center">Satker</th>
                        <th rowspan=2 class="text-center">Kegiatan</th>
                        <th rowspan=2 class="text-center">Nama Paket</th>
                        <th rowspan=2 class="text-center">PPK</th>
                        <th rowspan=2 class="text-center">Sumber Dana</th>
                        <th colspan=2 class="text-center">Waktu Pelaksanaan</th>
                        <th rowspan=2 class="text-center">Pagu</th>
                        <th rowspan=2 class="text-center">Realisasi</th>
                        <th colspan=2 class="text-center">Optimalisasi</th>
                        <th rowspan=2 class="text-center">Penyedia</th>
                        <th rowspan=2 class="text-center">Domisili</th>
                        <th rowspan=2 class="text-center">Uraian Pekerjaan</th>
                        <th rowspan=2 class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="text-center">Tgl. Mulai</th>
                        <th class="text-center">Tgl. Selesai</th>
                        <th class="text-center">Rp.</th>
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
                        <td class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td class="text-left"><?= $d->satker;?></td>
                        <td class="text-left"><?= $d->kegiatan;?></td>
                        <td class="text-left"><?= $d->nama_paket;?></td>
                        <td class="text-left"><?= $d->ppk;?></td>
                        <td class="text-center"><?= $d->sumber_dana;?></td>
                        <td class="text-center"><?= $d->tgl_mulai;?></td>
                        <td class="text-center"><?= $d->tgl_selesai;?></td>
                        <td class="text-center"><?= $d->pagu;?></td>
                        <td class="text-center"><?= $d->realisasi;?></td>
                        <td class="text-center"><?= $d->optimalisasi;?></td>
                        <td class="text-center"><?= $d->persen;?></td>
                        <td class="text-left"><?= $d->penyedia;?></td>
                        <td class="text-center"><?= $d->domisili;?></td>
                        <td class="text-left"><?= $d->uraian;?></td>
                        <td class="text-left"><?= $d->keterangan;?></td>
                    </tr>
                    <?}?>
                </tbody>
            </table>
    <?      break;?>
    <? case 10:?>
            <table class="record">
                <thead class="bg-gray">
                    <tr>
                        <th rowspan=2 class="text-center">No</th>
                        <th rowspan=2 class="text-center">Kode RUP Paket</th>
                        <th rowspan=2 class="text-center">Satker</th>
                        <th rowspan=2 class="text-center">Kegiatan</th>
                        <th rowspan=2 class="text-center">Nama Paket</th>
                        <th rowspan=2 class="text-center">PPK</th>
                        <th rowspan=2 class="text-center">Sumber Dana</th>
                        <th colspan=2 class="text-center">Waktu Pelaksanaan</th>
                        <th rowspan=2 class="text-center">Pagu</th>
                        <th rowspan=2 class="text-center">Realisasi</th>
                        <th colspan=2 class="text-center">Optimalisasi</th>
                        <th rowspan=2 class="text-center">Penyedia</th>
                        <th rowspan=2 class="text-center">Domisili</th>
                        <th rowspan=2 class="text-center">Uraian Pekerjaan</th>
                        <th rowspan=2 class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="text-center">Tgl. Mulai</th>
                        <th class="text-center">Tgl. Selesai</th>
                        <th class="text-center">Rp.</th>
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
                        <td class="text-center"><?= $d->kode_rup_paket;?></td>
                        <td class="text-left"><?= $d->satker;?></td>
                        <td class="text-left"><?= $d->kegiatan;?></td>
                        <td class="text-left"><?= $d->nama_paket;?></td>
                        <td class="text-left"><?= $d->ppk;?></td>
                        <td class="text-center"><?= $d->sumber_dana;?></td>
                        <td class="text-center"><?= $d->tgl_mulai;?></td>
                        <td class="text-center"><?= $d->tgl_selesai;?></td>
                        <td class="text-center"><?= $d->pagu;?></td>
                        <td class="text-center"><?= $d->realisasi;?></td>
                        <td class="text-center"><?= $d->optimalisasi;?></td>
                        <td class="text-center"><?= $d->persen;?></td>
                        <td class="text-left"><?= $d->penyedia;?></td>
                        <td class="text-center"><?= $d->domisili;?></td>
                        <td class="text-left"><?= $d->uraian;?></td>
                        <td class="text-left"><?= $d->keterangan;?></td>
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
                        <th rowspan=2 class="text-center">No</th>
                        <th rowspan=2 class="text-center">Metode Pemilihan Penyedia</th>
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
                        <th class="text-center">Persentase</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
                        <th class="text-center">7</th>
                        <th class="text-center">8</th>
                        <th class="text-center">9</th>
                        <th class="text-center">10</th>
                        <th class="text-center">11</th>
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
                        <td class="text-right"><?= $d->rup_paket;?></td>
                        <td class="text-right"><?= $d->rup_anggaran;?></td>
                        <td class="text-right"><?= $d->proses_paket;?></td>
                        <td class="text-right"><?= $d->proses_anggaran;?></td>
                        <td class="text-right"><?= $d->selesai_paket;?></td>
                        <td class="text-right"><?= $d->selesai_anggaran;?></td>
                        <td class="text-right"><?= $d->selesai_nilai;?></td>
                        <td class="text-right"><?= $d->hemat_anggaran;?></td>
                        <td class="text-center"><?= $d->hemat_persen;?></td>
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
                        <th rowspan=2 class="text-center">No</th>
                        <th rowspan=2 class="text-center">Metode Pemilihan Penyedia</th>
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
                        <th class="text-center">Persentase</th>
                    </tr>
                    <tr>
                        <th class="text-center">1</th>
                        <th class="text-center">2</th>
                        <th class="text-center">3</th>
                        <th class="text-center">4</th>
                        <th class="text-center">5</th>
                        <th class="text-center">6</th>
                        <th class="text-center">7</th>
                        <th class="text-center">8</th>
                        <th class="text-center">9</th>
                        <th class="text-center">10</th>
                        <th class="text-center">11</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    $hasil = json_decode($data2);
                    foreach ($hasil as $d2) {
                    ?>
                    <tr>
                        <td class="text-center"><?= $d2->no;?></td>
                        <td class="text-left"><?= $d2->metode;?></td>
                        <td class="text-right"><?= $d2->rup_paket;?></td>
                        <td class="text-right"><?= $d2->rup_anggaran;?></td>
                        <td class="text-right"><?= $d2->proses_paket;?></td>
                        <td class="text-right"><?= $d2->proses_anggaran;?></td>
                        <td class="text-right"><?= $d2->selesai_paket;?></td>
                        <td class="text-right"><?= $d2->selesai_anggaran;?></td>
                        <td class="text-right"><?= $d2->selesai_nilai;?></td>
                        <td class="text-right"><?= $d2->hemat_anggaran;?></td>
                        <td class="text-center"><?= $d2->hemat_persen;?></td>
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

    <?      break;?>
    <? case 13:?>

    <?      break;?>
    <? case 14:?>

    <?      break;?>
    <? case 15:?>

    <?      break;?>
    <?}?>
</body>
</html>