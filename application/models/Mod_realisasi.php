<?
class mod_realisasi extends CI_Model
{
    // satker
    public function satker()
    {
        return $this->db->query("SELECT kd_satker,singkatan,nama_satker FROM satker order by kdunit_satker ASC");
    }
    // end

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

    // rincian
    public function rincian($start, $limit, $table, $thn, $qcari, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qkelompok
                                ORDER BY $order ASC LIMIT $start,$limit");
    }

    public function jumlah_rincian($table, $thn, $qcari, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qkelompok
                                ORDER BY $order ASC")->num_rows();
    }
    // end

    // rup penyedia
    public function cek_rup_penyedia($kode)
    {
        return $this->db->query("SELECT kegiatan FROM rup_penyedia WHERE kode_rup='$kode'")->row_array();
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

    // status tender
    public function status_tender($kode, $status, $nilai)
    {
        $this->db->query("update tender set $status='$nilai' WHERE kd_tender='$kode'");
    }
    // end

    // status nontender
    public function status_nontender($kode, $status, $nilai)
    {
        $this->db->query("update non_tender set $status='$nilai' WHERE kd_nontender='$kode'");
    }
    // end
}