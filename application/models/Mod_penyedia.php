<?
class mod_penyedia extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }
    
   // rincian
    public function daftar($start, $limit, $qcari)
    {
        return $this->db->query("SELECT * FROM penyedia WHERE $qcari ORDER BY nama_penyedia ASC LIMIT $start,$limit");
    }

    public function jumlah($qcari)
    {
        return $this->db->query("SELECT * FROM penyedia WHERE $qcari")->num_rows();
    }
    // end

    // cek penyedia
    public function cek_kode($kode)
    {
        return $this->db->query("SELECT kode_penyedia FROM penyedia WHERE kd_penyedia='$kode'")->num_rows();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("SELECT nama_penyedia FROM penyedia WHERE nama_penyedia='$nama'")->num_rows();
    }

    public function cek_npwp($npwp)
    {
        return $this->db->query("SELECT npwp_penyedia FROM penyedia WHERE npwp_penyedia='$npwp'")->num_rows();
    }

    public function cek_email($email)
    {
        return $this->db->query("SELECT email FROM penyedia WHERE email='$email'")->num_rows();
    }

    public function cek_penyedia($kode)
    {
        return $this->db->query("SELECT nama_penyedia FROM penyedia WHERE kd_penyedia='$kode'")->row_array();
    }
    // end

    // proses data
    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into penyedia(kd_penyedia,
                                                nama_penyedia,
                                                bentuk_usaha,
                                                user_lpse,
                                                npwp_penyedia,
                                                alamat_penyedia,
                                                kabupaten_kota,
                                                provinsi,
                                                email,
                                                no_telp,
                                                no_pkp,
                                                lpse_terdaftar,
                                                status_aktif_agregasi) 
                                        values('$kd_penyedia',
                                                '$nama_penyedia',
                                                '$bentuk_usaha',
                                                '$user_lpse',
                                                '$npwp_penyedia',
                                                '$alamat_penyedia',
                                                '$kabupaten_kota',
                                                '$provinsi',
                                                '$email',
                                                '$no_telp',
                                                '$no_pkp',
                                                '$lpse_terdaftar',
                                                '$status_aktif_agregasi')");

        // tgl_terdaftar,
        // tgl_verifikasi,
        // '$tgl_terdaftar',
        // '$tgl_verifikasi',

    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update penyedia set nama_penyedia='$nama_penyedia',
                                                bentuk_usaha='$bentuk_usaha',
                                                user_lpse='$user_lpse',
                                                npwp_penyedia='$npwp_penyedia',
                                                alamat_penyedia='$alamat_penyedia',
                                                kabupaten_kota='$kabupaten_kota',
                                                provinsi='$provinsi',
                                                email='$email',
                                                no_telp='$no_telp',
                                                no_pkp='$no_pkp',
                                                lpse_terdaftar='$lpse_terdaftar',
                                                status_aktif_agregasi='$status_aktif_agregasi' 
                                            where kd_penyedia='$kd_penyedia'");
        // tgl_terdaftar='$tgl_terdaftar',
        // tgl_verifikasi='$tgl_verifikasi',
    }

    public function hapus($kode)
    {
        $this->db->query("delete from penyedia where kd_penyedia='$kode'");
    }
}