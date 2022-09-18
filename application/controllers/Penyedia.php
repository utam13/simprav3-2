<?
defined('BASEPATH') or exit('No direct script access allowed');

class Penyedia extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_penyedia');
    }


    public function index($page = 1, $limit = 20, $kategoricari = "-", $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Penyedia";

        $kantor = $this->mod_penyedia->kantor();
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
            $qcari = "kd_penyedia<>''";
        } else {
            $qcari = "(kd_penyedia like '%$getcari%' or nama_penyedia like '%$getcari%' or npwp_penyedia like '%$getcari%')";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_penyedia->jumlah($qcari);

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

        $daftar = $this->mod_penyedia->daftar($limit_start, $limit, $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;

            $subrecord['kd_penyedia'] = $d->kd_penyedia;
            $subrecord['nama_penyedia'] = $d->nama_penyedia;
            $subrecord['bentuk_usaha'] = $d->bentuk_usaha;
            $subrecord['user_lpse'] = $d->user_lpse;
            $subrecord['npwp_penyedia'] = $d->npwp_penyedia;
            $subrecord['alamat_penyedia'] = $d->alamat_penyedia == "" ? "-" : $d->alamat_penyedia;
            $subrecord['kabupaten_kota'] = $d->kabupaten_kota == "" ? "-" : $d->kabupaten_kota;
            $subrecord['provinsi'] = $d->provinsi == "" ? "-" : $d->provinsi;
            $subrecord['email'] = $d->email == "" ? "-" : $d->email;
            $subrecord['no_telp'] = $d->no_telp == "" ? "-" : $d->no_telp;
            $subrecord['no_pkp'] = $d->no_pkp == "" ? "-" : $d->no_pkp;
            $subrecord['lpse_terdaftar'] = $d->lpse_terdaftar == "" ? "-" : $d->lpse_terdaftar;
            // $subrecord['tgl_terdaftar'] = $d->tgl_terdaftar == "" ? "-" : date('d-m-Y',strtotime($d->tgl_terdaftar));
            // $subrecord['tgl_verifikasi'] = $d->tgl_terdaftar == "" ? "-" : date('d-m-Y',strtotime($d->tgl_terdaftar));
            $subrecord['status_aktif_agregasi'] = $d->status_aktif_agregasi == "" ? "-" : $d->status_aktif_agregasi;

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/penyedia');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function cek($jenis,$nilai)
    {
        $cari = urldecode($nilai);

        switch ($jenis) {
            case 'kode':
                $cek_kode = $this->mod_penyedia->cek_kode($cari);
                echo $cek_kode;
                break;
            case 'nama':
                $cek_nama = $this->mod_penyedia->cek_nama($cari);
                echo $cek_nama;
                break;
            case 'npwp':
                $cek_npwp = $this->mod_penyedia->cek_npwp($cari);
                echo $cek_npwp;
                break;
            case 'email':
                $cek_email = $this->mod_penyedia->cek_email($cari);
                echo $cek_email;
                break;
        }
    }

    public function proses($proses, $kode = "")
    {
        $kd_penyedia = $this->input->post('kd_penyedia');
        $awal = $this->input->post('awal');
        $nama_penyedia = $this->clear_string->clear_quotes(ucwords($this->input->post('nama_penyedia')));
        $bentuk_usaha = $this->input->post('bentuk_usaha');
        $user_lpse = $this->input->post('user_lpse');
        $npwp_penyedia = $this->input->post('npwp_penyedia');
        $alamat_penyedia = $this->input->post('alamat_penyedia');
        $kabupaten_kota = $this->input->post('kabupaten_kota');
        $provinsi = $this->input->post('provinsi');
        $email = $this->input->post('email');
        $no_telp = $this->input->post('no_telp');
        $no_pkp = $this->input->post('no_pkp');
        $lpse_terdaftar = $this->input->post('lpse_terdaftar');
        // $tgl_terdaftar = $this->input->post('tgl_terdaftar');
        // $tgl_verifikasi = $this->input->post('tgl_verifikasi');
        $status_aktif_agregasi = $this->input->post('status_aktif_agregasi');

        if ($proses != 3) {
            $data = array(
                "kd_penyedia" => $kd_penyedia,
                "nama_penyedia" => $nama_penyedia,
                "bentuk_usaha" => $bentuk_usaha,
                "user_lpse" => $user_lpse,
                "npwp_penyedia" => $npwp_penyedia,
                "alamat_penyedia" => $alamat_penyedia,
                "kabupaten_kota" => $kabupaten_kota,
                "provinsi" => $provinsi,
                "email" => $email,
                "no_telp" => $no_telp,
                "no_pkp" => $no_pkp,
                "lpse_terdaftar" => $lpse_terdaftar,
                // "tgl_terdaftar" => $tgl_terdaftar,
                // "tgl_verifikasi" => $tgl_verifikasi,
                "status_aktif_agregasi" => $status_aktif_agregasi
            );
        }

        

        switch ($proses) {
            case 1:
                $this->mod_penyedia->simpan($data);
                $pesan = 1;
                $isipesan = "Data Penyedia baru di tambahkan $nama_penyedia";
                break;
            case 2:
                $this->mod_penyedia->ubah($data);
                $pesan = 2;
                $isipesan = "Data Penyedia $nama_penyedia diubah";
                break;
            case 3:
                $cek_penyedia = $this->mod_penyedia->cek_penyedia($kode);
                $this->mod_penyedia->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Penyedia ".$cek_penyedia['nama_penyedia']." telah dihapus ";
                break;
        }

        $msg = str_replace(" ", "-", $isipesan);

        redirect("penyedia/index/1/20/-/-/$pesan/$msg");
    }
}
