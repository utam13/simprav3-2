<?
class mod_dashboard extends CI_Model
{
    // temp tender rekapitulasi metode
    public function tender_rekapitulasi_metode($kolom, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM($kolom),0) as total FROM temp_tender_rekapitulasi_metode WHERE thn='$thn' and (metode='Seleksi' or metode='Tender' or metode='Tender Cepat') ")->row_array();
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

    // rekapitulasi pencatatan epurchasing
    public function rekapitulasi_pencatatan_epurchasing($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu_rup),0) as total 
                                    FROM epurchasing a 
                                        inner join rup_penyedia b
                                            on a.rup_id=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND b.penyedia_didalam_swakelola='tidak' 
                                    AND b.status_aktif='ya' AND b.status_umumkan='sudah'")->row_array();
    }
    // end

    // rekapitulasi pencatatan nontender
    public function rekapitulasi_pencatatan_nontender($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_nontender a 
                                        inner join rup_penyedia b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' ")->row_array();
    }
    // end

    // rekapitulasi pencatatan swakelola
    public function rekapitulasi_pencatatan_swakelola($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_swakelola a 
                                        inner join rup_swakelola b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND a.status_swakelola_pct='Aktif'")->row_array();
    }
    // end

    // rekapitulasi proses epurchasing
    public function rekapitulasi_proses_epurchasing($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu_rup),0) as total 
                                    FROM epurchasing a 
                                        inner join rup_penyedia b
                                            on a.rup_id=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND b.penyedia_didalam_swakelola='tidak' 
                                        AND b.status_aktif='ya' 
                                        AND b.status_umumkan='sudah' 
                                        AND a.paket_status_str='Paket Proses'")->row_array();
    }
    // end

    // rekapitulasi selesai epurchasing
    public function rekapitulasi_selesai_epurchasing($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu_rup),0) as total_pagu,
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
    // end
    
    public function belanja_pengadaan($thn)
    {
        return $this->db->query("SELECT * FROM grafik_belanja_pengadaan 
                                    WHERE thn='$thn' 
                                        ORDER BY jenis_pengadaan ASC");
    }

    public function rup($thn, $kelompok)
    {
        return $this->db->query("SELECT * FROM grafik_rup 
                                    WHERE thn='$thn'
                                        AND kelompok='$kelompok'
                                        ORDER BY kategori ASC");
    }

    public function tender_nontender($thn, $kelompok)
    {
        return $this->db->query("SELECT * FROM grafik_tender_nontender where thn='$thn' and kelompok='$kelompok' ORDER BY kategori ASC");
    }

    public function rup_swakelola_rpp($thn)
    {
        return $this->db->query("SELECT COUNT(kode_rup) AS total_paket,  
                                        COALESCE(SUM(pagu_rup),0) as total_pagu 
                                    FROM rup_swakelola 
                                    WHERE tahun_anggaran='$thn'")->row_array();
    }

    public function temp_rencana_paket_pengadaan($thn)
    {
        return $this->db->query("SELECT * FROM temp_rencana_paket_pengadaan WHERE thn='$thn' ORDER BY jenis_pengadaan ASC");
    }

    public function temp_mekanisme_lainnya($thn)
    {
        return $this->db->query("SELECT * FROM temp_mekanisme_lainnya WHERE thn='$thn' ORDER BY mekanisme ASC");
    }
}