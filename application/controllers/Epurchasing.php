<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Epurchasing extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_epurchasing');
    }

    public function index($thn = "", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "e-Purchasing";

        $data['main'] = "";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_epurchasing');
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

        $jumlah_data = $this->mod_epurchasing->jumlah($data['thn'], $qcari);

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

        $daftar = $this->mod_epurchasing->daftar($limit_start, $limit, $data['thn'], $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kode_rup_paket'] = $d->rup_id;
            $subrecord['satker'] = $d->nama_satker;

            $rup_penyedia = $this->mod_epurchasing->cek_rup_penyedia($d->rup_id);
            $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

            $subrecord['nama_paket'] = $d->nama_paket;

            $pegawai = $this->mod_epurchasing->cek_pegawai($d->ppk_nip);
            $subrecord['ppk'] =  empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-" : $pegawai['nama_pegawai'];

            $subrecord['sumber_dana'] = $d->nama_sumber_dana;
            $subrecord['pagu'] = $d->pagu_rup == 0 ? "-" : "Rp. ".number_format($d->pagu_rup,0,',','.');
            $subrecord['nomor_paket'] = $d->no_paket;
            $subrecord['jenis_katalog'] = ucwords($d->jenis_katalog);
            $subrecord['nama_komoditas'] = $d->nama_komoditas;
            $subrecord['harga_satuan'] = $d->harga_satuan == 0 ? "-" : "Rp. ".number_format($d->harga_satuan,0,',','.');
            $subrecord['kuantitas'] = $d->kuantitas == 0 ? "-" : number_format($d->kuantitas,0,',','.');
            $subrecord['ongkos_kirim'] = $d->ongkos_kirim == 0 ? "-" : "Rp. ".number_format($d->ongkos_kirim,0,',','.');
            $subrecord['total_harga'] = $d->total_harga == 0 ? "-" : "Rp. ".number_format($d->total_harga,0,',','.');
            $subrecord['penyedia'] = $d->nama_penyedia;

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/epurchasing');
        $this->load->view('layout/footer');
    }
}