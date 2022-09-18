<?
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_pegawai');
    }


    public function index($page = 1, $limit = 20, $kategoricari = "-", $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Pegawai";

        $kantor = $this->mod_pegawai->kantor();
        $data['logo'] = empty($kantor) ? "-" : $kantor['logo'];

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

        $data['alert'] = $this->alert_lib->alert($pesan, str_replace("-"," ",$isipesan));

        // cari
        if ($isicari != "-" && $isicari != "") {
            $getcari = urldecode($isicari);
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $data['getcari'] = $getcari;

        if($getcari == "")  {
            $qcari = "nip_pegawai<>''";
        } else {
            $qcari = "(nip_pegawai like '%$getcari%' or nama_pegawai like '%$getcari%')";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_pegawai->jumlah($qcari);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $limit_start = ($page - 1) * $limit;

        $no = $limit_start + 1;

        $record = array();
        $subrecord = array();

        $daftar = $this->mod_pegawai->daftar($limit_start, $limit, $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kd_pegawai'] = $d->kd_pegawai;
            $subrecord['nip_pegawai'] = $d->nip_pegawai;
            $subrecord['nama_pegawai'] = $d->nama_pegawai;
            $subrecord['jabatan'] = $d->jabatan == "" ? "-" : $d->jabatan;
            $subrecord['email_ppk'] = $d->email_ppk == "" ? "-" : $d->email_ppk;
            $subrecord['no_sk_pegawai'] = $d->no_sk_pegawai == "" ? "-" : $d->no_sk_pegawai;
            $subrecord['no_sk_role'] = $d->no_sk_role == "" ? "-" : $d->no_sk_role;
            $subrecord['pembuat_sk_role'] = $d->pembuat_sk_role == "" ? "-" : $d->pembuat_sk_role;
            $subrecord['tgl_awal_role'] = $d->tgl_awal_role == "" || $d->tgl_awal_role == "-" ? "?" : date('d-m-Y',strtotime($d->tgl_awal_role));
            $subrecord['tgl_awal'] = $d->tgl_awal_role == "" || $d->tgl_awal_role == "-" ? "?" : date('Y-m-d',strtotime($d->tgl_awal_role));
            $subrecord['tgl_akhir_role'] = $d->tgl_akhir_role == "" || $d->tgl_akhir_role == "-" ? "?" : date('d-m-Y',strtotime($d->tgl_akhir_role));
            $subrecord['tgl_akhir'] = $d->tgl_akhir_role == "" || $d->tgl_akhir_role == "-" ? "?" : date('Y-m-d',strtotime($d->tgl_akhir_role));
            
            $subrecord['tgl_sk_role'] = $subrecord['tgl_awal_role'] . " - ". $subrecord['tgl_akhir_role'];
            
            $subrecord['kd_level'] = $d->kd_level == "" ? "-" : $d->kd_level;
            $subrecord['kd_satker'] = $d->kd_satker == "" ? "-" : $d->kd_satker;

            $satker = $this->mod_pegawai->cek_satker($d->kd_satker);
            $subrecord['nama_satker'] = empty($satker) || $satker['nama_satker'] == "" ? "-" : $satker['nama_satker'];

            $subrecord['username'] = $d->username == "" ? "-" : $d->username;
            $subrecord['password'] = $d->password == "" ? "-" : $d->password;
            $subrecord['status_ppk'] = $d->status_ppk;
            $subrecord['status_pokja'] = $d->status_pokja;
            $subrecord['status_pejabatpengadaan'] = $d->status_pejabatpengadaan;
            $subrecord['status_aktif_pegawai'] = $d->status_aktif_pegawai;

            $subrecord['role'] = "-";
            if($d->status_ppk == "ya"){
                $subrecord['role'] = "PPK (Pejabat Pembuat Komitmen)";
            }

            if($d->status_pokja == "ya"){
                if($subrecord['role'] == "-"){
                    $subrecord['role'] = "Pokja Pemilihan";
                } else {
                    $subrecord['role'] .= ", Pokja Pemilihan";
                }
            }

            if($d->status_pejabatpengadaan == "ya"){
                if($subrecord['role'] == "-"){
                    $subrecord['role'] = "Pejabat Pengadaan";
                } else {
                    $subrecord['role'] .= ", Pejabat Pengadaan";
                }
            }

            switch ($d->kd_level) {
                case '1':
                    $subrecord['level'] = "Administrator";
                    break;
                default:
                    $subrecord['level'] = "User";
                    break;
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        // satker
        $data['satker']= $this->mod_pegawai->satker()->result();

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/pegawai');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function cek($jenis,$nilai)
    {
        $cari = urldecode($nilai);

        switch ($jenis) {
            case 'nip':
                $cek_nip = $this->mod_pegawai->cek_nip($cari);
                echo $cek_nip;
                break;
            case 'username':
                $cek_username = $this->mod_pegawai->cek_username($cari);
                echo $cek_username;
                break;
        }
    }

    public function proses($proses, $kode = "")
    {
        $kd_pegawai = $this->input->post('kode');
        $awal = $this->input->post('awal');
        $nip = $this->input->post('nip');
        $nama = $this->clear_string->clear_quotes(ucwords($this->input->post('nama')));
        $jabatan = $this->input->post('jabatan');
        $satker = $this->input->post('satker');
        $email = $this->input->post('email');
        $sk_pegawai = $this->input->post('sk_pegawai');
        $sk_role = $this->input->post('sk_role');
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        
        $ppk = $this->input->post('role_ppk');
        if($ppk != "ya"){
            $ppk = "tidak";
        }

        $pokja = $this->input->post('role_pokja');
        if($pokja != "ya"){
            $pokja = "tidak";
        }

        $pengadaan = $this->input->post('role_pengadaan');
        if($pengadaan != "ya"){
            $pengadaan = "tidak";
        }

        $levelakses = $this->input->post('levelakses');
        $username = $this->input->post('userakses');
        $password = $this->input->post('userpass');

        if ($proses != 3) {
            

            $data = array(
                "kode" => $kd_pegawai,
                "nip" => $nip,
                "nama" => $nama,
                "jabatan" => $jabatan,
                "satker" => $satker,
                "email" => $email,
                "sk_pegawai" => $sk_pegawai,
                "sk_role" => $sk_role,
                "tgl_awal" => $tgl_awal,
                "tgl_akhir" => $tgl_akhir,
                "ppk" => $ppk,
                "pokja" => $pokja,
                "pengadaan" => $pengadaan,
                "levelakses" => $levelakses,
                "username" => $username,
                "password" => $password
            );
        }

        switch ($proses) {
            case 1:
                $this->mod_pegawai->simpan($data);
                $pesan = 1;
                $isipesan = "Data Pegawai baru $nip $nama di tambahkan";
                break;
            case 2:
                $this->mod_pegawai->ubah($data);

                $pesan = 2;
                $isipesan = "Data Pegawai $nip $nama diubah";
                break;
            case 3:
                $cek_pegawai = $this->mod_pegawai->cek_pegawai($kode);
                $nip = $cek_pegawai['nip_pegawai'];
                $nama = $cek_pegawai['nama_pegawai'];

                $this->mod_pegawai->hapus($kode);

                $pesan = 3;
                $isipesan = "Pegawai $nip $nama telah dihapus";
                break;
        }

        //save log
        // $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);
        // print_r($data);
        redirect("pegawai/index/1/20/-/-/$pesan/$isipesan");
    }
}
