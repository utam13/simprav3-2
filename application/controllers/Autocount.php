<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autocount extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_autocount');
    }

    
    public function index($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Count & Populate";

        $data['alert'] = $this->alert_lib->alert($pesan, $isipesan);

        $kantor = $this->mod_autocount->kantor();
        $data['logo'] = empty($kantor) ? "-" : $kantor['logo'];

        if ($data['logo'] == "") {
            $data['file_logo'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/logo/" . $data['logo'];
            if (file_exists($file_target)) {
                $data['file_logo'] = base_url() . "upload/logo/" . $data['logo'];
            } else {
                $data['file_logo'] = base_url() . "upload/no-image.png";
            }
        }

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header', $data);
        $this->load->view('backend/layout/sidebar', $data);
        $this->load->view('backend/page/autocount', $data);
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses()
    {
        $jenis = $this->input->post('jenis');
        $kelompok = $this->input->post('kelompok');
        $thn = $this->input->post('thn');

        switch ($jenis) {
            case 'struktur_apbd': $this->struktur_apbd($kelompok, $thn); break;
            case 'rincian_struktur_apbd': $this->rincian_struktur_apbd($kelompok, $thn); break;
            case 'rup_rekapitulasi': $this->rup_rekapitulasi($thn); break;
            case 'tender_rekapitulasi': $this->tender_rekapitulasi($kelompok, $thn); break;
            case 'nontender_rekapitulasi': $this->nontender_rekapitulasi($kelompok, $thn); break;
            case 'realisasi_rekapitulasi': $this->realisasi_rekapitulasi($thn); break;
            case 'realisasi_triwulan': $this->triwulan($thn); break;
            case 'monitoring_ppk': $this->monitoring_ppk($kelompok, $thn); break;
            case 'monitoring_personil': $this->monitoring_personil($kelompok, $thn); break;
            case 'monitoring_penyedia': $this->monitoring_penyedia($kelompok, $thn); break;
            case 'rencana_paket_pengadaan': $this->rencana_paket_pengadaan($thn); break;
            case 'grafik_belanja_pengadaan': $this->grafik_belanja_pengadaan($thn); break;
            case 'grafik_rup_penyedia': $this->grafik_rup_penyedia($thn); break;
            case 'grafik_rup_swakelola': $this->grafik_rup_swakelola($thn); break;
            case 'grafik_tender': $this->grafik_tender($thn); break;
            case 'grafik_nontender': $this->grafik_nontender($thn); break;
            case 'mekanisme_lainnya': $this->mekanisme_lainnya($thn); break;
        }

        $pesan = 2;
        $isipesan = "Proses count & populate data ".str_replace('_',' ',$jenis)." $kelompok tahun $thn selesai, silakan cek di halaman frontend";
        redirect("autocount/index/$pesan/$isipesan");
    }

    public function struktur_apbd($kelompok, $thn)
    {
        $this->mod_autocount->reset_struktur_apbd($kelompok, $thn);

        switch($kelompok){
            case "murni" :
                    $belanja_operasi_1 = $this->mod_autocount->apbd_murni_belanja_operasi_1($thn);
                    $belanja_operasi_1 = $belanja_operasi_1['total'];
                    
                    $belanja_modal = $this->mod_autocount->apbd_murni_belanja_modal($thn);
                    $belanja_modal = $belanja_modal['total'];
                    
                    $belanja_tidak_terduga_1 = 0;
                    
                    $belanja_pengadaan = $belanja_operasi_1 + $belanja_modal + $belanja_tidak_terduga_1;

                    $belanja_operasi_2 = $this->mod_autocount->apbd_murni_belanja_operasi_2($thn);
                    $belanja_operasi_2 = $belanja_operasi_2['total'];

                    $belanja_transfer = 0;

                    $belanja_tidak_terduga_2 = $this->mod_autocount->apbd_murni_belanja_tidak_terduga_2($thn);
                    $belanja_tidak_terduga_2 = $belanja_tidak_terduga_2['total'];

                    $belanja_non_pengadaan = $belanja_operasi_2 + $belanja_transfer + $belanja_tidak_terduga_2;
                    $belanja_non_pengadaan = $belanja_non_pengadaan;

                    $total_belanja = $belanja_pengadaan + $belanja_non_pengadaan;
                    
                    break;
            case "perubahan" :
                    $belanja_operasi_1 = $this->mod_autocount->apbd_perubahan_belanja_operasi_1($thn);
                    $belanja_operasi_1 = $belanja_operasi_1['total'];
                    
                    $belanja_modal = $this->mod_autocount->apbd_perubahan_belanja_modal($thn);
                    $belanja_modal = $belanja_modal['total'];
                    
                    $belanja_tidak_terduga_1 = 0;
                    
                    $belanja_pengadaan = $belanja_operasi_1 + $belanja_modal + $belanja_tidak_terduga_1;

                    $belanja_operasi_2 = $this->mod_autocount->apbd_perubahan_belanja_operasi_2($thn);
                    $belanja_operasi_2 = $belanja_operasi_2['total'];

                    $belanja_transfer = 0;

                    $belanja_tidak_terduga_2 = $this->mod_autocount->apbd_perubahan_belanja_tidak_terduga_2($thn);
                    $belanja_tidak_terduga_2 = $belanja_tidak_terduga_2['total'];

                    $belanja_non_pengadaan = $belanja_operasi_2 + $belanja_transfer + $belanja_tidak_terduga_2;
                    $belanja_non_pengadaan = $belanja_non_pengadaan;

                    $total_belanja = $belanja_pengadaan + $belanja_non_pengadaan;
                    
                    break;
        }

        $data = array(
            "thn" => $thn,
            "kelompok" => $kelompok,
            "belanja_operasi_1" => $belanja_operasi_1,
            "belanja_modal" => $belanja_modal,
            "belanja_tidak_terduga_1" => $belanja_tidak_terduga_1,
            "belanja_pengadaan" => $belanja_pengadaan,
            "belanja_operasi_2" => $belanja_operasi_2,
            "belanja_transfer" => $belanja_transfer,
            "belanja_tidak_terduga_2" => $belanja_tidak_terduga_2,
            "belanja_non_pengadaan" => $belanja_non_pengadaan,
            "total_belanja" => $total_belanja
        );

        $this->mod_autocount->simpan_struktur_apbd($data);

        // redirect(base_url()."struktur_anggaran/index/$kelompok/$thn");
    }

    public function rincian_struktur_apbd($kelompok, $thn)
    {
        $this->mod_autocount->reset_rincian_struktur_apbd($thn, $kelompok);

        $satker = $this->mod_autocount->satker()->result();
        foreach ($satker as $s) {
            $kd_satker = $s->kd_satker;

            switch($kelompok){
                case "murni" :
                        // total barang jasa
                        $query = "kd_blj_lv3='5.1.02' AND thn_ang='".$thn."'";
                        $total_barang_jasa = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        // total modal
                        $query = "kd_blj_lv2='5.2' AND thn_ang='".$thn."'";
                        $total_modal = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        // total pegawai
                        $query = "kd_blj_lv3='5.1.01' AND thn_ang='".$thn."'";
                        $total_pegawai = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        // total hibah
                        $query = "kd_blj_lv3='5.1.05' AND thn_ang='".$thn."'";
                        $total_hibah = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        // total bansos
                        $query = "kd_blj_lv3='5.1.06' AND thn_ang='".$thn."'";
                        $total_bansos = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        // total tidak terduga
                        $query = "kd_blj_lv2='5.3' AND thn_ang='".$thn."'";
                        $total_tidak_terduga = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        // total dll (subsidi)
                        $query = "kd_blj_lv3='5.1.04' AND thn_ang='".$thn."'";
                        $total_dll = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

                        break;
                case "perubahan":
                        // total barang jasa
                        $query = "kd_blj_lv3='5.1.02' AND thn_ang='".$thn."'";
                        $total_barang_jasa = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);

                        // total modal
                        $query = "kd_blj_lv2='5.2' AND thn_ang='".$thn."'";
                        $total_modal = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);

                        // total pegawai
                        $query = "kd_blj_lv3='5.1.01' AND thn_ang='".$thn."'";
                        $total_pegawai = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);

                        // total hibah
                        $query = "kd_blj_lv3='5.1.05' AND thn_ang='".$thn."'";
                        $total_hibah = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);

                        // total bansos
                        $query = "kd_blj_lv3='5.1.06' AND thn_ang='".$thn."'";
                        $total_bansos = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);

                        // total tidak terduga
                        $query = "kd_blj_lv2='5.3' AND thn_ang='".$thn."'";
                        $total_tidak_terduga = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);

                        // total dll (subsidi)
                        $query = "kd_blj_lv3='5.1.04' AND thn_ang='".$thn."'";
                        $total_dll = $this->mod_autocount->apbd_perubahan_satker($s->kd_satker,$query);
                        break;
            }

            // total
            $total = $total_barang_jasa['total'] + $total_modal['total'] + $total_pegawai['total'] + 
                    $total_hibah['total'] + $total_bansos['total'] + $total_tidak_terduga['total'] + 
                    $total_dll['total'];

            $data = array(
                "thn" => $thn,
                "kelompok" => $kelompok,
                "kd_satker" => $kd_satker,
                "total_barang_jasa" => $total_barang_jasa['total'],
                "total_modal" => $total_modal['total'],
                "total_pegawai" => $total_pegawai['total'],
                "total_hibah" => $total_hibah['total'],
                "total_bansos" => $total_bansos['total'],
                "total_tidak_terduga" => $total_tidak_terduga['total'],
                "total_dll" => $total_dll['total'],
                "total" => $total
            );

            $this->mod_autocount->simpan_rincian_struktur_apbd($data);
        }

        // redirect(base_url()."rincian_belanja/index/$kelompok/$thn");
    }

    public function rup_rekapitulasi($thn)
    {
        $this->mod_autocount->reset_rup_rekapitulasi($thn);

        $satker = $this->mod_autocount->satker()->result();
        foreach ($satker as $s) {
            $kd_satker = $s->kd_satker;

            // total barang jasa
            $query = "kd_blj_lv3='5.1.02' AND thn_ang='".$thn."'";
            $total_barang_jasa = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);
            // total modal
            $query = "kd_blj_lv2='5.2' AND thn_ang='".$thn."'";
            $total_modal = $this->mod_autocount->apbd_murni_satker($s->kd_satker,$query);

            $belanja_pengadaan = $total_barang_jasa['total'] + $total_modal['total'];

            $penyedia_paket = $this->mod_autocount->penyedia_paket($s->kd_satker, $thn);
            
            $penyedia_anggaran = $this->mod_autocount->penyedia_anggaran($s->kd_satker, $thn);
            
            $swakelola_paket = $this->mod_autocount->swakelola_paket($s->kd_satker, $thn);
            
            $swakelola_anggaran = $this->mod_autocount->swakelola_anggaran($s->kd_satker, $thn);

            $penyedia_dalam_swakelola_paket = $this->mod_autocount->penyedia_dalam_swakelola_paket($s->kd_satker, $thn);
            
            $penyedia_dalam_swakelola_anggaran = $this->mod_autocount->penyedia_dalam_swakelola_anggaran($s->kd_satker, $thn);

            $paket = $penyedia_paket + $swakelola_paket + $penyedia_dalam_swakelola_paket;
            $total_paket = $paket;

            $anggaran = $penyedia_anggaran['total'] + $swakelola_anggaran['total'] + $penyedia_dalam_swakelola_anggaran['total'];
            $total_anggaran = $anggaran;

            if($anggaran <= 0 || $belanja_pengadaan <= 0){
                $persentase = 0;
            } else {
                $persentase = ($anggaran / $belanja_pengadaan) * 100;
            }

            $data = array(
                "thn" => $thn,
                "kd_satker" => $kd_satker,
                "belanja_pengadaan" => $belanja_pengadaan,
                "penyedia_paket" => $penyedia_paket,
                "penyedia_anggaran" => $penyedia_anggaran['total'],
                "swakelola_paket" => $swakelola_paket,
                "swakelola_anggaran" => $swakelola_anggaran['total'],
                "penyedia_dalam_swakelola_paket" => $penyedia_dalam_swakelola_paket,
                "penyedia_dalam_swakelola_anggaran" => $penyedia_dalam_swakelola_anggaran['total'],
                "total_paket" => $total_paket,
                "total_anggaran" => $total_anggaran,
                "persentase" => $persentase
            );

            $this->mod_autocount->simpan_rup_rekapitulasi($data);
        }

        // redirect(base_url()."rup_rekapitulasi/index/$thn");
    }

    public function triwulan($thn)
    {
        $this->mod_autocount->reset_triwulan($thn);

        $satker = $this->mod_autocount->satker()->result();
        foreach ($satker as $s) {
            $kd_satker = $s->kd_satker;

            $penyedia_paket = $this->mod_autocount->penyedia_paket($s->kd_satker, $thn);
            
            $penyedia_anggaran = $this->mod_autocount->penyedia_anggaran($s->kd_satker, $thn);
            
            $swakelola_paket = $this->mod_autocount->swakelola_paket($s->kd_satker, $thn);
            
            $swakelola_anggaran = $this->mod_autocount->swakelola_anggaran($s->kd_satker, $thn);

            $belanja_pagu= $penyedia_anggaran['total'] + $swakelola_anggaran['total'];

            $belanja_paket= $penyedia_paket + $swakelola_paket ;

            $penyedia_dalam_swakelola_paket = $this->mod_autocount->penyedia_dalam_swakelola_paket($s->kd_satker, $thn);
            
            $penyedia_dalam_swakelola_anggaran = $this->mod_autocount->penyedia_dalam_swakelola_anggaran($s->kd_satker, $thn);

            $tender_pagu_1 = $this->mod_autocount->tender_pagu($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $tender_pagu_2 = $this->mod_autocount->tender_pagu($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $tender_pagu_3 = $this->mod_autocount->tender_pagu($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $tender_pagu_4 = $this->mod_autocount->tender_pagu($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $nontender_pagu_1 = $this->mod_autocount->nontender_pagu($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $nontender_pagu_2 = $this->mod_autocount->nontender_pagu($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $nontender_pagu_3 = $this->mod_autocount->nontender_pagu($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $nontender_pagu_4 = $this->mod_autocount->nontender_pagu($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $epurchasing_pagu_1 = $this->mod_autocount->epurchasing_pagu($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $epurchasing_pagu_2 = $this->mod_autocount->epurchasing_pagu($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $epurchasing_pagu_3 = $this->mod_autocount->epurchasing_pagu($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $epurchasing_pagu_4 = $this->mod_autocount->epurchasing_pagu($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $pct_nontender_pagu_1 = $this->mod_autocount->pct_nontender_pagu($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $pct_nontender_pagu_2 = $this->mod_autocount->pct_nontender_pagu($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $pct_nontender_pagu_3 = $this->mod_autocount->pct_nontender_pagu($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $pct_nontender_pagu_4 = $this->mod_autocount->pct_nontender_pagu($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $pct_swakelola_pagu_1 = $this->mod_autocount->pct_swakelola_pagu($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $pct_swakelola_pagu_2 = $this->mod_autocount->pct_swakelola_pagu($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $pct_swakelola_pagu_3 = $this->mod_autocount->pct_swakelola_pagu($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $pct_swakelola_pagu_4 = $this->mod_autocount->pct_swakelola_pagu($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $triwulan1_pagu = $tender_pagu_1['total'] + $nontender_pagu_1['total'] + $epurchasing_pagu_1['total'] + $pct_nontender_pagu_1['total'] + $pct_swakelola_pagu_1['total'];
            $triwulan2_pagu = $tender_pagu_2['total'] + $nontender_pagu_2['total'] + $epurchasing_pagu_2['total'] + $pct_nontender_pagu_2['total'] + $pct_swakelola_pagu_2['total'];
            $triwulan3_pagu = $tender_pagu_3['total'] + $nontender_pagu_3['total'] + $epurchasing_pagu_3['total'] + $pct_nontender_pagu_3['total'] + $pct_swakelola_pagu_3['total'];
            $triwulan4_pagu = $tender_pagu_4['total'] + $nontender_pagu_4['total'] + $epurchasing_pagu_4['total'] + $pct_nontender_pagu_4['total'] + $pct_swakelola_pagu_4['total'];

            $total_pagu =  $triwulan1_pagu + $triwulan2_pagu + $triwulan3_pagu + $triwulan4_pagu;

            $tender_paket_1 = $this->mod_autocount->tender_paket($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $tender_paket_2 = $this->mod_autocount->tender_paket($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $tender_paket_3 = $this->mod_autocount->tender_paket($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $tender_paket_4 = $this->mod_autocount->tender_paket($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $nontender_paket_1 = $this->mod_autocount->nontender_paket($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $nontender_paket_2 = $this->mod_autocount->nontender_paket($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $nontender_paket_3 = $this->mod_autocount->nontender_paket($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $nontender_paket_4 = $this->mod_autocount->nontender_paket($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $epurchasing_paket_1 = $this->mod_autocount->epurchasing_paket($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $epurchasing_paket_2 = $this->mod_autocount->epurchasing_paket($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $epurchasing_paket_3 = $this->mod_autocount->epurchasing_paket($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $epurchasing_paket_4 = $this->mod_autocount->epurchasing_paket($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $pct_nontender_paket_1 = $this->mod_autocount->pct_nontender_paket($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $pct_nontender_paket_2 = $this->mod_autocount->pct_nontender_paket($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $pct_nontender_paket_3 = $this->mod_autocount->pct_nontender_paket($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $pct_nontender_paket_4 = $this->mod_autocount->pct_nontender_paket($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $pct_swakelola_paket_1 = $this->mod_autocount->pct_swakelola_paket($s->kd_satker, "$thn-01-01", "$thn-03-31");
            $pct_swakelola_paket_2 = $this->mod_autocount->pct_swakelola_paket($s->kd_satker, "$thn-04-01", "$thn-06-30");
            $pct_swakelola_paket_3 = $this->mod_autocount->pct_swakelola_paket($s->kd_satker, "$thn-07-01", "$thn-09-30");
            $pct_swakelola_paket_4 = $this->mod_autocount->pct_swakelola_paket($s->kd_satker, "$thn-10-01", "$thn-12-31");

            $triwulan1_paket = $tender_paket_1 + $nontender_paket_1 + $epurchasing_paket_1 + $pct_nontender_paket_1 + $pct_swakelola_paket_1;
            $triwulan2_paket = $tender_paket_2 + $nontender_paket_2 + $epurchasing_paket_2 + $pct_nontender_paket_2 + $pct_swakelola_paket_2;
            $triwulan3_paket = $tender_paket_3 + $nontender_paket_3 + $epurchasing_paket_3 + $pct_nontender_paket_3 + $pct_swakelola_paket_3;
            $triwulan4_paket = $tender_paket_4 + $nontender_paket_4 + $epurchasing_paket_4 + $pct_nontender_paket_4 + $pct_swakelola_paket_4;

            $total_paket = $triwulan1_paket + $triwulan2_paket + $triwulan3_paket + $triwulan4_paket;

            $data = array(
                "thn" => $thn,
                "kd_satker" => $kd_satker,
                "belanja_pagu" => $belanja_pagu,
                "belanja_paket" => $belanja_paket,
                "triwulan1_pagu" => $triwulan1_pagu,
                "triwulan1_paket" => $triwulan1_paket,
                "triwulan2_pagu" => $triwulan2_pagu,
                "triwulan2_paket" => $triwulan2_paket,
                "triwulan3_pagu" => $triwulan3_pagu,
                "triwulan3_paket" => $triwulan3_paket,
                "triwulan4_pagu" => $triwulan4_pagu,
                "triwulan4_paket" => $triwulan4_paket,
                "total_pagu" => $total_pagu,
                "total_paket" => $total_paket
            );

            $this->mod_autocount->simpan_triwulan($data);
        }

        // redirect(base_url()."triwulan/index/$thn");
    }

    public function tender_rekapitulasi($kelompok, $thn)
    {
        switch ($kelompok) {
            case 'metode':
                $this->mod_autocount->reset_tender_rekapitulasi_metode($thn);

                $tender_rekapitulasi_rup_paket_anggaran = $this->mod_autocount->tender_rekapitulasi_rup_paket_anggaran($thn)->result();
                
                foreach ($tender_rekapitulasi_rup_paket_anggaran as $r) {
                    $metode = $r->metode_pemilihan;
                    $rup_paket = $r->jml;
                    $rup_anggaran = $r->total;

                    // proses tender
                    $proses_paket = 0;
                    $proses_anggaran = 0;
                    $tender_rekapitulasi_proses_paket_anggaran = $this->mod_autocount->tender_rekapitulasi_proses_paket_anggaran($thn, $metode)->result();
                    foreach ($tender_rekapitulasi_proses_paket_anggaran as $p) {
                        $proses_paket = $p->jml;
                        $proses_anggaran = $p->total;
                    }

                    // selesai tender
                    $selesai_paket = 0;
                    $selesai_anggaran = 0;
                    $selesai_nilai = 0;
                    $tender_rekapitulasi_selesai_paket_anggaran = $this->mod_autocount->tender_rekapitulasi_selesai_paket_anggaran($thn, $metode)->result();
                    foreach ($tender_rekapitulasi_selesai_paket_anggaran as $s) {
                        $selesai_paket = $s->jml;
                        $selesai_anggaran = $s->total_pagu;
                        $selesai_nilai = $s->total_nilai_negosiasi;
                    }

                    $hemat_anggaran = $selesai_anggaran - $selesai_nilai;
                    if($selesai_anggaran != 0){
                        $hemat_persen =  ($hemat_anggaran / $selesai_anggaran) * 100;
                    }else{
                        $hemat_persen = 0;
                    }

                    $data = array(
                        "thn" => $thn,
                        "metode" => $metode,
                        "rup_paket" => $rup_paket,
                        "rup_anggaran" => $rup_anggaran,
                        "proses_paket" => $proses_paket,
                        "proses_anggaran" => $proses_anggaran,
                        "selesai_paket" => $selesai_paket,
                        "selesai_anggaran" => $selesai_anggaran,
                        "selesai_nilai" => $selesai_nilai,
                        "hemat_anggaran" => $hemat_anggaran,
                        "hemat_persen" => $hemat_persen
                    );
        
                    $this->mod_autocount->simpan_tender_rekapitulasi_metode($data);
                }
                break;
            case 'jenis':
                $this->mod_autocount->reset_tender_rekapitulasi_jenis($thn);

                $tender_jenis_pengadaan = $this->mod_autocount->tender_jenis_pengadaan()->result();
                
                foreach ($tender_jenis_pengadaan as $j) {
                    $jenis = $j->jenis_pengadaan;

                    $total_paket = $this->mod_autocount->tender_total_paket($jenis, $thn);
                    $paket_selesai = $this->mod_autocount->tender_paket_selesai($jenis, $thn);
                    $paket_tayang = $this->mod_autocount->tender_paket_tayang($jenis, $thn);
                    $paket_review = $this->mod_autocount->tender_paket_review($jenis, $thn);
                    $paket_batal = $this->mod_autocount->tender_paket_batal($jenis, $thn);

                    $total_pagu_anggaran = $this->mod_autocount->tender_total_pagu_anggaran($jenis, $thn);
                    $persen_pagu_anggaran = 0;

                    $pagu_anggaran_selesai = $this->mod_autocount->tender_pagu_anggaran_selesai($jenis, $thn);
                    $harga_negosisasi = $this->mod_autocount->tender_harga_negosisasi($jenis, $thn);

                    $penghematan_optimalisasi = $pagu_anggaran_selesai['total'] - $harga_negosisasi['total'];
                    if($pagu_anggaran_selesai['total'] != 0){
                        $penghematan_persen = ($penghematan_optimalisasi / $pagu_anggaran_selesai['total']) * 100;
                    } else {
                        $penghematan_persen = 0;
                    }

                    $data = array(
                        "thn" => $thn,
                        "jenis" => $jenis,
                        "total_paket" => $total_paket,
                        "paket_selesai" => $paket_selesai,
                        "paket_tayang" => $paket_tayang,
                        "paket_review" => $paket_review,
                        "paket_batal" => $paket_batal,
                        "total_pagu_anggaran" => $total_pagu_anggaran['total'],
                        "persen_pagu_anggaran" => $persen_pagu_anggaran,
                        "pagu_anggaran_selesai" => $pagu_anggaran_selesai['total'],
                        "harga_negosisasi" => $harga_negosisasi['total'],
                        "penghematan_optimalisasi" => $penghematan_optimalisasi,
                        "penghematan_persen" => $penghematan_persen
                    );
        
                    $this->mod_autocount->simpan_tender_rekapitulasi_jenis($data);
                }
                break;
            case 'satker':
                $this->mod_autocount->reset_tender_rekapitulasi_satker($thn);

                $gtotal = 0;
                $satker = $this->mod_autocount->satker()->result();
                foreach ($satker as $s) {
                    $kd_satker = $s->kd_satker;

                    $paket = $this->mod_autocount->tender_total_paket_satker($kd_satker, $thn);

                    $qjenis = "AND jenis_pengadaan like '%Barang%'";
                    $pengadaan_barang = $this->mod_autocount->tender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $qjenis = "AND jenis_pengadaan like 'Jasa Konsultansi%'";
                    $jasa_konsultasi = $this->mod_autocount->tender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $qjenis = "AND jenis_pengadaan='Jasa Lainnya'";
                    $jasa_lainnya = $this->mod_autocount->tender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $qjenis = "AND jenis_pengadaan='Pekerjaan Konstruksi'";
                    $pekerjaan_konstruksi = $this->mod_autocount->tender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $total = $pengadaan_barang['total'] + $jasa_konsultasi['total'] + $jasa_lainnya['total'] + $pekerjaan_konstruksi['total']; 

                    $data = array(
                        "thn" => $thn,
                        "kd_satker" => $kd_satker,
                        "paket" => $paket,
                        "pengadaan_barang" => $pengadaan_barang['total'],
                        "jasa_konsultasi" => $jasa_konsultasi['total'],
                        "jasa_lainnya" => $jasa_lainnya['total'],
                        "pekerjaan_konstruksi" => $pekerjaan_konstruksi['total'],
                        "total" => $total
                    );
                    
                    $this->mod_autocount->simpan_tender_rekapitulasi_satker($data);
                }
                break;
        }

        // redirect(base_url()."tender_rekapitulasi/index/$thn");
    }

    public function nontender_rekapitulasi($kelompok, $thn)
    {
        switch ($kelompok) {
            case 'metode':
                $this->mod_autocount->reset_nontender_rekapitulasi_metode($thn);

                $nontender_rekapitulasi_rup_paket_anggaran = $this->mod_autocount->nontender_rekapitulasi_rup_paket_anggaran($thn)->result();
                
                foreach ($nontender_rekapitulasi_rup_paket_anggaran as $r) {
                    $metode = $r->metode_pemilihan;
                    $rup_paket = $r->jml;
                    $rup_anggaran = $r->total;

                    // proses tender
                    $proses_paket = 0;
                    $proses_anggaran = 0;
                    $nontender_rekapitulasi_proses_paket_anggaran = $this->mod_autocount->nontender_rekapitulasi_proses_paket_anggaran($thn, $metode)->result();
                    foreach ($nontender_rekapitulasi_proses_paket_anggaran as $p) {
                        $proses_paket = $p->jml;
                        $proses_anggaran = $p->total;
                    }

                    // selesai tender
                    $selesai_paket = 0;
                    $selesai_anggaran = 0;
                    $selesai_nilai = 0;
                    $nontender_rekapitulasi_selesai_paket_anggaran = $this->mod_autocount->nontender_rekapitulasi_selesai_paket_anggaran($thn, $metode)->result();
                    foreach ($nontender_rekapitulasi_selesai_paket_anggaran as $s) {
                        $selesai_paket = $s->jml;
                        $selesai_anggaran = $s->total_pagu;
                        $selesai_nilai = $s->total_nilai_negosiasi;
                    }

                    $hemat_anggaran = $selesai_anggaran - $selesai_nilai;
                    if($selesai_anggaran != 0){
                        $hemat_persen =  ($hemat_anggaran / $selesai_anggaran) * 100;
                    }else{
                        $hemat_persen = 0;
                    }

                    $data = array(
                        "thn" => $thn,
                        "metode" => $metode,
                        "rup_paket" => $rup_paket,
                        "rup_anggaran" => $rup_anggaran,
                        "proses_paket" => $proses_paket,
                        "proses_anggaran" => $proses_anggaran,
                        "selesai_paket" => $selesai_paket,
                        "selesai_anggaran" => $selesai_anggaran,
                        "selesai_nilai" => $selesai_nilai,
                        "hemat_anggaran" => $hemat_anggaran,
                        "hemat_persen" => $hemat_persen
                    );
        
                    $this->mod_autocount->simpan_nontender_rekapitulasi_metode($data);
                }
                break;
            case 'jenis':
                $this->mod_autocount->reset_nontender_rekapitulasi_jenis($thn);

                $tender_jenis_pengadaan = $this->mod_autocount->nontender_jenis_pengadaan()->result();
                
                foreach ($tender_jenis_pengadaan as $j) {
                    $jenis = $j->kategori_pengadaan;

                    $total_paket = $this->mod_autocount->nontender_total_paket($jenis, $thn);
                    $paket_selesai = $this->mod_autocount->nontender_paket_selesai($jenis, $thn);
                    $paket_tayang = $this->mod_autocount->nontender_paket_tayang($jenis, $thn);
                    $paket_review = $this->mod_autocount->nontender_paket_review($jenis, $thn);
                    $paket_batal = $this->mod_autocount->nontender_paket_batal($jenis, $thn);

                    $total_pagu_anggaran = $this->mod_autocount->nontender_total_pagu_anggaran($jenis, $thn);
                    $persen_pagu_anggaran = 0;

                    $pagu_anggaran_selesai = $this->mod_autocount->nontender_pagu_anggaran_selesai($jenis, $thn);
                    $harga_negosisasi = $this->mod_autocount->nontender_harga_negosisasi($jenis, $thn);

                    $penghematan_optimalisasi = $pagu_anggaran_selesai['total'] - $harga_negosisasi['total'];
                    if($pagu_anggaran_selesai['total'] != 0){
                        $penghematan_persen = ($penghematan_optimalisasi / $pagu_anggaran_selesai['total']) * 100;
                    } else {
                        $penghematan_persen = 0;
                    }

                    $data = array(
                        "thn" => $thn,
                        "jenis" => $jenis,
                        "total_paket" => $total_paket,
                        "paket_selesai" => $paket_selesai,
                        "paket_tayang" => $paket_tayang,
                        "paket_review" => $paket_review,
                        "paket_batal" => $paket_batal,
                        "total_pagu_anggaran" => $total_pagu_anggaran['total'],
                        "persen_pagu_anggaran" => $persen_pagu_anggaran,
                        "pagu_anggaran_selesai" => $pagu_anggaran_selesai['total'],
                        "harga_negosisasi" => $harga_negosisasi['total'],
                        "penghematan_optimalisasi" => $penghematan_optimalisasi,
                        "penghematan_persen" => $penghematan_persen
                    );
        
                    $this->mod_autocount->simpan_nontender_rekapitulasi_jenis($data);
                }
                break;
            case 'satker':
                $this->mod_autocount->reset_nontender_rekapitulasi_satker($thn);

                $gtotal = 0;
                $satker = $this->mod_autocount->satker()->result();
                foreach ($satker as $s) {
                    $kd_satker = $s->kd_satker;

                    $paket = $this->mod_autocount->nontender_total_paket_satker($kd_satker, $thn);

                    $qjenis = "AND kategori_pengadaan like '%Barang%'";
                    $pengadaan_barang = $this->mod_autocount->nontender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $qjenis = "AND kategori_pengadaan like 'Jasa Konsultansi%'";
                    $jasa_konsultasi = $this->mod_autocount->nontender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $qjenis = "AND kategori_pengadaan='Jasa Lainnya'";
                    $jasa_lainnya = $this->mod_autocount->nontender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $qjenis = "AND kategori_pengadaan='Pekerjaan Konstruksi'";
                    $pekerjaan_konstruksi = $this->mod_autocount->nontender_total_pagu_satker_jenis($kd_satker, $qjenis, $thn);

                    $total = $pengadaan_barang['total'] + $jasa_konsultasi['total'] + $jasa_lainnya['total'] + $pekerjaan_konstruksi['total']; 

                    $data = array(
                        "thn" => $thn,
                        "kd_satker" => $kd_satker,
                        "paket" => $paket,
                        "pengadaan_barang" => $pengadaan_barang['total'],
                        "jasa_konsultasi" => $jasa_konsultasi['total'],
                        "jasa_lainnya" => $jasa_lainnya['total'],
                        "pekerjaan_konstruksi" => $pekerjaan_konstruksi['total'],
                        "total" => $total
                    );
                    
                    $this->mod_autocount->simpan_nontender_rekapitulasi_satker($data);
                }
                break;
        }

        // redirect(base_url()."nontender_rekapitulasi/index/$thn");
    }

    public function realisasi_rekapitulasi($thn)
    {
        $this->mod_autocount->reset_realisasi_rekapitulasi($thn);

        $gtotal = 0;
        $satker = $this->mod_autocount->satker()->result();
        foreach ($satker as $s) {
            $kd_satker = $s->kd_satker;

            $belanja_pengadaan_paket = $this->mod_autocount->belanja_pengadaan_paket($kd_satker, $thn);
            $belanja_pengadaan_anggaran = $this->mod_autocount->belanja_pengadaan_anggaran($kd_satker, $thn);

            $realisasi_kontrak_tender_paket = $this->mod_autocount->realisasi_kontrak_tender_paket($kd_satker, $thn);
            $realisasi_kontrak_tender_anggaran = $this->mod_autocount->realisasi_kontrak_tender_anggaran($kd_satker, $thn);

            $realisasi_kontrak_nontender_paket = $this->mod_autocount->realisasi_kontrak_nontender_paket($kd_satker, $thn);
            $realisasi_kontrak_nontender_anggaran = $this->mod_autocount->realisasi_kontrak_nontender_anggaran($kd_satker, $thn);

            $realisasi_kontrak_paket = $realisasi_kontrak_tender_paket + $realisasi_kontrak_nontender_paket;
            $realisasi_kontrak_anggaran = $realisasi_kontrak_tender_anggaran['total'] + $realisasi_kontrak_nontender_anggaran['total'];

            if($belanja_pengadaan_anggaran['total'] > 0){
                $realisasi_kontrak_persen = ($realisasi_kontrak_anggaran / $belanja_pengadaan_anggaran['total']) * 100;
            } else {
                $realisasi_kontrak_persen = 0;
            }
            
            $paket_selesai_tender_paket = $this->mod_autocount->paket_selesai_tender_paket($kd_satker, $thn);
            $paket_selesai_tender_anggaran = $this->mod_autocount->paket_selesai_tender_anggaran($kd_satker, $thn);

            $paket_selesai_nontender_paket = $this->mod_autocount->paket_selesai_nontender_paket($kd_satker, $thn);
            $paket_selesai_nontender_anggaran = $this->mod_autocount->paket_selesai_nontender_anggaran($kd_satker, $thn);

            $paket_selesai_paket = $paket_selesai_tender_paket + $paket_selesai_nontender_paket;
            $paket_selesai_anggaran = $paket_selesai_tender_anggaran['total'] + $paket_selesai_nontender_anggaran['total'];
            
            if($belanja_pengadaan_anggaran['total'] > 0){
                $paket_selesai_persen = ($paket_selesai_anggaran / $belanja_pengadaan_anggaran['total']) * 100;
            } else {
                $paket_selesai_persen = 0;
            }

            $data = array(
                "thn" => $thn,
                "kd_satker" => $kd_satker,
                "belanja_pengadaan_paket" => $belanja_pengadaan_paket,
                "belanja_pengadaan_anggaran" => $belanja_pengadaan_anggaran['total'],
                "realisasi_kontrak_paket" => $realisasi_kontrak_paket,
                "realisasi_kontrak_anggaran" => $realisasi_kontrak_anggaran,
                "realisasi_kontrak_persen" => $realisasi_kontrak_persen,
                "paket_selesai_paket" => $paket_selesai_paket,
                "paket_selesai_anggaran" => $paket_selesai_anggaran['total'],
                "paket_selesai_persen" => $paket_selesai_persen
            );
            
            $this->mod_autocount->simpan_realisasi_rekapitulasi($data);
        }

        // redirect(base_url()."realisasi_rekapitulasi/index/$thn");
    }

    public function monitoring_ppk($kelompok, $thn)
    {
        switch ($kelompok) {
            case 'tender':
                $kolom = "nama_status_tender";
                $table = "tender";
                $kolom_nip = "nip_ppk"; 
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "nilai_kontrak"; 
                break;
            case 'nontender':
                $kolom = "nama_status_nontender";
                $table = "non_tender";
                $kolom_nip = "nip_ppk";
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "nilai_kontrak"; 
                break;
            case 'pctnontender':
                $kolom = "status_nontender_pct";
                $table = "pct_nontender";
                $kolom_nip = "nip_ppk";
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "total_realisasi"; 
                break;
            case 'pctswakelola':
                $kolom = "status_swakelola_pct";
                $table = "pct_swakelola";
                $kolom_nip = "nip_ppk";
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "total_realisasi"; 
                break;
            case 'epurchasing':
                $kolom = "paket_status_str";
                $table = "epurchasing";
                $kolom_nip = "ppk_nip";
                $kolom_pagu = "pagu_rup"; 
                $kolom_kontrak = "total_harga"; 
                break;
        }
        $this->mod_autocount->reset_monitoring_ppk($kelompok, $thn);

        $pegawai = $this->mod_autocount->pegawai()->result();
        foreach ($pegawai as $p) {
            $kd_pegawai = $p->kd_pegawai;

            $aktif = $this->mod_autocount->cek_paket($kolom, $table, $thn, 'Aktif', "$kolom_nip='".$p->nip_pegawai."'");
            $batal = $this->mod_autocount->cek_paket($kolom, $table, $thn, 'Batal', "$kolom_nip='".$p->nip_pegawai."'");
            $gagal = $this->mod_autocount->cek_paket($kolom, $table, $thn, 'Gagal', "$kolom_nip='".$p->nip_pegawai."'");
            $selesai = $this->mod_autocount->cek_paket($kolom, $table, $thn, 'Selesai', "$kolom_nip='".$p->nip_pegawai."'");
            $total_paket = $aktif['total'] + $batal['total'] + $gagal['total'] + $selesai['total'];

            $total_pagu =  $this->mod_autocount->total_pagu($kolom_pagu, $kolom, $table, $thn, "$kolom_nip='".$p->nip_pegawai."'");
            $total_kontrak =  $this->mod_autocount->total_kontrak($kolom_kontrak, $kolom, $table, $thn, "$kolom_nip='".$p->nip_pegawai."'");

            $data = array(
                "thn" => $thn,
                "kd_pegawai" => $kd_pegawai,
                "nip_pegawai" => $p->nip_pegawai,
                "kelompok" => $kelompok,
                "aktif" => $aktif['total'],
                "batal" => $batal['total'],
                "gagal" => $gagal['total'],
                "selesai" => $selesai['total'],
                "total_paket" => $total_paket,
                "total_pagu" => $total_pagu['total'],
                "total_kontrak" => $total_kontrak['total']
            );
            
            // echo print_r($data);
            $this->mod_autocount->simpan_monitoring_ppk($data);
        }

        // redirect(base_url()."monitoring_ppk/index/$kelompok/$thn");
    }

    public function monitoring_personil($personil, $thn)
    {
        $this->mod_autocount->reset_monitoring_personil($personil, $thn);

        $pegawai = $this->mod_autocount->pegawai()->result();
        foreach ($pegawai as $p) {
            $kd_pegawai = $p->kd_pegawai;

            switch ($personil) {
                case 'pokja':
                    $kolom = "nama_status_tender";
                    $table = "tender";
                    $kolom_nip = "nip_ppk"; 
                    $kolom_pagu = "pagu"; 
                    $kolom_kontrak = "nilai_kontrak"; 

                    $aktif = $this->mod_autocount->cek_paket_pokja($thn, 'Aktif', $p->nip_pegawai);
                    $batal = $this->mod_autocount->cek_paket_pokja($thn, 'Batal', $p->nip_pegawai);
                    $gagal = $this->mod_autocount->cek_paket_pokja($thn, 'Gagal', $p->nip_pegawai);
                    $selesai = $this->mod_autocount->cek_paket_pokja($thn, 'Selesai', $p->nip_pegawai);

                    $total_pagu =  $this->mod_autocount->total_pagu_pokja($thn, $p->nip_pegawai);
                    $total_kontrak =  $this->mod_autocount->total_kontrak_pokja($thn, $p->nip_pegawai);
                    break;
                case 'pp':
                    $kolom = "nama_status_nontender";
                    $table = "non_tender";
                    $kolom_nip = "nip_ppk";
                    $kolom_pagu = "pagu"; 
                    $kolom_kontrak = "nilai_kontrak"; 

                    $aktif = $this->mod_autocount->cek_paket_pp($thn, 'Aktif', $p->nip_pegawai);
                    $batal = $this->mod_autocount->cek_paket_pp($thn, 'Batal', $p->nip_pegawai);
                    $gagal = $this->mod_autocount->cek_paket_pp($thn, 'Gagal', $p->nip_pegawai);
                    $selesai = $this->mod_autocount->cek_paket_pp($thn, 'Selesai', $p->nip_pegawai);

                    $total_pagu =  $this->mod_autocount->total_pagu_pp($thn, $p->nip_pegawai);
                    $total_kontrak =  $this->mod_autocount->total_kontrak_pp($thn, $p->nip_pegawai);
                    break;
            }
            
            $total_paket = $aktif['total'] + $batal['total'] + $gagal['total'] + $selesai['total'];

            $data = array(
                "thn" => $thn,
                "kd_pegawai" => $kd_pegawai,
                "nip_pegawai" => $p->nip_pegawai,
                "personil" => $personil,
                "aktif" => $aktif['total'],
                "batal" => $batal['total'],
                "gagal" => $gagal['total'],
                "selesai" => $selesai['total'],
                "total_paket" => $total_paket,
                "total_pagu" => $total_pagu['total'],
                "total_kontrak" => $total_kontrak['total']
            );
            
            $this->mod_autocount->simpan_monitoring_personil($data);
        }

        // redirect(base_url()."monitoring_personil/index/$personil/$thn");
    }

    public function monitoring_penyedia($provinsi, $kabupaten_kota, $kelompok, $thn)
    {
        switch ($kelompok) {
            case 'tender':
                $kolom = "nama_status_tender";
                $table = "tender";
                $kolom_penyedia = "kd_penyedia"; 
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "nilai_kontrak"; 
                break;
            case 'nontender':
                $kolom = "nama_status_nontender";
                $table = "non_tender";
                $kolom_penyedia = "kd_penyedia";
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "nilai_kontrak"; 
                break;
            case 'pctnontender':
                $kolom = "status_nontender_pct";
                $table = "pct_nontender";
                $kolom_penyedia = "kd_penyedia";
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "total_realisasi"; 
                break;
            case 'pctswakelola':
                $kolom = "status_swakelola_pct";
                $table = "pct_swakelola";
                $kolom_penyedia = "npwp_penyedia";
                $kolom_pagu = "pagu"; 
                $kolom_kontrak = "total_realisasi"; 
                break;
            case 'epurchasing':
                $kolom = "paket_status_str";
                $table = "epurchasing";
                $kolom_penyedia = "npwp_penyedia";
                $kolom_pagu = "pagu_rup"; 
                $kolom_kontrak = "total_harga"; 
                break;
        }

        $this->mod_autocount->reset_monitoring_penyedia($kelompok, $thn);

        $penyedia = $this->mod_autocount->penyedia()->result();
        foreach ($penyedia as $p) {
            $kd_penyedia = $p->kd_penyedia;
            $npwp_penyedia = $p->npwp_penyedia;

            switch ($kelompok) {
                case 'tender':
                case 'nontender':
                case 'pctnontender':
                    $target = $p->kd_penyedia;
                    break;
                case 'pctswakelola':
                case 'epurchasing':
                    $target = $p->npwp_penyedia;
                    break;
            }

            $aktif = $this->mod_autocount->cek_paket_penyedia($kolom, $table, $thn, 'Aktif', "$kolom_penyedia='$target'");
            $batal = $this->mod_autocount->cek_paket_penyedia($kolom, $table, $thn, 'Batal', "$kolom_penyedia='$target'");
            $gagal = $this->mod_autocount->cek_paket_penyedia($kolom, $table, $thn, 'Gagal', "$kolom_penyedia='$target'");
            $selesai = $this->mod_autocount->cek_paket_penyedia($kolom, $table, $thn, 'Selesai', "$kolom_penyedia='$target'");
            $total_paket = $aktif['total'] + $batal['total'] + $gagal['total'] + $selesai['total'];

            $total_pagu =  $this->mod_autocount->total_pagu_penyedia($kolom_pagu, $kolom, $table, $thn, "$kolom_penyedia='$target'");
            $total_kontrak =  $this->mod_autocount->total_kontrak_penyedia($kolom_kontrak, $kolom, $table, $thn, "$kolom_penyedia='$target'");
            
            $total_paket = $aktif['total'] + $batal['total'] + $gagal['total'] + $selesai['total'];

            $data = array(
                "thn" => $thn,
                "kd_penyedia" => $kd_penyedia,
                "kelompok" => $kelompok,
                "aktif" => $aktif['total'],
                "batal" => $batal['total'],
                "gagal" => $gagal['total'],
                "selesai" => $selesai['total'],
                "total_paket" => $total_paket,
                "total_pagu" => $total_pagu['total'],
                "total_kontrak" => $total_kontrak['total']
            );
            
            $this->mod_autocount->simpan_monitoring_penyedia($data);
        }

        // redirect(base_url()."monitoring_penyedia/penyedia/$provinsi/$kabupaten_kota/$kelompok/$thn");
    }

    public function rencana_paket_pengadaan($thn)
    {
        $jenis_pengadaan = $this->mod_autocount->jenis_pengadaan()->result();
        foreach ($jenis_pengadaan as $jp) {
            $this->mod_autocount->reset_rencana_paket_pengadaan($jp->jenis_pengadaan, $thn);

            // <= 200 jt
            $qnominal = "pagu_rup<='200000000'";
            $kelompok_200 = $this->mod_autocount->total_jenis_pengadaan($thn, $qnominal, $jp->jenis_pengadaan);

            // > 200 jt and <= 2,5 M
            $qnominal = "pagu_rup>'200000000' AND pagu_rup<='2500000000'";
            $kelompok_200_25 = $this->mod_autocount->total_jenis_pengadaan($thn, $qnominal, $jp->jenis_pengadaan);

            // > 2,5 M and <= 50 M
            $qnominal = "pagu_rup>'2500000000' AND pagu_rup<='50000000000'";
            $kelompok_25_50 = $this->mod_autocount->total_jenis_pengadaan($thn, $qnominal, $jp->jenis_pengadaan);

            // > 50 M and <= 100 M
            $qnominal = "pagu_rup>'50000000000' AND pagu_rup<='100000000000'";
            $kelompok_50_100 = $this->mod_autocount->total_jenis_pengadaan($thn, $qnominal, $jp->jenis_pengadaan);

            // > 100 M
            $qnominal = "pagu_rup>'100000000000'";
            $kelompok_100 = $this->mod_autocount->total_jenis_pengadaan($thn, $qnominal, $jp->jenis_pengadaan);

            // swakelola

            $data = array(
                "thn" => $thn,
                "jenis_pengadaan" => $jp->jenis_pengadaan,
                "kelompok_200_paket" => $kelompok_200['total_paket'],
                "kelompok_200_pagu" => $kelompok_200['total_pagu'],
                "kelompok_200_25_paket" => $kelompok_200_25['total_paket'],
                "kelompok_200_25_pagu" => $kelompok_200_25['total_pagu'],
                "kelompok_25_50_paket" => $kelompok_25_50['total_paket'],
                "kelompok_25_50_pagu" => $kelompok_25_50['total_pagu'],
                "kelompok_50_100_paket" => $kelompok_50_100['total_paket'],
                "kelompok_50_100_pagu" => $kelompok_50_100['total_pagu'],
                "kelompok_100_paket" => $kelompok_100['total_paket'],
                "kelompok_100_pagu" => $kelompok_100['total_pagu'],
                "swakelola_paket" => 0,
                "swakelola_pagu" => 0
            );
            
            $this->mod_autocount->simpan_rencana_paket_pengadaan($data);
        }

        // redirect(base_url()."dashboard");
    }

    public function grafik_belanja_pengadaan($thn)
    {
        $daftar = $this->mod_autocount->belanja_pengadaan($thn)->result();
        foreach ($daftar as $d) {
            $this->mod_autocount->reset_belanja_pengadaan($d->jenis_pengadaan, $thn);

            $data = array(
                "thn" => $thn,
                "jenis_pengadaan" => $d->jenis_pengadaan,
                "total" => $d->total
            );
            
            $this->mod_autocount->simpan_belanja_pengadaan($data);
        }

        // redirect(base_url()."dashboard");
    }

    public function grafik_rup_penyedia($thn)
    {
        $metode = $this->mod_autocount->rup_penyedia($thn)->result();
        foreach ($metode as $m) {
            // realisasi
            $realisasi_anggaran = 0;
            $realisasi_paket = 0;

            // tender
            $tender = $this->mod_autocount->realisasi_tender($thn,$m->metode_pemilihan);
            $realisasi_anggaran += $tender['selesai_anggaran'];
            $realisasi_paket += $tender['selesai_paket'];

            // nontender
            $nontender = $this->mod_autocount->realisasi_nontender($thn,$m->metode_pemilihan);
            $realisasi_anggaran += $nontender['selesai_anggaran'];
            $realisasi_paket += $nontender['selesai_paket'];

            // pencatatan nontender
            $pct_nontender = $this->mod_autocount->realisasi_pencatatan_nontender($thn,$m->metode_pemilihan);
            $realisasi_anggaran += $pct_nontender['total'];
            $realisasi_paket += $pct_nontender['jml'];

            // epurchasing
            $epurchasing = $this->mod_autocount->realisasi_epurchasing($thn,$m->metode_pemilihan);
            $realisasi_anggaran += $epurchasing['total'];
            $realisasi_paket += $epurchasing['jml'];

            $this->mod_autocount->reset_rup_penyedia("penyedia", $m->metode_pemilihan, $thn);

            $data = array(
                "thn" => $thn,
                "kelompok" => "penyedia",
                "kategori" => $m->metode_pemilihan,
                "rup_anggaran" => $m->rup_anggaran,
                "rup_paket" => $m->rup_paket,
                "realisasi_anggaran" => $realisasi_anggaran,
                "realisasi_paket" => $realisasi_paket,
            );
            
            $this->mod_autocount->simpan_rup_penyedia($data);
        }

        // redirect(base_url()."dashboard");
    }

    public function grafik_rup_swakelola($thn)
    {
        $tipe = $this->mod_autocount->rup_swakelola($thn)->result();
        foreach ($tipe as $t) {
            // realisasi
            $realisasi_anggaran = 0;
            $realisasi_paket = 0;

            // pencatatan swakelola
            $pct_swakelola = $this->mod_autocount->realisasi_pencatatan_swakelola($thn,$t->tipe_swakelola);
            $realisasi_anggaran = $pct_swakelola['total'];
            $realisasi_paket = $pct_swakelola['jml'];

            $this->mod_autocount->reset_rup_swakelola("swakelola", $t->tipe_swakelola, $thn);

            $data = array(
                "thn" => $thn,
                "kelompok" => "swakelola",
                "kategori" =>$t->tipe_swakelola,
                "rup_anggaran" => $t->rup_anggaran,
                "rup_paket" => $t->rup_paket,
                "realisasi_anggaran" => $realisasi_anggaran,
                "realisasi_paket" => $realisasi_paket
            );
            
            $this->mod_autocount->simpan_rup_swakelola($data);
        }

        // redirect(base_url()."dashboard");
    }

    public function grafik_tender($thn)
    {
        $tender_rekapitulasi_rup_paket_anggaran = $this->mod_autocount->tender_rekapitulasi_rup_paket_anggaran_grafik($thn)->result();
        foreach ($tender_rekapitulasi_rup_paket_anggaran as $r) {
            // total
            $total = $this->mod_autocount->tender_rekapitulasi_total_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            // selesai
            $selesai = $this->mod_autocount->tender_rekapitulasi_selesai_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            // proses
            $proses = $this->mod_autocount->tender_rekapitulasi_proses_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            // batal
            $batal = $this->mod_autocount->tender_rekapitulasi_batal_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            $hemat_anggaran = $selesai['total_pagu'] - $selesai['total_nilai_negosiasi'];

            if($selesai['total_pagu'] != 0){
                $hemat_persen =  ($hemat_anggaran / $selesai['total_pagu']) * 100;
            }else{
                $hemat_persen = 0;
            }

            $this->mod_autocount->reset_tender("tender", $r->metode_pemilihan, $thn);

            $data = array(
                "thn" => $thn,
                "kelompok" => "tender",
                "kategori" => $r->metode_pemilihan,
                "rencana" => $r->total,
                "total" => $total['total_pagu'],
                "selesai" => $selesai['total_pagu'],
                "proses" => $proses['total_pagu'],
                "batal" => $batal['total_pagu'],
                "optimalisasi_anggaran" => $hemat_anggaran,
                "optimalisasi_persen" => $hemat_persen
            );
            
            $this->mod_autocount->simpan_tender($data);
        }

        // redirect(base_url()."dashboard");
    }

    public function grafik_nontender($thn)
    {
        $tender_rekapitulasi_rup_paket_anggaran = $this->mod_autocount->nontender_rekapitulasi_rup_paket_anggaran_grafik($thn)->result();
        foreach ($tender_rekapitulasi_rup_paket_anggaran as $r) {
            // total
            $total = $this->mod_autocount->nontender_rekapitulasi_total_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            // selesai
            $selesai = $this->mod_autocount->nontender_rekapitulasi_selesai_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            // proses
            $proses = $this->mod_autocount->nontender_rekapitulasi_proses_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            // batal
            $batal = $this->mod_autocount->nontender_rekapitulasi_batal_paket_anggaran_grafik($thn,  $r->metode_pemilihan);

            $hemat_anggaran = $selesai['total_pagu'] - $selesai['total_nilai_negosiasi'];

            if($selesai['total_pagu'] != 0){
                $hemat_persen =  ($hemat_anggaran / $selesai['total_pagu']) * 100;
            }else{
                $hemat_persen = 0;
            }

            $this->mod_autocount->reset_nontender("nontender", $r->metode_pemilihan, $thn);

            $data = array(
                "thn" => $thn,
                "kelompok" => "nontender",
                "kategori" => $r->metode_pemilihan,
                "rencana" => $r->total,
                "total" => $total['total_pagu'],
                "selesai" => $selesai['total_pagu'],
                "proses" => $proses['total_pagu'],
                "batal" => $batal['total_pagu'],
                "optimalisasi_anggaran" => $hemat_anggaran,
                "optimalisasi_persen" => $hemat_persen
            );
            
            $this->mod_autocount->simpan_nontender($data);
        }

        // redirect(base_url()."dashboard");
    }

    public function mekanisme_lainnya($thn)
    {
        // Pencatatan Non Tender
        $this->mod_autocount->reset_mekanisme_lainnya("Pencatatan Non tender", $thn);

        $qmetode = "metode_pemilihan='Pengadaan Langsung' or metode_pemilihan='Penunjukan Langsung'";
        $perencanaan_pctnontender = $this->mod_autocount->mekanisme_lainnya_perencanaan_pctnontender_mekanisme($qmetode, $thn);
    
        $realisasi_pctnontender = $this->mod_autocount->mekanisme_lainnya_realisasi_pctnontender_mekanisme($thn);

        if($perencanaan_pctnontender['total_paket'] != 0){
            $persentase = ($realisasi_pctnontender['total_paket'] / $perencanaan_pctnontender['total_paket']) * 100;
        }else{$persentase = 0;}

        $data = array(
            "thn" => $thn,
            "mekanisme" => "Pencatatan Non Tender",
            "perencanaan_paket" => $perencanaan_pctnontender['total_paket'],
            "perencanaan_pagu" => $realisasi_pctnontender['total_pagu'],
            "realisasi_paket" => $realisasi_pctnontender['total_paket'],
            "realisasi_pagu" => $realisasi_pctnontender['total_pagu'],
            "persentase" => $persentase
        );
        
        $this->mod_autocount->simpan_mekanisme_lainnya($data);

        // Pencatatan Swakelola
        $this->mod_autocount->reset_mekanisme_lainnya("Pencatatan Swakelola", $thn);

        $perencanaan_pctswakelola = $this->mod_autocount->mekanisme_lainnya_perencanaan_pctswakelola_mekanisme($thn);
    
        $realisasi_pctswakelola = $this->mod_autocount->mekanisme_lainnya_realisasi_pctswakelola_mekanisme($thn);

        if($perencanaan_pctswakelola['total_paket'] != 0){
            $persentase = ($realisasi_pctswakelola['total_paket'] / $perencanaan_pctswakelola['total_paket']) * 100;
        }else{$persentase = 0;}

        $data = array(
            "thn" => $thn,
            "mekanisme" => "Pencatatan Swakelola",
            "perencanaan_paket" => $perencanaan_pctswakelola['total_paket'],
            "perencanaan_pagu" => $realisasi_pctswakelola['total_pagu'],
            "realisasi_paket" => $realisasi_pctswakelola['total_paket'],
            "realisasi_pagu" => $realisasi_pctswakelola['total_pagu'],
            "persentase" => $persentase
        );
        
        $this->mod_autocount->simpan_mekanisme_lainnya($data);

        // epurchasing
        $this->mod_autocount->reset_mekanisme_lainnya("e-Purchasing", $thn);

        $perencanaan_epurchasing = $this->mod_autocount->mekanisme_lainnya_perencanaan_epurchasing_mekanisme($thn);
    
        $realisasi_epurchasing = $this->mod_autocount->mekanisme_lainnya_realisasi_epurchasing_mekanisme($thn);

        if($perencanaan_epurchasing['total_paket'] != 0){
            $persentase = ($realisasi_epurchasing['total_paket'] / $perencanaan_epurchasing['total_paket']) * 100;
        }else{$persentase = 0;}

        $data = array(
            "thn" => $thn,
            "mekanisme" => "e-Purchasing",
            "perencanaan_paket" => $perencanaan_epurchasing['total_paket'],
            "perencanaan_pagu" => $realisasi_epurchasing['total_pagu'],
            "realisasi_paket" => $realisasi_epurchasing['total_paket'],
            "realisasi_pagu" => $realisasi_epurchasing['total_pagu'],
            "persentase" => $persentase
        );
        
        $this->mod_autocount->simpan_mekanisme_lainnya($data);

        // redirect(base_url()."dashboard");
    }
}