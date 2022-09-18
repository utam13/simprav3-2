<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nontender extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_nontender');
    }

    public function rekapitulasi()
    {
        $data['halaman'] = "Non Tender - Rekapitulasi";

        $data['main'] = "nontender";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/nontender_rekapitulasi');
        $this->load->view('layout/footer');
    }

    public function rincian_paket($thn = "", $kelompok = "total", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Non Tender - Rincian Paket";

        $data['main'] = "nontender";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_rincian');
        }

        $tgl = date('Y-m-d');

        $data['kelompok'] = $kelompok;

        switch ($kelompok) {
            case 'total':
                $data['rowspan'] = "rowspan=2";

                $qkelompok = "(a.nama_status_nontender='aktif' OR a.nama_status_nontender='batal' OR a.nama_status_nontender='gagal')";
                break;
            case 'selesai':
                $data['rowspan'] = "rowspan=2";

                $qkelompok = "a.nama_status_nontender='aktif' AND a.nilai_negosiasi>'0'";
                break;
            case 'berjalan':
                $data['rowspan'] = "";

                $qkelompok = "a.nama_status_nontender='aktif' AND (a.nilai_negosiasi='0' OR a.nilai_negosiasi IS NULL)";
                break;
            case 'batal':
                $data['rowspan'] = "";

                $qkelompok = "a.nama_status_nontender='batal'";
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

        $jumlah_data = $this->mod_nontender->jumlah_rincian($data['thn'], $qcari, $qkelompok);

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

        $rincian = $this->mod_nontender->rincian($limit_start, $limit, $data['thn'], $qcari, $qkelompok)->result();
        foreach ($rincian as $r) {
            $subrecord['no'] = $no;
            $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "0" || $r->kd_rup_paket == "" ? "-" :$r->kd_rup_paket;
            $subrecord['satker'] = $r->nama_satker;

            $rup_penyedia = $this->mod_nontender->cek_rup_penyedia($r->kd_rup_paket);
            if(!empty($rup_penyedia)){
                $subrecord['kegiatan'] = $rup_penyedia['kegiatan'] == "" ? "-" : strtoupper($rup_penyedia['kegiatan']);
            } else {
                $subrecord['kegiatan'] = "-";
            }

            $subrecord['jml_teks'] = strlen($r->nama_paket);
            $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
            $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? strtoupper(substr($subrecord['nama_paket'],0,100)."...") : strtoupper($subrecord['nama_paket']);

            $pegawai = $this->mod_nontender->cek_pegawai($r->nip_ppk);
            if(!empty($rup_penyedia)){
                $subrecord['ppk'] = $pegawai['nama_pegawai'];
            } else {
                $subrecord['ppk'] = "-";
            }

            $subrecord['sumber_dana'] = $r->anggaran;
            $subrecord['tanggal_pengumuman_tender'] = date('d-m-Y',strtotime($r->tanggal_pengumuman_nontender));
            $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
            $subrecord['hps'] = $r->hps == 0 ? "-" : "Rp. ".number_format($r->hps,0,',','.');
            $subrecord['nilai_hasil_tender'] = $r->nilai_negosiasi == 0 ? "-" : "Rp. ".number_format($r->nilai_negosiasi,0,',','.');
            $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');
            
            $nilai_optimalisasi = $r->pagu - $r->nilai_negosiasi;
            if($r->nilai_negosiasi > 0){
                $persen_optimalisasi = ($nilai_optimalisasi / $r->pagu) * 100;
            } else {
                $persen_optimalisasi = 0;
            }

            $subrecord['nilai_optimalisasi'] =  $nilai_optimalisasi == 0 ? "-" : "Rp. ".number_format($nilai_optimalisasi,0,',','.');
            $subrecord['persen_optimalisasi'] = $persen_optimalisasi == 0 ? "-" : number_format($persen_optimalisasi,2,',','.')."%";

            $penyedia = $this->mod_nontender->cek_penyedia($r->kd_penyedia);
            if(!empty($penyedia)){
                $subrecord['penyedia'] = $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                $subrecord['domisili'] = $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];
            } else {
                $subrecord['penyedia'] = "-";
                $subrecord['domisili'] = "-";
            }

            $subrecord['status'] = "";
            $subrecord['alasan_batal'] =strip_tags(htmlentities(preg_replace('~[\r\n]+~', '',$r->ket_ditutup)));

            $no++;

            array_push($record, $subrecord);
        }

        $data['rincian'] = json_encode($record);

        $total_pagu = $this->mod_nontender->total_pagu($data['thn'], $qkelompok);
        $total_tender = $this->mod_nontender->total_tender($data['thn'], $qkelompok);
        $total_optimalisasi = $total_pagu['total'] - $total_tender['total'];
        if($total_pagu['total'] != 0){
            $total_persen = ($total_optimalisasi / $total_pagu['total']) * 100;
        } else {
            $total_persen = 0;
        }

        $data['total_paket'] = $jumlah_data;
        $data['total_pagu'] = $total_pagu['total'] == 0 ? "-" : "Rp. ".number_format($total_pagu['total'] / 1000000000,2,',','.')." M";
        $data['total_tender'] = $total_tender['total']  == 0 ? "-" : "Rp. ".number_format($total_tender['total'] / 1000000000,2,',','.')." M";
        $data['total_optimalisasi'] = $total_optimalisasi == 0 ? "-" : "Rp. ".number_format($total_optimalisasi / 1000000000,2,',','.')." M";
        $data['total_persen'] = $total_persen == 0 ? "-" : number_format($total_persen,2,',','.')."%";

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/nontender_rincian_paket');
        $this->load->view('layout/footer');
    }

    public function nontender($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        // metode
        $record_metode = array();
        $subrecord_metode = array();

        $record_metode_baris = array();
        $subrecord_metode_baris = array();

        $no = 1;

        $total_rup_paket = 0;
        $total_rup_anggaran = 0;
        $total_proses_paket = 0;
        $total_proses_anggaran = 0;
        $total_selesai_paket = 0;
        $total_selesai_anggaran = 0;
        $total_selesai_nilai = 0;
        $total_hemat_anggaran = 0;

        $metode = $this->mod_nontender->metode($thn)->result();
        foreach ($metode as $m) {
            $subrecord_metode_baris['no'] = $no;
            $subrecord_metode_baris['metode'] = $m->metode;
            $subrecord_metode_baris['rup_paket'] = $m->rup_paket == 0 ? "-" : number_format($m->rup_paket,0,',','.');
            $subrecord_metode_baris['rup_anggaran'] = $m->rup_anggaran == 0 ? "-" : "Rp. ".number_format($m->rup_anggaran / 1000000000,2,',','.')." M";
            $subrecord_metode_baris['proses_paket'] = $m->proses_paket == 0 ? "-" : number_format($m->proses_paket,0,',','.');
            $subrecord_metode_baris['proses_anggaran'] = $m->proses_anggaran == 0 ? "-" : "Rp. ".number_format($m->proses_anggaran / 1000000000,2,',','.')." M";
            $subrecord_metode_baris['selesai_paket'] = $m->selesai_paket == 0 ? "-" : number_format($m->selesai_paket,0,',','.');
            $subrecord_metode_baris['selesai_anggaran'] = $m->selesai_anggaran == 0 ? "-" : "Rp. ".number_format($m->selesai_anggaran / 1000000000,2,',','.')." M";
            $subrecord_metode_baris['selesai_nilai'] = $m->selesai_nilai == 0 ? "-" : "Rp. ".number_format($m->selesai_nilai / 1000000000,2,',','.')." M";
            $subrecord_metode_baris['hemat_anggaran'] = $m->hemat_anggaran == 0 ? "-" : "Rp. ".number_format($m->hemat_anggaran / 1000000000,2,',','.')." M";
            $subrecord_metode_baris['hemat_persen'] = $m->hemat_persen == 0 ? "-" : number_format($m->hemat_persen,2,',','.')."%";

            $total_rup_paket += $m->rup_paket;
            $total_rup_anggaran += $m->rup_anggaran;
            $total_proses_paket += $m->proses_paket;
            $total_proses_anggaran += $m->proses_anggaran;
            $total_selesai_paket += $m->selesai_paket;
            $total_selesai_anggaran += $m->selesai_anggaran;
            $total_selesai_nilai += $m->selesai_nilai;
            $total_hemat_anggaran += $m->hemat_anggaran;

            $no++;

            array_push($record_metode_baris, $subrecord_metode_baris);
        }

        $subrecord_metode['baris'] = $record_metode_baris;

        $subrecord_metode['total_rup_paket'] = $total_rup_paket == 0 ? "-" : number_format($total_rup_paket,0,',','.');
        $subrecord_metode['total_rup_anggaran'] = $total_rup_anggaran == 0 ? "-" : "Rp. ".number_format($total_rup_anggaran / 1000000000,2,',','.')." M";
        $subrecord_metode['total_proses_paket'] = $total_proses_paket == 0 ? "-" : number_format($total_proses_paket,0,',','.');
        $subrecord_metode['total_proses_anggaran'] = $total_proses_anggaran == 0 ? "-" : "Rp. ".number_format($total_proses_anggaran / 1000000000,2,',','.')." M";
        $subrecord_metode['total_selesai_paket'] = $total_selesai_paket == 0 ? "-" : number_format($total_selesai_paket,0,',','.');
        $subrecord_metode['total_selesai_anggaran'] = $total_selesai_anggaran == 0 ? "-" : "Rp. ".number_format($total_selesai_anggaran / 1000000000,2,',','.')." M";
        $subrecord_metode['total_selesai_nilai'] = $total_selesai_nilai == 0 ? "-" : "Rp. ".number_format($total_selesai_nilai / 1000000000,2,',','.')." M";
        $subrecord_metode['total_hemat_anggaran'] = $total_hemat_anggaran == 0 ? "-" : "Rp. ".number_format($total_hemat_anggaran / 1000000000,2,',','.')." M";

        array_push($record_metode, $subrecord_metode);

        $subrecord['metode'] = $record_metode;
        // end

        // jenis
        $record_jenis = array();
        $subrecord_jenis = array();

        $record_jenis_baris = array();
        $subrecord_jenis_baris = array();

        $no = 1;

        $total_total_paket = 0;
        $total_paket_selesai = 0;
        $total_paket_tayang = 0;
        $total_paket_review = 0;
        $total_paket_batal = 0;
        $total_total_pagu_anggaran = $this->mod_nontender->total_pagu_anggaran($thn);
        $total_pagu_anggaran_selesai = 0;
        $total_harga_negosiasi = 0;
        $total_hemat_optimalisasi = 0;

        $jenis = $this->mod_nontender->jenis($thn)->result();
        foreach ($jenis as $j) {
            $subrecord_jenis_baris['no'] = $no;
            $subrecord_jenis_baris['jenis'] = $j->jenis;
            $subrecord_jenis_baris['total_paket'] = $j->total_paket == 0 ? "-" : number_format($j->total_paket,0,',','.');
            $subrecord_jenis_baris['paket_selesai'] = $j->paket_selesai == 0 ? "-" : number_format($j->paket_selesai,0,',','.');
            $subrecord_jenis_baris['paket_tayang'] = $j->paket_tayang == 0 ? "-" : number_format($j->paket_tayang,0,',','.');
            $subrecord_jenis_baris['paket_review'] = $j->paket_review == 0 ? "-" : number_format($j->paket_review,0,',','.');
            $subrecord_jenis_baris['paket_batal'] = $j->paket_batal == 0 ? "-" : number_format($j->paket_batal,0,',','.');
            $subrecord_jenis_baris['total_pagu_anggaran'] = $j->total_pagu_anggaran == 0 ? "-" : "Rp. ".number_format($j->total_pagu_anggaran / 1000000000,2,',','.')." M";
            if($total_total_pagu_anggaran['total'] != 0){
                $persen_pagu_anggaran = ($j->total_pagu_anggaran / $total_total_pagu_anggaran['total']) * 100;
            } else {
                $persen_pagu_anggaran = 0;
            }
            $subrecord_jenis_baris['persen_pagu_anggaran'] = $persen_pagu_anggaran == 0 ? "-" : number_format($persen_pagu_anggaran,2,',','.')."%";
            $subrecord_jenis_baris['pagu_anggaran_selesai'] = $j->pagu_anggaran_selesai == 0 ? "-" : "Rp. ".number_format($j->pagu_anggaran_selesai / 1000000000,2,',','.')." M";
            $subrecord_jenis_baris['harga_negosiasi'] = $j->harga_negosiasi == 0 ? "-" : "Rp. ".number_format($j->harga_negosiasi / 1000000000,2,',','.')." M";
            $subrecord_jenis_baris['hemat_optimalisasi'] = $j->hemat_optimalisasi == 0 ? "-" : "Rp. ".number_format($j->hemat_optimalisasi / 1000000000,2,',','.')." M";
            $subrecord_jenis_baris['hemat_persen'] = $j->hemat_persen == 0 ? "-" : number_format($j->hemat_persen,2,',','.')."%";

            $total_total_paket += $j->total_paket;
            $total_paket_selesai += $j->paket_selesai;
            $total_paket_tayang += $j->paket_tayang;
            $total_paket_review += $j->paket_review;
            $total_paket_batal += $j->paket_batal;
            // $total_total_pagu_anggaran += $j->total_pagu_anggaran;
            $total_pagu_anggaran_selesai += $j->pagu_anggaran_selesai;
            $total_harga_negosiasi += $j->harga_negosiasi;
            $total_hemat_optimalisasi += $j->hemat_optimalisasi;

            $no++;

            array_push($record_jenis_baris, $subrecord_jenis_baris);
        }

        $subrecord_jenis['baris'] = $record_jenis_baris;

        $subrecord_jenis['total_total_paket'] = $total_total_paket == 0 ? "-" : number_format($total_total_paket,0,',','.');
        $subrecord_jenis['total_paket_selesai'] = $total_paket_selesai == 0 ? "-" : number_format($total_paket_selesai,0,',','.');
        $subrecord_jenis['total_paket_tayang'] = $total_paket_tayang == 0 ? "-" : number_format($total_paket_tayang,0,',','.');
        $subrecord_jenis['total_paket_review'] = $total_paket_review == 0 ? "-" : number_format($total_paket_review,0,',','.');
        $subrecord_jenis['total_paket_batal'] = $total_paket_batal == 0 ? "-" : number_format($total_paket_batal,0,',','.');
        $subrecord_jenis['total_total_pagu_anggaran'] = $total_total_pagu_anggaran == 0 ? "-" : "Rp. ".number_format($total_total_pagu_anggaran['total'] / 1000000000,2,',','.')." M";
        $subrecord_jenis['total_pagu_anggaran_selesai'] = $total_pagu_anggaran_selesai == 0 ? "-" : "Rp. ".number_format($total_pagu_anggaran_selesai / 1000000000,2,',','.')." M";
        $subrecord_jenis['total_harga_negosiasi'] = $total_harga_negosiasi == 0 ? "-" : "Rp. ".number_format($total_harga_negosiasi / 1000000000,2,',','.')." M";
        $subrecord_jenis['total_hemat_optimalisasi'] = $total_hemat_optimalisasi == 0 ? "-" : "Rp. ".number_format($total_hemat_optimalisasi / 1000000000,2,',','.')." M";

        array_push($record_jenis, $subrecord_jenis);

        $subrecord['jenis'] = $record_jenis;
        // end

        // satker
        $record_satker = array();
        $subrecord_satker = array();

        $record_satker_baris = array();
        $subrecord_satker_baris = array();

        $no = 1;

        $total_paket = 0;
        $total_pengadaan_barang = 0;
        $total_jasa_konsultasi = 0;
        $total_jasa_lainnya = 0;
        $total_pekerjaan_konstruksi = 0;
        $total_pagu_anggaran = $this->mod_nontender->total_anggaran($thn);

        $satker = $this->mod_nontender->satker($thn)->result();
        foreach ($satker as $s) {
            $subrecord_satker_baris['no'] = $no;

            $cek_satker = $this->mod_nontender->cek_satker($s->kd_satker);
            $subrecord_satker_baris['singkatan'] = $cek_satker['singkatan'];

            $subrecord_satker_baris['paket'] = $s->paket == 0 ? "-" : number_format($s->paket,0,',','.');
            $subrecord_satker_baris['pengadaan_barang'] = $s->pengadaan_barang == 0 ? "-" : "Rp. ".number_format($s->pengadaan_barang / 1000000000,2,',','.')." M";
            $subrecord_satker_baris['jasa_konsultasi'] = $s->jasa_konsultasi == 0 ? "-" : "Rp. ".number_format($s->jasa_konsultasi / 1000000000,2,',','.')." M";
            $subrecord_satker_baris['jasa_lainnya'] = $s->jasa_lainnya == 0 ? "-" : "Rp. ".number_format($s->jasa_lainnya / 1000000000,2,',','.')." M";
            $subrecord_satker_baris['pekerjaan_konstruksi'] = $s->pekerjaan_konstruksi == 0 ? "-" : "Rp. ".number_format($s->pekerjaan_konstruksi / 1000000000,2,',','.')." M";

            $subrecord_satker_baris['total'] = $s->total == 0 ? "-" : "Rp. ".number_format($s->total / 1000000000,2,',','.')." M";
            if($total_pagu_anggaran['total'] != 0){
                $persen = ($s->total / $total_pagu_anggaran['total']) * 100;
            } else {
                $persen = 0;
            }
            $subrecord_satker_baris['persen'] =  $persen == 0 ? "-" : number_format($persen,2,',','.')."%";

            $total_paket += $s->paket;
            $total_pengadaan_barang += $s->pengadaan_barang;
            $total_jasa_konsultasi += $s->jasa_konsultasi;
            $total_jasa_lainnya += $s->jasa_lainnya;
            $total_pekerjaan_konstruksi += $s->pekerjaan_konstruksi;

            $no++;

            array_push($record_satker_baris, $subrecord_satker_baris);
        }

        $subrecord_satker['baris'] = $record_satker_baris;

        $subrecord_satker['total_paket'] = $total_paket == 0 ? "-" : number_format($total_paket,0,',','.');
        $subrecord_satker['total_pengadaan_barang'] = $total_pengadaan_barang == 0 ? "-" : "Rp. ".number_format($total_pengadaan_barang / 1000000000,2,',','.')." M";
        $subrecord_satker['total_jasa_konsultasi'] = $total_jasa_konsultasi == 0 ? "-" : "Rp. ".number_format($total_jasa_konsultasi / 1000000000,2,',','.')." M";
        $subrecord_satker['total_jasa_lainnya'] = $total_jasa_lainnya == 0 ? "-" : "Rp. ".number_format($total_jasa_lainnya / 1000000000,2,',','.')." M";
        $subrecord_satker['total_pekerjaan_konstruksi'] = $total_pekerjaan_konstruksi == 0 ? "-" : "Rp. ".number_format($total_pekerjaan_konstruksi / 1000000000,2,',','.')." M";
        $subrecord_satker['total'] = $total_pagu_anggaran['total'] == 0 ? "-" : "Rp. ".number_format($total_pagu_anggaran['total'] / 1000000000,2,',','.')." M";

        array_push($record_satker, $subrecord_satker);

        $subrecord['satker'] = $record_satker;
        // end

        array_push($record, $subrecord);

        echo json_encode($record);
    }
}