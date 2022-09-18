<?
class mod_pencatatan extends CI_Model
{
    // pencatatan nontender
    public function daftar($start, $limit, $thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pct_nontender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                ORDER BY a.kd_nontender_pct ASC LIMIT $start,$limit");
    }

    public function jumlah($thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pct_nontender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari")->num_rows();
    }
    // end

    // rup penyedia
    public function cek_rup_penyedia($kode)
    {
        return $this->db->query("SELECT kegiatan,sumber_dana FROM rup_penyedia WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // pegawai
    public function cek_pegawai($kode)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$kode' AND status_ppk='ya'")->row_array();
    }
    // end

    // penyedia
    public function cek_penyedia($kode)
    {
        return $this->db->query("SELECT nama_penyedia,alamat_penyedia,kabupaten_kota FROM penyedia WHERE kd_penyedia='$kode'")->row_array();
    }
    // end

    // pencatatan swakelola
    public function daftar2($start, $limit, $thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pct_swakelola a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                ORDER BY a.kd_swakelola_pct ASC LIMIT $start,$limit");
    }

    public function jumlah2($thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pct_swakelola a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari")->num_rows();
    }
    // end

    // rup swakelola
    public function cek_rup_penyedia2($kode)
    {
        return $this->db->query("SELECT kegiatan,sumber_dana FROM rup_swakelola WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // pegawai
    public function cek_pegawai2($kode)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$kode' AND status_ppk='ya'")->row_array();
    }
    // end
}