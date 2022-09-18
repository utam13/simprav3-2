<?
class mod_login extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }

    public function cek_username($username)
    {
        return $this->db->query("select nip_pegawai from pegawai where username='$username'")->num_rows();
    }

    public function cek_password($username, $pass)
    {
        return $this->db->query("select nip_pegawai from pegawai where username='$username' and password='$pass'")->num_rows();
    }

    public function ambil($username)
    {
        return $this->db->query("select nip_pegawai,nama_pegawai,kd_level from pegawai where username='$username'")->row_array();
    }
}
