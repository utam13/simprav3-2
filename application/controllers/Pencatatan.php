<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pencatatan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_pencatatan');
    }

    public function nontender($thn = "", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Pencatatan - Non Tender";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_nontender');
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

        $jumlah_data = $this->mod_pencatatan->jumlah($data['thn'], $qcari);

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

        $daftar = $this->mod_pencatatan->daftar($limit_start, $limit, $data['thn'], $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kode_rup_paket'] = $d->kd_rup_paket;
            $subrecord['satker'] = $d->nama_satker;

            $rup_penyedia = $this->mod_pencatatan->cek_rup_penyedia($d->kd_rup_paket);
            if(!empty($rup_penyedia)){
                $subrecord['kegiatan'] = $rup_penyedia['kegiatan'] == "" ? "-" : strtoupper($rup_penyedia['kegiatan']);
            } else {
                $subrecord['kegiatan'] = "-";
            }

            $subrecord['nama_paket'] = $d->nama_paket;

            $pegawai = $this->mod_pencatatan->cek_pegawai($d->nip_ppk);
            $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

            // $cek_nontender = $this->mod_pencatatan->cek_rup_penyedia($d->kd_rup_paket);
            // $subrecord['sumber_dana'] = $cek_nontender['sumber_dana'];
            $subrecord['sumber_dana'] = $d->ang;

            $subrecord['tgl_mulai'] = date('d-m-Y',strtotime($d->tgl_mulai_paket));
            $subrecord['tgl_selesai'] = date('d-m-Y',strtotime($d->tgl_selesai_paket));
            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
            $subrecord['realisasi'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

            $optimalisasi = $d->pagu - $d->total_realisasi;
            $subrecord['optimalisasi'] = $optimalisasi == 0 ? "-" : "Rp. ".number_format($optimalisasi,0,',','.');

            if($d->pagu > 0){
                $persen = ($optimalisasi / $d->pagu) * 100;
            } else {
                $persen = 0;
            }
            $subrecord['persen'] = $persen == 0 ? "-" : number_format($persen,2,',','.')."%";

            $penyedia = $this->mod_pencatatan->cek_penyedia($d->kd_penyedia);
            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
            $subrecord['domisili'] = empty($penyedia) || $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];

            $subrecord['jml_teks'] = strlen($d->uraian_pekerjaan);
            $subrecord['uraian'] = $d->uraian_pekerjaan == "" ? "-" : htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->uraian_pekerjaan)));
            $subrecord['uraian_cut'] = strlen($subrecord['uraian']) > 150 ? substr($subrecord['uraian'],0,100)."..." : $subrecord['uraian'];

            $subrecord['keterangan'] = $d->keterangan == "" ? "-" : $d->keterangan;

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/pencatatan_nontender');
        $this->load->view('layout/footer');
    }

    public function swakelola($thn = "", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Pencatatan - Swakelola";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_swakelola');
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

        $jumlah_data = $this->mod_pencatatan->jumlah2($data['thn'], $qcari);

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

        $daftar = $this->mod_pencatatan->daftar2($limit_start, $limit, $data['thn'], $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kode_rup_paket'] = $d->kd_rup_paket;
            $subrecord['satker'] = $d->nama_satker;

            $rup_penyedia = $this->mod_pencatatan->cek_rup_penyedia2($d->kd_rup_paket);
            $subrecord['kegiatan'] =  empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

            $subrecord['nama_paket'] = $d->nama_paket;

            $pegawai = $this->mod_pencatatan->cek_pegawai2($d->nip_ppk);
            $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

            // $cek_nontender = $this->mod_pencatatan->cek_rup_penyedia($d->kd_rup_paket);
            // $subrecord['sumber_dana'] = $cek_nontender['sumber_dana'];
            $subrecord['sumber_dana'] = $d->ang;

            $subrecord['tgl_mulai'] = date('d-m-Y',strtotime($d->tgl_mulai_paket));
            $subrecord['tgl_selesai'] = date('d-m-Y',strtotime($d->tgl_selesai_paket));
            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
            $subrecord['realisasi'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

            $optimalisasi = $d->pagu - $d->total_realisasi;
            $subrecord['optimalisasi'] = $optimalisasi == 0 ? "-" : "Rp. ".number_format($optimalisasi,0,',','.');

            if($d->pagu > 0){
                $persen = ($optimalisasi / $d->pagu) * 100;
            } else {
                $persen = 0;
            }
            $subrecord['persen'] = $persen == 0 ? "-" : number_format($persen,2,',','.')."%";

            $penyedia = $this->mod_pencatatan->cek_penyedia($d->kd_penyedia);
            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
            $subrecord['domisili'] = empty($penyedia) || $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];

            $subrecord['jml_teks'] = strlen($d->uraian_pekerjaan);
            $subrecord['uraian'] = $d->uraian_pekerjaan == "" ? "-" : htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->uraian_pekerjaan)));
            $subrecord['uraian_cut'] = strlen($subrecord['uraian']) > 150 ? substr($subrecord['uraian'],0,100)."..." : $subrecord['uraian'];
            $subrecord['keterangan'] = $d->keterangan == "" ? "-" : $d->keterangan;

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/pencatatan_swakelola');
        $this->load->view('layout/footer');
    }
}