<?
class mod_struktur_apbd extends CI_Model
{
    // satker
    public function satker()
    {
        return $this->db->query("SELECT kd_satker,singkatan,nama_satker FROM satker order by kdunit_satker ASC");
    }
   // end

   // apbd 
    public function struktur_anggaran($thn, $kelompok)
    {
        return $this->db->query("SELECT * FROM temp_struktur_apbd WHERE thn='$thn' AND kelompok='$kelompok'")->row_array();
    }
   // end

   // rincian apbd 
    public function rincian_struktur_anggaran($kode, $thn, $kelompok)
    {
        return $this->db->query("SELECT * FROM temp_rincian_struktur_apbd WHERE thn='$thn' AND kelompok='$kelompok' AND kd_satker='$kode'")->row_array();
    }
   // end

    public function cek_satker($kode)
    {
        return $this->db->query("SELECT kd_satker,singkatan,nama_satker FROM satker WHERE kd_satker='$kode'")->row_array();
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
}