<?
defined('BASEPATH') or exit('No direct script access allowed');

class Satker extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_satker');
    }


    public function index($page = 1, $limit = 20, $kategoricari = "-", $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Satuan Kerja";

        $kantor = $this->mod_satker->kantor();
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
            $qcari = "kd_satker<>''";
        } else {
            $qcari = "(kd_satker like '%$getcari%' or nama_satker like '%$getcari%')";
        }

        // /pagination
        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }else{
            $limit = $limit;
        }

        $jumlah_data = $this->mod_satker->jumlah($qcari);

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

        $daftar = $this->mod_satker->daftar($limit_start, $limit, $qcari)->result();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;

            // $subrecord['kd_klpd'] = $d->kd_klpd;
            // $subrecord['nama_klpd'] = $d->nama_klpd;
            // $subrecord['jenis_klpd'] = $d->jenis_klpd;
            // $subrecord['kd_lpse'] = $d->kd_lpse;
            // $subrecord['nama_lpse'] = $d->nama_lpse;
            $subrecord['kd_satker'] = $d->kd_satker;
            $subrecord['kdunit_satker'] = $d->kdunit_satker;
            $subrecord['nama_satker'] = $d->nama_satker;
            $subrecord['singkatan'] = $d->singkatan;
            $subrecord['npwp_satker'] = $d->npwp_satker == "" ? "-" : $d->npwp_satker;
            $subrecord['alamat_satker'] = $d->alamat_satker == "" ? "-" : $d->alamat_satker;
            $subrecord['no_telp_satker'] = $d->no_telp_satker == "" ? "-" : $d->no_telp_satker;
            $subrecord['email_satker'] = $d->email_satker == "" ? "-" : $d->email_satker;
            $subrecord['kota'] = $d->kota == "" ? "-" : $d->kota;
            $subrecord['provinsi'] = $d->provinsi == "" ? "-" : $d->provinsi;

            $no++;

            array_push($record, $subrecord);
        }

        $data['daftar'] = json_encode($record);

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/satker');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function cek($jenis,$nilai)
    {
        $cari = urldecode($nilai);

        switch ($jenis) {
            case 'singkatan':
                $cek_singkatan= $this->mod_satker->cek_singkatan($cari);
                echo $cek_kode;
                break;
            case 'nama':
                $cek_nama = $this->mod_satker->cek_nama($cari);
                echo $cek_nama;
                break;
        }
    }

    public function proses($proses, $kode = "")
    {
        $kd_satker = $this->input->post('kd_satker');
        $kdunit_satker = $this->input->post('kdunit_satker');
        $nama_satker = $this->clear_string->clear_quotes(ucwords($this->input->post('nama_satker')));
        $singkatan = $this->input->post('singkatan');
        $npwp_satker = $this->input->post('npwp_satker');
        $alamat_satker = $this->input->post('alamat_satker');
        $no_telp_satker = $this->input->post('no_telp_satker');
        $email_satker = $this->input->post('email_satker');
        $kota = $this->input->post('kota');
        $provinsi = $this->input->post('provinsi');

        if ($proses != 3) {
            $data = array(
                "kd_satker" => $kd_satker,
                "kdunit_satker" => $kdunit_satker,
                "nama_satker" => $nama_satker,
                "singkatan" => $singkatan,
                "npwp_satker" => $npwp_satker,
                "alamat_satker" => $alamat_satker,
                "no_telp_satker" => $no_telp_satker,
                "email_satker" => $email_satker,
                "kota" => $kota,
                "provinsi" => $provinsi
            );
        }

        

        switch ($proses) {
            case 1:
                $this->mod_satker->simpan($data);
                $pesan = 1;
                $isipesan = "Data satker baru di tambahkan $nama_satker";
                break;
            case 2:
                $this->mod_satker->ubah($data);
                $pesan = 2;
                $isipesan = "Data satker $nama_satker diubah";
                break;
            case 3:
                $cek_satker = $this->mod_satker->cek_satker($kode);
                $this->mod_satker->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Satker ".$cek_satker['nama_satker']." telah dihapus ";
                break;
        }

        $msg = str_replace(" ", "-", $isipesan);

        redirect("satker/index/1/20/-/-/$pesan/$msg");
    }
}
