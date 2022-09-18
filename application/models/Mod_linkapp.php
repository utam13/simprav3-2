<?
class mod_linkapp extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }
    
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from linkapp where $q_cari order by kdlinkapp ASC limit $start,$end");
    }

    public function jumlah_data($q_cari)
    {
        return $this->db->query("select * from linkapp where $q_cari")->num_rows();
    }

    public function cek_url($url)
    {
        return $this->db->query("select kdlinkapp from linkapp where urlapp='$url'")->num_rows();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("select kdlinkapp from linkapp where nama='$nama'")->num_rows();
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from linkapp where kdlinkapp='$kode'");
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into linkapp(nama,
                                                urlapp,
                                                slide,
                                                iconapp)
                                    values('$nama',
                                            '$url',
                                            '$slide',
                                            '$icon')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update linkapp set nama='$nama',
                                            urlapp='$url',
                                            slide='$slide',
                                            iconapp='$icon' 
                                        where kdlinkapp='$kode'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from linkapp where kdlinkapp='$kode'");
    }
}
