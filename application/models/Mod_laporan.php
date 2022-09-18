<?
class mod_laporan extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }

    // satker
    public function satker()
    {
        return $this->db->query("SELECT kd_satker,singkatan,nama_satker FROM satker order by kdunit_satker ASC");
    }

    public function cek_satker($kode)
    {
        return $this->db->query("SELECT kd_satker,singkatan,nama_satker FROM satker WHERE kd_satker='$kode'")->row_array();
    }
    // end

    // table temp satker rup rekapitulasi
    public function rekapitulasi($kode_satker, $thn)
    {
        return $this->db->query("SELECT * FROM temp_satker_rup_rekapitulasi WHERE kd_satker='$kode_satker' AND thn='$thn'")->row_array();
    }
    // end

    // paket penyedia 
    public function paket_penyedia($thn, $kode_satker, $qcari)
    {
        return $this->db->query("SELECT kegiatan,nama_paket,metode_pemilihan,pagu_rup,jenis_pengadaan,sumber_dana,kode_rup,awal_pengadaan FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='tidak' AND status_aktif='ya' AND status_umumkan='sudah' $qcari ORDER BY nama_paket ASC");
    }
    // end

    // paket swakelola 
    public function paket_swakelola($thn, $kode_satker, $qcari)
    {
        return $this->db->query("SELECT kegiatan,nama_paket,tipe_swakelola,pagu_rup,sumber_dana,kode_rup,awal_pekerjaan FROM rup_swakelola WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND status_aktif='ya' AND status_umumkan='sudah' $qcari ORDER BY nama_paket ASC");
    }
    // end

    // info paket
    public function info_paket_penyedia($kode)
    {
        return $this->db->query("SELECT * FROM rup_penyedia WHERE kode_rup='$kode'")->row_array();
    }

    public function info_paket_swakelola($kode)
    {
        return $this->db->query("SELECT * FROM rup_swakelola WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // metode
    public function metode_tender($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_metode WHERE thn='$thn'");
    }
    // end

    // jenis
    public function jenis_tender($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_jenis WHERE thn='$thn'");
    }
    // end

    // total pagu anggaran tender
    public function total_pagu_anggaran_tender($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(total_pagu_anggaran),0) as total FROM temp_tender_rekapitulasi_jenis WHERE thn='$thn'")->row_array();
    }
    // end

    public function total_anggaran_tender($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(total),0) as total FROM temp_tender_rekapitulasi_satker WHERE thn='$thn'")->row_array();
    }
    // end

    public function temp_tender_rekapitulasi_satker($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_satker WHERE thn='$thn'");
    }

    // rincian tender
    public function rincian_tender($thn,$qcari,$qkelompok)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM tender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                AND $qcari 
                                AND $qkelompok
                                ORDER BY a.kd_paket ASC");
    }

    // rup penyedia
    public function cek_rup_penyedia($kode)
    {
        return $this->db->query("SELECT nama_paket,id_satker,kegiatan,program  FROM rup_penyedia WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // pegawai
    public function cek_pegawai($kode)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$kode' AND status_ppk='ya'")->row_array();
    }

    public function cek_pegawai2($kode)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$kode'")->row_array();
    }
    // end

    // penyedia
    public function cek_penyedia($kode)
    {
        return $this->db->query("SELECT nama_penyedia,alamat_penyedia,kabupaten_kota FROM penyedia WHERE kd_penyedia='$kode'")->row_array();
    }
    // end

    // metode nontender
    public function metode_nontender($thn)
    {
        return $this->db->query("SELECT * FROM temp_nontender_rekapitulasi_metode WHERE thn='$thn'");
    }
    // end

    // jenis nontender
    public function jenis_nontender($thn)
    {
        return $this->db->query("SELECT * FROM temp_nontender_rekapitulasi_jenis WHERE thn='$thn'");
    }
    // end

    // total pagu anggaran nontender
    public function total_pagu_anggaran_nontender($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(total_pagu_anggaran),0) as total FROM temp_nontender_rekapitulasi_jenis WHERE thn='$thn'")->row_array();
    }
    // end

    public function temp_nontender_rekapitulasi_satker($thn)
    {
        return $this->db->query("SELECT * FROM temp_nontender_rekapitulasi_satker WHERE thn='$thn'");
    }

    public function total_anggaran_nontender($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(total),0) as total FROM temp_nontender_rekapitulasi_satker WHERE thn='$thn'")->row_array();
    }

    public function rincian_nontender($thn, $qcari, $qkelompok)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM non_tender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                AND $qcari 
                                AND $qkelompok
                                ORDER BY a.kd_rup_paket ASC");
    }

    public function epurchasing($thn,$qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM epurchasing a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                ORDER BY a.rup_id ASC");
    }

    // pencatatan nontender
    public function pencatatan_nontender($thn,$qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pct_nontender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                ORDER BY a.kd_nontender_pct ASC");
    }

    // pencatatan swakelola
    public function pencatatan_swakelola($thn,$qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pct_swakelola a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                ORDER BY a.kd_swakelola_pct ASC");
    }

    // temp tender rekapitulasi metode
    public function tender_rekapitulasi_metode($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_metode WHERE thn='$thn' and (metode='Seleksi' or metode='Tender' or metode='Tender Cepat') ");
    }
    // end

    // temp nontender rekapitulasi metode
    public function nontender_rekapitulasi_metode($thn)
    {
        return $this->db->query("SELECT 
                                COALESCE(SUM(rup_paket),0) as total_rup_paket,
                                COALESCE(SUM(rup_anggaran),0) as total_rup_anggaran,
                                COALESCE(SUM(proses_paket),0) as total_proses_paket, 
                                COALESCE(SUM(proses_anggaran),0) as total_proses_anggaran, 
                                COALESCE(SUM(selesai_paket),0) as total_selesai_paket, 
                                COALESCE(SUM(selesai_anggaran),0) as total_selesai_anggaran, 
                                COALESCE(SUM(selesai_nilai),0) as total_selesai_nilai, 
                                COALESCE(SUM(hemat_anggaran),0) as total_hemat_anggaran, 
                                COALESCE(SUM(hemat_persen),0) as total_hemat_persen
                                FROM temp_nontender_rekapitulasi_metode where thn='$thn'")->row_array();
    }
    // end

    // temp tender rekapitulasi metode for epurchasing
    public function tender_rekapitulasi_epurchasing($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_metode WHERE thn='$thn' and metode='e-Purchasing'")->row_array();
    }
    // end

    // rekapitulasi pencatatan epurchasing
    public function rekapitulasi_pencatatan_epurchasing($thn)
    {
        return $this->db->query("SELECT COUNT(a.rup_id) AS jml,  COALESCE(SUM(a.pagu_rup),0) as total 
                                    FROM epurchasing a 
                                        inner join rup_penyedia b
                                            on a.rup_id=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND b.penyedia_didalam_swakelola='tidak' 
                                    AND b.status_aktif='ya' AND b.status_umumkan='sudah'")->row_array();
    }

    public function rekapitulasi_proses_epurchasing($thn)
    {
        return $this->db->query("SELECT COUNT(a.rup_id) AS jml,  COALESCE(SUM(a.pagu_rup),0) as total 
                                    FROM epurchasing a 
                                        inner join rup_penyedia b
                                            on a.rup_id=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND b.penyedia_didalam_swakelola='tidak' 
                                        AND b.status_aktif='ya' 
                                        AND b.status_umumkan='sudah' 
                                        AND a.paket_status_str='Paket Proses'")->row_array();
    }

    public function rekapitulasi_selesai_epurchasing($thn)
    {
        return $this->db->query("SELECT COUNT(a.rup_id) AS jml,  
                                        COALESCE(SUM(a.pagu_rup),0) as total_pagu,
                                        COALESCE(SUM(a.total_harga),0) as total_nilai_negosiasi
                                    FROM epurchasing a 
                                        inner join rup_penyedia b
                                            on a.rup_id=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.paket_status_str='Paket Selesai'")->row_array();
    }

    // rekapitulasi pencatatan nontender
    public function rekapitulasi_pencatatan_nontender($thn)
    {
        return $this->db->query("SELECT COUNT(a.kd_rup_paket) AS jml,  COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_nontender a 
                                        inner join rup_penyedia b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' ")->row_array();
    }

    public function rekapitulasi_proses_nontender($thn)
    {
        return $this->db->query("SELECT COUNT(a.kd_rup_paket) AS jml,  COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_nontender a 
                                        inner join rup_penyedia b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND a.paket_status_str='Aktif'")->row_array();
    }

    public function rekapitulasi_selesai_nontender($thn)
    {
        return $this->db->query("SELECT COUNT(a.kd_rup_paket) AS jml,  
                                        COALESCE(SUM(a.pagu),0) as total_pagu,
                                        COALESCE(SUM(a.total_realisasi),0) as total_nilai_negosiasi
                                    FROM pct_nontender a 
                                        inner join rup_penyedia b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND a.paket_status_str='Aktif'")->row_array();
    }

    // rekapitulasi pencatatan swakelola
    public function rekapitulasi_pencatatan_swakelola($thn)
    {
        return $this->db->query("SELECT COUNT(a.kd_rup_paket) AS jml,  COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_swakelola a 
                                        inner join rup_swakelola b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND a.status_swakelola_pct='Aktif'")->row_array();
    }

    // rincian apbd 
    public function rincian_struktur_anggaran($kode, $thn, $kelompok)
    {
        return $this->db->query("SELECT * FROM temp_rincian_struktur_apbd WHERE thn='$thn' AND kelompok='$kelompok' AND kd_satker='$kode'")->row_array();
    }
   // end

    // total anggaran apbd murni
    public function total_anggaran_murni($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_murni WHERE kd_satker_rup='$kode' AND thn_ang='$thn'")->row_array();
    }
    // end

    // total anggaran apbd perubahan
    public function total_anggaran_perubahan($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_perubahan WHERE kd_satker_rup='$kode' AND thn_ang='$thn'")->row_array();
    }
    // end

    // program murni
    public function program_murni($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total,kd_program,nama_program  FROM apbd_sipd_murni WHERE kd_satker_rup='$kode' AND thn_ang='$thn' GROUP BY kd_program ORDER BY kd_program ASC");
    }
    // end

    // program perubahan
    public function program_perubahan($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total,kd_program,nama_program  FROM apbd_sipd_perubahan WHERE kd_satker_rup='$kode' AND thn_ang='$thn' GROUP BY kd_program ORDER BY kd_program ASC");
    }
    // end

    // kegiatan murni
    public function kegiatan_murni($kode_satker, $kode_program, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total,kd_kegiatan,nama_kegiatan  FROM apbd_sipd_murni WHERE kd_satker_rup='$kode_satker' and kd_program='$kode_program' AND thn_ang='$thn' GROUP BY kd_kegiatan ORDER BY kd_kegiatan ASC");
    }
    // end

    // kegiatan perubahan
    public function kegiatan_perubahan($kode_satker, $kode_program, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total,kd_kegiatan,nama_kegiatan  FROM apbd_sipd_perubahan WHERE kd_satker_rup='$kode_satker' and kd_program='$kode_program' AND thn_ang='$thn' GROUP BY kd_kegiatan ORDER BY kd_kegiatan ASC");
    }
    // end

    // subkegiatan murni
    public function subkegiatan_murni($kode_satker, $kode_program, $kode_kegiatan, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total,kd_subkegiatan,nama_subkegiatan  FROM apbd_sipd_murni WHERE kd_satker_rup='$kode_satker' and kd_program='$kode_program' and kd_kegiatan='$kode_kegiatan' AND thn_ang='$thn' GROUP BY kd_subkegiatan ORDER BY kd_subkegiatan ASC");
    }
     // end

    // subkegiatan perubahan
    public function subkegiatan_perubahan($kode_satker, $kode_program, $kode_kegiatan, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total,kd_subkegiatan,nama_subkegiatan  FROM apbd_sipd_perubahan WHERE kd_satker_rup='$kode_satker' and kd_program='$kode_program' and kd_kegiatan='$kode_kegiatan' AND thn_ang='$thn' GROUP BY kd_subkegiatan ORDER BY kd_subkegiatan ASC");
    }
    // end

    
    // info apbd murni
    public function info_apbd_murni($kode, $thn)
    {
        return $this->db->query("SELECT nama_program,nama_kegiatan,nama_subkegiatan  FROM apbd_sipd_murni WHERE kd_subkegiatan='$kode' AND thn_ang='$thn' GROUP BY kd_subkegiatan ORDER BY kd_subkegiatan ASC")->row_array();
    }
    // end

    // info apbd perubahan
    public function info_apbd_perubahan($kode, $thn)
    {
        return $this->db->query("SELECT nama_program,nama_kegiatan,nama_subkegiatan  FROM apbd_sipd_perubahan WHERE kd_subkegiatan='$kode' AND thn_ang='$thn' GROUP BY kd_subkegiatan ORDER BY kd_subkegiatan ASC")->row_array();
    }
    // end

    // detail murni
    public function detail_murni($kode, $thn)
    {
        return $this->db->query("SELECT kd_rekening,rincian,pagu  FROM apbd_sipd_murni WHERE kd_subkegiatan='$kode' AND thn_ang='$thn' ORDER BY kd_rekening ASC");
    }
    // end

    // detail murni
    public function detail_perubahan($kode, $thn)
    {
        return $this->db->query("SELECT kd_rekening,rincian,pagu  FROM apbd_sipd_perubahan WHERE kd_subkegiatan='$kode' AND thn_ang='$thn' ORDER BY kd_rekening ASC");
    }
    // end

    // revisi paket
    public function revisi($thn, $qcari)
    {
        return $this->db->query("SELECT * FROM rup_historyrevisi WHERE tahun_anggaran='$thn' AND $qcari 
                                AND tipe<>'PEMBATALAN' AND tipe<>'PENGAKTIFAN' ORDER BY tanggal_kaji_ulang DESC");
    }
    // end

    // cek rup swakelola
    public function cek_rup_swakelola($kode)
    {
        return $this->db->query("SELECT nama_paket,id_satker FROM rup_swakelola WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // cek tahapan tender
    public function tahapan($kode)
    {
        return $this->db->query("SELECT tahapan
                                    FROM tenderjadwal
                                        WHERE kd_lelang='$kode' order by kd_akt DESC limit 0,1")->row_array();
    }

    // apbd 
    public function realisasi_rekapitulasi($kode, $thn)
    {
        return $this->db->query("SELECT * FROM temp_realisasi_rekapitulasi WHERE thn='$thn' AND kd_satker='$kode'")->row_array();
    }
    // end

    // apbd 
    public function realisasi_triwulan($kode, $thn)
    {
        return $this->db->query("SELECT * FROM temp_satker_triwulan WHERE thn='$thn' AND kd_satker='$kode'")->row_array();
    }
    // end

    public function rincian($table, $thn, $qcari, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn'
                                AND $qcari
                                AND $qkelompok
                                ORDER BY $order ASC");
    }

    // realisasi tender
    public function realisasi_tender($kode)
    {
        return $this->db->query("SELECT besar_pembayaran_bap FROM realisasi_tender WHERE kd_tender='$kode'")->row_array();
    }
    // end

    // realisasi non tender
    public function realisasi_nontender($kode)
    {
        return $this->db->query("SELECT besar_pembayaran_bap FROM realisasi_nontender WHERE kd_nontender='$kode'")->row_array();
    }
    // end

    public function rincian_sb($table, $thn, $qcari, $qanggaran, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qanggaran 
                                AND $qkelompok
                                ORDER BY $order ASC");
    }

    // provinsi
    public function provinsi()
    {
        return $this->db->query("SELECT provinsi, COUNT(provinsi) AS total 
                                    FROM penyedia 
                                        WHERE provinsi<>'' 
                                    GROUP BY provinsi 
                                        ORDER BY provinsi ASC ");
    }

    // kota
    public function kota($provinsi)
    {
        return $this->db->query("SELECT kabupaten_kota, COUNT(kabupaten_kota) AS total 
                                    FROM penyedia 
                                        WHERE provinsi='$provinsi' 
                                    GROUP BY kabupaten_kota 
                                        ORDER BY kabupaten_kota ASC");
    }

    public function daftar_penyedia($kabupaten_kota, $kelompok, $thn, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.kd_penyedia,b.nama_penyedia
                                FROM temp_monitoring_penyedia a 
                                    INNER JOIN penyedia b
                                    on a.kd_penyedia=b.kd_penyedia
                                WHERE a.thn='$thn'
                                    AND a.kelompok='$kelompok'
                                    AND b.kabupaten_kota='$kabupaten_kota'
                                    AND $qcari 
                                ORDER BY a.total_paket DESC");
    }

    // detail paket
    public function detail_paket($table, $thn, $qkelompok, $qstatus, $qcari, $orderby)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan 
                                FROM $table a 
                                    inner join satker b
                                        on a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                    AND $qkelompok
                                    AND $qstatus 
                                    AND $qcari 
                                ORDER BY $orderby ASC");
    }

    public function daftar_ppk($thn, $qkelompok, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nip_pegawai,b.nama_pegawai
                                FROM temp_monitoring_ppk a 
                                    INNER JOIN pegawai b
                                        on a.kd_pegawai=b.kd_pegawai
                                WHERE a.total_paket<>'0' 
                                    AND a.thn='$thn'
                                    AND $qkelompok 
                                    AND $qcari 
                                ORDER BY b.nip_pegawai ASC");
    }

    public function daftar_personil($thn, $qpersonil, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nip_pegawai,b.nama_pegawai
                                FROM temp_monitoring_personil a 
                                    INNER JOIN pegawai b
                                        on a.kd_pegawai=b.kd_pegawai
                                WHERE a.total_paket<>'0' 
                                    AND a.thn='$thn'
                                    AND $qpersonil  
                                    AND $qcari 
                                ORDER BY b.nip_pegawai ASC");
    }

    public function detail_pokja($thn, $nip, $status, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        c.nama_satker, c.singkatan 
                                    FROM tender a 
                                        inner join pokja_pemilihan b
                                            on a.kd_pokja = b.kd_pokja
                                        inner join satker c
                                            on a.kd_satker=c.kd_satker
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND  a.nama_status_tender like '%$status' 
                                    AND $qcari
                                    AND (b.nip_personil1='$nip' or 
                                            b.nip_personil2='$nip' or 
                                            b.nip_personil3='$nip' or 
                                            b.nip_personil4='$nip' or 
                                            b.nip_personil5='$nip')
                                    ORDER BY a.kd_rup_paket ASC");
    }

    public function detail_pp($thn, $nip, $status, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan
                                    FROM non_tender a
                                        inner join satker b
                                            on a.kd_satker=b.kd_satker
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND a.nip_pejabat_pengadaan='$nip'
                                        AND a.nama_status_nontender='$status'
                                        AND $qcari 
                                    ORDER BY a.kd_rup_paket ASC");
    }

    // rincian
    public function rincian_kelkerja($thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker  
                                    FROM pokja_pemilihan a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                AND $qcari 
                                ORDER BY a.kd_pokja ASC");
    }
    // end

    // tender
    public function cek_tender($kode)
    {
        return $this->db->query("SELECT nama_paket,ang,pagu,hps,nilai_kontrak,kd_penyedia FROM tender WHERE kd_tender='$kode'")->row_array();
    }
    // end
}
