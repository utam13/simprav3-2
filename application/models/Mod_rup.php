<?
class mod_rup extends CI_Model
{
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
    public function paket_penyedia($start, $limit, $thn, $kode_satker, $qcari)
    {
        return $this->db->query("SELECT kegiatan,nama_paket,metode_pemilihan,pagu_rup,jenis_pengadaan,sumber_dana,kode_rup,awal_pengadaan FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='tidak' AND status_aktif='ya' AND status_umumkan='sudah' $qcari ORDER BY nama_paket ASC LIMIT $start,$limit");
    }

    public function jumlah_paket_penyedia($thn, $kode_satker, $qcari)
    {
        return $this->db->query("SELECT kegiatan,nama_paket,metode_pemilihan,pagu_rup,jenis_pengadaan,sumber_dana,kode_rup,awal_pengadaan FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='tidak' AND status_aktif='ya' AND status_umumkan='sudah' $qcari")->num_rows();
    }
    // end

    // paket swakelola 
    public function paket_swakelola($start, $limit, $thn, $kode_satker, $qcari)
    {
        return $this->db->query("SELECT kegiatan,nama_paket,tipe_swakelola,pagu_rup,sumber_dana,kode_rup,awal_pekerjaan FROM rup_swakelola WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND status_aktif='ya' AND status_umumkan='sudah' $qcari ORDER BY nama_paket ASC LIMIT $start,$limit");
    }

    public function jumlah_paket_swakelola($thn, $kode_satker, $qcari)
    {
        return $this->db->query("SELECT kegiatan,nama_paket,tipe_swakelola,pagu_rup,sumber_dana,kode_rup,awal_pekerjaan FROM rup_swakelola WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND status_aktif='ya' AND status_umumkan='sudah' $qcari")->num_rows();
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

    // revisi paket
    public function revisi($start, $limit, $thn, $qcari)
    {
        return $this->db->query("SELECT * FROM rup_historyrevisi WHERE tahun_anggaran='$thn' AND $qcari 
                                AND tipe<>'PEMBATALAN' AND tipe<>'PENGAKTIFAN' ORDER BY tanggal_kaji_ulang DESC LIMIT $start,$limit");
    }

    public function jumlah_revisi($thn, $qcari)
    {
        return $this->db->query("SELECT * FROM rup_historyrevisi WHERE tahun_anggaran='$thn' AND $qcari
                                AND tipe<>'PEMBATALAN' AND tipe<>'PENGAKTIFAN' ")->num_rows();
    }
    // end

    // cek rup penyedia
    public function cek_rup_penyedia($kode)
    {
        return $this->db->query("SELECT nama_paket,id_satker  FROM rup_penyedia WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // cek rup swakelola
    public function cek_rup_swakelola($kode)
    {
        return $this->db->query("SELECT nama_paket,id_satker  FROM rup_swakelola WHERE kode_rup='$kode'")->row_array();
    }
    // end
}