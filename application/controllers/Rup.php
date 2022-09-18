<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rup extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_rup');
    }

    public function rekapitulasi()
    {
        $data['halaman'] = "RUP - Rekapitulasi";

        $data['main'] = "rup";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/rup_rekapitulasi');
        $this->load->view('layout/footer');
    }

    public function histori_revisi_paket($thn = "", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "RUP - Histori Revisi Paket";

        $data['main'] = "rup";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_histori');
        }

        // cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "kode_paket_lama<>''";
        } else {
            $qcari = "(kode_paket_lama='$getcari' or kode_paket_baru='$getcari')";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $jumlah_data = $this->mod_rup->jumlah_revisi($data['thn'], $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no= $limit_start + 1;

        $record = array();
        $subrecord = array();

        $revisi = $this->mod_rup->revisi($limit_start, $limit, $data['thn'], $qcari)->result();
        foreach ($revisi as $r) {
            $subrecord['no'] = $no;
            $subrecord['kode_kldi'] = $r->kode_kldi;
            $subrecord['kode_paket_lama'] = "<a href='#' onclick='info_histori(".$data['thn'].",\"$r->jenis\",\"$r->kode_paket_lama\")' title='Klik untuk melihat info detail paket'>$r->kode_paket_lama</a>";
            $subrecord['kode_paket_baru'] = "<a href='#' onclick='info_histori(".$data['thn'].",\"$r->jenis\",\"$r->kode_paket_lama\")' title='Klik untuk melihat info detail paket'>$r->kode_paket_baru</a>";
            $subrecord['jenis'] = $r->jenis;
            $subrecord['tipe'] = $r->tipe;
            $subrecord['alasan_kajiulang'] = $r->alasan_kajiulang;
            $subrecord['tanggal_kaji_ulang'] = $r->tanggal_kaji_ulang;
            $subrecord['tahun_anggaran'] = $r->tahun_anggaran;
            $subrecord['tahun_kajiulang'] = $r->tahun_kajiulang;
            $subrecord['bulan_kajiulang'] = $r->bulan_kajiulang;

            switch( $r->bulan_kajiulang)
            {
                case "1" : $subrecord['waktu'] = "Januari " . $r->tahun_kajiulang; break;
                case "2" : $subrecord['waktu'] = "Februari " . $r->tahun_kajiulang; break;
                case "3" : $subrecord['waktu'] = "Maret " . $r->tahun_kajiulang; break;
                case "4" : $subrecord['waktu'] = "April " . $r->tahun_kajiulang; break;
                case "5" : $subrecord['waktu'] = "Mei " . $r->tahun_kajiulang; break;
                case "6" : $subrecord['waktu'] = "Juni " . $r->tahun_kajiulang; break;
                case "7" : $subrecord['waktu'] = "Juli " . $r->tahun_kajiulang; break;
                case "8" : $subrecord['waktu'] = "Agustus " . $r->tahun_kajiulang; break;
                case "9" : $subrecord['waktu'] = "September " . $r->tahun_kajiulang; break;
                case "10" : $subrecord['waktu'] = "Oktober " . $r->tahun_kajiulang; break;
                case "11" : $subrecord['waktu'] = "November " . $r->tahun_kajiulang; break;
                case "12" : $subrecord['waktu'] = "Desember " . $r->tahun_kajiulang; break;
            }
            
            // cek rup
            switch ($r->jenis) {
                case 'PENYEDIA':
                    $cek_rup = $this->mod_rup->cek_rup_penyedia($r->kode_paket_lama);
                    if(!empty($cek_rup)){
                        $subrecord['nama_lama'] = $cek_rup['nama_paket'];
                    } else {
                        $subrecord['nama_lama'] = "-";
                    }

                    $cek_satker = $this->mod_rup->cek_satker($cek_rup['id_satker']);

                    $cek_rup = $this->mod_rup->cek_rup_penyedia($r->kode_paket_baru);
                    if(!empty($cek_rup)){
                        $subrecord['nama_baru'] = $cek_rup['nama_paket'];    
                    } else {
                        $subrecord['nama_baru'] = "-";
                    }
                
                    break;
                case 'SWAKELOLA':
                    $cek_rup = $this->mod_rup->cek_rup_swakelola($r->kode_paket_lama);
                    if(!empty($cek_rup)){
                        $subrecord['nama_lama'] = $cek_rup['nama_paket'];
                    } else {
                        $subrecord['nama_lama'] = "-";
                    }

                    $cek_satker = $this->mod_rup->cek_satker($cek_rup['id_satker']);

                    $cek_rup = $this->mod_rup->cek_rup_swakelola($r->kode_paket_baru);
                    if(!empty($cek_rup)){
                        $subrecord['nama_baru'] = $cek_rup['nama_paket'];
                    } else {
                        $subrecord['nama_baru'] = "-";
                    }
                    break;
            }

            $subrecord['singkatan'] = $cek_satker['singkatan'];
            $subrecord['nama_satker'] = $cek_satker['nama_satker'];

            $no++;

            array_push($record, $subrecord);
        }

        $data['histori_revisi'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/histori_revisi_paket');
        $this->load->view('layout/footer');
    }

    public function info_histori($kelompok,$kode_rup)
    {
        $record = array();
        $subrecord = array();

        $subrecord['kelompok'] = strtolower($kelompok);

        switch ($subrecord['kelompok']) {
            case 'penyedia':
                $info = $this->mod_rup->info_paket_penyedia($kode_rup);

                $subrecord['nama_program'] = $info['program'];
                $subrecord['nama_kegiatan'] = $info['kegiatan'];
                $subrecord['uraian_pekerjaan'] = $info['deskripsi'];
                $subrecord['spesifikasi_pekerjaan'] = $info['spesifikasi'];
                $subrecord['volume_pekerjaan'] = $info['volume'];
                $subrecord['usaha_kecil'] = $info['umkm'];
                $subrecord['jenis_pengadaan'] = $info['jenis_pengadaan'];
                $subrecord['total_pagu'] = "Rp. ".number_format($info['pagu_rup'],0,',','.');
                $subrecord['metode_pemilihan'] = $info['metode_pemilihan'];
                $subrecord['pemanfaatan_barangjasa_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                $subrecord['pemanfaatan_barangjasa_akhir'] = date('d-m-Y',strtotime($info['tanggal_kebutuhan']));
                $subrecord['jadwal_pelaksanaan_kontrak_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                $subrecord['jadwal_pelaksanaan_kontrak_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                $subrecord['jadwal_pemilihan_penyedia_mulai'] = date('d-m-Y',strtotime($info['awal_pengadaan']));
                $subrecord['jadwal_pemilihan_penyedia_akhir'] = date('d-m-Y',strtotime($info['akhir_pengadaan']));
                $subrecord['tanggal_perbarui_paket'] = date('d-m-Y h:i:s',strtotime($info['tanggal_terakhir_di_update']));

                switch($info['umkm']){
                    case "ya" : $subrecord['warna_badge'] = "bg-green"; break;
                    case "tidak" : $subrecord['warna_badge'] = "bg-red"; break;
                }
                break;
            case 'swakelola':
                $info = $this->mod_rup->info_paket_swakelola($kode_rup);

                $subrecord['tipe_swakelola'] = $info['tipe_swakelola'];
                $subrecord['penyelenggara_swakelola'] = $info['nama_kldi_penyelenggara'];
                $subrecord['deskripsi'] = $info['deskripsi'];
                $subrecord['pelaksanaan_pekerjaan_awal'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                $subrecord['pelaksanaan_pekerjaan_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                break;
        }
        
        $subrecord['kode_rup'] = $info['kode_rup'];
        $subrecord['nama_paket'] = $info['nama_paket'];
        $subrecord['nama_klpd'] = $info['kldi'];
        $subrecord['satuan_kerja'] = $info['nama_satker'];
        $subrecord['tahun_anggaran'] = $info['tahun_anggaran'];
        $subrecord['provinsi'] = "-";
        $subrecord['kabupaten_kota'] = $info['lokasi'];
        $subrecord['detail_lokasi'] = $info['detail_lokasi'];
        $subrecord['sumber_dana'] = $info['sumber_dana'];
        $subrecord['ta'] = $info['tahun_anggaran'];
        $subrecord['klpd'] = $info['kldi'];
        $subrecord['mak'] = $info['mak'];
        $subrecord['pagu'] = "Rp. ".number_format($info['pagu_rup'],0,',','.');

        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function paket($thn,$kode,$kelompok = "penyedia", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "RUP - Rekapitulasi";

        $data['main'] = "rup";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $data['thn'] = $thn;
        $data['kelompok'] = $kelompok;

        $satker = $this->mod_rup->cek_satker($kode);

        $data['kode_satker'] = $kode;
        $data['nama_satker'] = $satker['nama_satker'];

        switch ($kelompok) {
            case 'penyedia':
                $data['aktif_penyedia_tab'] = "active";
                $data['aktif_swakelola_tab'] = "";
                break;
            case 'swakelola':
                $data['aktif_penyedia_tab'] = "";
                $data['aktif_swakelola_tab'] = "active";
                break;
        }

        //cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = " AND kegiatan<>''";
        } else {
            $qcari = " AND kegiatan like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        switch ($kelompok) {
            case 'penyedia':
                $jumlah_data = $this->mod_rup->jumlah_paket_penyedia($thn, $kode, $qcari);
                break;
            case 'swakelola':
                $jumlah_data = $this->mod_rup->jumlah_paket_swakelola($thn, $kode, $qcari);
                break;
        }
        
        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no= $limit_start + 1;
        
        $record = array();
        $subrecord = array();

        switch ($kelompok) {
            case 'penyedia':
                $paket = $this->mod_rup->paket_penyedia($limit_start, $limit, $thn, $kode, $qcari)->result();
                break;
            case 'swakelola':
                $paket = $this->mod_rup->paket_swakelola($limit_start, $limit, $thn, $kode, $qcari)->result();
                break;
        }
        
        foreach ($paket as $p) {
            $subrecord['no'] = $no;
            $subrecord['btn'] = "<a href='#rup-rekapitulasi' class='btn btn-primary btn-xs' onclick='info(\"$thn\",\"$kode\",\"$kelompok\",\"$p->kode_rup\")'>Info Paket</a>";
            $subrecord['nama_paket'] = strtoupper($p->nama_paket);
            $subrecord['nama_kegiatan'] = strtoupper($p->kegiatan);
            $subrecord['pagu'] = $p->pagu_rup == 0 ? "-" : "Rp. ".number_format($p->pagu_rup,0,',','.');
            switch ($kelompok) {
                case 'penyedia':
                        $subrecord['metode_pemilihan'] = $p->metode_pemilihan;
                        $subrecord['jenis_pengadaan'] = $p->jenis_pengadaan;
                        $subrecord['waktu'] = date('d-m-Y',strtotime($p->awal_pengadaan));
                        break;
                case 'swakelola':
                        $subrecord['tipe_swakelola'] = "Tipe ".$p->tipe_swakelola;
                        $subrecord['waktu'] = date('d-m-Y',strtotime($p->awal_pekerjaan));
                        break;
            }
            $subrecord['sumber_dana'] = $p->sumber_dana;
            $subrecord['kode_rup'] = $p->kode_rup;

            $no++; 

            array_push($record, $subrecord);
        }

        $data['paket'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/rup_daftar_paket');
        $this->load->view('layout/footer');
    }

    public function info($kelompok,$kode_rup)
    {
        $record = array();
        $subrecord = array();

        switch ($kelompok) {
            case 'penyedia':
                $info = $this->mod_rup->info_paket_penyedia($kode_rup);

                $subrecord['nama_program'] = $info['program'];
                $subrecord['nama_kegiatan'] = $info['kegiatan'];
                $subrecord['uraian_pekerjaan'] = $info['deskripsi'];
                $subrecord['spesifikasi_pekerjaan'] = $info['spesifikasi'];
                $subrecord['volume_pekerjaan'] = $info['volume'];
                $subrecord['usaha_kecil'] = $info['umkm'];
                $subrecord['jenis_pengadaan'] = $info['jenis_pengadaan'];
                $subrecord['total_pagu'] = $info['pagu_rup'] == 0 ? "-" : "Rp. ".number_format($info['pagu_rup'],0,',','.');
                $subrecord['metode_pemilihan'] = $info['metode_pemilihan'];
                $subrecord['pemanfaatan_barangjasa_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                $subrecord['pemanfaatan_barangjasa_akhir'] = date('d-m-Y',strtotime($info['tanggal_kebutuhan']));
                $subrecord['jadwal_pelaksanaan_kontrak_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                $subrecord['jadwal_pelaksanaan_kontrak_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                $subrecord['jadwal_pemilihan_penyedia_mulai'] = date('d-m-Y',strtotime($info['awal_pengadaan']));
                $subrecord['jadwal_pemilihan_penyedia_akhir'] = date('d-m-Y',strtotime($info['akhir_pengadaan']));
                $subrecord['tanggal_perbarui_paket'] = date('d-m-Y h:i:s',strtotime($info['tanggal_terakhir_di_update']));

                switch($info['umkm']){
                    case "ya" : $subrecord['warna_badge'] = "bg-green"; break;
                    case "tidak" : $subrecord['warna_badge'] = "bg-red"; break;
                }
                break;
            case 'swakelola':
                $info = $this->mod_rup->info_paket_swakelola($kode_rup);

                $subrecord['tipe_swakelola'] = $info['tipe_swakelola'];
                $subrecord['penyelenggara_swakelola'] = $info['nama_kldi_penyelenggara'];
                $subrecord['deskripsi'] = $info['deskripsi'];
                $subrecord['pelaksanaan_pekerjaan_awal'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                $subrecord['pelaksanaan_pekerjaan_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                break;
        }
        
        $subrecord['kode_rup'] = $info['kode_rup'];
        $subrecord['nama_paket'] = $info['nama_paket'];
        $subrecord['nama_klpd'] = $info['kldi'];
        $subrecord['satuan_kerja'] = $info['nama_satker'];
        $subrecord['tahun_anggaran'] = $info['tahun_anggaran'];
        $subrecord['provinsi'] = "-";
        $subrecord['kabupaten_kota'] = $info['lokasi'];
        $subrecord['detail_lokasi'] = $info['detail_lokasi'];
        $subrecord['sumber_dana'] = $info['sumber_dana'];
        $subrecord['ta'] = $info['tahun_anggaran'];
        $subrecord['klpd'] = $info['kldi'];
        $subrecord['mak'] = $info['mak'];
        $subrecord['pagu'] = $info['pagu_rup'] == 0 ? "-" : "Rp. ".number_format($info['pagu_rup'],0,',','.');

        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function satuan_kerja($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $record_baris = array();
        $subrecord_baris = array();

        $no = 1;

        $total_belanja_pengadaan = 0;
        $total_penyedia_paket = 0;
        $total_penyedia_anggaran = 0;
        $total_swakelola_paket = 0;
        $total_swakelola_anggaran = 0;
        $total_penyedia_dalam_swakelola_paket = 0;
        $total_penyedia_dalam_swakelola_anggaran = 0;
        $total_paket = 0;
        $total_anggaran = 0;

        $satker = $this->mod_rup->satker()->result();
        if(COUNT($satker) > 0){
            foreach ($satker as $s) {
                $subrecord_baris['no'] = $no;
                $subrecord_baris['kode'] = $s->kd_satker;
                $subrecord_baris['singkatan'] = $s->singkatan;

                $rekapitulasi = $this->mod_rup->rekapitulasi($s->kd_satker, $thn);

                if(!empty($rekapitulasi)){
                    // $subrecord_baris['btn'] = "<button class='btn btn-primary btn-xs' onclick='paket(".$s->kd_satker.")'>Daftar Paket</button>";
                    $subrecord_baris['btn'] = "<a href='".base_url()."rup/paket/$thn/".$s->kd_satker."/penyedia' class='btn btn-primary btn-xs'>Daftar Paket</a>";

                    $subrecord_baris['belanja_pengadaan'] = $rekapitulasi['belanja_pengadaan'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['belanja_pengadaan']/1000000000,2,',','.')." M";
                    $subrecord_baris['penyedia_paket'] = $rekapitulasi['penyedia_paket'] == 0 ? "-" : number_format($rekapitulasi['penyedia_paket'],0,',','.');
                    $subrecord_baris['penyedia_anggaran'] = $rekapitulasi['penyedia_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['penyedia_anggaran']/1000000000,2,',','.')." M";
                    $subrecord_baris['swakelola_paket'] = $rekapitulasi['swakelola_paket'] == 0 ? "-" : number_format($rekapitulasi['swakelola_paket'],0,',','.');
                    $subrecord_baris['swakelola_anggaran'] = $rekapitulasi['swakelola_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['swakelola_anggaran']/1000000000,2,',','.')." M";
                    $subrecord_baris['penyedia_dalam_swakelola_paket'] = $rekapitulasi['penyedia_dalam_swakelola_paket'] == 0 ? "-" : number_format($rekapitulasi['penyedia_dalam_swakelola_paket'],0,',','.');
                    $subrecord_baris['penyedia_dalam_swakelola_anggaran'] = $rekapitulasi['penyedia_dalam_swakelola_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['penyedia_dalam_swakelola_anggaran']/1000000000,2,',','.')." M";
                    $subrecord_baris['paket'] = $rekapitulasi['total_paket'] == 0 ? "-" : number_format($rekapitulasi['total_paket'],0,',','.');
                    $subrecord_baris['anggaran'] = $rekapitulasi['total_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['total_anggaran']/1000000000,2,',','.')." M";
                    $subrecord_baris['persentase'] = $rekapitulasi['persentase'] == 0 ? "-" : number_format($rekapitulasi['persentase'],2,',','.')."%";

                    // indikator warna
                    // if($rekapitulasi['persentase'] > 100){
                    //     $subrecord_baris['warna'] = "bg-orange-active";
                    // } elseif ($rekapitulasi['persentase'] == 100 ) {
                    //     $subrecord_baris['warna'] = "bg-green";
                    // } elseif ($rekapitulasi['persentase'] > 60 and $rekapitulasi['persentase'] <=99 ) {
                    //     $subrecord_baris['warna'] = "bg-light-yellow";
                    // } elseif ($rekapitulasi['persentase'] > 40 and $rekapitulasi['persentase'] <=60 ) {
                    //     $subrecord_baris['warna'] = "bg-light-maroon";
                    // } elseif ($rekapitulasi['persentase'] > 0 and $rekapitulasi['persentase'] <= 40 ) {
                    //     $subrecord_baris['warna'] = "bg-maroon-active";
                    // }

                    $subrecord_baris['warna'] = "";

                    $total_belanja_pengadaan += $rekapitulasi['belanja_pengadaan'];
                    $total_penyedia_paket += $rekapitulasi['penyedia_paket'];
                    $total_penyedia_anggaran += $rekapitulasi['penyedia_anggaran'];
                    $total_swakelola_paket += $rekapitulasi['swakelola_paket'];
                    $total_swakelola_anggaran += $rekapitulasi['swakelola_anggaran'];
                    $total_penyedia_dalam_swakelola_paket += $rekapitulasi['penyedia_dalam_swakelola_paket'];
                    $total_penyedia_dalam_swakelola_anggaran += $rekapitulasi['penyedia_dalam_swakelola_anggaran'];
                    $total_paket += $rekapitulasi['total_paket'];
                    $total_anggaran += $rekapitulasi['total_anggaran'];
                } else {
                    $subrecord_baris['btn'] = "-";

                    $subrecord_baris['belanja_pengadaan'] = "-";
                    $subrecord_baris['penyedia_paket'] = "-";
                    $subrecord_baris['penyedia_anggaran'] = "-";
                    $subrecord_baris['swakelola_paket'] = "-";
                    $subrecord_baris['swakelola_anggaran'] = "-";
                    $subrecord_baris['penyedia_dalam_swakelola_paket'] = "-";
                    $subrecord_baris['penyedia_dalam_swakelola_anggaran'] = "-";
                    $subrecord_baris['paket'] = "-";
                    $subrecord_baris['anggaran'] = "-";
                    $subrecord_baris['persentase'] = "-";

                    $subrecord_baris['warna'] = "bg-gray-light";
                }

                $no++;

                array_push($record_baris, $subrecord_baris);
            }

            $subrecord['baris'] = $record_baris;

            $subrecord['total_belanja_pengadaan'] = $total_belanja_pengadaan == 0 ? "-" : "Rp. ".number_format($total_belanja_pengadaan/1000000000,2,',','.')." M";
            $subrecord['total_penyedia_paket'] = $total_penyedia_paket == 0 ? "-" : number_format($total_penyedia_paket,0,',','.');
            $subrecord['total_penyedia_anggaran'] = $total_penyedia_anggaran == 0 ? "-" : "Rp. ".number_format($total_penyedia_anggaran/1000000000,2,',','.')." M";
            $subrecord['total_swakelola_paket'] = $total_swakelola_paket == 0 ? "-" : number_format($total_swakelola_paket,0,',','.');
            $subrecord['total_swakelola_anggaran'] = $total_swakelola_anggaran == 0 ? "-" : "Rp. ".number_format($total_swakelola_anggaran/1000000000,2,',','.')." M";
            $subrecord['total_penyedia_dalam_swakelola_paket'] = $total_penyedia_dalam_swakelola_paket == 0 ? "-" : number_format($total_penyedia_dalam_swakelola_paket,0,',','.');
            $subrecord['total_penyedia_dalam_swakelola_anggaran'] = $total_penyedia_dalam_swakelola_anggaran == 0 ? "-" : "Rp. ".number_format($total_penyedia_dalam_swakelola_anggaran/1000000000,2,',','.')." M";
            $subrecord['total_paket'] = $total_paket == 0 ? "-" : number_format($total_paket,0,',','.');
            $subrecord['total_anggaran'] = $total_anggaran == 0 ? "-" : "Rp. ".number_format($total_anggaran/1000000000,2,',','.')." M";

            array_push($record, $subrecord);
        } else {
            array_push($record_baris, $subrecord_baris);
            array_push($record, $subrecord);
        }

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/tabel_rup_satker_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json tabel_rup_satker_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json tabel_rup_satker_".$thn.".json");
        // }
    }
}