<?
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_laporan');
    }

    public function index()
    {
        $data['halaman'] = "Laporan";

        $kantor = $this->mod_laporan->kantor();
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
        $this->load->view('backend/page/laporan', $data);
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($laporan = "", $thn = "-", $kode_satker = "-", $kelompok = "-", $kode_cek= "-", $ang = "-")
    {
        if($laporan == ""){
            $laporan = $this->input->post('jenis');
            $thn = $this->input->post('thn');
        }
        // $hasil = $this->input->post('hasil');
        $hasil = "excel";

        $data['laporan'] = $laporan;
        $data['kelompok'] = $kelompok;
        $data['thn'] = $thn;

        $record = array();
        $subrecord = array();

        $record2 = array();
        $subrecord2 = array();

        $no = 1;

        $no2 = 1;

        switch ($laporan) {
            case 1:
                $data['judul'] = "Rekap Rencana Umum Pengadaan";

                $total_belanja_pengadaan = 0;
                $total_penyedia_paket = 0;
                $total_penyedia_anggaran = 0;
                $total_swakelola_paket = 0;
                $total_swakelola_anggaran = 0;
                $total_penyedia_dalam_swakelola_paket = 0;
                $total_penyedia_dalam_swakelola_anggaran = 0;
                $total_paket = 0;
                $total_anggaran = 0;

                $satker = $this->mod_laporan->satker()->result();
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;
                    $subrecord['kode'] = $s->kd_satker;
                    $subrecord['singkatan'] = $s->singkatan;

                    $rekapitulasi = $this->mod_laporan->rekapitulasi($s->kd_satker, $thn);

                    $subrecord['belanja_pengadaan'] = empty($rekapitulasi) || $rekapitulasi['belanja_pengadaan'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['belanja_pengadaan'],0,',','.');
                    $subrecord['penyedia_paket'] = empty($rekapitulasi) || $rekapitulasi['penyedia_paket'] == 0 ? "-" : number_format($rekapitulasi['penyedia_paket'],0,',','.');
                    $subrecord['penyedia_anggaran'] = empty($rekapitulasi) || $rekapitulasi['penyedia_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['penyedia_anggaran'],0,',','.');
                    $subrecord['swakelola_paket'] = empty($rekapitulasi) || $rekapitulasi['swakelola_paket'] == 0 ? "-" : number_format($rekapitulasi['swakelola_paket'],0,',','.');
                    $subrecord['swakelola_anggaran'] = empty($rekapitulasi) || $rekapitulasi['swakelola_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['swakelola_anggaran'],0,',','.');
                    $subrecord['penyedia_dalam_swakelola_paket'] = empty($rekapitulasi) || $rekapitulasi['penyedia_dalam_swakelola_paket'] == 0 ? "-" : number_format($rekapitulasi['penyedia_dalam_swakelola_paket'],0,',','.');
                    $subrecord['penyedia_dalam_swakelola_anggaran'] = empty($rekapitulasi) || $rekapitulasi['penyedia_dalam_swakelola_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['penyedia_dalam_swakelola_anggaran'],0,',','.');
                    $subrecord['paket'] = empty($rekapitulasi) || $rekapitulasi['total_paket'] == 0 ? "-" : number_format($rekapitulasi['total_paket'],0,',','.');
                    $subrecord['anggaran'] = empty($rekapitulasi) || $rekapitulasi['total_anggaran'] == 0 ? "-" : "Rp. ".number_format($rekapitulasi['total_anggaran'],0,',','.');
                    $subrecord['persentase'] = empty($rekapitulasi) || $rekapitulasi['persentase'] == 0 ? "-" : number_format($rekapitulasi['persentase'],2,',','.')."%";

                    // indikator warna
                    if(!empty($rekapitulasi)){
                        // if($rekapitulasi['persentase'] > 100){
                        //     $subrecord['warna'] = "bg-orange-active";
                        // } elseif ($rekapitulasi['persentase'] == 100 ) {
                        //     $subrecord['warna'] = "bg-green";
                        // } elseif ($rekapitulasi['persentase'] > 60 and $rekapitulasi['persentase'] <=99 ) {
                        //     $subrecord['warna'] = "bg-light-yellow";
                        // } elseif ($rekapitulasi['persentase'] > 40 and $rekapitulasi['persentase'] <=60 ) {
                        //     $subrecord['warna'] = "bg-light-maroon";
                        // } elseif ($rekapitulasi['persentase'] > 0 and $rekapitulasi['persentase'] <= 40 ) {
                        //     $subrecord['warna'] = "bg-maroon-active";
                        // }
                        $subrecord['warna'] = "";

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
                        $subrecord['warna'] = "bg-gray";
                    }

                    $no++;

                    array_push($record, $subrecord);
                }

                $data['total_belanja_pengadaan'] = $total_belanja_pengadaan == 0 ? "-" : "Rp. ".number_format($total_belanja_pengadaan,0,',','.');
                $data['total_penyedia_paket'] = $total_penyedia_paket == 0 ? "-" : number_format($total_penyedia_paket,0,',','.');
                $data['total_penyedia_anggaran'] = $total_penyedia_anggaran == 0 ? "-" : "Rp. ".number_format($total_penyedia_anggaran,0,',','.');
                $data['total_swakelola_paket'] = $total_swakelola_paket == 0 ? "-" : number_format($total_swakelola_paket,0,',','.');
                $data['total_swakelola_anggaran'] = $total_swakelola_anggaran == 0 ? "-" : "Rp. ".number_format($total_swakelola_anggaran,0,',','.');
                $data['total_penyedia_dalam_swakelola_paket'] = $total_penyedia_dalam_swakelola_paket == 0 ? "-" : number_format($total_penyedia_dalam_swakelola_paket,0,',','.');
                $data['total_penyedia_dalam_swakelola_anggaran'] = $total_penyedia_dalam_swakelola_anggaran == 0 ? "-" : "Rp. ".number_format($total_penyedia_dalam_swakelola_anggaran,0,',','.');
                $data['total_paket'] = $total_paket == 0 ? "-" : number_format($total_paket,0,',','.');
                $data['total_anggaran'] = $total_anggaran == 0 ? "-" : "Rp. ".number_format($total_anggaran,0,',','.');
                break;
            case 2:
                $data['judul'] = "Rekap Tender Per-Metode Pemilihan Penyedia";

                $total_rup_paket = 0;
                $total_rup_anggaran = 0;
                $total_proses_paket = 0;
                $total_proses_anggaran = 0;
                $total_selesai_paket = 0;
                $total_selesai_anggaran = 0;
                $total_selesai_nilai = 0;
                $total_hemat_anggaran = 0;

                $metode = $this->mod_laporan->metode_tender($thn)->result();
                foreach ($metode as $m) {
                    $subrecord['no'] = $no;
                    $subrecord['metode'] = $m->metode;
                    $subrecord['rup_paket'] = $m->rup_paket == 0 ? "-" : number_format($m->rup_paket,0,',','.');
                    $subrecord['rup_anggaran'] = $m->rup_anggaran == 0 ? "-" : "Rp. ".number_format($m->rup_anggaran,0,',','.');
                    $subrecord['proses_paket'] = $m->proses_paket == 0 ? "-" : number_format($m->proses_paket,0,',','.');
                    $subrecord['proses_anggaran'] = $m->proses_anggaran == 0 ? "-" : "Rp. ".number_format($m->proses_anggaran,0,',','.');
                    $subrecord['selesai_paket'] = $m->selesai_paket == 0 ? "-" : number_format($m->selesai_paket,0,',','.');
                    $subrecord['selesai_anggaran'] = $m->selesai_anggaran == 0 ? "-" : "Rp. ".number_format($m->selesai_anggaran,0,',','.');
                    $subrecord['selesai_nilai'] = $m->selesai_nilai == 0 ? "-" : "Rp. ".number_format($m->selesai_nilai,0,',','.');
                    $subrecord['hemat_anggaran'] = $m->hemat_anggaran == 0 ? "-" : "Rp. ".number_format($m->hemat_anggaran,0,',','.');
                    $subrecord['hemat_persen'] = $m->hemat_persen == 0 ? "-" : number_format($m->hemat_persen,2,',','.')."%";

                    $total_rup_paket += $m->rup_paket;
                    $total_rup_anggaran += $m->rup_anggaran;
                    $total_proses_paket += $m->proses_paket;
                    $total_proses_anggaran += $m->proses_anggaran;
                    $total_selesai_paket += $m->selesai_paket;
                    $total_selesai_anggaran += $m->selesai_anggaran;
                    $total_selesai_nilai += $m->selesai_nilai;
                    $total_hemat_anggaran += $m->hemat_anggaran;

                    $no++;

                    array_push($record, $subrecord);
                }

                $data['total_rup_paket'] = $total_rup_paket == 0 ? "-" : number_format($total_rup_paket,0,',','.');
                $data['total_rup_anggaran'] = $total_rup_anggaran == 0 ? "-" : "Rp. ".number_format($total_rup_anggaran,0,',','.');
                $data['total_proses_paket'] = $total_proses_paket == 0 ? "-" : number_format($total_proses_paket,0,',','.');
                $data['total_proses_anggaran'] = $total_proses_anggaran == 0 ? "-" : "Rp. ".number_format($total_proses_anggaran,0,',','.');
                $data['total_selesai_paket'] = $total_selesai_paket == 0 ? "-" : number_format($total_selesai_paket,0,',','.');
                $data['total_selesai_anggaran'] = $total_selesai_anggaran == 0 ? "-" : "Rp. ".number_format($total_selesai_anggaran,0,',','.');
                $data['total_selesai_nilai'] = $total_selesai_nilai == 0 ? "-" : "Rp. ".number_format($total_selesai_nilai,0,',','.');
                $data['total_hemat_anggaran'] = $total_hemat_anggaran == 0 ? "-" : "Rp. ".number_format($total_hemat_anggaran,0,',','.');
                break;
            case 3:
                $data['judul'] = "Rekap Tender Per-Satuan Kerja";

                $total_paket = 0;
                $total_pengadaan_barang = 0;
                $total_jasa_konsultasi = 0;
                $total_jasa_lainnya = 0;
                $total_pekerjaan_konstruksi = 0;
                $total_pagu_anggaran = $this->mod_laporan->total_anggaran_tender($thn);

                $satker = $this->mod_laporan->temp_tender_rekapitulasi_satker($thn)->result();
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;

                    $cek_satker = $this->mod_laporan->cek_satker($s->kd_satker);
                    $subrecord['singkatan'] = $cek_satker['singkatan'];

                    $subrecord['paket'] = $s->paket == 0 ? "-" : number_format($s->paket,0,',','.');
                    $subrecord['pengadaan_barang'] = $s->pengadaan_barang == 0 ? "-" : "Rp. ".number_format($s->pengadaan_barang,0,',','.');
                    $subrecord['jasa_konsultasi'] = $s->jasa_konsultasi == 0 ? "-" : "Rp. ".number_format($s->jasa_konsultasi,0,',','.');
                    $subrecord['jasa_lainnya'] = $s->jasa_lainnya == 0 ? "-" : "Rp. ".number_format($s->jasa_lainnya,0,',','.');
                    $subrecord['pekerjaan_konstruksi'] = $s->pekerjaan_konstruksi == 0 ? "-" : "Rp. ".number_format($s->pekerjaan_konstruksi,0,',','.');

                    $subrecord['total'] = $s->total == 0 ? "-" : "Rp. ".number_format($s->total,0,',','.');
                    if($total_pagu_anggaran['total'] != 0){
                        $persen = ($s->total / $total_pagu_anggaran['total']) * 100;
                    } else {
                        $persen = 0;
                    }
                    $subrecord['persen'] = $persen == 0 ? "-" : number_format($persen,2,',','.')."%";

                    $total_paket += $s->paket;
                    $total_pengadaan_barang += $s->pengadaan_barang;
                    $total_jasa_konsultasi += $s->jasa_konsultasi;
                    $total_jasa_lainnya += $s->jasa_lainnya;
                    $total_pekerjaan_konstruksi += $s->pekerjaan_konstruksi;

                    $no++;

                    array_push($record, $subrecord);
                }

                $data['total_paket'] = $total_paket == 0 ? "-" : number_format($total_paket,0,',','.');
                $data['total_pengadaan_barang'] = $total_pengadaan_barang == 0 ? "-" : "Rp. ".number_format($total_pengadaan_barang,0,',','.');
                $data['total_jasa_konsultasi'] = $total_jasa_konsultasi == 0 ? "-" : "Rp. ".number_format($total_jasa_konsultasi,0,',','.');
                $data['total_jasa_lainnya'] = $total_jasa_lainnya == 0 ? "-" : "Rp. ".number_format($total_jasa_lainnya,0,',','.');
                $data['total_pekerjaan_konstruksi'] = $total_pekerjaan_konstruksi == 0 ? "-" : "Rp. ".number_format($total_pekerjaan_konstruksi,0,',','.');
                $data['total'] = $total_pagu_anggaran['total'] == 0 ? "-" : "Rp. ".number_format($total_pagu_anggaran['total'],0,',','.');
                break;
            case 4:
                $data['judul'] = "Rincian Tender (".ucwords($kelompok).")";

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

                switch ($kelompok) {
                    case 'total':
                        $data['rowspan'] = "rowspan=2";
        
                        $qkelompok = "(a.nama_status_tender='aktif' OR a.nama_status_tender='batal' OR a.nama_status_tender='gagal')";
                        break;
                    case 'selesai':
                        $data['rowspan'] = "rowspan=2";
        
                        $qkelompok = "a.nama_status_tender='aktif' AND a.nilai_negosiasi>'0'";
                        break;
                    case 'berjalan':
                        $data['rowspan'] = "";
        
                        $qkelompok = "a.nama_status_tender='aktif' AND (a.nilai_negosiasi='0' OR a.nilai_negosiasi IS NULL)";
                        break;
                    case 'batal':
                        $data['rowspan'] = "";
        
                        $qkelompok = "a.nama_status_tender='batal'";
                        break;
                }

                $rincian = $this->mod_laporan->rincian_tender($thn,$qcari,$qkelompok)->result();
                foreach ($rincian as $r) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_paket'] = $r->kd_paket;
                    $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "0" || $r->kd_rup_paket == "" ? "-" :$r->kd_rup_paket;
                    $subrecord['satker'] = $r->nama_satker;
        
                    $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                    $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : strtoupper($rup_penyedia['kegiatan']);
        
                    $subrecord['jml_teks'] = strlen($r->nama_paket);
                    $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
        
                    $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                    $subrecord['ppk'] = empty($pegawai) ? "-":$pegawai['nama_pegawai'];
        
                    $subrecord['sumber_dana'] = $r->ang;
        
                    $subrecord['tanggal_pembuatan'] = strtotime($r->tgl_buat_paket) > 0 || $r->tgl_buat_paket == "" ? "-" : date('d-m-Y',strtotime($r->tgl_buat_paket));
                    $subrecord['tanggal_penetapan_pemenang'] = strtotime($r->tgl_penetapan_pemenang) > 0 || $r->tgl_penetapan_pemenang == "" ? "-" : date('d-m-Y',strtotime($r->tgl_penetapan_pemenang));
                    $subrecord['tanggal_ttd_kontrak'] = strtotime($r->tgl_ttd_kontrak) > 0 || $r->tgl_ttd_kontrak == "" ? "-" : date('d-m-Y',strtotime($r->tgl_ttd_kontrak));
        
                    // cek tahapan tender
                    $tahapan = $this->mod_laporan->tahapan($r->kd_tender);
                    $subrecord['tahapan'] = empty($tahapan) || $tahapan['tahapan'] == "" ? "-" : $tahapan['tahapan'];
        
                    $subrecord['tanggal_pengumuman_tender'] = date('d-m-Y',strtotime($r->tgl_pengumuman_tender));
                    $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                    $subrecord['hps'] = $r->hps == 0 ? "-" : "Rp. ".number_format($r->hps,0,',','.');
                    $subrecord['nilai_hasil_tender'] = $r->nilai_negosiasi == 0 ? "-" : "Rp. ".number_format($r->nilai_negosiasi,0,',','.');
                    $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');
                    
                    if($r->nilai_negosiasi > 0){
                        $nilai_optimalisasi = $r->pagu - $r->nilai_negosiasi;
                        $persen_optimalisasi = ($nilai_optimalisasi / $r->pagu) * 100;
                    } else {
                        $nilai_optimalisasi = 0;
                        $persen_optimalisasi = 0;
                    }
        
                    $subrecord['nilai_optimalisasi'] =  $nilai_optimalisasi == 0 ? "-" : "Rp. ".number_format($nilai_optimalisasi,0,',','.');
                    $subrecord['persen_optimalisasi'] = $persen_optimalisasi == 0 ? "-" : number_format($persen_optimalisasi,2,',','.')."%";
        
                    $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    $subrecord['domisili'] = empty($penyedia) || $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];
        
                    $subrecord['status'] = "";
                    $subrecord['alasan_batal'] =strip_tags(htmlentities(preg_replace('~[\r\n]+~', '',$r->ket_ditutup)));
                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 5:
                $data['judul'] = "Rekap Non Tender Per-Metode Pemilihan Penyedia";
                
                $total_rup_paket = 0;
                $total_rup_anggaran = 0;
                $total_proses_paket = 0;
                $total_proses_anggaran = 0;
                $total_selesai_paket = 0;
                $total_selesai_anggaran = 0;
                $total_selesai_nilai = 0;
                $total_hemat_anggaran = 0;

                $metode = $this->mod_laporan->metode_nontender($thn)->result();
                foreach ($metode as $m) {
                    $subrecord['no'] = $no;
                    $subrecord['metode'] = $m->metode;
                    $subrecord['rup_paket'] = $m->rup_paket == 0 ? "-" : number_format($m->rup_paket,0,',','.');
                    $subrecord['rup_anggaran'] = $m->rup_anggaran == 0 ? "-" : "Rp. ".number_format($m->rup_anggaran,0,',','.');
                    $subrecord['proses_paket'] = $m->proses_paket == 0 ? "-" : number_format($m->proses_paket,0,',','.');
                    $subrecord['proses_anggaran'] = $m->proses_anggaran == 0 ? "-" : "Rp. ".number_format($m->proses_anggaran,0,',','.');
                    $subrecord['selesai_paket'] = $m->selesai_paket == 0 ? "-" : number_format($m->selesai_paket,0,',','.');
                    $subrecord['selesai_anggaran'] = $m->selesai_anggaran == 0 ? "-" : "Rp. ".number_format($m->selesai_anggaran,0,',','.');
                    $subrecord['selesai_nilai'] = $m->selesai_nilai == 0 ? "-" : "Rp. ".number_format($m->selesai_nilai,0,',','.');
                    $subrecord['hemat_anggaran'] = $m->hemat_anggaran == 0 ? "-" : "Rp. ".number_format($m->hemat_anggaran,0,',','.');
                    $subrecord['hemat_persen'] = $m->hemat_persen == 0 ? "-" : number_format($m->hemat_persen,2,',','.')."%";

                    $total_rup_paket += $m->rup_paket;
                    $total_rup_anggaran += $m->rup_anggaran;
                    $total_proses_paket += $m->proses_paket;
                    $total_proses_anggaran += $m->proses_anggaran;
                    $total_selesai_paket += $m->selesai_paket;
                    $total_selesai_anggaran += $m->selesai_anggaran;
                    $total_selesai_nilai += $m->selesai_nilai;
                    $total_hemat_anggaran += $m->hemat_anggaran;

                    $no++;

                    array_push($record, $subrecord);
                }

                $data['total_rup_paket'] = $total_rup_paket == 0 ? "-" : number_format($total_rup_paket,0,',','.');
                $data['total_rup_anggaran'] = $total_rup_anggaran == 0 ? "-" : "Rp. ".number_format($total_rup_anggaran,0,',','.');
                $data['total_proses_paket'] = $total_proses_paket == 0 ? "-" : number_format($total_proses_paket,0,',','.');
                $data['total_proses_anggaran'] = $total_proses_anggaran == 0 ? "-" : "Rp. ".number_format($total_proses_anggaran,0,',','.');
                $data['total_selesai_paket'] = $total_selesai_paket == 0 ? "-" : number_format($total_selesai_paket,0,',','.');
                $data['total_selesai_anggaran'] = $total_selesai_anggaran == 0 ? "-" : "Rp. ".number_format($total_selesai_anggaran,0,',','.');
                $data['total_selesai_nilai'] = $total_selesai_nilai == 0 ? "-" : "Rp. ".number_format($total_selesai_nilai,0,',','.');
                $data['total_hemat_anggaran'] = $total_hemat_anggaran == 0 ? "-" : "Rp. ".number_format($total_hemat_anggaran,0,',','.');
                // end
                break;
            case 6:
                $data['judul'] = "Rekap Non Tender Per-Satuan Kerja";

                $total_paket = 0;
                $total_pengadaan_barang = 0;
                $total_jasa_konsultasi = 0;
                $total_jasa_lainnya = 0;
                $total_pekerjaan_konstruksi = 0;
                $total_pagu_anggaran = $this->mod_laporan->total_anggaran_nontender($thn);
        
                $satker = $this->mod_laporan->temp_nontender_rekapitulasi_satker($thn)->result();
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;
        
                    $cek_satker = $this->mod_laporan->cek_satker($s->kd_satker);
                    $subrecord['singkatan'] = $cek_satker['singkatan'];
        
                    $subrecord['paket'] = $s->paket == 0 ? "-" : number_format($s->paket,0,',','.');
                    $subrecord['pengadaan_barang'] = $s->pengadaan_barang == 0 ? "-" : "Rp. ".number_format($s->pengadaan_barang,0,',','.');
                    $subrecord['jasa_konsultasi'] = $s->jasa_konsultasi == 0 ? "-" : "Rp. ".number_format($s->jasa_konsultasi,0,',','.');
                    $subrecord['jasa_lainnya'] = $s->jasa_lainnya == 0 ? "-" : "Rp. ".number_format($s->jasa_lainnya,0,',','.');
                    $subrecord['pekerjaan_konstruksi'] = $s->pekerjaan_konstruksi == 0 ? "-" : "Rp. ".number_format($s->pekerjaan_konstruksi,0,',','.');
        
                    $subrecord['total'] = $s->total == 0 ? "-" : "Rp. ".number_format($s->total,0,',','.');
                    if($total_pagu_anggaran['total'] != 0){
                        $persen = ($s->total / $total_pagu_anggaran['total']) * 100;
                    } else {
                        $persen = 0;
                    }
                    $subrecord['persen'] =  $persen == 0 ? "-" : number_format($persen,2,',','.')."%";
        
                    $total_paket += $s->paket;
                    $total_pengadaan_barang += $s->pengadaan_barang;
                    $total_jasa_konsultasi += $s->jasa_konsultasi;
                    $total_jasa_lainnya += $s->jasa_lainnya;
                    $total_pekerjaan_konstruksi += $s->pekerjaan_konstruksi;
        
                    $no++;
        
                    array_push($record, $subrecord);
                }
        
                $data['total_paket'] = $total_paket == 0 ? "-" : number_format($total_paket,0,',','.');
                $data['total_pengadaan_barang'] = $total_pengadaan_barang == 0 ? "-" : "Rp. ".number_format($total_pengadaan_barang,0,',','.');
                $data['total_jasa_konsultasi'] = $total_jasa_konsultasi == 0 ? "-" : "Rp. ".number_format($total_jasa_konsultasi,0,',','.');
                $data['total_jasa_lainnya'] = $total_jasa_lainnya == 0 ? "-" : "Rp. ".number_format($total_jasa_lainnya,0,',','.');
                $data['total_pekerjaan_konstruksi'] = $total_pekerjaan_konstruksi == 0 ? "-" : "Rp. ".number_format($total_pekerjaan_konstruksi,0,',','.');
                $data['total'] = $total_pagu_anggaran['total'] == 0 ? "-" : "Rp. ".number_format($total_pagu_anggaran['total'],0,',','.');
                break;
            case 7:
                $data['judul'] = "Rincian Non Tender (".ucwords($kelompok).")";

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

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

                $rincian = $this->mod_laporan->rincian_nontender($thn, $qcari, $qkelompok)->result();
                foreach ($rincian as $r) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "0" || $r->kd_rup_paket == "" ? "-" :$r->kd_rup_paket;
                    $subrecord['satker'] = $r->nama_satker;

                    $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                    $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : strtoupper($rup_penyedia['kegiatan']);

                    $subrecord['jml_teks'] = strlen($r->nama_paket);
                    $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));

                    $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                    $subrecord['ppk'] = empty($rup_penyedia) || $pegawai['nama_pegawai'];

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

                    $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    $subrecord['domisili'] = empty($penyedia) || $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];

                    $subrecord['status'] = "";
                    $subrecord['alasan_batal'] =strip_tags(htmlentities(preg_replace('~[\r\n]+~', '',$r->ket_ditutup)));

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 8:
                $data['judul'] = "Rincian ePurchasing";

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

                $daftar = $this->mod_laporan->epurchasing($thn,$qcari)->result();
                foreach ($daftar as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_rup_paket'] = $d->rup_id;
                    $subrecord['satker'] = $d->nama_satker;

                    $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($d->rup_id);
                    $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

                    $subrecord['nama_paket'] = $d->nama_paket;

                    $pegawai = $this->mod_laporan->cek_pegawai($d->ppk_nip);
                    $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-" : $pegawai['nama_pegawai'];

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
                break;
            case 9:
                $data['judul'] = "Rincian Pencatatan Non Tender";

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

                $daftar = $this->mod_laporan->pencatatan_nontender($thn,$qcari)->result();
                foreach ($daftar as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_rup_paket'] = $d->kd_rup_paket;
                    $subrecord['satker'] = $d->nama_satker;

                    $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($d->kd_rup_paket);
                    $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

                    $subrecord['nama_paket'] = $d->nama_paket;

                    $pegawai = $this->mod_laporan->cek_pegawai($d->nip_ppk);
                    $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

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

                    $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    $subrecord['domisili'] = empty($penyedia) || $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];

                    $subrecord['uraian'] = $d->uraian_pekerjaan == "" ? "-" : htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->uraian_pekerjaan)));

                    $subrecord['keterangan'] = $d->keterangan == "" ? "-" : $d->keterangan;

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 10:
                $data['judul'] = "Rincian Pencatatan Swakelola";

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

                $daftar = $this->mod_laporan->pencatatan_swakelola($thn,$qcari)->result();
                foreach ($daftar as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_rup_paket'] = $d->kd_rup_paket;
                    $subrecord['satker'] = $d->nama_satker;

                    $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($d->kd_rup_paket);
                    $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

                    $subrecord['nama_paket'] = $d->nama_paket;

                    $pegawai = $this->mod_laporan->cek_pegawai($d->nip_ppk);
                    $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

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

                    $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                    $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    $subrecord['domisili'] = empty($penyedia) || $penyedia['kabupaten_kota'] == "" ? "-" : $penyedia['kabupaten_kota'];

                    $subrecord['uraian'] = $d->uraian_pekerjaan == "" ? "-" : htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->uraian_pekerjaan)));
                    
                    $subrecord['keterangan'] = $d->keterangan == "" ? "-" : $d->keterangan;

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 11:
                $data['judul'] = "Rekapitulasi Pengadaan Barang/Jasa";

                $total_rup_paket = 0;
                $total_rup_anggaran = 0;
                $total_proses_paket = 0;
                $total_proses_anggaran = 0;
                $total_selesai_paket = 0;
                $total_selesai_anggaran = 0;
                $total_selesai_nilai = 0;
                $total_hemat_anggaran = 0;

                $tender = $this->mod_laporan->tender_rekapitulasi_metode($thn)->result();
                foreach ($tender as $t) {
                    $subrecord['no'] = $no;
                    $subrecord['metode'] = $t->metode;
                    $subrecord['rup_paket'] = $t->rup_paket == 0 ? "-" : number_format($t->rup_paket,0,',','.');
                    $subrecord['rup_anggaran'] = $t->rup_anggaran == 0 ? "-" : "Rp. ".number_format($t->rup_anggaran,0,',','.');
                    $subrecord['proses_paket'] = $t->proses_paket == 0 ? "-" : number_format($t->proses_paket,0,',','.');
                    $subrecord['proses_anggaran'] = $t->proses_anggaran == 0 ? "-" : "Rp. ".number_format($t->proses_anggaran,0,',','.');
                    $subrecord['selesai_paket'] = $t->selesai_paket == 0 ? "-" : number_format($t->selesai_paket,0,',','.');
                    $subrecord['selesai_anggaran'] = $t->selesai_anggaran == 0 ? "-" : "Rp. ".number_format($t->selesai_anggaran,0,',','.');
                    $subrecord['selesai_nilai'] = $t->selesai_nilai == 0 ? "-" : "Rp. ".number_format($t->selesai_nilai,0,',','.');
                    $subrecord['hemat_anggaran'] = $t->hemat_anggaran == 0 ? "-" : "Rp. ".number_format($t->hemat_anggaran,0,',','.');
                    $subrecord['hemat_persen'] = $t->hemat_persen == 0 ? "-" : number_format($t->hemat_persen,2,',','.')."%";

                    $total_rup_paket += $t->rup_paket;
                    $total_rup_anggaran += $t->rup_anggaran;
                    $total_proses_paket += $t->proses_paket;
                    $total_proses_anggaran += $t->proses_anggaran;
                    $total_selesai_paket += $t->selesai_paket;
                    $total_selesai_anggaran += $t->selesai_anggaran;
                    $total_selesai_nilai += $t->selesai_nilai;
                    $total_hemat_anggaran += $t->hemat_anggaran;

                    $no++;

                    array_push($record, $subrecord);
                }

                $data['total_rup_paket'] = $total_rup_paket == 0 ? "-" : number_format($total_rup_paket,0,',','.');
                $data['total_rup_anggaran'] = $total_rup_anggaran == 0 ? "-" : "Rp. ".number_format($total_rup_anggaran,0,',','.');
                $data['total_proses_paket'] = $total_proses_paket == 0 ? "-" : number_format($total_proses_paket,0,',','.');
                $data['total_proses_anggaran'] = $total_proses_anggaran == 0 ? "-" : "Rp. ".number_format($total_proses_anggaran,0,',','.');
                $data['total_selesai_paket'] = $total_selesai_paket == 0 ? "-" : number_format($total_selesai_paket,0,',','.');
                $data['total_selesai_anggaran'] = $total_selesai_anggaran == 0 ? "-" : "Rp. ".number_format($total_selesai_anggaran,0,',','.');
                $data['total_selesai_nilai'] = $total_selesai_nilai == 0 ? "-" : "Rp. ".number_format($total_selesai_nilai,0,',','.');
                $data['total_hemat_anggaran'] = $total_hemat_anggaran == 0 ? "-" : "Rp. ".number_format($total_hemat_anggaran,0,',','.');

                $total_rup_paket2 = 0;
                $total_rup_anggaran2 = 0;
                $total_proses_paket2 = 0;
                $total_proses_anggaran2 = 0;
                $total_selesai_paket2 = 0;
                $total_selesai_anggaran2 = 0;
                $total_selesai_nilai2 = 0;
                $total_hemat_anggaran2 = 0;

                $nontender = $this->mod_laporan->nontender_rekapitulasi_metode($thn);
                $subrecord2['no'] = 1;
                $subrecord2['metode'] = "Non Tender";
                $subrecord2['rup_paket'] = empty($nontender) || $nontender['total_rup_paket'] == 0 ? "-" : number_format($nontender['total_rup_paket'],0,',','.');
                $subrecord2['rup_anggaran'] = empty($nontender) || $nontender['total_rup_anggaran'] == 0 ? "-" : "Rp. ".number_format($nontender['total_rup_anggaran'],0,',','.');
                $subrecord2['proses_paket'] = empty($nontender) || $nontender['total_proses_paket'] == 0 ? "-" : number_format($nontender['total_proses_paket'],0,',','.');
                $subrecord2['proses_anggaran'] = empty($nontender) || $nontender['total_proses_anggaran'] == 0 ? "-" : "Rp. ".number_format($nontender['total_proses_anggaran'],0,',','.');
                $subrecord2['selesai_paket'] = empty($nontender) || $nontender['total_selesai_paket'] == 0 ? "-" : number_format($nontender['total_selesai_paket'],0,',','.');
                $subrecord2['selesai_anggaran'] = empty($nontender) || $nontender['total_selesai_anggaran'] == 0 ? "-" : "Rp. ".number_format($nontender['total_selesai_anggaran'],0,',','.');
                $subrecord2['selesai_nilai'] = empty($nontender) || $nontender['total_selesai_nilai'] == 0 ? "-" : "Rp. ".number_format($nontender['total_selesai_nilai'],0,',','.');
                $subrecord2['hemat_anggaran'] = empty($nontender) || $nontender['total_hemat_anggaran'] == 0 ? "-" : "Rp. ".number_format($nontender['total_hemat_anggaran'],0,',','.');
                $subrecord2['hemat_persen'] = empty($nontender) || $nontender['total_hemat_anggaran'] == 0 ? "-" : number_format($nontender['total_hemat_persen'],2,',','.')."%";

                if(!empty($nontender)){
                    $total_rup_paket += $nontender['total_rup_paket'];
                    $total_rup_anggaran += $nontender['total_rup_anggaran'];
                    $total_proses_paket += $nontender['total_proses_paket'];
                    $total_proses_anggaran += $nontender['total_proses_anggaran'];
                    $total_selesai_paket += $nontender['total_selesai_paket'];
                    $total_selesai_anggaran += $nontender['total_selesai_anggaran'];
                    $total_selesai_nilai += $nontender['total_selesai_nilai'];
                    $total_hemat_anggaran += $nontender['total_hemat_anggaran'];
                } 

                array_push($record2, $subrecord2);

                // $epurchasing = $this->mod_laporan->tender_rekapitulasi_epurchasing($thn);
                $subrecord2['no'] = 2;
                $subrecord2['metode'] = "e-Purchasing";
                $rup_pct_epurchasing = $this->mod_laporan->rekapitulasi_pencatatan_epurchasing($thn);
                $subrecord2['rup_paket'] = empty($rup_pct_epurchasing) || $rup_pct_epurchasing['jml'] == 0 ? "-" : number_format($rup_pct_epurchasing['jml'],0,',','.');
                $subrecord2['rup_anggaran'] = empty($rup_pct_epurchasing) || $rup_pct_epurchasing['total'] == 0 ? "-" : "Rp. ".number_format($rup_pct_epurchasing['total'],0,',','.');

                $proses_pct_epurchasing = $this->mod_laporan->rekapitulasi_proses_epurchasing($thn);
                $subrecord2['proses_paket'] = empty($proses_pct_epurchasing) || $proses_pct_epurchasing['jml'] == 0 ? "-" : number_format($proses_pct_epurchasing['jml'],0,',','.');
                $subrecord2['proses_anggaran'] = empty($proses_pct_epurchasing) || $proses_pct_epurchasing['total'] == 0 ? "-" : "Rp. ".number_format($proses_pct_epurchasing['total'],0,',','.');

                $selesai_pct_epurchasing = $this->mod_laporan->rekapitulasi_selesai_epurchasing($thn);
                $subrecord2['selesai_paket'] = empty($selesai_pct_epurchasing) || $selesai_pct_epurchasing['jml'] == 0 ? "-" : number_format($selesai_pct_epurchasing['jml'],0,',','.');
                $subrecord2['selesai_anggaran'] = empty($selesai_pct_epurchasing) || $selesai_pct_epurchasing['total_pagu'] == 0 ? "-" : "Rp. ".number_format($selesai_pct_epurchasing['total_pagu'],0,',','.');
                $subrecord2['selesai_nilai'] = empty($selesai_pct_epurchasing) || $selesai_pct_epurchasing['total_nilai_negosiasi'] == 0 ? "-" : "Rp. ".number_format($selesai_pct_epurchasing['total_nilai_negosiasi'],0,',','.');

                $hemat_anggaran_epurchasing = empty($selesai_pct_epurchasing) ? 0 : $selesai_pct_epurchasing['total_pagu'] - $selesai_pct_epurchasing['total_nilai_negosiasi'];
                if(!empty($selesai_pct_epurchasing) && $selesai_pct_epurchasing['total_pagu'] != 0){
                    $hemat_persen_epurchasing =  ($hemat_anggaran_epurchasing / $selesai_pct_epurchasing['total_pagu']) * 100;
                }else{
                    $hemat_persen_epurchasing = 0;
                }
                $subrecord2['hemat_anggaran'] = $hemat_anggaran_epurchasing == 0 ? "-" : "Rp. ".number_format($hemat_anggaran_epurchasing,0,',','.');
                $subrecord2['hemat_persen'] = $hemat_persen_epurchasing == 0 ? "-" : number_format($hemat_persen_epurchasing,2,',','.')."%";


                $total_rup_paket += $rup_pct_epurchasing['jml'];
                $total_rup_anggaran += $rup_pct_epurchasing['total'];
                $total_proses_paket += $proses_pct_epurchasing['jml'];
                $total_proses_anggaran += $proses_pct_epurchasing['total'];
                $total_selesai_paket += $selesai_pct_epurchasing['jml'];
                $total_selesai_anggaran += $selesai_pct_epurchasing['total_pagu'];
                $total_selesai_nilai += $selesai_pct_epurchasing['total_nilai_negosiasi'];
                $total_hemat_anggaran += $hemat_anggaran_epurchasing;

                array_push($record2, $subrecord2);

                $subrecord2['no'] = 3;
                $subrecord2['metode'] = "Pencatatan Non Tender";
                $rup_pct_nontender = $this->mod_laporan->rekapitulasi_pencatatan_nontender($thn);
                $subrecord2['rup_paket'] = empty($rup_pct_nontender) || $rup_pct_nontender['jml'] == 0 ? "-" : number_format($rup_pct_nontender['jml'],0,',','.');
                $subrecord2['rup_anggaran'] = empty($rup_pct_nontender) || $rup_pct_nontender['total'] == 0 ? "-" : "Rp. ".number_format($rup_pct_nontender['total'],0,',','.');
                $subrecord2['proses_paket'] = "-";
                $subrecord2['proses_anggaran'] = "-";
                $subrecord2['selesai_paket'] = "-";
                $subrecord2['selesai_anggaran'] = "-";
                $subrecord2['selesai_nilai'] = "-";
                $subrecord2['hemat_anggaran'] = "-";
                $subrecord2['hemat_persen'] = "-";

                if(!empty($rup_pct_nontender)){
                    $total_rup_paket += $rup_pct_nontender['jml'];
                    $total_rup_anggaran += $rup_pct_nontender['total'];
                    // $total_proses_paket += $proses_pct_epurchasing['jml'];
                    // $total_proses_anggaran += $proses_pct_epurchasing['total'];
                    // $total_selesai_paket += $selesai_pct_epurchasing['jml'];
                    // $total_selesai_anggaran += $selesai_pct_epurchasing['total_pagu'];
                    // $total_selesai_nilai += $selesai_pct_epurchasing['total_nilai_negosiasi'];
                    // $total_hemat_anggaran += $hemat_anggaran_epurchasing;
                }

                array_push($record2, $subrecord2);

                $subrecord2['no'] = 4;
                $subrecord2['metode'] = "Pencatatan Swakelola";
                $rup_pct_swakelola = $this->mod_laporan->rekapitulasi_pencatatan_swakelola($thn);
                $subrecord2['rup_paket'] = empty($rup_pct_swakelola) || $rup_pct_swakelola['jml'] == 0 ? "-" : number_format($rup_pct_swakelola['jml'],0,',','.');
                $subrecord2['rup_anggaran'] = empty($rup_pct_swakelola) || $rup_pct_swakelola['total'] == 0 ? "-" : "Rp. ".number_format($rup_pct_swakelola['total'],0,',','.');
                $subrecord2['proses_paket'] = "-";
                $subrecord2['proses_anggaran'] = "-";
                $subrecord2['selesai_paket'] = "-";
                $subrecord2['selesai_anggaran'] = "-";
                $subrecord2['selesai_nilai'] = "-";
                $subrecord2['hemat_anggaran'] = "-";
                $subrecord2['hemat_persen'] = "-";

                if(!empty($rup_pct_swakelola)){
                    $total_rup_paket += $rup_pct_swakelola['jml'];
                    $total_rup_anggaran += $rup_pct_swakelola['total'];
                    // $total_proses_paket += $proses_pct_epurchasing['jml'];
                    // $total_proses_anggaran += $proses_pct_epurchasing['total'];
                    // $total_selesai_paket += $selesai_pct_epurchasing['jml'];
                    // $total_selesai_anggaran += $selesai_pct_epurchasing['total_pagu'];
                    // $total_selesai_nilai += $selesai_pct_epurchasing['total_nilai_negosiasi'];
                    // $total_hemat_anggaran += $hemat_anggaran_epurchasing;
                }
                
                array_push($record2, $subrecord2);

                $data['total_rup_paket2'] = $total_rup_paket == 0 ? "-" : number_format($total_rup_paket,0,',','.');
                $data['total_rup_anggaran2'] = $total_rup_anggaran == 0 ? "-" : "Rp. ".number_format($total_rup_anggaran,0,',','.');
                $data['total_proses_paket2'] = $total_proses_paket == 0 ? "-" : number_format($total_proses_paket,0,',','.');
                $data['total_proses_anggaran2'] = $total_proses_anggaran == 0 ? "-" : "Rp. ".number_format($total_proses_anggaran,0,',','.');
                $data['total_selesai_paket2'] = $total_selesai_paket == 0 ? "-" : number_format($total_selesai_paket,0,',','.');
                $data['total_selesai_anggaran2'] = $total_selesai_anggaran == 0 ? "-" : "Rp. ".number_format($total_selesai_anggaran,0,',','.');
                $data['total_selesai_nilai2'] = $total_selesai_nilai == 0 ? "-" : "Rp. ".number_format($total_selesai_nilai,0,',','.');
                $data['total_hemat_anggaran2'] = $total_hemat_anggaran == 0 ? "-" : "Rp. ".number_format($total_hemat_anggaran,0,',','.');
                break;
            case 12:
            case 13:
                switch ($laporan) {
                    case 12:
                        $data['judul'] = "APBD Murni";
                        $kelompok = "murni";
                        break;
                    case 13:
                        $data['judul'] = "APBD Perubahan";
                        $kelompok = "perubahan";
                        break;
                }

                $data['judul'] .= " - Rincian Anggaran Per Satuan Kerja";

                $record = array();
                $subrecord = array();
        
                $no = 1;
        
                $total_1 = 0;
                $total_2 = 0;
                $total_3 = 0;
                $total_4 = 0;
                $total_5 = 0;
                $total_6 = 0;
                $total_7 = 0;
                $total_8 = 0;
                
                $satker = $this->mod_laporan->satker()->result();
        
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;
                    $subrecord['kode'] = $s->kd_satker;
                    $subrecord['singkatan'] = $s->singkatan;
                    
                    $rincian = $this->mod_laporan->rincian_struktur_anggaran($s->kd_satker, $thn, $kelompok);
                    
                    if(!empty($rincian)){
                        $subrecord['total_barang_jasa'] = $rincian['total_barang_jasa'] == 0 ? "-" : "Rp. ".number_format($rincian['total_barang_jasa']/1000000000,2,',','.')." M";
                        $subrecord['total_modal'] = $rincian['total_modal'] == 0 ? "-" : "Rp. ".number_format($rincian['total_modal']/1000000000,2,',','.')." M";
                        $subrecord['total_pegawai'] = $rincian['total_pegawai'] == 0 ? "-" : "Rp. ".number_format($rincian['total_pegawai']/1000000000,2,',','.')." M";
                        $subrecord['total_hibah'] = $rincian['total_hibah'] == 0 ? "-" : "Rp. ".number_format($rincian['total_hibah']/1000000000,2,',','.')." M";
                        $subrecord['total_bansos'] = $rincian['total_bansos'] == 0 ? "-" : "Rp. ".number_format($rincian['total_bansos']/1000000000,2,',','.')." M";
                        $subrecord['total_tidak_terduga'] = $rincian['total_tidak_terduga'] == 0 ? "-" : "Rp. ".number_format($rincian['total_tidak_terduga']/1000000000,2,',','.')." M";
                        $subrecord['total_dll'] = $rincian['total_dll'] == 0 ? "-" : "Rp. ".number_format($rincian['total_dll']/1000000000,2,',','.')." M";
                        $subrecord['total'] = $rincian['total'] == 0 ? "-" : "Rp. ".number_format($rincian['total']/1000000000,2,',','.')." M";
    
                        $total_1 += $rincian['total_barang_jasa'];
                        $total_2 += $rincian['total_modal'];
                        $total_3 += $rincian['total_pegawai'];
                        $total_4 += $rincian['total_hibah'];
                        $total_5 += $rincian['total_bansos'];
                        $total_6 += $rincian['total_tidak_terduga'];
                        $total_7 += $rincian['total_dll'];
                        $total_8 += $rincian['total'];
                    } else {
                        $subrecord['total_barang_jasa'] = "-";
                        $subrecord['total_modal'] = "-";
                        $subrecord['total_pegawai'] = "-";
                        $subrecord['total_hibah'] = "-";
                        $subrecord['total_bansos'] = "-";
                        $subrecord['total_tidak_terduga'] = "-";
                        $subrecord['total_dll'] = "-";
                        $subrecord['total'] = "-";
                    }
    
                    $no++;
    
                    array_push($record, $subrecord);
                }
    
                $data['baris'] = $record;
    
                $data['total_1'] = $total_1 == 0 ? "-" : "Rp. ".number_format($total_1/1000000000,2,',','.')." M";
                $data['total_2'] = $total_2 == 0 ? "-" : "Rp. ".number_format($total_2/1000000000,2,',','.')." M";
                $data['total_3'] = $total_3 == 0 ? "-" : "Rp. ".number_format($total_3/1000000000,2,',','.')." M";
                $data['total_4'] = $total_4 == 0 ? "-" : "Rp. ".number_format($total_4/1000000000,2,',','.')." M";
                $data['total_5'] = $total_5 == 0 ? "-" : "Rp. ".number_format($total_5/1000000000,2,',','.')." M";
                $data['total_6'] = $total_6 == 0 ? "-" : "Rp. ".number_format($total_6/1000000000,2,',','.')." M";
                $data['total_7'] = $total_7 == 0 ? "-" : "Rp. ".number_format($total_7/1000000000,2,',','.')." M";
                $data['total_8'] = $total_8 == 0 ? "-" : "Rp. ".number_format($total_8/1000000000,2,',','.')." M";
                break;
            case 14:
            case 15:
                switch ($laporan) {
                    case 14:
                        $data['judul'] = "APBD Murni";
                        $kelompok = "murni";
                        break;
                    case 15:
                        $data['judul'] = "APBD Perubahan";
                        $kelompok = "perubahan";
                        break;
                }

                $data['judul'] .= " - Rincian Belanja Per Satuan Kerja";

                $record = array();
                $subrecord = array();

                $no = 1;
                
                $total= 0;
                $total = 0;

                $satker = $this->mod_laporan->satker()->result();
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;
                    $subrecord['kode'] = $s->kd_satker;
                    $subrecord['singkatan'] = $s->singkatan;
                    $subrecord['nama_satker'] = $s->nama_satker;

                    switch ($laporan) {
                        case 14:
                            $total_anggaran_murni = $this->mod_laporan->total_anggaran_murni($s->kd_satker, $thn);
                            $subrecord['total'] = $total_anggaran_murni['total'] == 0 ? "-" : "Rp. ".number_format($total_anggaran_murni['total'],0,',','.');

                            $total += $total_anggaran_murni['total'];
                            break;
                        case 15:
                            $total_anggaran_perubahan = $this->mod_laporan->total_anggaran_perubahan($s->kd_satker, $thn);
                            $subrecord['total'] = $total_anggaran_perubahan['total'] == 0 ? "-" : "Rp. ".number_format($total_anggaran_perubahan['total'],0,',','.');

                            $total += $total_anggaran_perubahan['total'];
                            break;
                    }

                    $no++;

                    array_push($record, $subrecord);
                }

                $data['baris'] = $record;

                $data['total'] = "Rp. ".number_format($total,0,',','.');
                break;
            case 16:
                $data['judul'] = "Daftar Uraian Anggaran Belanja";

                $record = array();
                $subrecord = array();

                $satker = $this->mod_laporan->cek_satker($kode_satker);

                $data['judul'] .= " (".$kode_satker."-".$satker['nama_satker'].")";

                switch($kelompok)
                {
                    case "murni" :  
                        $program = $this->mod_laporan->program_murni($kode_satker, $thn)->result();
                        break;
                    case "perubahan" :
                        $program = $this->mod_laporan->program_perubahan($kode_satker, $thn)->result();
                        break;
                }
                
                foreach ($program as $p) {
                    $subrecord['bg'] = "bg-gray";
                    $subrecord['kode_1'] = $p->kd_program;
                    $subrecord['kode_2'] = "";
                    $subrecord['kode_3'] = "";
                    $subrecord['nama'] = $p->nama_program ;
                    $subrecord['total'] = $p->total == 0 ? "-" : "Rp. ".number_format($p->total,0,',','.');
                    array_push($record, $subrecord);

                    switch($kelompok)
                    {
                        case "murni" :  
                            $kegiatan = $this->mod_laporan->kegiatan_murni($kode_satker, $p->kd_program, $thn)->result();
                            break;
                        case "perubahan" :
                            $kegiatan = $this->mod_laporan->kegiatan_perubahan($kode_satker, $p->kd_program, $thn)->result();
                            break;
                    }
                    foreach ($kegiatan as $k) {
                        $subrecord['bg'] = "bg-gray-light";
                        $subrecord['kode_1'] = "";
                        $subrecord['kode_2'] = $k->kd_kegiatan;
                        $subrecord['kode_3'] = "";
                        $subrecord['nama'] = $k->nama_kegiatan;
                        $subrecord['total'] = $k->total == 0 ? "-" : "Rp. ".number_format($k->total,0,',','.');
                        array_push($record, $subrecord);

                        switch($kelompok)
                        {
                            case "murni" :  
                                $subkegiatan = $this->mod_laporan->subkegiatan_murni($kode_satker, $p->kd_program, $k->kd_kegiatan, $thn)->result();
                                break;
                            case "perubahan" :
                                $subkegiatan = $this->mod_laporan->subkegiatan_perubahan($kode_satker, $p->kd_program, $k->kd_kegiatan, $thn)->result();
                                break;
                        }
                        foreach ($subkegiatan as $sk) {
                            $subrecord['bg'] = "";
                            $subrecord['kode_1'] = "";
                            $subrecord['kode_2'] = "";
                            $subrecord['kode_3'] = $sk->kd_subkegiatan;
                            $subrecord['nama'] = $sk->nama_subkegiatan;
                            $subrecord['total'] = $sk->total == 0 ? "-" : "Rp. ".number_format($sk->total,0,',','.');
                            array_push($record, $subrecord);
                        }
                    }
                }

                $data['baris'] = $record;

                break;
            case 17:
                $data['judul'] = "Daftar Detail Belanja";

                $record = array();
                $subrecord = array();

                $satker = $this->mod_laporan->cek_satker($kode_satker);

                $data['judul'] .= " (".$kode_satker."-".$satker['nama_satker'].")";

                switch ($kelompok) {
                    case "murni":
                        $info_apbd = $this->mod_laporan->info_apbd_murni($kode_cek,$thn);
                        $detail = $this->mod_laporan->detail_murni($kode_cek,$thn)->result();
                        break;
                    case "perubahan":
                        $info_apbd = $this->mod_laporan->info_apbd_perubahan($kode_cek,$thn);
                        $detail = $this->mod_laporan->detail_perubahan($kode_cek,$thn)->result();
                        break;
                }     

                $data['program'] = $info_apbd['nama_program'];
                $data['kegiatan'] = $info_apbd['nama_kegiatan'];
                $data['subkegiatan'] = $info_apbd['nama_subkegiatan'];

                $total = 0;

                foreach ($detail as $d) {
                    $subrecord['kode'] = $d->kd_rekening;
                    $subrecord['rincian'] = $d->rincian;
                    $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                    
                    $total += $d->pagu;

                    array_push($record, $subrecord);
                }

                $data['baris'] = $record;

                $data['total'] = $total == 0 ? "-" : "Rp. ".number_format($total,0,',','.');

                break;
            case 18:
                switch ($kelompok) {
                    case 'penyedia':
                        $data['judul'] = "Daftar Paket Penyedia";
                        break;
                    case 'swakelola':
                        $data['judul'] = "Daftar Paket Swakelola";
                        break;
                }
                
                $record = array();
                $subrecord = array();

                $satker = $this->mod_laporan->cek_satker($kode_satker);

                $data['judul'] .= " (".$kode_satker."-".$satker['nama_satker'].")";

                $no= 1;

                
                if($kode_cek == "-")  {
                    $qcari = " AND kegiatan<>''";
                } else {
                    $qcari = " AND kegiatan like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }
        
                switch ($kelompok) {
                    case 'penyedia':
                        $paket = $this->mod_laporan->paket_penyedia($thn, $kode_satker, $qcari)->result();
                        break;
                    case 'swakelola':
                        $paket = $this->mod_laporan->paket_swakelola($thn, $kode_satker, $qcari)->result();
                        break;
                }

                foreach ($paket as $p) {
                    $subrecord['no'] = $no;
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

                $data['baris'] = $record;
                
                break;
            case 19:
                switch ($kelompok) {
                    case 'penyedia':
                        $data['judul'] = "Informasi Detail Paket Rencana Umum Pengadaan Penyedia";
                        break;
                    case 'swakelola':
                        $data['judul'] = "Informasi Detail Paket Rencana Umum Pengadaan Swakelola";
                        break;
                }

                $record = array();
                $subrecord = array();

                $satker = $this->mod_laporan->cek_satker($kode_satker);

                $data['judul'] .= " (".$kode_satker."-".$satker['nama_satker'].")";

                switch ($kelompok) {
                    case 'penyedia':
                        $info = $this->mod_laporan->info_paket_penyedia($kode_cek);
        
                        $data['nama_program'] = $info['program'];
                        $data['nama_kegiatan'] = $info['kegiatan'];
                        $data['uraian_pekerjaan'] = $info['deskripsi'];
                        $data['spesifikasi_pekerjaan'] = $info['spesifikasi'];
                        $data['volume_pekerjaan'] = $info['volume'];
                        $data['usaha_kecil'] = $info['umkm'];
                        $data['jenis_pengadaan'] = $info['jenis_pengadaan'];
                        $data['total_pagu'] = $info['pagu_rup'] == 0 ? "-" : "Rp. ".number_format($info['pagu_rup'],0,',','.');
                        $data['metode_pemilihan'] = $info['metode_pemilihan'];
                        $data['pemanfaatan_barangjasa_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                        $data['pemanfaatan_barangjasa_akhir'] = date('d-m-Y',strtotime($info['tanggal_kebutuhan']));
                        $data['jadwal_pelaksanaan_kontrak_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                        $data['jadwal_pelaksanaan_kontrak_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                        $data['jadwal_pemilihan_penyedia_mulai'] = date('d-m-Y',strtotime($info['awal_pengadaan']));
                        $data['jadwal_pemilihan_penyedia_akhir'] = date('d-m-Y',strtotime($info['akhir_pengadaan']));
                        $data['tanggal_perbarui_paket'] = "'".date('d-m-Y h:i:s',strtotime($info['tanggal_terakhir_di_update']));
                        $data['usaha_kecil'] = $info['umkm'];
                        break;
                    case 'swakelola':
                        $info = $this->mod_laporan->info_paket_swakelola($kode_cek);
        
                        $data['tipe_swakelola'] = "'".$info['tipe_swakelola'];
                        $data['penyelenggara_swakelola'] = $info['nama_kldi_penyelenggara'];
                        $data['deskripsi'] = $info['deskripsi'];
                        $data['pelaksanaan_pekerjaan_awal'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                        $data['pelaksanaan_pekerjaan_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                        break;
                }
                
                $data['kode_rup'] = "'".$info['kode_rup'];
                $data['nama_paket'] = $info['nama_paket'];
                $data['nama_klpd'] = $info['kldi'];
                $data['satuan_kerja'] = $info['nama_satker'];
                $data['tahun_anggaran'] = "'".$info['tahun_anggaran'];
                $data['provinsi'] = "-";
                $data['kabupaten_kota'] = $info['lokasi'];
                $data['detail_lokasi'] = $info['detail_lokasi'];
                $data['sumber_dana'] = $info['sumber_dana'];
                // $data['ta'] = $info['tahun_anggaran'];
                $data['klpd'] = $info['kldi'];
                $data['mak'] = $info['mak'];
                $data['pagu'] = $info['pagu_rup'] == 0 ? "-" : "Rp. ".number_format($info['pagu_rup'],0,',','.');
                
                break;
            case 20:
                $data['judul'] = "Daftar Histori Revisi Paket";

                $no= 1;

                if($kode_cek == "-")  {
                    $qcari = "kode_paket_lama<>''";
                } else {
                    $qcari = "(kode_paket_lama='$kode_cek' or kode_paket_baru='$kode_cek')";
                    $data['judul'] .= " - Kode Paket ".ucwords($kode_cek);
                }
        
                $record = array();
                $subrecord = array();
        
                $revisi = $this->mod_laporan->revisi($thn, $qcari)->result();
                foreach ($revisi as $r) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_kldi'] = $r->kode_kldi;
                    $subrecord['kode_paket_lama'] = $r->kode_paket_lama;
                    $subrecord['kode_paket_baru'] = $r->kode_paket_baru;
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
                            $cek_rup = $this->mod_laporan->cek_rup_penyedia($r->kode_paket_lama);
                            if(!empty($cek_rup)){
                                $subrecord['nama_lama'] = $cek_rup['nama_paket'];
                            } else {
                                $subrecord['nama_lama'] = "-";
                            }

                            $cek_satker = $this->mod_laporan->cek_satker($cek_rup['id_satker']);

                            $cek_rup = $this->mod_laporan->cek_rup_penyedia($r->kode_paket_baru);
                            if(!empty($cek_rup)){
                                $subrecord['nama_baru'] = $cek_rup['nama_paket'];    
                            } else {
                                $subrecord['nama_baru'] = "-";
                            }
                        
                            break;
                        case 'SWAKELOLA':
                            $cek_rup = $this->mod_laporan->cek_rup_swakelola($r->kode_paket_lama);
                            if(!empty($cek_rup)){
                                $subrecord['nama_lama'] = $cek_rup['nama_paket'];
                            } else {
                                $subrecord['nama_lama'] = "-";
                            }

                            $cek_satker = $this->mod_laporan->cek_satker($cek_rup['id_satker']);

                            $cek_rup = $this->mod_laporan->cek_rup_swakelola($r->kode_paket_baru);
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

                $data['baris'] = $record;
                break;
            case 21:
                echo $kelompok;
                $data['judul'] = "Informasi Detail Paket Rencana Umum Pengadaan";

                $record = array();
                $subrecord = array();

                switch ($kelompok) {
                    case 'PENYEDIA':
                        $info = $this->mod_laporan->info_paket_penyedia($kode_cek);
        
                        $data['nama_program'] = $info['program'];
                        $data['nama_kegiatan'] = $info['kegiatan'];
                        $data['uraian_pekerjaan'] = $info['deskripsi'];
                        $data['spesifikasi_pekerjaan'] = $info['spesifikasi'];
                        $data['volume_pekerjaan'] = $info['volume'];
                        $data['usaha_kecil'] = $info['umkm'];
                        $data['jenis_pengadaan'] = $info['jenis_pengadaan'];
                        $data['total_pagu'] = $info['pagu_rup'] == 0 ? "-" : "Rp. ".number_format($info['pagu_rup'],0,',','.');
                        $data['metode_pemilihan'] = $info['metode_pemilihan'];
                        $data['pemanfaatan_barangjasa_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                        $data['pemanfaatan_barangjasa_akhir'] = date('d-m-Y',strtotime($info['tanggal_kebutuhan']));
                        $data['jadwal_pelaksanaan_kontrak_mulai'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                        $data['jadwal_pelaksanaan_kontrak_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                        $data['jadwal_pemilihan_penyedia_mulai'] = date('d-m-Y',strtotime($info['awal_pengadaan']));
                        $data['jadwal_pemilihan_penyedia_akhir'] = date('d-m-Y',strtotime($info['akhir_pengadaan']));
                        $data['tanggal_perbarui_paket'] = "'".date('d-m-Y h:i:s',strtotime($info['tanggal_terakhir_di_update']));
                        $data['usaha_kecil'] = $info['umkm'];
                        break;
                    case 'SWAKELOLA':
                        $info = $this->mod_laporan->info_paket_swakelola($kode_cek);
        
                        $data['tipe_swakelola'] = "'".$info['tipe_swakelola'];
                        $data['penyelenggara_swakelola'] = $info['nama_kldi_penyelenggara'];
                        $data['deskripsi'] = $info['deskripsi'];
                        $data['pelaksanaan_pekerjaan_awal'] = date('d-m-Y',strtotime($info['awal_pekerjaan']));
                        $data['pelaksanaan_pekerjaan_akhir'] = date('d-m-Y',strtotime($info['akhir_pekerjaan']));
                        break;
                }
                
                $data['kode_rup'] = "'".$info['kode_rup'];
                $data['nama_paket'] = $info['nama_paket'];
                $data['nama_klpd'] = $info['kldi'];
                $data['satuan_kerja'] = $info['nama_satker'];
                $data['tahun_anggaran'] = "'".$info['tahun_anggaran'];
                $data['provinsi'] = "-";
                $data['kabupaten_kota'] = $info['lokasi'];
                $data['detail_lokasi'] = $info['detail_lokasi'];
                $data['sumber_dana'] = $info['sumber_dana'];
                // $data['ta'] = $info['tahun_anggaran'];
                $data['klpd'] = $info['kldi'];
                $data['mak'] = $info['mak'];
                $data['pagu'] = $info['pagu_rup'] == 0 ? "-" : "Rp. ".number_format($info['pagu_rup'],0,',','.');
                
                break;
            case 22:
                $data['judul'] = "Rekap Tender Per-Jenis Pekerjaan";

                $total_total_paket = 0;
                $total_paket_selesai = 0;
                $total_paket_tayang = 0;
                $total_paket_review = 0;
                $total_paket_batal = 0;
                $total_total_pagu_anggaran = $this->mod_laporan->total_pagu_anggaran_tender($thn);
                $total_pagu_anggaran_selesai = 0;
                $total_harga_negosiasi = 0;
                $total_hemat_optimalisasi = 0;

                $record = array();
                $subrecord = array();

                $jenis = $this->mod_laporan->jenis_tender($thn)->result();
                foreach ($jenis as $j) {
                    $subrecord['no'] = $no2;
                    $subrecord['jenis'] = $j->jenis;
                    $subrecord['total_paket'] = $j->total_paket == 0 ? "-" : number_format($j->total_paket,0,',','.');
                    $subrecord['paket_selesai'] = $j->paket_selesai == 0 ? "-" : number_format($j->paket_selesai,0,',','.');
                    $subrecord['paket_tayang'] = $j->paket_tayang == 0 ? "-" : number_format($j->paket_tayang,0,',','.');
                    $subrecord['paket_review'] = $j->paket_review == 0 ? "-" : number_format($j->paket_review,0,',','.');
                    $subrecord['paket_batal'] = $j->paket_batal == 0 ? "-" : number_format($j->paket_batal,0,',','.');
                    $subrecord['total_pagu_anggaran'] = $j->total_pagu_anggaran == 0 ? "-" : "Rp. ".number_format($j->total_pagu_anggaran,0,',','.');
                    if($total_total_pagu_anggaran['total'] != 0){
                        $persen_pagu_anggaran = ($j->total_pagu_anggaran / $total_total_pagu_anggaran['total']) * 100;
                    } else {
                        $persen_pagu_anggaran = 0;
                    }
                    $subrecord['persen_pagu_anggaran'] = $persen_pagu_anggaran == 0 ? "-" : number_format($persen_pagu_anggaran,2,',','.')."%";
                    $subrecord['pagu_anggaran_selesai'] = $j->pagu_anggaran_selesai == 0 ? "-" : "Rp. ".number_format($j->pagu_anggaran_selesai,0,',','.');
                    $subrecord['harga_negosiasi'] = $j->harga_negosiasi == 0 ? "-" : "Rp. ".number_format($j->harga_negosiasi,0,',','.');
                    $subrecord['hemat_optimalisasi'] = $j->hemat_optimalisasi == 0 ? "-" : "Rp. ".number_format($j->hemat_optimalisasi,0,',','.');
                    $subrecord['hemat_persen'] = $j->hemat_persen == 0 ? "-" : number_format($j->hemat_persen,2,',','.')."%";

                    $total_total_paket += $j->total_paket;
                    $total_paket_selesai += $j->paket_selesai;
                    $total_paket_tayang += $j->paket_tayang;
                    $total_paket_review += $j->paket_review;
                    $total_paket_batal += $j->paket_batal;
                    // $total_total_pagu_anggaran += $j->total_pagu_anggaran;
                    $total_pagu_anggaran_selesai += $j->pagu_anggaran_selesai;
                    $total_harga_negosiasi += $j->harga_negosiasi;
                    $total_hemat_optimalisasi += $j->hemat_optimalisasi;

                    $no2++;

                    array_push($record, $subrecord);
                }

                $data['total_total_paket'] = $total_total_paket == 0 ? "-" : number_format($total_total_paket,0,',','.');
                $data['total_paket_selesai'] = $total_paket_selesai == 0 ? "-" : number_format($total_paket_selesai,0,',','.');
                $data['total_paket_tayang'] = $total_paket_tayang == 0 ? "-" : number_format($total_paket_tayang,0,',','.');
                $data['total_paket_review'] = $total_paket_review == 0 ? "-" : number_format($total_paket_review,0,',','.');
                $data['total_paket_batal'] = $total_paket_batal == 0 ? "-" : number_format($total_paket_batal,0,',','.');
                $data['total_total_pagu_anggaran'] = $total_total_pagu_anggaran == 0 ? "-" : "Rp. ".number_format($total_total_pagu_anggaran['total'],0,',','.');
                $data['total_pagu_anggaran_selesai'] = $total_pagu_anggaran_selesai == 0 ? "-" : "Rp. ".number_format($total_pagu_anggaran_selesai,0,',','.');
                $data['total_harga_negosiasi'] = $total_harga_negosiasi == 0 ? "-" : "Rp. ".number_format($total_harga_negosiasi,0,',','.');
                $data['total_hemat_optimalisasi'] = $total_hemat_optimalisasi == 0 ? "-" : "Rp. ".number_format($total_hemat_optimalisasi,0,',','.');
                break;
            case 23:
                $data['judul'] = "Rekap Non Tender Per-Jenis Pekerjaan";

                // jenis
                $total_total_paket = 0;
                $total_paket_selesai = 0;
                $total_paket_tayang = 0;
                $total_paket_review = 0;
                $total_paket_batal = 0;
                $total_total_pagu_anggaran = $this->mod_laporan->total_pagu_anggaran_nontender($data['thn']);
                $total_pagu_anggaran_selesai = 0;
                $total_harga_negosiasi = 0;
                $total_hemat_optimalisasi = 0;

                $record = array();
                $subrecord = array();

                $jenis = $this->mod_laporan->jenis_nontender($thn)->result();
                foreach ($jenis as $j) {
                    $subrecord['no'] = $no;
                    $subrecord['jenis'] = $j->jenis;
                    $subrecord['total_paket'] = $j->total_paket == 0 ? "-" : number_format($j->total_paket,0,',','.');
                    $subrecord['paket_selesai'] = $j->paket_selesai == 0 ? "-" : number_format($j->paket_selesai,0,',','.');
                    $subrecord['paket_tayang'] = $j->paket_tayang == 0 ? "-" : number_format($j->paket_tayang,0,',','.');
                    $subrecord['paket_review'] = $j->paket_review == 0 ? "-" : number_format($j->paket_review,0,',','.');
                    $subrecord['paket_batal'] = $j->paket_batal == 0 ? "-" : number_format($j->paket_batal,0,',','.');
                    $subrecord['total_pagu_anggaran'] = $j->total_pagu_anggaran == 0 ? "-" : "Rp. ".number_format($j->total_pagu_anggaran,0,',','.');
                    if($total_total_pagu_anggaran['total'] != 0){
                        $persen_pagu_anggaran = ($j->total_pagu_anggaran / $total_total_pagu_anggaran['total']) * 100;
                    } else {
                        $persen_pagu_anggaran = 0;
                    }
                    $subrecord['persen_pagu_anggaran'] = $persen_pagu_anggaran == 0 ? "-" : number_format($persen_pagu_anggaran,2,',','.')."%";
                    $subrecord['pagu_anggaran_selesai'] = $j->pagu_anggaran_selesai == 0 ? "-" : "Rp. ".number_format($j->pagu_anggaran_selesai,0,',','.');
                    $subrecord['harga_negosiasi'] = $j->harga_negosiasi == 0 ? "-" : "Rp. ".number_format($j->harga_negosiasi,0,',','.');
                    $subrecord['hemat_optimalisasi'] = $j->hemat_optimalisasi == 0 ? "-" : "Rp. ".number_format($j->hemat_optimalisasi,0,',','.');
                    $subrecord['hemat_persen'] = $j->hemat_persen == 0 ? "-" : number_format($j->hemat_persen,2,',','.')."%";

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

                    array_push($record, $subrecord);
                }

                $data['total_total_paket'] = $total_total_paket == 0 ? "-" : number_format($total_total_paket,0,',','.');
                $data['total_paket_selesai'] = $total_paket_selesai == 0 ? "-" : number_format($total_paket_selesai,0,',','.');
                $data['total_paket_tayang'] = $total_paket_tayang == 0 ? "-" : number_format($total_paket_tayang,0,',','.');
                $data['total_paket_review'] = $total_paket_review == 0 ? "-" : number_format($total_paket_review,0,',','.');
                $data['total_paket_batal'] = $total_paket_batal == 0 ? "-" : number_format($total_paket_batal,0,',','.');
                $data['total_total_pagu_anggaran'] = $total_total_pagu_anggaran == 0 ? "-" : "Rp. ".number_format($total_total_pagu_anggaran['total'],0,',','.');
                $data['total_pagu_anggaran_selesai'] = $total_pagu_anggaran_selesai == 0 ? "-" : "Rp. ".number_format($total_pagu_anggaran_selesai,0,',','.');
                $data['total_harga_negosiasi'] = $total_harga_negosiasi == 0 ? "-" : "Rp. ".number_format($total_harga_negosiasi,0,',','.');
                $data['total_hemat_optimalisasi'] = $total_hemat_optimalisasi == 0 ? "-" : "Rp. ".number_format($total_hemat_optimalisasi,0,',','.');
                break;
            case 24:
                $data['judul'] = "Daftar Rekapitulasi Belanja Pengadaan, Realisasi Kontrak & Paket Selesai";

                $record = array();
                $subrecord = array();

                $no = 1;

                $total_1 = 0;
                $total_2 = 0;
                $total_3 = 0;
                $total_4 = 0;
                $total_5 = 0;
                $total_6 = 0;
                
                $satker = $this->mod_laporan->satker()->result();
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;
                    $subrecord['kode'] = $s->kd_satker;
                    $subrecord['singkatan'] = $s->singkatan;

                    $realisasi = $this->mod_laporan->realisasi_rekapitulasi($s->kd_satker, $thn);

                    $subrecord['belanja_pengadaan_paket'] = empty($realisasi) || $realisasi['belanja_pengadaan_paket'] == 0 ? "-" : number_format($realisasi['belanja_pengadaan_paket'],0,',','.');
                    $subrecord['belanja_pengadaan_anggaran'] = empty($realisasi) || $realisasi['belanja_pengadaan_anggaran'] == 0 ? "-" : "Rp. ".number_format($realisasi['belanja_pengadaan_anggaran']/1000000000,2,',','.')." M";
                    $subrecord['realisasi_kontrak_paket'] = empty($realisasi) || $realisasi['realisasi_kontrak_paket'] == 0 ? "-" : number_format($realisasi['realisasi_kontrak_paket'],0,',','.');
                    $subrecord['realisasi_kontrak_anggaran'] = empty($realisasi) || $realisasi['realisasi_kontrak_anggaran'] == 0 ? "-" : "Rp. ".number_format($realisasi['realisasi_kontrak_anggaran']/1000000000,2,',','.')." M";
                    $subrecord['realisasi_kontrak_persen'] = empty($realisasi) || $realisasi['realisasi_kontrak_persen'] == 0 ? "-" : number_format($realisasi['realisasi_kontrak_persen'],2,',','.')." %";
                    $subrecord['paket_selesai_paket'] = empty($realisasi) || $realisasi['paket_selesai_paket'] == 0 ? "-" : number_format($realisasi['paket_selesai_paket'],0,',','.');
                    $subrecord['paket_selesai_anggaran'] = empty($realisasi) || $realisasi['paket_selesai_anggaran'] == 0 ? "-" : "Rp. ".number_format($realisasi['paket_selesai_anggaran']/1000000000,2,',','.')." M";
                    $subrecord['paket_selesai_persen'] = empty($realisasi) || $realisasi['paket_selesai_persen'] == 0 ? "-" : number_format($realisasi['paket_selesai_persen'],2,',','.')."%";

                    $no++;

                    if(!empty($realisasi)){
                        $total_1 += $realisasi['belanja_pengadaan_paket'];
                        $total_2 += $realisasi['belanja_pengadaan_anggaran'];
                        $total_3 += $realisasi['realisasi_kontrak_paket'];
                        $total_4 += $realisasi['realisasi_kontrak_anggaran'];
                        $total_5 += $realisasi['paket_selesai_paket'];
                        $total_6 += $realisasi['paket_selesai_anggaran'];
                    }

                    array_push($record, $subrecord);
                }

                $data['total_1'] = $total_1 == 0 ? "-" : number_format($total_1,0,',','.');
                $data['total_2'] = $total_2 == 0 ? "-" : "Rp. ".number_format($total_2/1000000000,2,',','.')." M";
                $data['total_3'] = $total_3 == 0 ? "-" : number_format($total_3,0,',','.');
                $data['total_4'] = $total_4 == 0 ? "-" : "Rp. ".number_format($total_4/1000000000,2,',','.')." M";
                $data['total_5'] = $total_5 == 0 ? "-" : number_format($total_5,0,',','.');
                $data['total_6'] = $total_6 == 0 ? "-" : "Rp. ".number_format($total_6/1000000000,2,',','.')." M";
                break;
            case 25:
                $data['judul'] = "Daftar Rincian Paket (".ucwords($kelompok).")";

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

                switch ($kelompok) {
                    case 'tender':
                        $data['rowspan']="rowspan=2";
                        $table = "tender";
                        $qkelompok = "a.nama_status_tender='selesai'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'nontender':
                        $data['rowspan']="rowspan=2";
                        $table = "non_tender";
                        $qkelompok = "a.nama_status_nontender='aktif'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'pencatatan_nontender':
                        $data['rowspan']="";
                        $table = "pct_nontender";
                        $qkelompok = "a.status_nontender_pct='aktif'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'pencatatan_swakelola':
                        $data['rowspan']="";
                        $table = "pct_swakelola";
                        $qkelompok = "a.status_swakelola_pct='aktif'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'epurchasing':
                        $data['rowspan']="";
                        $table = "epurchasing";
                        $qkelompok = "a.rup_id<>''";
                        $orderby = "a.rup_id";
                        break;
                }

                $no = $limit_start + 1;

                $record = array();
                $subrecord = array();

                $rincian = $this->mod_laporan->rincian($table, $thn, $qcari, $qkelompok, $orderby)->result();
                foreach ($rincian as $r) {
                    $subrecord['no'] = $no;

                    switch ($kelompok) {
                        case 'tender':
                                $subrecord['kode_paket'] = $r->kd_paket;
                                $subrecord['kode_utama'] = $r->kd_tender;
                                $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
                                $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                                
                                $realisasi_tender = $this->mod_laporan->realisasi_tender($r->kd_tender);
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
                                $subrecord['status_paket_strategis'] = $r->status_paket_strategis;

                                $subrecord['keterangan'] = "";

                                break;
                        case 'nontender':
                                $subrecord['kode_paket'] = "";
                                $subrecord['kode_utama'] = $r->kd_nontender;
                                $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
                                $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                                
                                $realisasi_nontender = $this->mod_laporan->realisasi_nontender($r->kd_nontender);
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
                                $subrecord['status_paket_strategis'] = $r->status_paket_strategis;

                                $subrecord['keterangan'] = "";

                                break;
                        case 'pencatatan_nontender':
                                $subrecord['kode_paket'] = "";
                                $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                                $subrecord['keterangan'] = $r->keterangan == "" ? "-" : $r->keterangan;

                                break;
                        case 'pencatatan_swakelola':
                                $subrecord['kode_paket'] = "";
                                $subrecord['kode_rup_paket'] = $r->kd_rup_paket == "" || $r->kd_rup_paket == "0" ? "-":$r->kd_rup_paket;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] =  empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                                $subrecord['keterangan'] = $r->keterangan == "" ? "-" : $r->keterangan;

                                break;
                        case 'epurchasing':
                                $subrecord['kode_paket'] = "";
                                $subrecord['kode_rup_paket'] = $r->rup_id == "" || $r->rup_id == "0" ? "-":$r->rup_id;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->rup_id);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->ppk_nip);
                                $subrecord['ppk'] = empty($pegawai) ? "-" : $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu_rup == 0 ? "-" : "Rp. ".number_format($r->pagu_rup,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->total_harga == 0 ? "-" : "Rp. ".number_format($r->total_harga,0,',','.');
                                
                                $subrecord['keterangan'] = "";
                                break;
                    }

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 26:
                $data['judul'] = "Daftar Rekapitulasi Triwulan";

                $record = array();
                $subrecord = array();

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
                
                $satker = $this->mod_laporan->satker()->result();
                foreach ($satker as $s) {
                    $subrecord['no'] = $no;
                    $subrecord['kode'] = $s->kd_satker;
                    $subrecord['singkatan'] = $s->singkatan;

                    $triwulan = $this->mod_laporan->realisasi_triwulan($s->kd_satker, $thn);

                    $subrecord['belanja_pagu'] = empty($triwulan) || $triwulan['belanja_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['belanja_pagu']/1000000000,2,',','.')." M";
                    $subrecord['belanja_paket'] = empty($triwulan) || $triwulan['belanja_paket'] == 0 ? "-" : number_format($triwulan['belanja_paket'],0,',','.');
                    $subrecord['triwulan1_pagu'] = empty($triwulan) || $triwulan['triwulan1_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan1_pagu']/1000000000,2,',','.')." M";
                    $subrecord['triwulan1_paket'] = empty($triwulan) || $triwulan['triwulan1_paket'] == 0 ? "-" : number_format($triwulan['triwulan1_paket'],0,',','.');
                    $subrecord['triwulan2_pagu'] = empty($triwulan) || $triwulan['triwulan2_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan2_pagu']/1000000000,2,',','.')." M";
                    $subrecord['triwulan2_paket'] = empty($triwulan) || $triwulan['triwulan2_paket'] == 0 ? "-" : number_format($triwulan['triwulan2_paket'],0,',','.');
                    $subrecord['triwulan3_pagu'] = empty($triwulan) || $triwulan['triwulan3_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan3_pagu']/1000000000,2,',','.')." M";
                    $subrecord['triwulan3_paket'] = empty($triwulan) || $triwulan['triwulan3_paket'] == 0 ? "-" : number_format($triwulan['triwulan3_paket'],0,',','.');
                    $subrecord['triwulan4_pagu'] = empty($triwulan) || $triwulan['triwulan4_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['triwulan4_pagu']/1000000000,2,',','.')." M";
                    $subrecord['triwulan4_paket'] = empty($triwulan) || $triwulan['triwulan4_paket'] == 0 ? "-" : number_format($triwulan['triwulan4_paket'],0,',','.');
                    $subrecord['total_pagu'] = empty($triwulan) || $triwulan['total_pagu'] == 0 ? "-" : "Rp. ".number_format($triwulan['total_pagu']/1000000000,2,',','.')." M";
                    $subrecord['total_paket'] = empty($triwulan) || $triwulan['total_paket'] == 0 ? "-" : number_format($triwulan['total_paket'],0,',','.');
                    
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

                    array_push($record, $subrecord);
                }

                $data['total_1'] = $total_1 == 0 ? "-" : "Rp. ".number_format($total_1/1000000000,2,',','.')." M";
                $data['total_2'] = $total_2 == 0 ? "-" : number_format($total_2,0,',','.');
                $data['total_3'] = $total_3 == 0 ? "-" : "Rp. ".number_format($total_3/1000000000,2,',','.')." M";
                $data['total_4'] = $total_4 == 0 ? "-" : number_format($total_4,0,',','.');
                $data['total_5'] = $total_5 == 0 ? "-" : "Rp. ".number_format($total_5/1000000000,2,',','.')." M";
                $data['total_6'] = $total_6 == 0 ? "-" : number_format($total_6,0,',','.');
                $data['total_7'] = $total_7 == 0 ? "-" : "Rp. ".number_format($total_7/1000000000,2,',','.')." M";
                $data['total_8'] = $total_8 == 0 ? "-" : number_format($total_8,0,',','.');
                $data['total_9'] = $total_9 == 0 ? "-" : "Rp. ".number_format($total_9/1000000000,2,',','.')." M";
                $data['total_10'] = $total_10 == 0 ? "-" : number_format($total_10,0,',','.');
                $data['total_11'] = $total_11 == 0 ? "-" : "Rp. ".number_format($total_11/1000000000,2,',','.')." M";
                $data['total_12'] = $total_12 == 0 ? "-" : number_format($total_12,0,',','.');
                break;
            case 27:
                $data['judul'] = "Daftar Paket Strategis (".ucwords($kelompok).")";
                
                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

                switch ($kelompok) {
                    case 'tender':
                        $table = "tender";
                        $qkelompok = "a.nama_status_tender='selesai' and status_paket_strategis='ya'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'nontender':
                        $table = "non_tender";
                        $qkelompok = "a.nama_status_nontender='aktif' and status_paket_strategis='ya'";
                        $orderby = "a.kd_rup_paket";
                        break;
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                $rincian = $this->mod_laporan->rincian($table, $thn, $qcari, $qkelompok, $orderby)->result();
                foreach ($rincian as $r) {
                    $subrecord['no'] = $no;

                    switch ($kelompok) {
                        case 'tender':
                                $subrecord['kode_paket'] = $r->kd_paket;
                                $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" : $rup_penyedia['kegiatan'];
                                $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" : $rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                                $subrecord['sumber_dana'] = $r->ang == "" ? "-" : $r->ang;
                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
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

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                                $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                                $subrecord['sumber_dana'] = $r->anggaran == "" ? "-" : $r->anggaran;
                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
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
        
                break;
            case 28:
                $data['judul'] = "Daftar Sumber Dana (".ucwords(str_replace("_"," ",$kelompok)).")";

                if($ang == "-"){
                    $data['anggaran'] = "APBD";
                } else {
                    $data['anggaran'] =  $ang;
                }
                $data['judul'] .= " - Anggaran ".$data['anggaran'];

                if($kode_cek == "-")  {
                    $qcari = "b.nama_satker<>''";
                } else {
                    $qcari = "b.nama_satker like '%".urldecode($kode_cek)."%'";
                    $data['judul'] .= " - ".ucwords(urldecode($kode_cek));
                }

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

                $no = 1;

                $record = array();
                $subrecord = array();

                $rincian = $this->mod_laporan->rincian_sb($table, $data['thn'], $qcari, $qanggaran, $qkelompok, $orderby)->result();
                foreach ($rincian as $r) {
                    $subrecord['no'] = $no;

                    switch ($kelompok) {
                        case 'tender':
                                $subrecord['kode_paket'] = $r->kd_paket;
                                $subrecord['kode_utama'] = $r->kd_tender;
                                $subrecord['kode_rup_paket'] = $r->kd_rup_paket;
                                $subrecord['nama_satker'] = $r->nama_satker;

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] =  empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                                $subrecord['program'] =  empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
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

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                                $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($r->nilai_kontrak,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
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

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                                $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
                                $subrecord['ppk'] = empty($pegawai) || $pegawai['nama_pegawai'] == "" ? "-": $pegawai['nama_pegawai'];

                                $subrecord['pagu'] = $r->pagu == 0 ? "-" : "Rp. ".number_format($r->pagu,0,',','.');
                                $subrecord['nilai_kontrak'] = $r->total_realisasi == 0 ? "-" : "Rp. ".number_format($r->total_realisasi,0,',','.');

                                $penyedia = $this->mod_laporan->cek_penyedia($r->kd_penyedia);
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

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->kd_rup_paket);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                                $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->nip_ppk);
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

                                $rup_penyedia = $this->mod_laporan->cek_rup_penyedia($r->rup_id);
                                $subrecord['kegiatan'] = empty($rup_penyedia) || $rup_penyedia['kegiatan'] == "" ? "-" :$rup_penyedia['kegiatan'];
                                $subrecord['program'] = empty($rup_penyedia) || $rup_penyedia['program'] == "" ? "-" :$rup_penyedia['program'];

                                $subrecord['jml_teks'] = strlen($r->nama_paket);
                                $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_paket)));
                                $subrecord['nama_paket_cut'] = strlen($subrecord['nama_paket']) > 150 ? substr($subrecord['nama_paket'],0,100)."..." : $subrecord['nama_paket'];
                                
                                $pegawai = $this->mod_laporan->cek_pegawai($r->ppk_nip);
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

                break;
            case 29:
                $data['judul'] = "Rekap Penyedia Per-Provinsi";
                
                $no = 1;

                $record = array();
                $subrecord = array();

                $provinsi = $this->mod_laporan->provinsi($thn)->result();
                foreach ($provinsi as $p) {
                    $subrecord['no'] = $no;
                    $subrecord['provinsi'] = $p->provinsi;
                    $subrecord['total'] = $p->total == 0 ? "-" : number_format($p->total,0,',','.');

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 30:
                $data['judul'] = "Rekap Penyedia Per-Kabupaten/Kota Provinsi ".urldecode($kode_cek);
                
                $provinsi = urldecode($kode_cek);

                $no = 1;

                $record = array();
                $subrecord = array();

                $kota = $this->mod_laporan->kota($provinsi)->result();
                foreach ($kota as $k) {
                    $subrecord['no'] = $no;
                    $subrecord['kabupaten_kota'] = $k->kabupaten_kota;
                    $subrecord['total'] = $k->total == 0 ? "-" : number_format($k->total,0,',','.');

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 31:
                list($namakel,$provinsi,$kabkota) = explode('-',$kelompok);

                $data['judul'] = "Daftar Penyedia ".urldecode($provinsi)." - ".urldecode($kabkota)." (".ucwords($namakel).")";

                if($kode_cek == "-")  {
                    $qcari = "a.kd_penyedia<>''";
                } else {
                    $qcari = "b.nama_penyedia like '%".urldecode($kode_cek)."%'";
                }

                switch ($namakel) {
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

                $no = 1;

                $record = array();
                $subrecord = array();

                $daftar = $this->mod_laporan->daftar_penyedia(urldecode($kabkota), $namakel, $thn, $qcari)->result();
                foreach ($daftar as $d) {
                    $subrecord['no'] = $no;
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
                
                break;
            case 32:
                list($status,$kode,$provinsi,$kabkota,$namakel) = explode('-',$kelompok);

                // penyedia
                $penyedia = $this->mod_laporan->cek_penyedia($kode);
                $namapenyedia = empty($penyedia) ? "-" : $penyedia['nama_penyedia'];

                $data['namakel'] = urldecode(strtolower(str_replace("/","",$namakel)));

                switch ($data['namakel']) {
                    case 'tender':
                        $namakelompok = "Tender";
                        break;
                    case 'nontender':
                        $namakelompok = "Non Tender";
                        break;
                    case 'pencatatan_nontender':
                        $namakelompok = "Pencatatan Non Tender";
                        break;
                    case 'pencatatan_swakelola':
                        $namakelompok = "Pencatatan Swakelola";
                        break;
                    case 'epurchasing':
                        $namakelompok = "ePurchasing";
                        break;
                }

                $data['judul'] = "Daftar Paket ".ucwords($namakelompok)." ".$namapenyedia." - ".urldecode($provinsi)." - ".urldecode($kabkota)." (Status ".ucwords($status).")";

                if($kode_cek == "-")  {
                    $qcari = "a.nama_paket<>''";
                } else {
                    $qcari = "a.nama_paket like '%".urldecode($kode_cek)."%'";
                }

                switch ($data['namakel']) {
                    case 'tender':
                        $table = "tender";
                        $qkelompok = "a.kd_penyedia='$kode'";
                        $qstatus = "a.nama_status_tender='".ucwords($status)."'";
                        $orderby = "a.kd_paket";
                        break;
                    case 'nontender':
                        $table = "non_tender";
                        $qkelompok = "a.kd_penyedia='$kode'";
                        $qstatus = "a.nama_status_nontender='".ucwords($status)."'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'pencatatan_nontender':
                        $table = "pct_nontender";
                        $qkelompok = "a.kd_penyedia='$kode'";
                        $qstatus = "a.status_nontender_pct='".ucwords($status)."'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'pencatatan_swakelola':
                        $table = "pct_swakelola";
                        $qkelompok = "a.npwp_penyedia='".$data['npwp_penyedia']."'";
                        $qstatus = "a.status_swakelola_pct='".ucwords($status)."'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'epurchasing':
                        $table = "epurchasing";
                        $qkelompok = "a.npwp_penyedia='".$data['npwp_penyedia']."'";
                        $qstatus = "a.paket_status_str like '%".ucwords($status)."'";
                        $orderby = "a.no_paket";
                        break;
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                $detail = $this->mod_laporan->detail_paket($table, $thn, $qkelompok, $qstatus, $qcari, $orderby)->result();
                foreach ($detail as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['jml_teks'] = strlen($d->nama_paket);
                    $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->nama_paket)));

                    $subrecord['nama_satker'] = $d->nama_satker;
                    $subrecord['singkatan'] = $d->singkatan;

                    switch ($data['namakel']) {
                        case 'tender':
                            $subrecord['kode_paket'] = $d->kd_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                            // $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            // $subrecord['penyedia'] = empty($penyedia) || penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                            $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                            break;
                        case 'nontender':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->anggaran;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                            // $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            // $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                            $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                            break;
                        case 'pctnontender':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                            // $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            // $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                            break;
                        case 'pctswakelola':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                            // $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            // $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                            break;
                        case 'epurchasing':
                            $subrecord['kode_paket'] = $d->no_paket;
                            $subrecord['sumber_dana'] = $d->nama_sumber_dana;
                            $subrecord['pagu'] = $d->pagu_rup == 0 ? "-" : "Rp. ".number_format($d->pagu_rup,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->total_harga == 0 ? "-" : "Rp. ".number_format($d->total_harga,0,',','.');
                            // $subrecord['penyedia'] = empty($penyedia) || $d->nama_penyedia == "" ? "-" : $d->nama_penyedia;
                            break;
                    }        
                    
                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 33:
                $data['judul'] = "Rekap Paket PPK ";

                $qkelompok = "a.kelompok='$kelompok'";
                switch ($kelompok) {
                    case 'tender':
                        $data['judul'] .= "(Tender)";
                        break;
                    case 'nontender':
                        $data['judul'] .= "(Non Tender)";
                        break;
                    case 'pencatatan_nontender':
                        $data['judul'] .= "(Pencatatan Non Tender)";
                        break;
                    case 'pencatatan_swakelola':
                        $data['judul'] .= "(Pencatatan Swakelola)";
                        break;
                    case 'epurchasing':
                        $data['judul'] .= "(ePurchasing)";
                        break;
                }

                if($kode_cek == "-")  {
                    $qcari = "b.nip_pegawai<>''";
                } else {
                    $qcari = "(b.nip_pegawai='".urldecode($kode_cek)."' or b.nama_pegawai like '%".urldecode($kode_cek)."%')";
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                $daftar = $this->mod_laporan->daftar_ppk($thn, $qkelompok, $qcari)->result();
                foreach ($daftar as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['nip_pegawai'] = "'".$d->nip_pegawai;
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
                break;
            case 34:
                list($status,$nip,$nama,$namakel) = explode('-',$kelompok);

                $data['namakel'] = urldecode(strtolower(str_replace("/","",$namakel)));

                switch ($data['namakel']) {
                    case 'tender':
                        $namakelompok = "Tender";
                        break;
                    case 'nontender':
                        $namakelompok = "Non Tender";
                        break;
                    case 'pencatatan_nontender':
                        $namakelompok = "Pencatatan Non Tender";
                        break;
                    case 'pencatatan_swakelola':
                        $namakelompok = "Pencatatan Swakelola";
                        break;
                    case 'epurchasing':
                        $namakelompok = "ePurchasing";
                        break;
                }

                $data['judul'] = "Daftar Paket ".ucwords($namakelompok)." PPK (".$nip." - ".urldecode($nama).") Status ".ucwords($status);

                if($kode_cek == "-")  {
                    $qcari = "a.nama_paket<>''";
                } else {
                    $qcari = "a.nama_paket like '%".urldecode($kode_cek)."%'";
                }

                switch ($data['namakel']) {
                    case 'tender':
                        $table = "tender";
                        $qkelompok = "a.nip_ppk='$nip'";
                        $qstatus = "a.nama_status_tender='".ucwords($status)."'";
                        $orderby = "a.kd_paket";
                        break;
                    case 'nontender':
                        $table = "non_tender";
                        $qkelompok = "a.nip_ppk='$nip'";
                        $qstatus = "a.nama_status_nontender='".ucwords($status)."'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'pencatatan_nontender':
                        $table = "pct_nontender";
                        $qkelompok = "a.nip_ppk='$nip'";
                        $qstatus = "a.status_nontender_pct='".ucwords($status)."'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'pencatatan_swakelola':
                        $table = "pct_swakelola";
                        $qkelompok = "a.nip_ppk='$nip'";
                        $qstatus = "a.status_swakelola_pct='".ucwords($status)."'";
                        $orderby = "a.kd_rup_paket";
                        break;
                    case 'epurchasing':
                        $table = "epurchasing";
                        $qkelompok = "a.ppk_nip='$nip'";
                        $qstatus = "a.paket_status_str like '%".ucwords($status)."'";
                        $orderby = "a.no_paket";
                        break;
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                $detail = $this->mod_laporan->detail_paket($table, $thn, $qkelompok, $qstatus, $qcari, $orderby)->result();
                foreach ($detail as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['jml_teks'] = strlen($d->nama_paket);
                    $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->nama_paket)));

                    $subrecord['nama_satker'] = $d->nama_satker;
                    $subrecord['singkatan'] = $d->singkatan;

                    switch ($data['namakel']) {
                        case 'tender':
                            $subrecord['kode_paket'] = $d->kd_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                            $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                            $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                            break;
                        case 'nontender':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->anggaran;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                            $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                            $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                            break;
                        case 'pctnontender':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                            $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                            break;
                        case 'pctswakelola':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->total_realisasi == 0 ? "-" : "Rp. ".number_format($d->total_realisasi,0,',','.');

                            $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
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
                break;
            case 35:
                $data['judul'] = "Rekap Paket Personil ".strtoupper($kelompok);

                $qpersonil = "a.personil='$kelompok'";

                if($kode_cek == "-")  {
                    $qcari = "b.nip_pegawai<>''";
                } else {
                    $qcari = "(b.nip_pegawai='".urldecode($kode_cek)."' or b.nama_pegawai like '%".urldecode($kode_cek)."%')";
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                $daftar = $this->mod_laporan->daftar_personil($thn, $qpersonil, $qcari)->result();
                foreach ($daftar as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['nip_pegawai'] = "'".$d->nip_pegawai;
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
                break;
            case 36:
                list($status,$nip,$nama,$namakel) = explode('-',$kelompok);

                $data['judul'] = "Daftar Paket Personil ".strtoupper($namakel)." (".$nip." - ".urldecode($nama).") Status ".ucwords($status);

                if($kode_cek == "-")  {
                    $qcari = "a.nama_paket<>''";
                } else {
                    $qcari = "a.nama_paket like '%".urldecode($kode_cek)."%'";
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                switch ($namakel) {
                    case 'pokja':
                        $detail = $this->mod_laporan->detail_pokja($thn, $nip, ucwords($status), $qcari)->result();
                        break;
                    case 'pp':
                        $detail = $this->mod_laporan->detail_pp($thn, $nip, ucwords($status), $qcari)->result();
                        break;
                }
                
                foreach ($detail as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['jml_teks'] = strlen($d->nama_paket);
                    $subrecord['nama_paket'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($d->nama_paket)));

                    $subrecord['nama_satker'] = $d->nama_satker;
                    $subrecord['singkatan'] = $d->singkatan;

                    switch ($namakel) {
                        case 'pokja':
                            $subrecord['kode_paket'] = $d->kd_paket;
                            $subrecord['sumber_dana'] = $d->ang;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                            $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                            $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                            break;
                        case 'pp':
                            $subrecord['kode_paket'] = $d->kd_rup_paket;
                            $subrecord['sumber_dana'] = $d->anggaran;
                            $subrecord['pagu'] = $d->pagu == 0 ? "-" : "Rp. ".number_format($d->pagu,0,',','.');
                            $subrecord['nilai_kontrak'] = $d->nilai_kontrak == 0 ? "-" : "Rp. ".number_format($d->nilai_kontrak,0,',','.');

                            $penyedia = $this->mod_laporan->cek_penyedia($d->kd_penyedia);
                            $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];

                            $subrecord['status_pelaksanaan'] = $d->nama_status_pekerjaan == "" ? "-" : $d->nama_status_pekerjaan;
                            break;
                    }        
                    
                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 37:
                $data['judul'] = "Daftar Paket Kelompok Kerja";

                if($kode_cek == "-")  {
                    $qcari = "a.nama_pokja<>''";
                } else {
                    $qcari = "(a.nama_pokja like '%".urldecode($kode_cek)."%' OR b.nama_satker like '%".urldecode($kode_cek)."%')";
                }

                $no = 1;

                $record = array();
                $subrecord = array();

                $rincian = $this->mod_laporan->rincian_kelkerja($thn, $qcari)->result();
                foreach ($rincian as $r) {
                    $subrecord['no'] = $no;
                    $subrecord['kode_pokja'] = $r->kd_pokja;

                    $subrecord['jml_teks_pokja'] = strlen($r->nama_pokja);
                    $subrecord['nama_pokja'] = htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($r->nama_pokja)));
                    
                    $subrecord['nama_satker'] = $r->nama_satker;

                    $subrecord['anggota'] = "";
                    $pegawai = $this->mod_laporan->cek_pegawai2($r->nip_personil1);
                    $subrecord['anggota'] .= empty($pegawai) ? "": $r->nip_personil1." - ".$pegawai['nama_pegawai'];

                    if($r->nip_personil2 != ""){
                        $pegawai = $this->mod_laporan->cek_pegawai2($r->nip_personil2);
                        $subrecord['anggota'] .= empty($pegawai) ? "":"<br>".$r->nip_personil2." - ".$pegawai['nama_pegawai'];
                    }

                    if($r->nip_personil3 != ""){
                        $pegawai = $this->mod_laporan->cek_pegawai2($r->nip_personil3);
                        $subrecord['anggota'] .= empty($pegawai) ? "":"<br>".$r->nip_personil3." - ".$pegawai['nama_pegawai'];
                    }

                    if($r->nip_personil4 != ""){
                        $pegawai = $this->mod_laporan->cek_pegawai2($r->nip_personil4);
                        $subrecord['anggota'] .= empty($pegawai) ? "":"<br>".$r->nip_personil4." - ".$pegawai['nama_pegawai'];
                    }

                    if($r->nip_personil5 != ""){
                        $pegawai = $this->mod_laporan->cek_pegawai2($r->nip_personil5);
                        $subrecord['anggota'] .= empty($pegawai) ? "":"<br>".$r->nip_personil5." - ".$pegawai['nama_pegawai'];
                    }

                    $tender = $this->mod_laporan->cek_tender($r->kd_tender);
                    $subrecord['jml_teks'] = empty($tender) ? 0 : strlen($tender['nama_paket']);
                    $subrecord['nama_paket'] = empty($tender) ?  "-" : htmlentities(preg_replace('~[\r\n]+~', '',strip_tags($tender['nama_paket'])));
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
                        $penyedia = $this->mod_laporan->cek_penyedia($tender['kd_penyedia']);
                        $subrecord['penyedia'] = empty($penyedia) || $penyedia['nama_penyedia'] == "" ? "-" : $penyedia['nama_penyedia'];
                    } else {
                        $subrecord['penyedia'] = "-";
                    }
                    $no++;

                    array_push($record, $subrecord);
                }
                break;
        }

        $data['data'] = json_encode($record);

        $data['data2'] = json_encode($record2);

        $this->load->view('backend/page/cetak_excel', $data);
    }
}
