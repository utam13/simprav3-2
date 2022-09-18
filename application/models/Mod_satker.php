<?
class mod_satker extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }
    
   // rincian
    public function daftar($start, $limit, $qcari)
    {
        return $this->db->query("SELECT * FROM satker WHERE $qcari ORDER BY nama_satker ASC LIMIT $start,$limit");
    }

    public function jumlah($qcari)
    {
        return $this->db->query("SELECT * FROM satker WHERE $qcari")->num_rows();
    }
    // end

    // cek penyedia
    public function cek_singkatan($singkatan)
    {
        return $this->db->query("SELECT singkatan FROM satker WHERE singkatan='$singkatan'")->num_rows();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("SELECT nama_satker FROM satker WHERE nama_satker='$nama'")->num_rows();
    }

    // public function cek_npwp($npwp)
    // {
    //     return $this->db->query("SELECT npwp_penyedia FROM penyedia WHERE npwp_penyedia='$npwp'")->num_rows();
    // }

    // public function cek_email($email)
    // {
    //     return $this->db->query("SELECT email FROM penyedia WHERE email='$email'")->num_rows();
    // }

    public function cek_satker($kode)
    {
        return $this->db->query("SELECT nama_satker FROM satker WHERE kd_satker='$kode'")->row_array();
    }
    // end

    // proses data
    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into satker(kd_satker,
                                                kdunit_satker,
                                                nama_satker,
                                                singkatan,
                                                npwp_satker,
                                                alamat_satker,
                                                no_telp_satker,
                                                email_satker,
                                                kota,
                                                provinsi) 
                                        values('$kd_satker',
                                                '$kdunit_satker',
                                                '$nama_satker',
                                                '$singkatan',
                                                '$npwp_satker',
                                                '$alamat_satker',
                                                '$no_telp_satker',
                                                '$email_satker',
                                                '$kota',
                                                '$provinsi')");

    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update satker set kdunit_satker='$kdunit_satker',
                                                nama_satker='$nama_satker',
                                                singkatan='$singkatan',
                                                npwp_satker='$npwp_satker',
                                                alamat_satker='$alamat_satker',
                                                no_telp_satker='$no_telp_satker',
                                                email_satker='$email_satker',
                                                kota='$kota',
                                                provinsi='$provinsi'
                                            where kd_satker='$kd_satker'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from satker where kd_satker='$kode'");
    }
}