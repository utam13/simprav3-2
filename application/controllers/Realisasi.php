<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Realisasi extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_realisasi');
    }

    public function rekapitulasi()
    {
        $data['halaman'] = "Realisasi - Rekapitulasi";

        $data['main'] = "realisasi";
        $data['grafik'] = "grafik_realisasi";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/realisasi_rekapitulasi');
        $this->load->view('layout/footer');
    }

    public function rincian_paket($thn = "", $kelompok = "tender", $page = 1, $limit = 20, $isicari = "")
    {
        $data['halaman'] = "Realisasi - Rincian Paket";

        $data['main'] = "realisasi";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        if($thn != ""){
            $data['thn'] =  $thn;
        } else{
            $data['thn'] = $this->input->post('thn_rincian');
        }

        $data['kelompok'] = $kelompok;

        switch ($kelompok) {
            case 'tender':
                $table = "tender";
                $qkelompok = "a.nama_status_tender='selesai'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'nontender':
                $table = "non_tender";
                $qkelompok = "a.nama_status_nontender='aktif'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_nontender':
                $table = "pct_nontender";
                $qkelompok = "a.status_nontender_pct='aktif'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'pencatatan_swakelola':
                $table = "pct_swakelola";
                $qkelompok = "a.status_swakelola_pct='aktif'";
                $orderby = "a.kd_rup_paket";
                break;
            case 'epurchasing':
                $table = "epurchasing";
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
        } else {
            $qcari = "b.nama_satker like '%$getcari%'";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_realisasi->jumlah_rincian($table, $data['thn'], $qcari, $qkelompok, $orderby);

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

        $rincian = $this->mod_realisasi->rincian($limit_start, $limit, $table, $data['thn'], $qcari, $qkelompok, $orderby)->result();
        foreach ($rincian as $r) {
            $subrecord['no'] = $no;

            switch ($kelompok) {
                case 'tender':
                        $subrecord['kode_paket'] = $r->kd_paket;
                        $subrecord['kode_utama'] = $r->kd_tender;
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_realisasi->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_realisasi->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                        $penyedia = $this->mod_realisasi->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                        
                        $realisasi_tender = $this->mod_realisasi->realisasi_tender($r->kd_tender);
                        $subrecord['realisasi_kontrak'] = empty($realisasi_tender) || $realisasi_tender['besar_pembayaran_bap'] == 0 ? "-" : "Rp. ".number_format($realisasi_tender['besar_pembayaran_bap'],0,',','.');
                        if($r->nilai_kontrak != 0){
                            $realisasi_kontrak_persen = ($realisasi_tender['besar_pembayaran_bap'] / $r->nilai_kontrak) * 100;
                        } else {
                            $realisasi_kontrak_persen = 0;
                        }
                        $subrecord['realisasi_kontrak_persen'] = $realisasi_kontrak_persen == 0 ? "-" : number_format($realisasi_kontrak_persen,2,',','.')."%";

                        if(!empty($realisasi_tender) && $realisasi_tender['besar_pembayaran_bap'] != 0){
                            $sisa_kontrak = $r->nilai_kontrak - $realisasi_tender['besar_pembayaran_bap'];
                        } else {
                            $sisa_kontrak = 0;
                        }
                        $subrecord['sisa_kontrak'] = $sisa_kontrak == 0 ? "-" : "Rp. ".number_format($sisa_kontrak,0,',','.');

                        if(!empty($realisasi_tender) && $realisasi_tender['besar_pembayaran_bap'] != 0){
                            $sisa_kontrak_persen = ($sisa_kontrak / $realisasi_tender['besar_pembayaran_bap']) * 100;
                        } else {
                            $sisa_kontrak_persen = 0;
                        }
                        $subrecord['sisa_kontrak_persen'] = $sisa_kontrak_persen == 0 ? "-" : number_format($sisa_kontrak_persen,2,',','.')."%";


                        $subrecord['nama_status_pekerjaan'] = $r->nama_status_pekerjaan;
                        switch ($r->nama_status_pekerjaan) {
                            case 'ya':
                                $subrecord['status_pelaksanaan_ya'] = "checked";
                                $subrecord['status_pelaksanaan_tidak'] = "";
                                break;
                            case 'tidak':
                                $subrecord['status_pelaksanaan_ya'] = "";
                                $subrecord['status_pelaksanaan_tidak'] = "checked";
                                break;
                            default:
                                $subrecord['status_pelaksanaan_ya'] = "";
                                $subrecord['status_pelaksanaan_tidak'] = "checked";
                                break;
                        }
                        
                        $subrecord['status_paket_strategis'] = $r->status_paket_strategis;
                        switch ($r->status_paket_strategis) {
                            case 'ya':
                                $subrecord['status_strategis_ya'] = "checked";
                                $subrecord['status_strategis_tidak'] = "";
                                break;
                            case 'tidak':
                                $subrecord['status_strategis_ya'] = "";
                                $subrecord['status_strategis_tidak'] = "checked";
                                break;
                            default:
                                $subrecord['status_strategis_ya'] = "";
                                $subrecord['status_strategis_tidak'] = "checked";
                                break;
                        }

                        $subrecord['keterangan'] = "";

                        break;
                case 'nontender':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_utama'] = $r->kd_nontender;
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_realisasi->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_realisasi->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                        $penyedia = $this->mod_realisasi->cek_penyedia($r->kd_penyedia);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                        
                        $realisasi_nontender = $this->mod_realisasi->realisasi_nontender($r->kd_nontender);
                        $subrecord['realisasi_kontrak'] = empty($realisasi_nontender) || $realisasi_nontender['besar_pembayaran_bap'] == 0 ? "-" : "Rp. ".number_format($realisasi_nontender['besar_pembayaran_bap'],0,',','.');
                        if($r->nilai_kontrak != 0){
                            $realisasi_kontrak_persen = ($realisasi_nontender['besar_pembayaran_bap'] / $r->nilai_kontrak) * 100;
                        } else {
                            $realisasi_kontrak_persen = 0;
                        }
                        $subrecord['realisasi_kontrak_persen'] = $realisasi_kontrak_persen == 0 ? "-" : number_format($realisasi_kontrak_persen,2,',','.')."%";

                        if(!empty($realisasi_nontender) && $realisasi_nontender['besar_pembayaran_bap'] != 0){
                            $sisa_kontrak = $r->nilai_kontrak - $realisasi_nontender['besar_pembayaran_bap'];
                        } else {
                            $sisa_kontrak = 0;
                        }
                        $subrecord['sisa_kontrak'] = $sisa_kontrak == 0 ? "-" : "Rp. ".number_format($sisa_kontrak,0,',','.');

                        if(!empty($realisasi_nontender) &&$realisasi_nontender['besar_pembayaran_bap'] != 0){
                            $sisa_kontrak_persen = ($sisa_kontrak / $realisasi_nontender['besar_pembayaran_bap']) * 100;
                        } else {
                            $sisa_kontrak_persen = 0;
                        }
                        $subrecord['sisa_kontrak_persen'] = $sisa_kontrak_persen == 0 ? "-" : number_format($sisa_kontrak_persen,2,',','.')."%";

                        $subrecord['nama_status_pekerjaan'] = $r->nama_status_pekerjaan;
                        switch ($r->nama_status_pekerjaan) {
                            case 'ya':
                                $subrecord['status_pelaksanaan_ya'] = "checked";
                                $subrecord['status_pelaksanaan_tidak'] = "";
                                break;
                            case 'tidak':
                                $subrecord['status_pelaksanaan_ya'] = "";
                                $subrecord['status_pelaksanaan_tidak'] = "checked";
                                break;
                            default:
                                $subrecord['status_pelaksanaan_ya'] = "";
                                $subrecord['status_pelaksanaan_tidak'] = "checked";
                                break;
                        }
                        
                        $subrecord['status_paket_strategis'] = $r->status_paket_strategis;
                        switch ($r->status_paket_strategis) {
                            case 'ya':
                                $subrecord['status_strategis_ya'] = "checked";
                                $subrecord['status_strategis_tidak'] = "";
                                break;
                            case 'tidak':
                                $subrecord['status_strategis_ya'] = "";
                                $subrecord['status_strategis_tidak'] = "checked";
                                break;
                            default:
                                $subrecord['status_strategis_ya'] = "";
                                $subrecord['status_strategis_tidak'] = "checked";
                                break;
                        }

                        $subrecord['keterangan'] = "";

                        break;
                case 'pencatatan_nontender':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_realisasi->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_realisasi->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                        $subrecord['keterangan'] = $r->keterangan == "" ? "-" : $r->keterangan;

                        break;
                case 'pencatatan_swakelola':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_realisasi->cek_rup_penyedia($r->kd_rup_paket);
                        $subrecord['kegiatan'] =  empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_realisasi->cek_pegawai($r->nip_ppk);
                        $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                        $subrecord['keterangan'] = $r->keterangan == "" ? "-" : $r->keterangan;

                        break;
                case 'epurchasing':
                        $subrecord['kode_paket'] = "";
                        $subrecord['kode_rup_paket'] = $r->rup_id == "" || $r->rup_id == "0" ? "-":$r->rup_id;
                        $subrecord['nama_satker'] = $r->nama_satker;

                        $rup_penyedia = $this->mod_realisasi->cek_rup_penyedia($r->rup_id);
                        $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                        $subrecord['jml_teks'] = strlen($r->nama_paket);
                        $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                        $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                        
                        $pegawai = $this->mod_realisasi->cek_pegawai($r->ppk_nip);
                        $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                        $subrecord['pagu'] = $r->pagu_rup == 0 ? "-" : "Rp. ".number_format($r->pagu_rup,0,',','.');
                        $subrecord['nilai_kontrak'] = $r->total_harga == 0 ? "-" : "Rp. ".number_format($r->total_harga,0,',','.');
                        
                        $subrecord['keterangan'] = "";
                        break;
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['rincian'] = json_encode($record);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/realisasi_rincian_paket');
        $this->load->view('layout/footer');
    }

    public function triwulan()
    {
        $data['halaman'] = "Realisasi - Triwulan";

        $data['main'] = "realisasi";
        $data['grafik'] = "grafik_realisasi";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/realisasi_triwulan');
        $this->load->view('layout/footer');
    }

    public function rekap($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $record_baris = array();
        $subrecord_baris = array();

        $no = 1;

        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        $total_4 = 0;
        $total_5 = 0;
        $total_6 = 0;
        
        $satker = $this->mod_realisasi->satker()->result();
        foreach ($satker as $s) {
            $subrecord_baris['no'] = $no;
            $subrecord_baris['kode'] = $s->kd_satker;
            $subrecord_baris['singkatan'] = $s->singkatan;

            $realisasi = $this->mod_realisasi->realisasi_rekapitulasi($s->kd_satker, $thn);

            $subrecord_baris['belanja_pengadaan_paket'] = empty($realisasi) || $realisasi['belanja_pengadaan_paket'] == 0 ? "-" : number_format($realisasi['belanja_pengadaan_paket'],0,',','.');
            $subrecord_baris['belanja_pengadaan_anggaran'] = empty($realisasi) || $realisasi['belanja_pengadaan_anggaran'] == 0 ? "-" : "Rp. ".number_format($realisasi['belanja_pengadaan_anggaran']/1000000000,2,',','.')." M";
            $subrecord_baris['realisasi_kontrak_paket'] = empty($realisasi) || $realisasi['realisasi_kontrak_paket'] == 0 ? "-" : number_format($realisasi['realisasi_kontrak_paket'],0,',','.');
            $subrecord_baris['realisasi_kontrak_anggaran'] = empty($realisasi) || $realisasi['realisasi_kontrak_anggaran'] == 0 ? "-" : "Rp. ".number_format($realisasi['realisasi_kontrak_anggaran']/1000000000,2,',','.')." M";
            $subrecord_baris['realisasi_kontrak_persen'] = empty($realisasi) || $realisasi['realisasi_kontrak_persen'] == 0 ? "-" : number_format($realisasi['realisasi_kontrak_persen'],2,',','.')." %";
            $subrecord_baris['paket_selesai_paket'] = empty($realisasi) || $realisasi['paket_selesai_paket'] == 0 ? "-" : number_format($realisasi['paket_selesai_paket'],0,',','.');
            $subrecord_baris['paket_selesai_anggaran'] = empty($realisasi) || $realisasi['paket_selesai_anggaran'] == 0 ? "-" : "Rp. ".number_format($realisasi['paket_selesai_anggaran']/1000000000,2,',','.')." M";
            $subrecord_baris['paket_selesai_persen'] = empty($realisasi) || $realisasi['paket_selesai_persen'] == 0 ? "-" : number_format($realisasi['paket_selesai_persen'],2,',','.')."%";

            $subrecord_baris['belanja_pengadaan_anggaran_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['belanja_pengadaan_anggaran']));
            $subrecord_baris['realisasi_kontrak_anggaran_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['realisasi_kontrak_anggaran']));
            $subrecord_baris['paket_selesai_anggaran_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['paket_selesai_anggaran']));

            $no++;

            if(!empty($realisasi)){
                $total_1 += $realisasi['belanja_pengadaan_paket'];
                $total_2 += $realisasi['belanja_pengadaan_anggaran'];
                $total_3 += $realisasi['realisasi_kontrak_paket'];
                $total_4 += $realisasi['realisasi_kontrak_anggaran'];
                $total_5 += $realisasi['paket_selesai_paket'];
                $total_6 += $realisasi['paket_selesai_anggaran'];
            }

            array_push($record_baris, $subrecord_baris);
        }

        $subrecord['baris'] = $record_baris;

        $subrecord['total_1'] = $total_1 == 0 ? "-" : number_format($total_1,0,',','.');
        $subrecord['total_2'] = $total_2 == 0 ? "-" : "Rp. ".number_format($total_2/1000000000,2,',','.')." M";
        $subrecord['total_3'] = $total_3 == 0 ? "-" : number_format($total_3,0,',','.');
        $subrecord['total_4'] = $total_4 == 0 ? "-" : "Rp. ".number_format($total_4/1000000000,2,',','.')." M";
        $subrecord['total_5'] = $total_5 == 0 ? "-" : number_format($total_5,0,',','.');
        $subrecord['total_6'] = $total_6 == 0 ? "-" : "Rp. ".number_format($total_6/1000000000,2,',','.')." M";

        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function status($kode, $kelompok, $status, $nilai)
    {
        $record = array();
        $subdata = array();

        switch ($kelompok) {
            case 'tender':
                    $this->mod_realisasi->status_tender($kode, $status, $nilai);
                    $subdata['hasil'] =  "ok";
                break;
            case 'nontender':
                    $this->mod_realisasi->status_nontender($kode, $status, $nilai);
                    $subdata['hasil'] =  "ok";
                break;
            default:
                $subdata['hasil'] =  "gagal";
                break;
        }

        array_push($record,$subdata);

        echo json_encode($record);
    }

    public function rekap_triwulan($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $record_baris = array();
        $subrecord_baris = array();

        $no = 1;

        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        $total_4 = 0;
        $total_5 = 0;
        $total_6 = 0;
        $total_7 = 0;
        $total_8 = 0;
        $total_9 = 0;
        $total_10 = 0;
        $total_11 = 0;
        $total_12 = 0;
        
        $satker = $this->mod_realisasi->satker()->result();
        foreach ($satker as $s) {
            $subrecord_baris['no'] = $no;
            $subrecord_baris['kode'] = $s->kd_satker;
            $subrecord_baris['singkatan'] = $s->singkatan;

            $triwulan = $this->mod_realisasi->realisasi_triwulan($s->kd_satker, $thn);

            $subrecord_baris['belanja_pagu'] = empty($triwulan) || $triwulan['belanja_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['belanja_pagu']/1000000000,2,',','.')." M";
            $subrecord_baris['belanja_paket'] = empty($triwulan) || $triwulan['belanja_paket'] == 0 ? "-" : number_format($triwulan['belanja_paket'],0,',','.');
            $subrecord_baris['triwulan1_pagu'] = empty($triwulan) || $triwulan['triwulan1_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan1_pagu']/1000000000,2,',','.')." M";
            $subrecord_baris['triwulan1_paket'] = empty($triwulan) || $triwulan['triwulan1_paket'] == 0 ? "-" : number_format($triwulan['triwulan1_paket'],0,',','.');
            $subrecord_baris['triwulan2_pagu'] = empty($triwulan) || $triwulan['triwulan2_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan2_pagu']/1000000000,2,',','.')." M";
            $subrecord_baris['triwulan2_paket'] = empty($triwulan) || $triwulan['triwulan2_paket'] == 0 ? "-" : number_format($triwulan['triwulan2_paket'],0,',','.');
            $subrecord_baris['triwulan3_pagu'] = empty($triwulan) || $triwulan['triwulan3_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan3_pagu']/1000000000,2,',','.')." M";
            $subrecord_baris['triwulan3_paket'] = empty($triwulan) || $triwulan['triwulan3_paket'] == 0 ? "-" : number_format($triwulan['triwulan3_paket'],0,',','.');
            $subrecord_baris['triwulan4_pagu'] = empty($triwulan) || $triwulan['triwulan4_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan4_pagu']/1000000000,2,',','.')." M";
            $subrecord_baris['triwulan4_paket'] = empty($triwulan) || $triwulan['triwulan4_paket'] == 0 ? "-" : number_format($triwulan['triwulan4_paket'],0,',','.');
            $subrecord_baris['total_pagu'] = empty($triwulan) || $triwulan['total_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['total_pagu']/1000000000,2,',','.')." M";
            $subrecord_baris['total_paket'] = empty($triwulan) || $triwulan['total_paket'] == 0 ? "-" : number_format($triwulan['total_paket'],0,',','.');

            $subrecord_baris['triwulan1_pagu_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['triwulan1_pagu']));
            $subrecord_baris['triwulan2_pagu_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['triwulan2_pagu']));
            $subrecord_baris['triwulan3_pagu_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['triwulan3_pagu']));
            $subrecord_baris['triwulan4_pagu_grafik'] = str_replace('Rp. ','',str_replace(' M','',$subrecord_baris['triwulan4_pagu']));
            
            $no++;

            if(!empty($triwulan)){
                $total_1 += $triwulan['belanja_pagu'];
                $total_2 += $triwulan['belanja_paket'];
                $total_3 += $triwulan['triwulan1_pagu'];
                $total_4 += $triwulan['triwulan1_paket'];
                $total_5 += $triwulan['triwulan2_pagu'];
                $total_6 += $triwulan['triwulan2_paket'];
                $total_7 += $triwulan['triwulan3_pagu'];
                $total_8 += $triwulan['triwulan3_paket'];
                $total_9 += $triwulan['triwulan4_pagu'];
                $total_10 += $triwulan['triwulan4_paket'];
                $total_11 += $triwulan['total_pagu'];
                $total_12 += $triwulan['total_paket'];
            }

            array_push($record_baris, $subrecord_baris);
        }

        $subrecord['baris'] = $record_baris;

        $subrecord['total_1'] = $total_1 == 0 ? "-" : "Rp. ".number_format($total_1/1000000000,2,',','.')." M";
        $subrecord['total_2'] = $total_2 == 0 ? "-" : number_format($total_2,0,',','.');
        $subrecord['total_3'] = $total_3 == 0 ? "-" : "Rp. ".number_format($total_3/1000000000,2,',','.')." M";
        $subrecord['total_4'] = $total_4 == 0 ? "-" : number_format($total_4,0,',','.');
        $subrecord['total_5'] = $total_5 == 0 ? "-" : "Rp. ".number_format($total_5/1000000000,2,',','.')." M";
        $subrecord['total_6'] = $total_6 == 0 ? "-" : number_format($total_6,0,',','.');
        $subrecord['total_7'] = $total_7 == 0 ? "-" : "Rp. ".number_format($total_7/1000000000,2,',','.')." M";
        $subrecord['total_8'] = $total_8 == 0 ? "-" : number_format($total_8,0,',','.');
        $subrecord['total_9'] = $total_9 == 0 ? "-" : "Rp. ".number_format($total_9/1000000000,2,',','.')." M";
        $subrecord['total_10'] = $total_10 == 0 ? "-" : number_format($total_10,0,',','.');
        $subrecord['total_11'] = $total_11 == 0 ? "-" : "Rp. ".number_format($total_11/1000000000,2,',','.')." M";
        $subrecord['total_12'] = $total_12 == 0 ? "-" : number_format($total_12,0,',','.');
        

        array_push($record, $subrecord);

        echo json_encode($record);
    }
}