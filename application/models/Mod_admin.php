<?
class mod_admin extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select * from kantor")->row_array();
    }

    public function jml_pegawai()
    {
        return $this->db->query("select kd_pegawai from pegawai")->num_rows();
    }

    public function jml_penyedia()
    {
        return $this->db->query("select kd_penyedia from penyedia")->num_rows();
    }
}
