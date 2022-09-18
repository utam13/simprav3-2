<?
defined('BASEPATH') or exit('No direct script access allowed');

class Linkapp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_linkapp');
    }


    public function index($page = 1, $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Link Aplikasi Pendukung";

        $kantor = $this->mod_linkapp->kantor();
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

        //cari
        if ($isicari != "-") {
            $cari = urldecode($isicari);
        } else {
            $cari =  $this->input->post('cari');
        }

        if ($cari != "") {
            $q_cari = "nama like '%$cari%'";
        } else {
            $q_cari = "nama<>''";
        }

        $data['cari'] =  $cari;

        $data['alert'] = $this->alert_lib->alert($pesan, $isipesan);

        //pagination
        $jumlah_data = $this->mod_linkapp->jumlah_data($q_cari);

        $limit = 10;
        $limit_start = ($page - 1) * 10;

        $data['limit'] = $limit;

        $no = $page;

        $linlapp = $this->mod_linkapp->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($linlapp as $l) {
            $subrecord['no'] = $no;
            $subrecord['kode'] = $l->kdlinkapp;
            $subrecord['nama'] = html_entity_decode($l->nama);
            $subrecord['url'] = html_entity_decode($l->urlapp);
            $subrecord['slide'] = $l->slide;
            $subrecord['iconapp'] = $l->iconapp;

            if ($l->slide == "") {
                $subrecord['file_slide'] = "upload/no-image.png";
            } else {
                $foto_slide = "upload/linkapp/" . $l->slide;
                if (file_exists($foto_slide)) {
                    $subrecord['file_slide'] = "upload/linkapp/".$l->slide . "?" . rand();
                } else {
                    $subrecord['file_slide'] = "upload/no-image.png";
                }
            }

            if ($l->iconapp == "") {
                $subrecord['file_iconapp'] = "upload/no-image.png";
            } else {
                $foto_icon = "upload/linkapp/" . $l->iconapp;
                if (file_exists($foto_icon)) {
                    $subrecord['file_iconapp'] = "upload/linkapp/".$l->iconapp . "?" . rand();
                } else {
                    $subrecord['file_iconapp'] = "upload/no-image.png";
                }
            }

            $no++;

            array_push($record, $subrecord);
        }
        $data['linkapp'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/linkapp');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function upload($jenis)
    {
        $config['upload_path']      = './upload/linkapp';
        $config['allowed_types']    = 'gif|jpg|jpeg|png|bmp';
        $config['file_name']        = $jenis."_".date('dmYhis')."_app";
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);

            echo $file_name;
        }
    }

    public function cek($jenis,$nilai)
    {
        switch ($jenis) {
            case 'nama':
                $cek_nama = $this->mod_linkapp->cek_nama($nilai);
                echo $cek_nama;
                break;
            case 'url':
                $cek_url = $this->mod_linkapp->cek_url($nilai);
                echo $cek_url;
                break;
        }
    }

    public function proses($proses = 1, $kode = "")
    {
        if($proses != 3){
            $kdlinkapp = $this->input->post('kode');
            $nama_awal =  $this->clear_string->clear_quotes(ucwords($this->input->post('nama_awal')));
            $nama =  $this->clear_string->clear_quotes(ucwords($this->input->post('nama')));
            $url_awal =  $this->clear_string->clear_quotes(ucwords($this->input->post('url_awal')));
            $url =  $this->clear_string->clear_quotes(ucwords($this->input->post('urlapp')));
            $slide = $this->input->post('slide');
            $icon = $this->input->post('icon');

            $data = array(
                "kode" => $kdlinkapp,
                "nama" => $nama,
                "url" => $url,
                "slide" => $slide,
                "icon" => $icon
            );
        }


        switch ($proses) {
            case 1:
                $this->mod_linkapp->simpan($data);
                $pesan = 1;
                $isipesan = "Data link app $nama di tambahkan";
                break;
            case 2:
                $this->mod_linkapp->ubah($data);
                $pesan = 2;
                $isipesan = "Data staff $kode $nama diubah";
                break;
            case 3:
                $data_linkapp = $this->mod_linkapp->ambil($kode)->result();
                foreach ($data_linkapp as $dl) {
                    $nama = $dl->nama;

                    if ($dl->slide != "") {
                        unlink("./upload/linkapp/" . $dl->slide);
                    }

                    if ($dl->iconapp != "") {
                        unlink("./upload/linkapp/" . $dl->iconapp);
                    }
                }

                $this->mod_linkapp->hapus($kode);

                $pesan = 3;
                $isipesan = "Link App $nama telah dihapus ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        redirect("linkapp/index/1/-/$pesan/$isipesan");
    }
}
