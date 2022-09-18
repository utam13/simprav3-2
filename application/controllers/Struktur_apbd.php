<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_apbd extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_struktur_apbd');
    }

    public function struktur_anggaran()
    {
        $data['halaman'] = "Struktur APBD - Struktur Anggaran";

        $data['main'] = "struktur_apbd";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/struktur_anggaran');
        $this->load->view('layout/footer');
    }

    public function rincian_belanja()
    {
        $data['halaman'] = "Struktur APBD - Rincian Belanja";

        $data['main'] = "struktur_apbd";
        $data['grafik'] = "";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/rincian_belanja');
        $this->load->view('layout/footer');
    }

    public function struktur($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        // kelompok murni
        $record_murni = array();
        $subrecord_murni = array();

        $subrecord['murni'] = "";

        $struktur_anggaran = $this->mod_struktur_apbd->struktur_anggaran($thn, "murni");
        
        $subrecord_murni['belanja_operasi_1'] =  $struktur_anggaran['belanja_operasi_1'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_operasi_1']/1000000000,2,',','.')." M";
        $subrecord_murni['belanja_modal'] = $struktur_anggaran['belanja_modal'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_modal']/1000000000,2,',','.')." M";
        $subrecord_murni['belanja_tidak_terduga_1'] = $struktur_anggaran['belanja_tidak_terduga_1'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_tidak_terduga_1'],0,',','.')." M";
        $subrecord_murni['belanja_pengadaan'] = $struktur_anggaran['belanja_pengadaan'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_pengadaan']/1000000000,2,',','.')." M";
        $subrecord_murni['belanja_operasi_2'] = $struktur_anggaran['belanja_operasi_2'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_operasi_2']/1000000000,2,',','.')." M";
        $subrecord_murni['belanja_transfer'] = $struktur_anggaran['belanja_transfer'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_transfer']/1000000000,2,',','.')." M";
        $subrecord_murni['belanja_tidak_terduga_2'] = $struktur_anggaran['belanja_tidak_terduga_2'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_tidak_terduga_2']/1000000000,2,',','.')." M";
        $subrecord_murni['belanja_non_pengadaan'] = $struktur_anggaran['belanja_non_pengadaan'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_non_pengadaan']/1000000000,2,',','.')." M";
        $subrecord_murni['total_belanja'] = $struktur_anggaran['total_belanja'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['total_belanja']/1000000000,2,',','.')." M";

        array_push($record_murni, $subrecord_murni);

        $subrecord['murni'] = $record_murni;

        // kelompok perubahan
        $record_perubahan = array();
        $subrecord_perubahan = array();

        $subrecord['perubahan'] = "";

        $struktur_anggaran = $this->mod_struktur_apbd->struktur_anggaran($thn, "perubahan");
        
        $subrecord_perubahan['belanja_operasi_1'] =  $struktur_anggaran['belanja_operasi_1'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_operasi_1']/1000000000,2,',','.')." M";
        $subrecord_perubahan['belanja_modal'] = $struktur_anggaran['belanja_modal'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_modal']/1000000000,2,',','.')." M";
        $subrecord_perubahan['belanja_tidak_terduga_1'] = $struktur_anggaran['belanja_tidak_terduga_1'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_tidak_terduga_1'],0,',','.')." M";
        $subrecord_perubahan['belanja_pengadaan'] = $struktur_anggaran['belanja_pengadaan'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_pengadaan']/1000000000,2,',','.')." M";
        $subrecord_perubahan['belanja_operasi_2'] = $struktur_anggaran['belanja_operasi_2'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_operasi_2']/1000000000,2,',','.')." M";
        $subrecord_perubahan['belanja_transfer'] = $struktur_anggaran['belanja_transfer'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_transfer']/1000000000,2,',','.')." M";
        $subrecord_perubahan['belanja_tidak_terduga_2'] = $struktur_anggaran['belanja_tidak_terduga_2'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_tidak_terduga_2']/1000000000,2,',','.')." M";
        $subrecord_perubahan['belanja_non_pengadaan'] = $struktur_anggaran['belanja_non_pengadaan'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['belanja_non_pengadaan']/1000000000,2,',','.')." M";
        $subrecord_perubahan['total_belanja'] = $struktur_anggaran['total_belanja'] == 0 ? "-" : "Rp. ".number_format($struktur_anggaran['total_belanja']/1000000000,2,',','.')." M";

        array_push($record_perubahan, $subrecord_perubahan);

        $subrecord['perubahan'] = $record_perubahan;

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/struktur_anggaran_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json struktur_anggaran_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json struktur_anggaran_".$thn.".json");
        // }
    }

    public function satuan_kerja($thn = 2021)
    {
        $record = array();
        $subrecord = array();

        // kelompok murni
        $subrecord['murni'] = "";

        $record_total_murni = array();
        $subrecord_total_murni = array();

        $record_baris_murni = array();
        $subrecord_baris_murni = array();

        $no_murni = 1;

        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        $total_4 = 0;
        $total_5 = 0;
        $total_6 = 0;
        $total_7 = 0;
        $total_8 = 0;
        
        $satker = $this->mod_struktur_apbd->satker()->result();

        if(COUNT($satker) > 0){
            foreach ($satker as $s) {
                $subrecord_baris_murni['no'] = $no_murni;
                $subrecord_baris_murni['kode'] = $s->kd_satker;
                $subrecord_baris_murni['singkatan'] = $s->singkatan;
                
                $rincian = $this->mod_struktur_apbd->rincian_struktur_anggaran($s->kd_satker, $thn, "murni");
                
                if(!empty($rincian)){
                    $subrecord_baris_murni['total_barang_jasa'] = $rincian['total_barang_jasa'] == 0 ? "-" : "Rp. ".number_format($rincian['total_barang_jasa']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total_modal'] = $rincian['total_modal'] == 0 ? "-" : "Rp. ".number_format($rincian['total_modal']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total_pegawai'] = $rincian['total_pegawai'] == 0 ? "-" : "Rp. ".number_format($rincian['total_pegawai']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total_hibah'] = $rincian['total_hibah'] == 0 ? "-" : "Rp. ".number_format($rincian['total_hibah']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total_bansos'] = $rincian['total_bansos'] == 0 ? "-" : "Rp. ".number_format($rincian['total_bansos']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total_tidak_terduga'] = $rincian['total_tidak_terduga'] == 0 ? "-" : "Rp. ".number_format($rincian['total_tidak_terduga']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total_dll'] = $rincian['total_dll'] == 0 ? "-" : "Rp. ".number_format($rincian['total_dll']/1000000000,2,',','.')." M";
                    $subrecord_baris_murni['total'] = $rincian['total'] == 0 ? "-" : "Rp. ".number_format($rincian['total']/1000000000,2,',','.')." M";

                    $total_1 += $rincian['total_barang_jasa'];
                    $total_2 += $rincian['total_modal'];
                    $total_3 += $rincian['total_pegawai'];
                    $total_4 += $rincian['total_hibah'];
                    $total_5 += $rincian['total_bansos'];
                    $total_6 += $rincian['total_tidak_terduga'];
                    $total_7 += $rincian['total_dll'];
                    $total_8 += $rincian['total'];
                } else {
                    $subrecord_baris_murni['total_barang_jasa'] = "-";
                    $subrecord_baris_murni['total_modal'] = "-";
                    $subrecord_baris_murni['total_pegawai'] = "-";
                    $subrecord_baris_murni['total_hibah'] = "-";
                    $subrecord_baris_murni['total_bansos'] = "-";
                    $subrecord_baris_murni['total_tidak_terduga'] = "-";
                    $subrecord_baris_murni['total_dll'] = "-";
                    $subrecord_baris_murni['total'] = "-";
                }

                $no_murni++;

                array_push($record_baris_murni, $subrecord_baris_murni);
            }

            $subrecord_total_murni['baris'] = $record_baris_murni;

            $subrecord_total_murni['total_1'] = $total_1 == 0 ? "-" : "Rp. ".number_format($total_1/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_2'] = $total_2 == 0 ? "-" : "Rp. ".number_format($total_2/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_3'] = $total_3 == 0 ? "-" : "Rp. ".number_format($total_3/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_4'] = $total_4 == 0 ? "-" : "Rp. ".number_format($total_4/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_5'] = $total_5 == 0 ? "-" : "Rp. ".number_format($total_5/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_6'] = $total_6 == 0 ? "-" : "Rp. ".number_format($total_6/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_7'] = $total_7 == 0 ? "-" : "Rp. ".number_format($total_7/1000000000,2,',','.')." M";
            $subrecord_total_murni['total_8'] = $total_8 == 0 ? "-" : "Rp. ".number_format($total_8/1000000000,2,',','.')." M";

            array_push($record_total_murni, $subrecord_total_murni);
        } else {
            array_push($record_baris_murni, $subrecord_baris_murni);
            array_push($record_total_murni, $subrecord_total_murni);
        }

        $subrecord['murni'] = $record_total_murni;

        // kelompok perubahan
        $subrecord['perubahan'] = "";

        $record_total_perubahan = array();
        $subrecord_total_perubahan = array();

        $record_baris_perubahan = array();
        $subrecord_baris_perubahan = array();

        $no_perubahan = 1;

        $total_1 = 0;
        $total_2 = 0;
        $total_3 = 0;
        $total_4 = 0;
        $total_5 = 0;
        $total_6 = 0;
        $total_7 = 0;
        $total_8 = 0;

        $satker = $this->mod_struktur_apbd->satker()->result();

        if(COUNT($satker) > 0){
            foreach ($satker as $s) {
                $subrecord_baris_perubahan['no'] = $no_perubahan;
                $subrecord_baris_perubahan['kode'] = $s->kd_satker;
                $subrecord_baris_perubahan['singkatan'] = $s->singkatan;
                
                $rincian = $this->mod_struktur_apbd->rincian_struktur_anggaran($s->kd_satker, $thn, "perubahan");
                
                if(!empty($rincian)){
                    $subrecord_baris_perubahan['total_barang_jasa'] = $rincian['total_barang_jasa'] == 0 ? "-" : "Rp. ".number_format($rincian['total_barang_jasa']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total_modal'] = $rincian['total_modal'] == 0 ? "-" : "Rp. ".number_format($rincian['total_modal']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total_pegawai'] = $rincian['total_pegawai'] == 0 ? "-" : "Rp. ".number_format($rincian['total_pegawai']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total_hibah'] = $rincian['total_hibah'] == 0 ? "-" : "Rp. ".number_format($rincian['total_hibah']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total_bansos'] = $rincian['total_bansos'] == 0 ? "-" : "Rp. ".number_format($rincian['total_bansos']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total_tidak_terduga'] = $rincian['total_tidak_terduga'] == 0 ? "-" : "Rp. ".number_format($rincian['total_tidak_terduga']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total_dll'] = $rincian['total_dll'] == 0 ? "-" : "Rp. ".number_format($rincian['total_dll']/1000000000,2,',','.')." M";
                    $subrecord_baris_perubahan['total'] = $rincian['total'] == 0 ? "-" : "Rp. ".number_format($rincian['total']/1000000000,2,',','.')." M";

                    $total_1 += $rincian['total_barang_jasa'];
                    $total_2 += $rincian['total_modal'];
                    $total_3 += $rincian['total_pegawai'];
                    $total_4 += $rincian['total_hibah'];
                    $total_5 += $rincian['total_bansos'];
                    $total_6 += $rincian['total_tidak_terduga'];
                    $total_7 += $rincian['total_dll'];
                    $total_8 += $rincian['total'];
                } else {
                    $subrecord_baris_perubahan['total_barang_jasa'] = "-";
                    $subrecord_baris_perubahan['total_modal'] = "-";
                    $subrecord_baris_perubahan['total_pegawai'] = "-";
                    $subrecord_baris_perubahan['total_hibah'] = "-";
                    $subrecord_baris_perubahan['total_bansos'] = "-";
                    $subrecord_baris_perubahan['total_tidak_terduga'] = "-";
                    $subrecord_baris_perubahan['total_dll'] = "-";
                    $subrecord_baris_perubahan['total'] = "-";
                }

                $no_perubahan++;

                array_push($record_baris_perubahan, $subrecord_baris_perubahan);
            }

            $subrecord_total_perubahan['baris'] = $record_baris_perubahan;

            $subrecord_total_perubahan['total_1'] = $total_1 == 0 ? "-" : "Rp. ".number_format($total_1/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_2'] = $total_2 == 0 ? "-" : "Rp. ".number_format($total_2/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_3'] = $total_3 == 0 ? "-" : "Rp. ".number_format($total_3/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_4'] = $total_4 == 0 ? "-" : "Rp. ".number_format($total_4/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_5'] = $total_5 == 0 ? "-" : "Rp. ".number_format($total_5/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_6'] = $total_6 == 0 ? "-" : "Rp. ".number_format($total_6/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_7'] = $total_7 == 0 ? "-" : "Rp. ".number_format($total_7/1000000000,2,',','.')." M";
            $subrecord_total_perubahan['total_8'] = $total_8 == 0 ? "-" : "Rp. ".number_format($total_8/1000000000,2,',','.')." M";

            array_push($record_total_perubahan, $subrecord_total_perubahan);
        } else {
            array_push($record_baris_perubahan, $subrecord_baris_perubahan);
            array_push($record_total_perubahan, $subrecord_total_perubahan);
        }

        $subrecord['perubahan'] = $record_total_perubahan;

        array_push($record, $subrecord);

        echo json_encode($record);

        // $listdata= json_encode($record);

        // if ( ! write_file('./json/tabel_anggaran_satker_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json tabel_anggaran_satker_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json tabel_anggaran_satker_".$thn.".json");
        // }
    }

    public function satker_rincian_belanja($thn = 2021)
    {
        $record_total= array();
        $subrecord_total = array();

        $record_baris = array();
        $subrecord_baris = array();

        $no = 1;
        
        $total_murni = 0;
        $total_perubahan = 0;

        $satker = $this->mod_struktur_apbd->satker()->result();
        foreach ($satker as $s) {
            $subrecord_baris['no'] = $no;
            $subrecord_baris['kode'] = $s->kd_satker;
            $subrecord_baris['singkatan'] = $s->singkatan;
            $subrecord_baris['nama_satker'] = $s->nama_satker;

            $total_anggaran_murni = $this->mod_struktur_apbd->total_anggaran_murni($s->kd_satker, $thn);
            $subrecord_baris['total_anggaran_murni'] = $total_anggaran_murni['total'] == 0 ? "-" : "Rp. ".number_format($total_anggaran_murni['total'],0,',','.');
        
            $total_anggaran_perubahan = $this->mod_struktur_apbd->total_anggaran_perubahan($s->kd_satker, $thn);
            $subrecord_baris['total_anggaran_perubahan'] = $total_anggaran_perubahan['total'] == 0 ? "-" : "Rp. ".number_format($total_anggaran_perubahan['total'],0,',','.');

            $subrecord_baris['btn_uraian_murni'] = $total_anggaran_murni['total'] == 0 ? "-" : "<button class='btn btn-primary btn-xs' onclick='uraian(".$s->kd_satker.",\"murni\")'>Uraian</button>";
            $subrecord_baris['btn_uraian_perubahan'] = $total_anggaran_perubahan['total'] == 0 ? "-" : "<button class='btn btn-primary btn-xs' onclick='uraian(".$s->kd_satker.",\"perubahan\")'>Uraian</button>";
            
            $total_murni += $total_anggaran_murni['total'];
            $total_perubahan += $total_anggaran_perubahan['total'];

            $no++;

            array_push($record_baris, $subrecord_baris);
        }

        $subrecord_total['baris'] = $record_baris;

        $subrecord_total['total_murni'] = "Rp. ".number_format($total_murni,0,',','.');
        $subrecord_total['total_perubahan'] = "Rp. ".number_format($total_perubahan,0,',','.');

        array_push($record_total, $subrecord_total);

        echo json_encode($record_total);

        // $listdata= json_encode($record_total);

        // if ( ! write_file('./json/tabel_rincian_belanja_'.$thn.'.json', $listdata)){
        //     //save log
        //     $this->log_lib->log_info("Gagal membuat json tabel_rincian_belanja_".$thn.".json");
        // } else {
        //     //save log
        //     $this->log_lib->log_info("Membuat json tabel_rincian_belanja_".$thn.".json");
        // }
    }

    public function uraian($thn, $kode, $kelompok)
    {
        $record = array();
        $subrecord = array();

        $record_baris = array();
        $subrecord_baris = array();

        $satker = $this->mod_struktur_apbd->cek_satker($kode);

        $subrecord['kode_satker'] = $kode;
        $subrecord['nama_satker'] = $satker['nama_satker'];

        switch($kelompok)
        {
            case "murni" :  
                $program = $this->mod_struktur_apbd->program_murni($kode, $thn)->result();
                break;
            case "perubahan" :
                $program = $this->mod_struktur_apbd->program_perubahan($kode, $thn)->result();
                break;
        }
        
        foreach ($program as $p) {
            $subrecord_baris['bg'] = "bg-gray text-light";
            $subrecord_baris['kode_1'] = $p->kd_program;
            $subrecord_baris['kode_2'] = "";
            $subrecord_baris['kode_3'] = "";
            $subrecord_baris['nama'] = $p->nama_program ;
            $subrecord_baris['total'] = $p->total == 0 ? "-" : "Rp. ".number_format($p->total,0,',','.');
            $subrecord_baris['btn'] = "";
            array_push($record_baris, $subrecord_baris);

            switch($kelompok)
            {
                case "murni" :  
                    $kegiatan = $this->mod_struktur_apbd->kegiatan_murni($kode, $p->kd_program, $thn)->result();
                    break;
                case "perubahan" :
                    $kegiatan = $this->mod_struktur_apbd->kegiatan_perubahan($kode, $p->kd_program, $thn)->result();
                    break;
            }
            foreach ($kegiatan as $k) {
                $subrecord_baris['bg'] = "bg-gray-light";
                $subrecord_baris['kode_1'] = "";
                $subrecord_baris['kode_2'] = $k->kd_kegiatan;
                $subrecord_baris['kode_3'] = "";
                $subrecord_baris['nama'] = $k->nama_kegiatan;
                $subrecord_baris['total'] = $k->total == 0 ? "-" : "Rp. ".number_format($k->total,0,',','.');
                $subrecord_baris['btn'] = "";
                array_push($record_baris, $subrecord_baris);

                switch($kelompok)
                {
                    case "murni" :  
                        $subkegiatan = $this->mod_struktur_apbd->subkegiatan_murni($kode, $p->kd_program, $k->kd_kegiatan, $thn)->result();
                        break;
                    case "perubahan" :
                        $subkegiatan = $this->mod_struktur_apbd->subkegiatan_perubahan($kode, $p->kd_program, $k->kd_kegiatan, $thn)->result();
                        break;
                }
                foreach ($subkegiatan as $sk) {
                    $subrecord_baris['bg'] = "";
                    $subrecord_baris['kode_1'] = "";
                    $subrecord_baris['kode_2'] = "";
                    $subrecord_baris['kode_3'] = $sk->kd_subkegiatan;
                    $subrecord_baris['nama'] = $sk->nama_subkegiatan;
                    $subrecord_baris['total'] = $sk->total == 0 ? "-" : "Rp. ".number_format($sk->total,0,',','.');
                    $subrecord_baris['btn'] = $sk->total == 0 ? "-" : "<button class='btn btn-primary btn-xs' onclick='detail(\"".$sk->kd_subkegiatan."\",\"".$kelompok."\",\"".$kode."\")'>detail</button>";
                    array_push($record_baris, $subrecord_baris);
                }
            }
        }

        $subrecord['baris'] = $record_baris;

        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function detail($thn, $kode, $kodesatker, $kelompok)
    {
        $record = array();
        $subrecord = array();

        $record_baris = array();
        $subrecord_baris = array();

        $satker = $this->mod_struktur_apbd->cek_satker($kodesatker);

        $subrecord['kode_satker'] = $kodesatker;
        $subrecord['nama_satker'] = $satker['nama_satker'];

        switch ($kelompok) {
            case "murni":
                $info_apbd = $this->mod_struktur_apbd->info_apbd_murni($kode,$thn);
                $detail = $this->mod_struktur_apbd->detail_murni($kode,$thn)->result();
                break;
            case "perubahan":
                $info_apbd = $this->mod_struktur_apbd->info_apbd_perubahan($kode,$thn);
                $detail = $this->mod_struktur_apbd->detail_perubahan($kode,$thn)->result();
                break;
        }     

        $subrecord['program'] = $info_apbd['nama_program'];
        $subrecord['kegiatan'] = $info_apbd['nama_kegiatan'];
        $subrecord['subkegiatan'] = $info_apbd['nama_subkegiatan'];

        $total = 0;

        foreach ($detail as $d) {
            $subrecord_baris['kode'] = $d->kd_rekening;
            $subrecord_baris['rincian'] = $d->rincian;
            $subrecord_baris['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
            
            $total += $d->pagu;

            array_push($record_baris, $subrecord_baris);
        }

        $subrecord['baris'] = $record_baris;

        $subrecord['total'] = $total == 0 ? "-" : "Rp. ".number_format($total,0,',','.');

        array_push($record, $subrecord);

        echo json_encode($record);
    }
}