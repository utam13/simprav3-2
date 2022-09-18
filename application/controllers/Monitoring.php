<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_monitoring');
    }

    public function paket_strategis($thn = "", $kelompok = "tender", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Paket Strategis";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_paket');
        }

        $data['kelompok'] = $kelompok;

        switch ($kelompok) {
            case 'tender':
                $data['aktif_tender_tab'] = "active";
                $data['aktif_nontender_tab'] = "";

                $table = "tender";
                $qkelompok = "a.nama_status_tender='selesai' and status_paket_strategis='ya'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'nontender':
                $data['aktif_tender_tab'] = "";
                $data['aktif_nontender_tab'] = "active";

                $table = "non_tender";
                $qkelompok = "a.nama_status_nontender='aktif' and status_paket_strategis='ya'";
                $orderby = "a.kd_rup_paket";
                break;
        }

        // cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "b.nama_satker<>''";
        } else {
            $qcari = "b.nama_satker like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_rincian($table, $data['thn'], $qcari, $qkelompok, $orderby);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $rincian = $this->mod_monitoring->rincian($limit_start, $limit, $table, $data['thn'], $qcari, $qkelompok, $orderby)->result();
        foreach ($rincian as $r) {
            $subrecord['no'] = $no;

            switch ($kelompok) {
                case 'tender':
                        $subrecord['kode_paket'] = $r->kd_paket;
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['sumber_dana'] = $r->ang == "" ? "-" : $r->ang;
                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                        $penyedia = $this->mod_monitoring->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                        
                        if($r->nilai_kontrak != 0){
                            $optimalisasi_nilai = $r->pagu - $r->nilai_kontrak;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        $subrecord['status_pelaksanaan'] = $r->nama_status_pekerjaan == "" ? "-" : $r->nama_status_pekerjaan;
                        $subrecord['status_strategis'] = $r->status_paket_strategis == "" ? "-" : $r->status_paket_strategis;
                        break;
                case 'nontender':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['sumber_dana'] = $r->anggaran == "" ? "-" : $r->anggaran;
                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                        $penyedia = $this->mod_monitoring->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                        
                        if($r->nilai_kontrak != 0){
                            $optimalisasi_nilai = $r->pagu - $r->nilai_kontrak;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        $subrecord['status_pelaksanaan'] = $r->nama_status_pekerjaan == "" ? "-" : $r->nama_status_pekerjaan;
                        $subrecord['status_strategis'] = $r->status_paket_strategis == "" ? "-" : $r->status_paket_strategis;

                        break;
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['rincian'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_paket_strategis');
        $this->load->view('layout/footer');
    }

    public function sumber_dana($thn = "", $kelompok = "tender", $anggaran = "APBD", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Sumber Dana";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_sumber');
        }

        $ang = $this->input->post('anggaran');
        if($ang != ""){
            $data['anggaran'] = $ang;
        } else {
            $data['anggaran'] =  $anggaran;
        }

        $data['kelompok'] = $kelompok;

        switch ($kelompok) {
            case 'tender':
                $table = "tender";
                $qanggaran = "a.ang='".$data['anggaran']."'";
                $qkelompok = "(a.nama_status_tender='aktif' OR a.nama_status_tender='selesai' OR a.nama_status_tender='batal' OR a.nama_status_tender='gagal')";
                $orderby = "a.kd_rup_paket";
                break;
            case 'nontender':
                $table = "non_tender";
                $qanggaran = "a.anggaran='".$data['anggaran']."'";
                $qkelompok = "(a.nama_status_nontender='aktif' OR a.nama_status_nontender='batal' OR a.nama_status_nontender='gagal')";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_nontender':
                $table = "pct_nontender";
                $qanggaran = "a.ang='".$data['anggaran']."'";
                $qkelompok = "a.status_nontender_pct='aktif'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_swakelola':
                $table = "pct_swakelola";
                $qanggaran = "a.ang='".$data['anggaran']."'";
                $qkelompok = "a.status_swakelola_pct='aktif'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'epurchasing':
                $table = "epurchasing";
                $qanggaran = "a.nama_sumber_dana='".$data['anggaran']."'";
                $qkelompok = "a.rup_id<>''";
                $orderby = "a.rup_id";
                break;
        }

        // cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "b.nama_satker<>''";
            $data['getcari2'] = "-";
        } else {
            $qcari = "b.nama_satker like '%$getcari%'";
            $data['getcari2'] = $getcari;
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_rincian_sb($table, $data['thn'], $qcari, $qanggaran, $qkelompok, $orderby);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $rincian = $this->mod_monitoring->rincian_sb($limit_start, $limit, $table, $data['thn'], $qcari, $qanggaran, $qkelompok, $orderby)->result();
        foreach ($rincian as $r) {
            $subrecord['no'] = $no;

            switch ($kelompok) {
                case 'tender':
                        $subrecord['kode_paket'] = $r->kd_paket;
                        $subrecord['kode_utama'] = $r->kd_tender;
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                        $penyedia = $this->mod_monitoring->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                        
                        if($r->nilai_kontrak != 0){
                            $optimalisasi_nilai = $r->pagu - $r->nilai_kontrak;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        switch (strtolower($r->nama_status_tender)) {
                            case 'aktif':
                                $warna_status_paket = "bg-blue";
                                break;
                            case 'selesai':
                                $warna_status_paket = "bg-green";
                                break;
                            case 'gagal':
                            case 'batal':
                                $warna_status_paket = "bg-red";
                                break;
                            case 'draft':
                                $warna_status_paket = "bg-gray-light";
                                break;
                            case 'ditutup':
                                $warna_status_paket = "bg-gray";
                                break;
                        }
                        
                        $subrecord['status_paket'] = $r->nama_status_tender == "" ? "-" : "<span class='badge badge-pill $warna_status_paket'>". $r->nama_status_tender."</span>";

                        $subrecord['status_pelaksanaan'] = $r->nama_status_pekerjaan == "" ? "-" : $r->nama_status_pekerjaan;
                        
                        break;
                case 'nontender':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_utama'] = $r->kd_nontender;
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                        $penyedia = $this->mod_monitoring->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                        
                        if($r->nilai_kontrak != 0){
                            $optimalisasi_nilai = $r->pagu - $r->nilai_kontrak;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        switch (strtolower($r->nama_status_nontender)) {
                            case 'aktif':
                                $warna_status_paket = "bg-blue";
                                break;
                            case 'selesai':
                                $warna_status_paket = "bg-green";
                                break;
                            case 'gagal':
                            case 'batal':
                                $warna_status_paket = "bg-red";
                                break;
                            case 'draft':
                                $warna_status_paket = "bg-gray-light";
                                break;
                            case 'ditutup':
                                $warna_status_paket = "bg-gray";
                                break;
                        }
                        
                        $subrecord['status_paket'] = $r->nama_status_nontender == "" ? "-" : "<span class='badge badge-pill $warna_status_paket'>". $r->nama_status_nontender."</span>";
                        $subrecord['status_pelaksanaan'] = $r->nama_status_pekerjaan == "" ? "-" : $r->nama_status_pekerjaan;

                        break;
                case 'pencatatan_nontender':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                        $penyedia = $this->mod_monitoring->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                        if($r->total_realisasi != 0){
                            $optimalisasi_nilai = $r->pagu - $r->total_realisasi;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        break;
                case 'pencatatan_swakelola':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                        if($r->total_realisasi != 0){
                            $optimalisasi_nilai = $r->pagu - $r->total_realisasi;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        break;
                case 'epurchasing':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->rup_id;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_monitoring->cek_rup_penyedia($r->rup_id);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                        $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_monitoring->cek_pegawai($r->ppk_nip);
                        $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu_rup == 0 ? "-" : "Rp. ".number_format($r->pagu_rup,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->total_harga == 0 ? "-" : "Rp. ".number_format($r->total_harga,0,',','.');

                        if($r->total_harga != 0){
                            $optimalisasi_nilai = $r->pagu_rup - $r->total_harga;
                        } else {
                            $optimalisasi_nilai = 0;
                        }
                        $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
                        if($r->pagu_rup != 0){
                            $optimalisasi_persen = ($optimalisasi_nilai / $r->pagu_rup) * 100;
                        } else {
                            $optimalisasi_persen = 0;
                        }
                        $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

                        break;
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['rincian'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_sumber_dana');
        $this->load->view('layout/footer');
    }

    public function penyedia()
    {
        $data['halaman'] = "Monitoring - Penyedia";

        $data['main'] = "monitoring";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_penyedia');
        $this->load->view('layout/footer');
    }

    public function penyedia_prov($thn = 2021)
    {
        $no = 1;

        $record = array();
        $subrecord = array();

        $provinsi = $this->mod_monitoring->provinsi($thn)->result();
        foreach ($provinsi as $p) {
            $subrecord['no'] = $no;
            $subrecord['provinsi'] = "<a href='#monitoring' onclick='kota(\"$p->provinsi\")'>$p->provinsi</a>";
            $subrecord['total'] = $p->total == 0 ? "-" : number_format($p->total,0,',','.');

            $no++;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function penyedia_kota($prov)
    {
        $provinsi = urldecode($prov);

        $no = 1;

        $record = array();
        $subrecord = array();

        $kota = $this->mod_monitoring->kota($provinsi)->result();
        foreach ($kota as $k) {
            $subrecord['no'] = $no;
            $subrecord['kabupaten_kota'] = " <a href='".base_url()."monitoring/daftar_penyedia/$provinsi/$k->kabupaten_kota'>$k->kabupaten_kota</i>";
            $subrecord['total'] = $k->total == 0 ? "-" : number_format($k->total,0,',','.');

            $no++;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function daftar_penyedia($prov,$kabkot, $thn = "", $kelompok = "tender", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Penyedia";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_penyedia') != "" ? $this->input->post('thn_penyedia') : date('Y');
        }

        $data['provinsi'] = urldecode($prov);
        $data['kabupaten_kota'] = urldecode($kabkot);

        $data['kelompok'] = $kelompok;
        switch ($kelompok) {
            case 'tender':
                $data['nama_kelompok'] = "Tender";
                break;
            case 'nontender':
                $data['nama_kelompok'] = "Non Tender";
                break;
            case 'pencatatan_nontender':
                $data['nama_kelompok'] = "Pencatatan Non Tender";
                break;
            case 'pencatatan_swakelola':
                $data['nama_kelompok'] = "Pencatatan Swakelola";
                break;
            case 'epurchasing':
                $data['nama_kelompok'] = "ePurchasing";
                break;
        }

        // cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "a.kd_penyedia<>''";
        } else {
            $qcari = "b.nama_penyedia like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_penyedia($data['kabupaten_kota'], $kelompok, $data['thn'], $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $daftar = $this->mod_monitoring->daftar_penyedia($limit_start, $limit, $data['kabupaten_kota'], $kelompok, $data['thn'], $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['btn'] = $d->total_paket == 0 ? "-" : "<a href='".base_url()."monitoring/paket_penyedia/".$data['provinsi']."/".$data['kabupaten_kota']."/".$kelompok."/".$data['thn']."/".$d->kd_penyedia."' class='btn btn-primary btn-xs'>Daftar Paket</i>";
            $subrecord['kd_penyedia'] = $d->kd_penyedia;
            $subrecord['nama_penyedia'] = $d->nama_penyedia;
            $subrecord['aktif'] = $d->aktif == 0 ? "-" : number_format($d->aktif,0,',','.');
            $subrecord['batal'] = $d->batal == 0 ? "-" : number_format($d->batal,0,',','.');
            $subrecord['gagal'] = $d->gagal == 0 ? "-" : number_format($d->gagal,0,',','.');
            $subrecord['selesai'] = $d->selesai == 0 ? "-" : number_format($d->selesai,0,',','.');
            $subrecord['total_paket'] = $d->total_paket == 0 ? "-" : number_format($d->total_paket,0,',','.');
            $subrecord['total_pagu'] = $d->total_pagu == 0 ? "-" : "Rp. ".number_format($d->total_pagu,0,',','.');
            $subrecord['total_kontrak'] = $d->total_kontrak == 0 ? "-" : "Rp. ".number_format($d->total_kontrak,0,',','.');

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_penyedia_daftar');
        $this->load->view('layout/footer');
    }

    public function paket_penyedia($provinsi, $kabupaten_kota, $kelompok, $thn, $kode, $status = "aktif", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Penyedia";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $data['kelompok'] = $kelompok;
        $data['thn'] = $thn;
        $data['provinsi'] = urldecode($provinsi);
        $data['kabupaten_kota'] = urldecode($kabupaten_kota);

        // penyedia
        $penyedia = $this->mod_monitoring->cek_penyedia2($kode);
        $data['kd_penyedia'] = $kode;
        $data['npwp_penyedia'] = empty($penyedia) ? "-" : $penyedia['npwp_penyedia'];
        $data['nama_penyedia'] = empty($penyedia) ? "-" : $penyedia['nama_penyedia'];

        switch ($kelompok) {
            case 'tender':
                $data['nama_kelompok'] = "Tender";

                $table = "tender";
                $qkelompok = "a.kd_penyedia='$kode'";
                $qstatus = "a.nama_status_tender='".ucwords($status)."'";
                $orderby = "a.kd_paket";
                break;
            case 'nontender':
                $data['nama_kelompok'] = "Non Tender";

                $table = "non_tender";
                $qkelompok = "a.kd_penyedia='$kode'";
                $qstatus = "a.nama_status_nontender='".ucwords($status)."'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_nontender':
                $data['nama_kelompok'] = "Pencatatan Non Tender";

                $table = "pct_nontender";
                $qkelompok = "a.kd_penyedia='$kode'";
                $qstatus = "a.status_nontender_pct='".ucwords($status)."'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_swakelola':
                $data['nama_kelompok'] = "Pencatatan Swakelola";

                $table = "pct_swakelola";
                $qkelompok = "a.npwp_penyedia='".$data['npwp_penyedia']."'";
                $qstatus = "a.status_swakelola_pct='".ucwords($status)."'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'epurchasing':
                $data['nama_kelompok'] = "ePurchasing";

                $table = "epurchasing";
                $qkelompok = "a.npwp_penyedia='".$data['npwp_penyedia']."'";
                $qstatus = "a.paket_status_str like '%".ucwords($status)."'";
                $orderby = "a.no_paket";
                break;
        }

        $data['status'] = $status;

        // cari
        if ($isicari != "-" && $isicari != "") {
            $getcari = $isicari;
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "a.nama_paket<>''";
        } else {
            $qcari = "a.nama_paket like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_detail($table, $thn, $qkelompok, $qstatus, $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $detail = $this->mod_monitoring->detail($limit_start, $limit, $table, $thn, $qkelompok, $qstatus, $qcari, $orderby)->result();
        foreach ($detail as $d) {
            $subrecord['no'] = $no;
            $subrecord['jml_teks'] = strlen($d->nama_paket);
            $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->nama_paket)));
            $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];

            $subrecord['nama_satker'] = $d->nama_satker;
            $subrecord['singkatan'] = $d->singkatan;

            switch ($kelompok) {
                case 'tender':
                    $subrecord['kode_paket'] = $d->kd_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                    // $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    // $subrecord['penyedia'] = $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                    $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                    break;
                case 'nontender':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->anggaran;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                    // $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    // $subrecord['penyedia'] = $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                    $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                    break;
                case 'pctnontender':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                    // $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    // $subrecord['penyedia'] = $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    break;
                case 'pctswakelola':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                    // $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    // $subrecord['penyedia'] = $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    break;
                case 'epurchasing':
                    $subrecord['kode_paket'] = $d->no_paket;
                    $subrecord['sumber_dana'] = $d->nama_sumber_dana;
                    $subrecord['pagu'] = $d->pagu_rup == 0 ? "-" : "Rp. ".number_format($d->pagu_rup,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->total_harga == 0 ? "-" : "Rp. ".number_format($d->total_harga,0,',','.');
                    // $subrecord['penyedia'] = $d->nama_penyedia == "" ? "-" : $d->nama_penyedia;
                    break;
            }        
            
            $no++;

            array_push($record, $subrecord);
        }

        $data['detail'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_penyedia_paket');
        $this->load->view('layout/footer');
    }

    public function ppk($thn = "", $kelompok = "tender", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - PPK";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_ppk');
        }

        $data['kelompok'] = $kelompok;
        $qkelompok = "a.kelompok='$kelompok'";
        switch ($kelompok) {
            case 'tender':
                $data['nama_kelompok'] = "Tender";
                break;
            case 'nontender':
                $data['nama_kelompok'] = "Non Tender";
                break;
            case 'pencatatan_nontender':
                $data['nama_kelompok'] = "Pencatatan Non Tender";
                break;
            case 'pencatatan_swakelola':
                $data['nama_kelompok'] = "Pencatatan Swakelola";
                break;
            case 'epurchasing':
                $data['nama_kelompok'] = "ePurchasing";
                break;
        }

        // cari
        if ($isicari != "-" && $isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "b.nip_pegawai<>''";
        } else {
            $qcari = "(b.nip_pegawai='$getcari' or b.nama_pegawai like '%$getcari%')";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah($data['thn'], $qkelompok, $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $daftar = $this->mod_monitoring->daftar($limit_start, $limit, $data['thn'], $qkelompok, $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['btn'] = "<a href='".base_url()."monitoring/paket_ppk/".$data['thn']."/$kelompok/$d->nip_pegawai"."' class='btn btn-primary btn-xs'>Daftar Paket</i>";
            $subrecord['nip_pegawai'] = $d->nip_pegawai;
            $subrecord['nama_pegawai'] = $d->nama_pegawai;
            $subrecord['aktif'] = $d->aktif == 0 ? "-" : number_format($d->aktif,0,',','.');
            $subrecord['batal'] = $d->batal == 0 ? "-" : number_format($d->batal,0,',','.');
            $subrecord['gagal'] = $d->gagal == 0 ? "-" : number_format($d->gagal,0,',','.');
            $subrecord['selesai'] = $d->selesai == 0 ? "-" : number_format($d->selesai,0,',','.');
            $subrecord['total_paket'] = $d->total_paket == 0 ? "-" : number_format($d->total_paket,0,',','.');
            $subrecord['total_pagu'] = $d->total_pagu == 0 ? "-" : "Rp. ".number_format($d->total_pagu,0,',','.');
            $subrecord['total_kontrak'] = $d->total_kontrak == 0 ? "-" : "Rp. ".number_format($d->total_kontrak,0,',','.');

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_ppk');
        $this->load->view('layout/footer');
    }

    public function paket_ppk($thn, $kelompok, $nip, $status = "aktif", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - PPK";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $data['kelompok'] = $kelompok;
        $data['thn'] = $thn;

        switch ($kelompok) {
            case 'tender':
                $data['nama_kelompok'] = "Tender";

                $table = "tender";
                $qkelompok = "a.nip_ppk='$nip'";
                $qstatus = "a.nama_status_tender='".ucwords($status)."'";
                $orderby = "a.kd_paket";
                break;
            case 'nontender':
                $data['nama_kelompok'] = "Non Tender";

                $table = "non_tender";
                $qkelompok = "a.nip_ppk='$nip'";
                $qstatus = "a.nama_status_nontender='".ucwords($status)."'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_nontender':
                $data['nama_kelompok'] = "Pencatatan Non Tender";

                $table = "pct_nontender";
                $qkelompok = "a.nip_ppk='$nip'";
                $qstatus = "a.status_nontender_pct='".ucwords($status)."'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_swakelola':
                $data['nama_kelompok'] = "Pencatatan Swakelola";

                $table = "pct_swakelola";
                $qkelompok = "a.nip_ppk='$nip'";
                $qstatus = "a.status_swakelola_pct='".ucwords($status)."'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'epurchasing':
                $data['nama_kelompok'] = "ePurchasing";

                $table = "epurchasing";
                $qkelompok = "a.ppk_nip='$nip'";
                $qstatus = "a.paket_status_str like '%".ucwords($status)."'";
                $orderby = "a.no_paket";
                break;
        }

        $data['status'] = $status;

        // ppk
        $ppk = $this->mod_monitoring->ppk($nip);
        $data['nip'] = $nip;
        $data['nama'] = $ppk['nama_pegawai'];

        // cari
        if ($isicari != "-" && $isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "a.nama_paket<>''";
        } else {
            $qcari = "a.nama_paket like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_detail($table, $thn, $qkelompok, $qstatus, $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $detail = $this->mod_monitoring->detail($limit_start, $limit, $table, $thn, $qkelompok, $qstatus, $qcari, $orderby)->result();
        foreach ($detail as $d) {
            $subrecord['no'] = $no;
            $subrecord['jml_teks'] = strlen($d->nama_paket);
            $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->nama_paket)));
            $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];

            $subrecord['nama_satker'] = $d->nama_satker;
            $subrecord['singkatan'] = $d->singkatan;

            switch ($kelompok) {
                case 'tender':
                    $subrecord['kode_paket'] = $d->kd_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                    $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                    $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                    break;
                case 'nontender':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->anggaran;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                    $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                    $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                    break;
                case 'pencatatan_nontender':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                    $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    break;
                case 'pencatatan_swakelola':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                    $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    break;
                case 'epurchasing':
                    $subrecord['kode_paket'] = $d->no_paket;
                    $subrecord['sumber_dana'] = $d->nama_sumber_dana;
                    $subrecord['pagu'] = $d->pagu_rup == 0 ? "-" : "Rp. ".number_format($d->pagu_rup,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->total_harga == 0 ? "-" : "Rp. ".number_format($d->total_harga,0,',','.');
                    $subrecord['penyedia'] = $d->nama_penyedia == "" ? "-" : $d->nama_penyedia;
                    break;
            }        
            
            $no++;

            array_push($record, $subrecord);
        }

        $data['detail'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_paket_ppk');
        $this->load->view('layout/footer');
    }

    public function personil($thn = "", $kelompok = "pokja", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Personil";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_personil');
        }

        $data['kelompok'] = $kelompok;

        // cari
        if ($isicari != "-" && $isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "b.nip_pegawai<>''";
        } else {
            $qcari = "(b.nip_pegawai='$getcari' or b.nama_pegawai like '%$getcari%')";
        }

        $qpersonil = "a.personil='$kelompok'";

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_personil($data['thn'], $qpersonil, $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $daftar = $this->mod_monitoring->daftar_personil($limit_start, $limit, $data['thn'], $qpersonil, $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['btn'] = "<a href='".base_url()."monitoring/paket_personil/".$data['thn']."/$kelompok/$d->nip_pegawai"."' class='btn btn-primary btn-xs'>Daftar Paket</i>";
            $subrecord['nip_pegawai'] = $d->nip_pegawai;
            $subrecord['nama_pegawai'] = $d->nama_pegawai;
            $subrecord['aktif'] = $d->aktif == 0 ? "-" : number_format($d->aktif,0,',','.');
            $subrecord['batal'] = $d->batal == 0 ? "-" : number_format($d->batal,0,',','.');
            $subrecord['gagal'] = $d->gagal == 0 ? "-" : number_format($d->gagal,0,',','.');
            $subrecord['selesai'] = $d->selesai == 0 ? "-" : number_format($d->selesai,0,',','.');
            $subrecord['total_paket'] = $d->total_paket == 0 ? "-" : number_format($d->total_paket,0,',','.');
            $subrecord['total_pagu'] = $d->total_pagu == 0 ? "-" : "Rp. ".number_format($d->total_pagu,0,',','.');
            $subrecord['total_kontrak'] = $d->total_kontrak == 0 ? "-" : "Rp. ".number_format($d->total_kontrak,0,',','.');

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_personil');
        $this->load->view('layout/footer');
    }

    public function paket_personil($thn,$kelompok,$nip,$status = "aktif", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Personil";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $data['kelompok'] = $kelompok;
        $data['thn'] = $thn;

        $data['status'] = $status;

        // ppk
        $ppk = $this->mod_monitoring->pegawai($nip);
        $data['nip'] = $nip;
        $data['nama'] = $ppk['nama_pegawai'];

        // cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "a.nama_paket<>''";
        } else {
            $qcari = "a.nama_paket like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        switch ($kelompok) {
            case 'pokja':
                $jumlah_data = $this->mod_monitoring->jumlah_detail_pokja($thn, $nip, ucwords($status), $qcari);
                break;
            case 'pp':
                $jumlah_data = $this->mod_monitoring->jumlah_detail_pp($thn, $nip, ucwords($status), $qcari);
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

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        switch ($kelompok) {
            case 'pokja':
                $detail = $this->mod_monitoring->detail_pokja($limit_start, $limit, $thn, $nip, ucwords($status), $qcari)->result();
                break;
            case 'pp':
                $detail = $this->mod_monitoring->detail_pp($limit_start, $limit, $thn, $nip, ucwords($status), $qcari)->result();
                break;
        }
        
        foreach ($detail as $d) {
            $subrecord['no'] = $no;
            $subrecord['jml_teks'] = strlen($d->nama_paket);
            $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->nama_paket)));
            $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];

            $subrecord['nama_satker'] = $d->nama_satker;
            $subrecord['singkatan'] = $d->singkatan;

            switch ($kelompok) {
                case 'pokja':
                    $subrecord['kode_paket'] = $d->kd_paket;
                    $subrecord['sumber_dana'] = $d->ang;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                    $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                    $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                    break;
                case 'pp':
                    $subrecord['kode_paket'] = $d->kd_rup_paket;
                    $subrecord['sumber_dana'] = $d->anggaran;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                    $penyedia = $this->mod_monitoring->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                    $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                    break;
            }        
            
            $no++;

            array_push($record, $subrecord);
        }

        $data['detail'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_paket_personil');
        $this->load->view('layout/footer');
    }

    Public function kelompok_kerja($thn = "", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Monitoring - Kelompok Kerja";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_kelkerja');
        }

        // cari
        if ($isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "a.nama_pokja<>''";
        } else {
            $qcari = "(a.nama_pokja like '%$getcari%' OR b.nama_satker like '%$getcari%')";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_monitoring->jumlah_rincian_kelkerja($data['thn'], $qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $rincian = $this->mod_monitoring->rincian_kelkerja($limit_start, $limit, $data['thn'], $qcari)->result();
        foreach ($rincian as $r) {
            $subrecord['no'] = $no;
            $subrecord['kode_pokja'] = $r->kd_pokja;

            $subrecord['jml_teks_pokja'] = strlen($r->nama_pokja);
            $subrecord['nama_pokja'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_pokja)));
            $subrecord['nama_pokja_cut'] = strlen($subrecord['nama_pokja']) > 100 ? substr($subrecord['nama_pokja'],0,100)."..." : $subrecord['nama_pokja'];
            
            $subrecord['nama_satker'] = $r->nama_satker;

            $subrecord['anggota'] = "<ol class='item-in-table'>";
            $pegawai = $this->mod_monitoring->cek_pegawai2($r->nip_personil1);
            $subrecord['anggota'] .= empty($pegawai) ? "":"<li>".$r->nip_personil1." - ".$pegawai['nama_pegawai']."</li>";

            if($r->nip_personil2 != ""){
                $pegawai = $this->mod_monitoring->cek_pegawai2($r->nip_personil2);
                $subrecord['anggota'] .= empty($pegawai) ? "":"<li>".$r->nip_personil2." - ".$pegawai['nama_pegawai']."</li>";
            }

            if($r->nip_personil3 != ""){
                $pegawai = $this->mod_monitoring->cek_pegawai2($r->nip_personil3);
                $subrecord['anggota'] .= empty($pegawai) ? "":"<li>".$r->nip_personil3." - ".$pegawai['nama_pegawai']."</li>";
            }

            if($r->nip_personil4 != ""){
                $pegawai = $this->mod_monitoring->cek_pegawai2($r->nip_personil4);
                $subrecord['anggota'] .= empty($pegawai) ? "":"<li>".$r->nip_personil4." - ".$pegawai['nama_pegawai']."</li>";
            }

            if($r->nip_personil5 != ""){
                $pegawai = $this->mod_monitoring->cek_pegawai2($r->nip_personil5);
                $subrecord['anggota'] .= empty($pegawai) ? "":"<li>".$r->nip_personil5." - ".$pegawai['nama_pegawai']."</li>";
            }

            $subrecord['anggota'] .= "</ol>";

            $tender = $this->mod_monitoring->cek_tender($r->kd_tender);
            $subrecord['jml_teks'] = empty($tender) ? 0 : strlen($tender['nama_paket']);
            $subrecord['nama_paket'] = empty($tender) ?  "-" : htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($tender['nama_paket'])));
            $subrecord['nama_paket_cut'] = empty($tender) || strlen($subrecord['nama_paket']) > 100 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
            
            $subrecord['sumber_dana'] = empty($tender) || $tender['ang'] == "" ? "-" : $tender['ang'];
            $subrecord['pagu'] = empty($tender) || $tender['pagu'] == 0 ? "-" : "Rp. ".number_format($tender['pagu'],0,',','.');
            $subrecord['hps'] = empty($tender) || $tender['hps'] == 0 ? "-" : "Rp. ".number_format($tender['hps'],0,',','.');
            $subrecord['nilai_kontrak'] = empty($tender) || $tender['nilai_kontrak'] == 0 ? "-" : "Rp. ".number_format($tender['nilai_kontrak'],0,',','.');
            
            if(!empty($tender) && $tender['nilai_kontrak'] != 0){
                $optimalisasi_nilai = $tender['pagu'] - $tender['nilai_kontrak'];
            } else {
                $optimalisasi_nilai = 0;
            }
            $subrecord['optimalisasi_nilai'] = $optimalisasi_nilai == 0 ? "-" : "Rp. ".number_format($optimalisasi_nilai,0,',','.');
            
            if(!empty($tender) && $tender['pagu'] != 0){
                $optimalisasi_persen = ($optimalisasi_nilai / $tender['pagu']) * 100;
            } else {
                $optimalisasi_persen = 0;
            }
            $subrecord['optimalisasi_persen'] = $optimalisasi_persen == 0 ? "-" : number_format($optimalisasi_persen,2,',','.')."%";

            if(!empty($tender)){
                $penyedia = $this->mod_monitoring->cek_penyedia($tender['kd_penyedia']);
                $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
            } else {
                $subrecord['penyedia'] = "-";
            }
            $no++;

            array_push($record, $subrecord);
        }

        $data['rincian'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/monitoring_kelompok_kerja');
        $this->load->view('layout/footer');
    }
}