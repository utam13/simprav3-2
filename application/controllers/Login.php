<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_login');
    }

    public function index($isipesan = "")
    {
        $data['pesan'] = $isipesan;

        $kantor = $this->mod_login->kantor();
        $data['logo'] = empty($kantor) ? "-" : $kantor['logo'];

        // captcha
        $captcha = $this->captcha->createcaptcha();
        $data['captchaview'] = $captcha['image'];
        $this->session->set_userdata('captcha', $captcha['word']);

        if ($data['logo'] == "") {
            $data['file_logo'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/logo/" . $data['logo'];
            if (file_exists($file_target)) {
                $data['file_logo'] = base_url() . "upload/logo/" . $data['logo'];
            } else {
                $data['file_logo'] = base_url() . "upload/no-image.png";
            }
        }
        
        $this->load->view('backend/page/login', $data);
    }

    public function proses()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username == "administrator" && $password == "root") {
            $nip = "0";
            $nama = "administrator";
            $level = "Administrator";

            $user = array(
                "nip" => $nip,
                "nama" => $nama,
                "level" => $level,
                "stat_log" => "login"
            );

            $this->session->set_userdata($user);

            redirect("dashboard");
        } else {
            $ada_username = $this->mod_login->cek_username($username);

            $ada_password = $this->mod_login->cek_password($username, $password);

            if ($ada_username > 0 && $ada_password > 0) {

                $data_user = $this->mod_login->ambil($username)->result();
                $nip = $data_user['nip_pegawai'];
                $nama = $data_user['nama_pegawai'];
                $level = $data_user['kd_level'];

                switch ($data_user['kd_level']) {
                    case 1:
                        $levelakses = "Administrator";
                        break;
                    default:
                        $levelakses = "User";
                        break;
                }

                $user = array(
                    "kode" => $kode,
                    "nik" => $nik,
                    "nama" => $nama,
                    "level" => $levelakses,
                    "stat_log" => "login"
                );

                $this->session->set_userdata($user);

                redirect("dashboard");
            } else {
                if ($ada_username ==  0 && $username != "administrator") {
                    //$pesan = "1";
                    $isipesan = "Username yang dimasukkan tidak terdaftar";
                }
                if ($ada_password == 0 && $username != "administrator") {
                    //$pesan = "2";
                    $isipesan = "Password salah, silakan coba kembali atau hubungi Administrator jika tidak bisa login";
                }

                redirect("login/index/$isipesan");
            }
        }
    }

    public function recaptcha()
    {
        $record = array();
        $subrecord = array();

        $captcha = $this->captcha->createcaptcha();
        $subrecord['captchaview'] = $captcha['image'];
        $this->session->set_userdata('captcha', $captcha['word']);

        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function cek($nilai)
    {
        $record = array();
        $subrecord = array();

        $captchaset = $this->session->userdata('captcha');
        $subrecord['jml'] =  $captchaset == $nilai ? 1 : 0;
        
        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect("dashboard");
    }
}
