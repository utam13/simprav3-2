<?
class mod_tender extends CI_Model
{
    // metode
    public function metode($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_metode WHERE thn='$thn'");
    }
    // end

    // jenis
    public function jenis($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_jenis WHERE thn='$thn'");
    }
    // end

    // jenis
    public function total_pagu_anggaran($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(total_pagu_anggaran),0) as total FROM temp_tender_rekapitulasi_jenis WHERE thn='$thn'")->row_array();
    }
    // end

    // satker
    public function satker($thn)
    {
        return $this->db->query("SELECT * FROM temp_tender_rekapitulasi_satker WHERE thn='$thn'");
    }

    public function cek_satker($kode)
    {
        return $this->db->query("SELECT kd_satker,singkatan,nama_satker FROM satker WHERE kd_satker='$kode'")->row_array();
    }

    public function total_anggaran($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(total),0) as total FROM temp_tender_rekapitulasi_satker WHERE thn='$thn'")->row_array();
    }
    // end

    // rincian tender
    public function rincian($start, $limit, $thn, $qcari, $qkelompok)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM tender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qkelompok
                                ORDER BY a.kd_paket ASC LIMIT $start,$limit");
    }

    public function jumlah_rincian($thn, $qcari, $qkelompok)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM tender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qkelompok
                                ORDER BY a.kd_paket ASC")->num_rows();
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

    // total pagu
    public function total_pagu($thn, $qkelompok)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total
                                    FROM tender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qkelompok")->row_array();
    }
    // end

    // total tender
    public function total_tender($thn, $qkelompok)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.nilai_negosiasi),0) as total
                                    FROM tender a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qkelompok")->row_array();
    }
    // end

    // cek tahapan tender
    public function tahapan($kode)
    {
        return $this->db->query("SELECT tahapan
                                    FROM tenderjadwal
                                        WHERE kd_lelang='$kode' order by kd_akt DESC limit 0,1")->row_array();
    }
}