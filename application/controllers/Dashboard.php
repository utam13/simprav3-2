<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_dashboard');
    }

    public function index()
    {
        $data['halaman'] = "Dashboard";

        $data['main'] = "dashboard";
        $data['grafik'] = "grafik_dashboard";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/dashboard');
        $this->load->view('layout/footer');
    }

    public function info_total($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        // box belanja pengadaan
        $belanja_pengadaan = 0;

        $tender = $this->mod_dashboard->tender_rekapitulasi_metode("rup_anggaran",$thn);
        $belanja_pengadaan += $tender['total'];

        $nontender = $this->mod_dashboard->nontender_rekapitulasi_metode($thn);
        $belanja_pengadaan += $nontender['total_rup_anggaran'];

        $rup_pct_epurchasing = $this->mod_dashboard->rekapitulasi_pencatatan_epurchasing($thn);
        $belanja_pengadaan += $rup_pct_epurchasing['total'];

        $rup_pct_nontender = $this->mod_dashboard->rekapitulasi_pencatatan_nontender($thn);
        $belanja_pengadaan += $rup_pct_nontender['total'];

        $rup_pct_swakelola = $this->mod_dashboard->rekapitulasi_pencatatan_swakelola($thn);
        $belanja_pengadaan += $rup_pct_swakelola['total'];

        $subrecord['belanja_pengadaan'] = number_format($belanja_pengadaan / 1000000000,2,',','.');
        // end

        // box total pengadaan
        $total_pengadaan = 0;

        $tender = $this->mod_dashboard->tender_rekapitulasi_metode("proses_anggaran",$thn);
        $total_pengadaan += $tender['total'];

        $nontender = $this->mod_dashboard->nontender_rekapitulasi_metode($thn);
        $total_pengadaan += $nontender['total_proses_anggaran'];

        $proses_pct_epurchasing = $this->mod_dashboard->rekapitulasi_proses_epurchasing($thn);
        $total_pengadaan += $proses_pct_epurchasing['total'];

        $subrecord['total_pengadaan'] = number_format($total_pengadaan / 1000000000,2,',','.');
        // end

        // box pengadaan selesai
        $pengadaan_selesai = 0;

        $tender = $this->mod_dashboard->tender_rekapitulasi_metode("selesai_anggaran",$thn);
        $pengadaan_selesai += $tender['total'];

        $nontender = $this->mod_dashboard->nontender_rekapitulasi_metode($thn);
        $pengadaan_selesai += $nontender['total_selesai_anggaran'];

        $selesai_pct_epurchasing = $this->mod_dashboard->rekapitulasi_selesai_epurchasing($thn);
        $pengadaan_selesai += $selesai_pct_epurchasing['total_pagu'];

        $subrecord['pengadaan_selesai'] = number_format($pengadaan_selesai / 1000000000,2,',','.');
        // end

        // box optimalisasi
        $optimalisasi = 0;

        $tender = $this->mod_dashboard->tender_rekapitulasi_metode("hemat_anggaran",$thn);
        $optimalisasi += $tender['total'];

        $nontender = $this->mod_dashboard->nontender_rekapitulasi_metode($thn);
        $optimalisasi += $nontender['total_hemat_anggaran'];

        $hemat_anggaran_epurchasing = $selesai_pct_epurchasing['total_pagu'] - $selesai_pct_epurchasing['total_nilai_negosiasi'];
        $optimalisasi += $hemat_anggaran_epurchasing;

        $subrecord['optimalisasi'] = number_format($optimalisasi / 1000000000,2,',','.');
        // end

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/info_total_'.$thn.'.json', $listdata)){
            //save log
            // $this->log_lib->log_info("Gagal membuat json info_total_".$thn.".json");
        // } else {
            //save log
            // $this->log_lib->log_info("Membuat json info_total_".$thn.".json");
        // }
    }

    public function belanja_pengadaan($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $daftar = $this->mod_dashboard->belanja_pengadaan($thn)->result();
        foreach ($daftar as $d) {
            $subrecord['name'] = $d->jenis_pengadaan;
            $subrecord['y'] = (float)number_format($d->total/1000000000,2,'.',',');

            array_push($record, $subrecord);
        }

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/grafik_belanja_pengadaan_apbd_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json grafik_belanja_pengadaan_apbd_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json grafik_belanja_pengadaan_apbd_".$thn.".json");
        // }
    }

    public function rup_penyedia($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $subrecord['kategori'] = array();
        $subrecord['rup_anggaran'] = array();
        $subrecord['rup_paket'] = array();
        $subrecord['realisasi_anggaran'] = array();
        $subrecord['realisasi_paket'] = array();

        $metode = $this->mod_dashboard->rup($thn, "penyedia")->result();
        foreach ($metode as $m) {
            array_push($subrecord['kategori'], $m->kategori);

            array_push($subrecord['rup_anggaran'], (float)number_format($m->rup_anggaran/1000000000,2,'.',','));
            array_push($subrecord['rup_paket'], (int)number_format($m->rup_paket,0,'.',','));

            array_push($subrecord['realisasi_anggaran'], (float)number_format($m->realisasi_anggaran/1000000000,2,'.',','));
            array_push($subrecord['realisasi_paket'], (int)number_format($m->realisasi_paket,0,'.',','));
        }

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/grafik_rup_penyedia_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json grafik_rup_penyedia_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json grafik_rup_penyedia_".$thn.".json");
        // }
    }

    public function rup_swakelola($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $subrecord['kategori'] = array();
        $subrecord['rup_anggaran'] = array();
        $subrecord['rup_paket'] = array();
        $subrecord['realisasi_anggaran'] = array();
        $subrecord['realisasi_paket'] = array();

        $tipe = $this->mod_dashboard->rup($thn, "swakelola")->result();
        foreach ($tipe as $t) {
            array_push($subrecord['kategori'], "Tipe ".$t->kategori);

            array_push($subrecord['rup_anggaran'], (float)number_format($t->rup_anggaran/1000000000,2,'.',','));
            array_push($subrecord['rup_paket'], (int)number_format($t->rup_paket,0,'.',','));

            array_push($subrecord['realisasi_anggaran'], (float)number_format($t->realisasi_anggaran/1000000000,2,'.',','));
            array_push($subrecord['realisasi_paket'], (int)number_format($t->realisasi_paket,0,'.',','));
        }

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/grafik_rup_swakelola_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json grafik_rup_swakelola_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json grafik_rup_swakelola_".$thn.".json");
        // }
    }

    public function tender($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $subrecord['kategori'] = array();
        $subrecord['rencana'] = array();
        $subrecord['total'] = array();
        $subrecord['selesai'] = array();
        $subrecord['proses'] = array();
        $subrecord['batal'] = array();
        $subrecord['optimalisasi_anggaran'] = array();
        $subrecord['optimalisasi_persen'] = array();

        $tender = $this->mod_dashboard->tender_nontender($thn, "tender")->result();
        foreach ($tender as $t) {
            array_push($subrecord['kategori'], $t->kategori);
            array_push($subrecord['rencana'], (float)number_format($t->rencana/1000000000,2,'.',','));
            array_push($subrecord['total'], (float)number_format($t->total/1000000000,2,'.',','));
            array_push($subrecord['selesai'], (float)number_format($t->selesai/1000000000,2,'.',','));
            array_push($subrecord['proses'], (float)number_format($t->proses/1000000000,2,'.',','));
            array_push($subrecord['batal'], (float)number_format($t->batal/1000000000,2,'.',','));
            array_push($subrecord['optimalisasi_anggaran'], (float)number_format($t->optimalisasi_anggaran/1000000000,2,'.',','));
            array_push($subrecord['optimalisasi_persen'], (float)number_format($t->optimalisasi_persen,2,'.',','));
        }

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/grafik_tender_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json grafik_tender_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json grafik_tender_".$thn.".json");
        // }
    }

    public function nontender($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $subrecord['kategori'] = array();
        $subrecord['rencana'] = array();
        $subrecord['total'] = array();
        $subrecord['selesai'] = array();
        $subrecord['proses'] = array();
        $subrecord['batal'] = array();
        $subrecord['optimalisasi_anggaran'] = array();
        $subrecord['optimalisasi_persen'] = array();

        $nontender = $this->mod_dashboard->tender_nontender($thn, "nontender")->result();
        foreach ($nontender as $n) {
            array_push($subrecord['kategori'], $n->kategori);
            array_push($subrecord['rencana'], (float)number_format($n->rencana/1000000000,2,'.',','));
            array_push($subrecord['total'], (float)number_format($n->total/1000000000,2,'.',','));
            array_push($subrecord['selesai'], (float)number_format($n->selesai/1000000000,2,'.',','));
            array_push($subrecord['proses'], (float)number_format($n->proses/1000000000,2,'.',','));
            array_push($subrecord['batal'], (float)number_format($n->batal/1000000000,2,'.',','));
            array_push($subrecord['optimalisasi_anggaran'], (float)number_format($n->optimalisasi_anggaran/1000000000,2,'.',','));
            array_push($subrecord['optimalisasi_persen'], (float)number_format($n->optimalisasi_persen,2,'.',','));
        }

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/grafik_nontender_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json grafik_nontender_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json grafik_nontender_".$thn.".json");
        // }
    }

    public function rencana_paket_pengadaan($thn = 2021)
    {
        $record_total = array();
        $subrecord_total = array();

        $record_baris = array();
        $subrecord_baris = array();

        $no = 1;
        $total_penyedia_200_paket = 0;
        $total_penyedia_200_pagu = 0;
        $total_penyedia_200_25_paket = 0;
        $total_penyedia_200_25_pagu = 0;
        $total_penyedia_25_50_paket = 0;
        $total_penyedia_25_50_pagu = 0;
        $total_penyedia_50_100_paket = 0;
        $total_penyedia_50_100_pagu = 0;
        $total_penyedia_100_paket = 0;
        $total_penyedia_100_pagu = 0;
        $total_swakelola_paket = 0;
        $total_swakelola_pagu = 0;
        $gtotal_paket = 0;
        $gtotal_pagu = 0;

        $rencana_paket_pengadaan = $this->mod_dashboard->temp_rencana_paket_pengadaan($thn)->result();
        
        if(COUNT($rencana_paket_pengadaan) > 0){
            foreach ($rencana_paket_pengadaan as $rpp) {
                $subrecord_baris['no'] = $no;
                $subrecord_baris['jenis_pengadaan'] = $rpp->jenis_pengadaan;

                // <= 200 jt
                $subrecord_baris['penyedia_200_pagu'] = number_format($rpp->penyedia_200_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['penyedia_200_paket'] = number_format($rpp->penyedia_200_paket,0,'.',',');

                // > 200 jt and <= 2,5 M
                $subrecord_baris['penyedia_200_25_pagu'] = number_format($rpp->penyedia_200_25_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['penyedia_200_25_paket'] = number_format($rpp->penyedia_200_25_paket,0,'.',',');

                // > 2,5 M and <= 50 M
                $subrecord_baris['penyedia_25_50_pagu'] = number_format($rpp->penyedia_25_50_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['penyedia_25_50_paket'] = number_format($rpp->penyedia_25_50_paket,0,'.',',');

                // > 50 M and <= 100 M
                $subrecord_baris['penyedia_50_100_pagu'] = number_format($rpp->penyedia_50_100_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['penyedia_50_100_paket'] = number_format($rpp->penyedia_50_100_paket,0,'.',',');

                // > 100 M
                $subrecord_baris['penyedia_100_pagu'] = number_format($rpp->penyedia_100_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['penyedia_100_paket'] = number_format($rpp->penyedia_100_paket,0,'.',',');

                $subrecord_baris['swakelola_pagu'] = number_format($rpp->swakelola_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['swakelola_paket'] = number_format($rpp->swakelola_paket,0,'.',',');

                $total_pagu = $rpp->penyedia_200_pagu + $rpp->penyedia_200_25_pagu + $rpp->penyedia_25_50_pagu + $rpp->penyedia_50_100_pagu + $rpp->penyedia_100_paket + $rpp->swakelola_pagu;
                $total_paket = $rpp->penyedia_200_paket + $rpp->penyedia_200_25_paket + $rpp->penyedia_25_50_paket + $rpp->penyedia_50_100_paket + $rpp->penyedia_100_paket + $rpp->swakelola_paket;

                $subrecord_baris['total_pagu'] = number_format($total_pagu/1000000000,2,'.',',')." M";
                $subrecord_baris['total_paket'] = number_format($total_paket,0,'.',',');

                $total_penyedia_200_paket += $rpp->penyedia_200_paket;
                $total_penyedia_200_pagu += $rpp->penyedia_200_pagu;
                $total_penyedia_200_25_paket += $rpp->penyedia_200_25_paket;
                $total_penyedia_200_25_pagu += $rpp->penyedia_200_25_pagu;
                $total_penyedia_25_50_paket += $rpp->penyedia_25_50_paket;
                $total_penyedia_25_50_pagu += $rpp->penyedia_25_50_pagu;
                $total_penyedia_50_100_paket += $rpp->penyedia_50_100_paket;
                $total_penyedia_50_100_pagu += $rpp->penyedia_50_100_pagu;
                $total_penyedia_100_paket += $rpp->penyedia_100_paket;
                $total_penyedia_100_pagu += $rpp->penyedia_100_pagu;
                $total_swakelola_paket += $rpp->swakelola_paket;
                $total_swakelola_pagu += $rpp->swakelola_pagu;
                $gtotal_paket += $total_paket;
                $gtotal_pagu += $total_pagu;

                $no++;

                array_push($record_baris, $subrecord_baris);
            }

            $subrecord_total['baris'] = $record_baris;

            $subrecord_total['total_penyedia_200_pagu'] = number_format($total_penyedia_200_pagu/1000000000,2,'.',',')." M";
            $subrecord_total['total_penyedia_200_paket'] = number_format($total_penyedia_200_paket,0,'.',',');
            $subrecord_total['total_penyedia_200_25_pagu'] = number_format($total_penyedia_200_25_pagu/1000000000,2,'.',',')." M";
            $subrecord_total['total_penyedia_200_25_paket'] = number_format($total_penyedia_200_25_paket,0,'.',',');
            $subrecord_total['total_penyedia_25_50_pagu'] = number_format($total_penyedia_25_50_pagu/1000000000,2,'.',',')." M";
            $subrecord_total['total_penyedia_25_50_paket'] = number_format($total_penyedia_25_50_paket,0,'.',',');
            $subrecord_total['total_penyedia_50_100_pagu'] = number_format($total_penyedia_50_100_pagu/1000000000,2,'.',',')." M";
            $subrecord_total['total_penyedia_50_100_paket'] = number_format($total_penyedia_50_100_paket,0,'.',',');
            $subrecord_total['total_penyedia_100_pagu'] = number_format($total_penyedia_100_pagu/1000000000,2,'.',',')." M";
            $subrecord_total['total_penyedia_100_paket'] = number_format($total_penyedia_100_paket,0,'.',',');

            $rup_swakelola_rpp = $this->mod_dashboard->rup_swakelola_rpp($thn);
            $subrecord_total['total_swakelola_pagu'] = number_format($rup_swakelola_rpp['total_pagu']/1000000000,2,'.',',')." M";
            $subrecord_total['total_swakelola_paket'] = number_format($rup_swakelola_rpp['total_paket'],0,'.',',');

            $subrecord_total['total_pagu'] = number_format($gtotal_pagu/1000000000,2,'.',',')." M";
            $subrecord_total['total_paket'] = number_format($gtotal_paket,0,'.',',');

            array_push($record_total, $subrecord_total);
        } else {
            array_push($record_baris, $subrecord_baris);
            array_push($record_total, $subrecord_total);
        }

        echo json_encode($record_total);

        // $listdata= json_encode($record_total);

        // if ( ! write_file('./json/tabel_rencana_paket_pengadaan_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json tabel_rencana_paket_pengadaan_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json tabel_rencana_paket_pengadaan_".$thn.".json");
        // }
    }

    public function mekanisme_lainnya($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        $no = 1;

        $mekanisme_lainnya = $this->mod_dashboard->temp_mekanisme_lainnya($thn)->result();
        foreach ($mekanisme_lainnya as $ml) {
            $subrecord['no'] = $no;
            $subrecord['mekanisme'] = $ml->mekanisme;
            $subrecord['perencanaan_pagu'] = "Rp. ".number_format($ml->perencanaan_pagu,0,'.',',');
            $subrecord['perencanaan_paket'] = number_format($ml->perencanaan_paket,0,'.',',');
            $subrecord['realisasi_pagu'] = "Rp. ".number_format($ml->realisasi_pagu,0,'.',',');
            $subrecord['realisasi_paket'] = number_format($ml->realisasi_paket,0,'.',',');
            $subrecord['persentase'] = number_format($ml->persentase,2,'.',',')." %";

            $no++;

            array_push($record, $subrecord);
        }

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/tabel_mekanisme_lainnya_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json tabel_mekanisme_lainnya_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json tabel_mekanisme_lainnya_".$thn.".json");
        // }
    }
}