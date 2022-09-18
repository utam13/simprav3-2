<?
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_admin');
    }


    public function index($page = 1, $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Dashboard";

        $data['alert'] = $this->alert_lib->alert($pesan, $isipesan);

        $kantor = $this->mod_admin->kantor();
        $data['nama'] = empty($kantor) ? "-" : html_entity_decode($kantor['nama']);
        $data['alamat'] = empty($kantor) ? "-" : html_entity_decode($kantor['alamat']);
        $data['telp'] = empty($kantor) ? "-" : $kantor['telp'];
        $data['email'] = empty($kantor) ? "-" : $kantor['email'];
        $data['googlemap'] = empty($kantor) ? "-" : $kantor['googlemap'];
        $data['logo'] = empty($kantor) ? "-" : $kantor['logo'];

        if ($data['logo'] == "") {
            $data['gambar_logo'] = "logoapp";
            $data['file_logo'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/logo/" . $data['logo'];
            if (file_exists($file_target)) {
                $data['gambar_logo'] = $data['logo'];
                $data['file_logo'] = base_url() . "upload/logo/" . $data['logo'];
            } else {
                $data['gambar_logo'] = "logoapp";
                $data['file_logo'] = base_url() . "upload/no-image.png";
            }
        }

        $jml_pegawai = $this->mod_admin->jml_pegawai();
        $data['jml_pegawai'] = number_format($jml_pegawai,0,',','.');

        $jml_penyedia = $this->mod_admin->jml_penyedia();
        $data['jml_penyedia'] =  number_format($jml_penyedia,0,',','.');

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/dashboard');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }
}
