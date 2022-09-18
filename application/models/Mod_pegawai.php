<?
class mod_pegawai extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }

    // rincian
    public function daftar($start, $limit, $qcari)
    {
        return $this->db->query("SELECT * FROM pegawai WHERE $qcari ORDER BY nip_pegawai ASC LIMIT $start,$limit");
    }

    public function jumlah($qcari)
    {
        return $this->db->query("SELECT nip_pegawai FROM pegawai WHERE $qcari")->num_rows();
    }
    // end
    
    // satker
    public function satker()
    {
        return $this->db->query("SELECT kd_satker,nama_satker,singkatan FROM satker ORDER BY nama_satker ASC");
    }

    public function cek_satker($kode)
    {
        return $this->db->query("SELECT nama_satker FROM satker WHERE kd_satker='$kode'")->row_array();
    }
    // end

    // proses data
    public function cek_nip($nip)
    {
        return $this->db->query("SELECT nip_pegawai FROM pegawai WHERE nip_pegawai='$nip'")->num_rows();
    }

    public function cek_username($username)
    {
        return $this->db->query("SELECT nip_pegawai FROM pegawai WHERE username='$username'")->num_rows();
    }

    public function cek_pegawai($kode)
    {
        return $this->db->query("SELECT nip_pegawai,nama_pegawai FROM pegawai WHERE kd_pegawai='$kode'")->row_array();
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into pegawai(kd_pegawai,
                                            nip_pegawai,
                                            nama_pegawai,
                                            jabatan,
                                            email_ppk,
                                            no_sk_pegawai,
                                            no_sk_role,
                                            tgl_awal_role,
                                            tgl_akhir_role,
                                            kd_level,
                                            kd_satker,
                                            username,
                                            password,
                                            status_ppk,
                                            status_pokja,
                                            status_pejabatpengadaan) 
                                        values('$kode',
                                                '$nip',
                                                '$nama',
                                                '$jabatan',
                                                '$email',
                                                '$sk_pegawai',
                                                '$sk_role',
                                                '$tgl_awal',
                                                '$tgl_akhir',
                                                '$levelakses',
                                                '$satker',
                                                '$username',
                                                '$password',
                                                '$ppk',
                                                '$pokja',
                                                '$pengadaan')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update pegawai set nip_pegawai='$nip',
                                            nama_pegawai='$nama',
                                            jabatan='$jabatan',
                                            email_ppk='$email',
                                            no_sk_pegawai='$sk_pegawai',
                                            no_sk_role='$sk_role',
                                            tgl_awal_role='$tgl_awal',
                                            tgl_akhir_role='$tgl_akhir',
                                            kd_level='$levelakses',
                                            kd_satker='$satker',
                                            username='$username',
                                            password='$password',
                                            status_ppk='$ppk',
                                            status_pokja='$pokja',
                                            status_pejabatpengadaan='$pengadaan'
                                        where kd_pegawai='$kode'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from pegawai where kd_pegawai='$kode'");
    }
}