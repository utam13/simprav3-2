<?
class mod_autocount extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }
    
    // satker
    public function satker()
    {
        return $this->db->query("SELECT kd_satker FROM satker order by kdunit_satker ASC");
    }
    // end

    // pegawai
    public function pegawai()
    {
        return $this->db->query("SELECT kd_pegawai,nip_pegawai FROM pegawai ORDER BY nip_pegawai ASC");
    }
    // end

    // penyedia
    public function penyedia()
    {
        return $this->db->query("SELECT kd_penyedia,nama_penyedia,npwp_penyedia FROM penyedia ORDER BY kd_penyedia ASC");
    }
    // end

    // struktur anggaran
    public function apbd_murni_belanja_operasi_1($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_murni WHERE kd_blj_lv3='5.1.02' AND thn_ang='$thn'")->row_array();
    }

    public function apbd_murni_belanja_modal($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_murni WHERE kd_blj_lv2='5.2' AND thn_ang='$thn'")->row_array();
    }

    public function apbd_murni_belanja_operasi_2($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_murni WHERE kd_blj_lv3 LIKE '5.1.%' AND kd_blj_lv3!='5.1.02' AND thn_ang='$thn'")->row_array();
    }

    public function apbd_murni_belanja_tidak_terduga_2($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_murni WHERE kd_blj_lv2='5.3' AND thn_ang='$thn'")->row_array();
    }

    public function apbd_perubahan_belanja_operasi_1($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_perubahan WHERE kd_blj_lv3='5.1.02' AND thn_ang='$thn'")->row_array();
    }

    public function apbd_perubahan_belanja_modal($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_perubahan WHERE kd_blj_lv2='5.2' AND thn_ang='$thn'")->row_array();
    }

    public function apbd_perubahan_belanja_operasi_2($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_perubahan WHERE kd_blj_lv3 LIKE '5.1.%' AND kd_blj_lv3!='5.1.02' AND thn_ang='$thn'")->row_array();
    }
    
    public function apbd_perubahan_belanja_tidak_terduga_2($thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_perubahan WHERE kd_blj_lv2='5.3' AND thn_ang='$thn'")->row_array();
    }
    // end

    // reset record struktur apbd per tahun
    public function reset_struktur_apbd($kelompok, $thn)
    {
        $this->db->query("delete from temp_struktur_apbd where thn='$thn' and kelompok='$kelompok'");
    }
    // end

    // simpan data baru struktur apbd
    public function simpan_struktur_apbd($data)
    {
        extract($data);
        $this->db->query("insert into temp_struktur_apbd(thn,
                                                        kelompok,
                                                        belanja_operasi_1,
                                                        belanja_modal,
                                                        belanja_tidak_terduga_1,
                                                        belanja_pengadaan,
                                                        belanja_operasi_2,
                                                        belanja_transfer,
                                                        belanja_tidak_terduga_2,
                                                        belanja_non_pengadaan,
                                                        total_belanja) 
                        values('$thn',
                                '$kelompok',
                                '$belanja_operasi_1',
                                '$belanja_modal',
                                '$belanja_tidak_terduga_1',
                                '$belanja_pengadaan',
                                '$belanja_operasi_2',
                                '$belanja_transfer',
                                '$belanja_tidak_terduga_2',
                                '$belanja_non_pengadaan',
                                '$total_belanja')");
    }
    // end

    // table apbd murni
    public function apbd_murni_satker($kode_satker, $q_belanja)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_murni WHERE kd_satker_rup='$kode_satker' AND $q_belanja")->row_array();
    }
    // end

    // table apbd perubahan
    public function apbd_perubahan_satker($kode_satker, $q_belanja)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM apbd_sipd_perubahan WHERE kd_satker_rup='$kode_satker' AND $q_belanja")->row_array();
    }
    // end

    // reset record struktur apbd per tahun
    public function reset_rincian_struktur_apbd($thn, $kelompok)
    {
        $this->db->query("delete from temp_rincian_struktur_apbd where thn='$thn' and kelompok='$kelompok'");
    }
    // end

    // simpan data baru struktur apbd
    public function simpan_rincian_struktur_apbd($data)
    {
        extract($data);
        $this->db->query("insert into temp_rincian_struktur_apbd(thn,
                                                                kelompok,
                                                                kd_satker,
                                                                total_barang_jasa,
                                                                total_modal,
                                                                total_pegawai,
                                                                total_hibah,
                                                                total_bansos,
                                                                total_tidak_terduga,
                                                                total_dll,
                                                                total) 
                        values('$thn',
                                '$kelompok',
                                '$kd_satker',
                                '$total_barang_jasa',
                                '$total_modal',
                                '$total_pegawai',
                                '$total_hibah',
                                '$total_bansos',
                                '$total_tidak_terduga',
                                '$total_dll',
                                '$total')");
    }
    // end

    // penyedia_paket
    public function penyedia_paket($kode_satker, $thn)
    {
        return $this->db->query("SELECT nama_paket FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='tidak' AND status_aktif='ya' AND status_umumkan='sudah'")->num_rows();
    }
    // end

    // penyedia_anggaran
    public function penyedia_anggaran($kode_satker, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='tidak' AND status_aktif='ya' AND status_umumkan='sudah'")->row_array();
    }
    // end

    // swakelola_paket
    public function swakelola_paket($kode_satker, $thn)
    {
        return $this->db->query("SELECT nama_paket FROM rup_swakelola WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND status_aktif='ya' AND status_umumkan='sudah'")->num_rows();
    }
    // end

    // swakelola_anggaran
    public function swakelola_anggaran($kode_satker, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu_rup),0) as total FROM rup_swakelola WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND status_aktif='ya' AND status_umumkan='sudah'")->row_array();
    }
    // end

    // penyedia_dalam_swakelola_paket
    public function penyedia_dalam_swakelola_paket($kode_satker, $thn)
    {
        return $this->db->query("SELECT nama_paket FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='ya' AND status_aktif='ya' AND status_umumkan='sudah'")->num_rows();
    }
    // end

    // penyedia_dalam_swakelola_anggaran
    public function penyedia_dalam_swakelola_anggaran($kode_satker, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia WHERE tahun_anggaran='$thn' and id_satker='$kode_satker' AND penyedia_didalam_swakelola='ya' AND status_aktif='ya' AND status_umumkan='sudah'")->row_array();
    }
    // end

    // reset record rup_rekapitulasi
    public function reset_rup_rekapitulasi($thn)
    {
        $this->db->query("delete from temp_satker_rup_rekapitulasi where thn='$thn'");
    }
    // end

    // simpan data baru rup_rekapitulasi
    public function simpan_rup_rekapitulasi($data)
    {
        extract($data);
        $this->db->query("insert into temp_satker_rup_rekapitulasi(thn,
                                                                    kd_satker,
                                                                    belanja_pengadaan,
                                                                    penyedia_paket,
                                                                    penyedia_anggaran,
                                                                    swakelola_paket,
                                                                    swakelola_anggaran,
                                                                    penyedia_dalam_swakelola_paket,
                                                                    penyedia_dalam_swakelola_anggaran,
                                                                    total_paket,
                                                                    total_anggaran,
                                                                    persentase) 
                        values('$thn',
                                '$kd_satker',
                                '$belanja_pengadaan',
                                '$penyedia_paket',
                                '$penyedia_anggaran',
                                '$swakelola_paket',
                                '$swakelola_anggaran',
                                '$penyedia_dalam_swakelola_paket',
                                '$penyedia_dalam_swakelola_anggaran',
                                '$total_paket',
                                '$total_anggaran',
                                '$persentase')");
    }
    // end

    // reset record triwulan
    public function reset_triwulan($thn)
    {
        $this->db->query("delete from temp_satker_triwulan where thn='$thn'");
    }
    // end

    // simpan data baru triwulan
    public function simpan_triwulan($data)
    {
        extract($data);
        $this->db->query("insert into temp_satker_triwulan(thn,
                                                            kd_satker,
                                                            belanja_pagu,
                                                            belanja_paket,
                                                            triwulan1_pagu,
                                                            triwulan1_paket,
                                                            triwulan2_pagu,
                                                            triwulan2_paket,
                                                            triwulan3_pagu,
                                                            triwulan3_paket,
                                                            triwulan4_pagu,
                                                            triwulan4_paket,
                                                            total_pagu,
                                                            total_paket) 
                        values('$thn',
                                '$kd_satker',
                                '$belanja_pagu',
                                '$belanja_paket',
                                '$triwulan1_pagu',
                                '$triwulan1_paket',
                                '$triwulan2_pagu',
                                '$triwulan2_paket',
                                '$triwulan3_pagu',
                                '$triwulan3_paket',
                                '$triwulan4_pagu',
                                '$triwulan4_paket',
                                '$total_pagu',
                                '$total_paket')");
    }
    // end

    // tender metode pemilihan penyedia
    public function tender_rekapitulasi_rup_paket_anggaran($thn)
    {
        return $this->db->query("SELECT metode_pemilihan, COUNT(metode_pemilihan) AS jml,  COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia 
                                    WHERE tahun_anggaran='$thn' AND penyedia_didalam_swakelola='tidak' 
                                    AND status_aktif='ya' AND status_umumkan='sudah' GROUP BY metode_pemilihan ");
    }

    public function tender_rekapitulasi_proses_paket_anggaran($thn, $metode)
    {
        return $this->db->query("SELECT b.metode_pemilihan, 
                                        COUNT(b.metode_pemilihan) AS jml, 
                                        COALESCE(SUM(a.pagu),0) as total
                                    FROM tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_tender='aktif' 
                                    GROUP BY b.metode_pemilihan");
    }

    public function tender_rekapitulasi_selesai_paket_anggaran($thn, $metode)
    {
        return $this->db->query("SELECT b.metode_pemilihan, 
                                        COUNT(b.metode_pemilihan) AS jml, 
                                        COALESCE(SUM(a.pagu),0) as total_pagu,
                                        COALESCE(SUM(a.nilai_negosiasi),0) as total_nilai_negosiasi
                                    FROM tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_tender='aktif' 
                                            AND a.nilai_negosiasi<>''
                                    GROUP BY b.metode_pemilihan");
    }

    public function reset_tender_rekapitulasi_metode($thn)
    {
        $this->db->query("delete from temp_tender_rekapitulasi_metode where thn='$thn'");
    }

    public function simpan_tender_rekapitulasi_metode($data)
    {
        extract($data);
        $this->db->query("insert into temp_tender_rekapitulasi_metode(thn,
                                                                    metode,
                                                                    rup_paket,
                                                                    rup_anggaran,
                                                                    proses_paket,
                                                                    proses_anggaran,
                                                                    selesai_paket,
                                                                    selesai_anggaran,
                                                                    selesai_nilai,
                                                                    hemat_anggaran,
                                                                    hemat_persen) 
                        values('$thn',
                                '$metode',
                                '$rup_paket',
                                '$rup_anggaran',
                                '$proses_paket',
                                '$proses_anggaran',
                                '$selesai_paket',
                                '$selesai_anggaran',
                                '$selesai_nilai',
                                '$hemat_anggaran',
                                '$hemat_persen')");
    }
    // end

    // tender jenis pengadaan
    public function tender_jenis_pengadaan()
    {
        return $this->db->query("SELECT jenis_pengadaan FROM tender GROUP BY jenis_pengadaan ");
    }

    public function tender_total_paket($jenis, $thn)
    {
        return $this->db->query("SELECT jenis_pengadaan FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND (nama_status_tender='aktif' OR nama_status_tender='batal' OR nama_status_tender='gagal')")->num_rows();
    }

    public function tender_paket_selesai($jenis, $thn)
    {
        return $this->db->query("SELECT jenis_pengadaan FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND nama_status_tender='aktif' AND nilai_negosiasi>'0'")->num_rows();
    }

    public function tender_paket_tayang($jenis, $thn)
    {
        return $this->db->query("SELECT jenis_pengadaan FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND nama_status_tender='aktif' AND (nilai_negosiasi='0' OR nilai_negosiasi IS NULL)")->num_rows();
    }

    public function tender_paket_review($jenis, $thn)
    {
        return $this->db->query("SELECT jenis_pengadaan FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND nama_status_tender='gagal'")->num_rows();
    }

    public function tender_paket_batal($jenis, $thn)
    {
        return $this->db->query("SELECT jenis_pengadaan FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND nama_status_tender='batal'")->num_rows();
    }

    public function tender_total_pagu_anggaran($jenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND (nama_status_tender='aktif' OR nama_status_tender='batal' OR nama_status_tender='gagal')")->row_array();
    }

    public function tender_pagu_anggaran_selesai($jenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND nama_status_tender='aktif' AND nilai_negosiasi>'0'")->row_array();
    }

    public function tender_harga_negosisasi($jenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(nilai_negosiasi),0) as total FROM tender WHERE tahun_anggaran='$thn' AND jenis_pengadaan='$jenis' AND nama_status_tender='aktif' AND nilai_negosiasi>'0'")->row_array();
    }

    public function reset_tender_rekapitulasi_jenis($thn)
    {
        $this->db->query("delete from temp_tender_rekapitulasi_jenis where thn='$thn'");
    }

    public function simpan_tender_rekapitulasi_jenis($data)
    {
        extract($data);
        $this->db->query("insert into temp_tender_rekapitulasi_jenis(thn,
                                                                    jenis,
                                                                    total_paket,
                                                                    paket_selesai,
                                                                    paket_tayang,
                                                                    paket_review,
                                                                    paket_batal,
                                                                    total_pagu_anggaran,
                                                                    persen_pagu_anggaran,
                                                                    pagu_anggaran_selesai,
                                                                    harga_negosiasi,
                                                                    hemat_optimalisasi,
                                                                    hemat_persen) 
                        values('$thn',
                                '$jenis',
                                '$total_paket',
                                '$paket_selesai',
                                '$paket_tayang',
                                '$paket_review',
                                '$paket_batal',
                                '$total_pagu_anggaran',
                                '$persen_pagu_anggaran',
                                '$pagu_anggaran_selesai',
                                '$harga_negosisasi',
                                '$penghematan_optimalisasi',
                                '$penghematan_persen')");
    }
    // end


    // tender satker
    public function tender_total_paket_satker($kode, $thn)
    {
        return $this->db->query("SELECT kd_satker FROM tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND (nama_status_tender='aktif' OR nama_status_tender='batal' OR nama_status_tender='gagal')")->num_rows();
    }

    public function tender_total_pagu_satker_jenis($kode, $qjenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' $qjenis AND (nama_status_tender='aktif' OR nama_status_tender='batal' OR nama_status_tender='gagal')")->row_array();
    }

    public function reset_tender_rekapitulasi_satker($thn)
    {
        $this->db->query("delete from temp_tender_rekapitulasi_satker where thn='$thn'");
    }

    public function simpan_tender_rekapitulasi_satker($data)
    {
        extract($data);
        $this->db->query("insert into temp_tender_rekapitulasi_satker(thn,
                                                                    kd_satker,
                                                                    paket,
                                                                    pengadaan_barang,
                                                                    jasa_konsultasi,
                                                                    jasa_lainnya,
                                                                    pekerjaan_konstruksi,
                                                                    total) 
                        values('$thn',
                                '$kd_satker',
                                '$paket',
                                '$pengadaan_barang',
                                '$jasa_konsultasi',
                                '$jasa_lainnya',
                                '$pekerjaan_konstruksi',
                                '$total')");
    }
    // end

    // nontender metode pemilihan penyedia
    public function nontender_rekapitulasi_rup_paket_anggaran($thn)
    {
        return $this->db->query("SELECT metode_pemilihan, COUNT(metode_pemilihan) AS jml,  COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia 
                                    WHERE tahun_anggaran='$thn' 
                                    AND (metode_pemilihan='Pengadaan Langsung' OR metode_pemilihan='Penunjukan Langsung')
                                    AND status_aktif='ya' AND status_umumkan='sudah' GROUP BY metode_pemilihan ");
    }

    public function nontender_rekapitulasi_proses_paket_anggaran($thn, $metode)
    {
        return $this->db->query("SELECT b.metode_pemilihan, 
                                        COUNT(b.metode_pemilihan) AS jml, 
                                        COALESCE(SUM(a.pagu),0) as total
                                    FROM non_tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_nontender='aktif' 
                                    GROUP BY b.metode_pemilihan");
    }

    public function nontender_rekapitulasi_selesai_paket_anggaran($thn, $metode)
    {
        return $this->db->query("SELECT b.metode_pemilihan, 
                                        COUNT(b.metode_pemilihan) AS jml, 
                                        COALESCE(SUM(a.pagu),0) as total_pagu,
                                        COALESCE(SUM(a.nilai_negosiasi),0) as total_nilai_negosiasi
                                    FROM non_tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_nontender='aktif' 
                                            AND a.nilai_negosiasi<>''
                                    GROUP BY b.metode_pemilihan");
    }

    public function reset_nontender_rekapitulasi_metode($thn)
    {
        $this->db->query("delete from temp_nontender_rekapitulasi_metode where thn='$thn'");
    }

    public function simpan_nontender_rekapitulasi_metode($data)
    {
        extract($data);
        $this->db->query("insert into temp_nontender_rekapitulasi_metode(thn,
                                                                    metode,
                                                                    rup_paket,
                                                                    rup_anggaran,
                                                                    proses_paket,
                                                                    proses_anggaran,
                                                                    selesai_paket,
                                                                    selesai_anggaran,
                                                                    selesai_nilai,
                                                                    hemat_anggaran,
                                                                    hemat_persen) 
                        values('$thn',
                                '$metode',
                                '$rup_paket',
                                '$rup_anggaran',
                                '$proses_paket',
                                '$proses_anggaran',
                                '$selesai_paket',
                                '$selesai_anggaran',
                                '$selesai_nilai',
                                '$hemat_anggaran',
                                '$hemat_persen')");
    }
    // end

    // nontender jenis pengadaan
    public function nontender_jenis_pengadaan()
    {
        return $this->db->query("SELECT kategori_pengadaan FROM non_tender GROUP BY kategori_pengadaan ");
    }

    public function nontender_total_paket($jenis, $thn)
    {
        return $this->db->query("SELECT kategori_pengadaan FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND (nama_status_nontender='aktif' OR nama_status_nontender='batal' OR nama_status_nontender='gagal')")->num_rows();
    }

    public function nontender_paket_selesai($jenis, $thn)
    {
        return $this->db->query("SELECT kategori_pengadaan FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND nama_status_nontender='aktif' AND nilai_negosiasi>'0'")->num_rows();
    }

    public function nontender_paket_tayang($jenis, $thn)
    {
        return $this->db->query("SELECT kategori_pengadaan FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND nama_status_nontender='aktif' AND (nilai_negosiasi='0' OR nilai_negosiasi IS NULL)")->num_rows();
    }

    public function nontender_paket_review($jenis, $thn)
    {
        return $this->db->query("SELECT kategori_pengadaan FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND nama_status_nontender='gagal'")->num_rows();
    }

    public function nontender_paket_batal($jenis, $thn)
    {
        return $this->db->query("SELECT kategori_pengadaan FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND nama_status_nontender='batal'")->num_rows();
    }

    public function nontender_total_pagu_anggaran($jenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND (nama_status_nontender='aktif' OR nama_status_nontender='batal' OR nama_status_nontender='gagal')")->row_array();
    }

    public function nontender_pagu_anggaran_selesai($jenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND nama_status_nontender='aktif' AND nilai_negosiasi>'0'")->row_array();
    }

    public function nontender_harga_negosisasi($jenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(nilai_negosiasi),0) as total FROM non_tender WHERE tahun_anggaran='$thn' AND kategori_pengadaan='$jenis' AND nama_status_nontender='aktif' AND nilai_negosiasi>'0'")->row_array();
    }

    public function reset_nontender_rekapitulasi_jenis($thn)
    {
        $this->db->query("delete from temp_nontender_rekapitulasi_jenis where thn='$thn'");
    }

    public function simpan_nontender_rekapitulasi_jenis($data)
    {
        extract($data);
        $this->db->query("insert into temp_nontender_rekapitulasi_jenis(thn,
                                                                    jenis,
                                                                    total_paket,
                                                                    paket_selesai,
                                                                    paket_tayang,
                                                                    paket_review,
                                                                    paket_batal,
                                                                    total_pagu_anggaran,
                                                                    persen_pagu_anggaran,
                                                                    pagu_anggaran_selesai,
                                                                    harga_negosiasi,
                                                                    hemat_optimalisasi,
                                                                    hemat_persen) 
                        values('$thn',
                                '$jenis',
                                '$total_paket',
                                '$paket_selesai',
                                '$paket_tayang',
                                '$paket_review',
                                '$paket_batal',
                                '$total_pagu_anggaran',
                                '$persen_pagu_anggaran',
                                '$pagu_anggaran_selesai',
                                '$harga_negosisasi',
                                '$penghematan_optimalisasi',
                                '$penghematan_persen')");
    }
    // end


    // nontender satker
    public function nontender_total_paket_satker($kode, $thn)
    {
        return $this->db->query("SELECT kd_satker FROM non_tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND (nama_status_nontender='aktif' OR nama_status_nontender='batal' OR nama_status_nontender='gagal')")->num_rows();
    }

    public function nontender_total_pagu_satker_jenis($kode, $qjenis, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total FROM non_tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' $qjenis AND (nama_status_nontender='aktif' OR nama_status_nontender='batal' OR nama_status_nontender='gagal')")->row_array();
    }

    public function reset_nontender_rekapitulasi_satker($thn)
    {
        $this->db->query("delete from temp_nontender_rekapitulasi_satker where thn='$thn'");
    }

    public function simpan_nontender_rekapitulasi_satker($data)
    {
        extract($data);
        $this->db->query("insert into temp_nontender_rekapitulasi_satker(thn,
                                                                    kd_satker,
                                                                    paket,
                                                                    pengadaan_barang,
                                                                    jasa_konsultasi,
                                                                    jasa_lainnya,
                                                                    pekerjaan_konstruksi,
                                                                    total) 
                        values('$thn',
                                '$kd_satker',
                                '$paket',
                                '$pengadaan_barang',
                                '$jasa_konsultasi',
                                '$jasa_lainnya',
                                '$pekerjaan_konstruksi',
                                '$total')");
    }
    // end

    // realisasi rekapitulasi
    public function belanja_pengadaan_paket($kode, $thn)
    {
        return $this->db->query("SELECT nama_paket FROM rup_penyedia WHERE tahun_anggaran='$thn' AND id_satker='$kode' AND status_aktif='ya' AND status_umumkan='sudah'")->num_rows();
    }

    public function belanja_pengadaan_anggaran($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia WHERE tahun_anggaran='$thn' AND id_satker='$kode' AND status_aktif='ya' AND status_umumkan='sudah'")->row_array();
    }

    // realisasi kontrak
    public function realisasi_kontrak_tender_paket($kode, $thn)
    {
        return $this->db->query("SELECT kd_rup_paket FROM tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND nama_status_tender='aktif'")->num_rows();
    }

    public function realisasi_kontrak_tender_anggaran($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(nilai_kontrak),0) as total FROM tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode'AND nama_status_tender='aktif'")->row_array();
    }

    public function realisasi_kontrak_nontender_paket($kode, $thn)
    {
        return $this->db->query("SELECT kd_rup_paket FROM non_tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND nama_status_nontender='aktif'")->num_rows();
    }

    public function realisasi_kontrak_nontender_anggaran($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(nilai_kontrak),0) as total FROM non_tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND nama_status_nontender='aktif'")->row_array();
    }

    // paket selesai
    public function paket_selesai_tender_paket($kode, $thn)
    {
        return $this->db->query("SELECT kd_rup_paket FROM tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND nama_status_tender='aktif' AND besar_pembayaran_bap>'0'")->num_rows();
    }

    public function paket_selesai_tender_anggaran($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(besar_pembayaran_bap),0) as total FROM tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode'AND nama_status_tender='aktif' AND besar_pembayaran_bap>'0'")->row_array();
    }

    public function paket_selesai_nontender_paket($kode, $thn)
    {
        return $this->db->query("SELECT kd_rup_paket FROM non_tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND nama_status_nontender='aktif' AND besar_pembayaran_bap>'0'")->num_rows();
    }

    public function paket_selesai_nontender_anggaran($kode, $thn)
    {
        return $this->db->query("SELECT COALESCE(SUM(besar_pembayaran_bap),0) as total FROM non_tender WHERE tahun_anggaran='$thn' AND kd_satker='$kode' AND nama_status_nontender='aktif' AND besar_pembayaran_bap>'0'")->row_array();
    }

    public function reset_realisasi_rekapitulasi($thn)
    {
        $this->db->query("delete from temp_realisasi_rekapitulasi where thn='$thn'");
    }

    public function simpan_realisasi_rekapitulasi($data)
    {
        extract($data);
        $this->db->query("insert into temp_realisasi_rekapitulasi(thn,
                                                                    kd_satker,
                                                                    belanja_pengadaan_paket,
                                                                    belanja_pengadaan_anggaran,
                                                                    realisasi_kontrak_paket,
                                                                    realisasi_kontrak_anggaran,
                                                                    realisasi_kontrak_persen,
                                                                    paket_selesai_paket,
                                                                    paket_selesai_anggaran,
                                                                    paket_selesai_persen) 
                        values('$thn',
                                '$kd_satker',
                                '$belanja_pengadaan_paket',
                                '$belanja_pengadaan_anggaran',
                                '$realisasi_kontrak_paket',
                                '$realisasi_kontrak_anggaran',
                                '$realisasi_kontrak_persen',
                                '$paket_selesai_paket',
                                '$paket_selesai_anggaran',
                                '$paket_selesai_persen')");
    }
    // end

    // monitoring ppk
    public function cek_paket($kolom, $table, $thn, $status, $qnip)
    {
        return $this->db->query("SELECT COUNT($kolom) AS total FROM $table WHERE tahun_anggaran='$thn' AND  $kolom like '%$status' AND $qnip")->row_array();
    }

    public function total_pagu($pagu, $status, $table, $thn, $qnip)
    {
        return $this->db->query("SELECT COALESCE(SUM($pagu),0) AS total FROM $table WHERE tahun_anggaran='$thn' AND $qnip AND ($status like '%Aktif' OR $status like '%Batal' OR $status like '%Gagal' OR $status like '%Selesai')")->row_array();
    }

    public function total_kontrak($kontrak, $status, $table, $thn, $qnip)
    {
        return $this->db->query("SELECT  COALESCE(SUM($kontrak),0) AS total FROM $table WHERE tahun_anggaran='$thn' AND $qnip AND ($status like '%Aktif' OR $status like '%Batal' OR $status like '%Gagal' OR $status like '%Selesai')")->row_array();
    }

    public function reset_monitoring_ppk($kelompok, $thn)
    {
        $this->db->query("delete from temp_monitoring_ppk where thn='$thn' and kelompok='$kelompok'");
    }

    public function simpan_monitoring_ppk($data)
    {
        extract($data);
        $this->db->query("insert into temp_monitoring_ppk(thn,
                                                        kd_pegawai,
                                                        kelompok,
                                                        aktif,
                                                        batal,
                                                        gagal,
                                                        selesai,
                                                        total_paket,
                                                        total_pagu,
                                                        total_kontrak) 
                        values('$thn',
                                '$kd_pegawai',
                                '$kelompok',
                                '$aktif',
                                '$batal',
                                '$gagal',
                                '$selesai',
                                '$total_paket',
                                '$total_pagu',
                                '$total_kontrak')");
    }
    // end

    // monitoring personil
    public function cek_paket_pokja($thn, $status, $nip)
    {
        return $this->db->query("SELECT COUNT(a.nama_status_tender) AS total 
                                        FROM tender a 
                                            inner join pokja_pemilihan b
                                                on a.kd_pokja = b.kd_pokja
                                        WHERE a.tahun_anggaran='$thn' 
                                        AND  a.nama_status_tender like '%$status' 
                                        AND (b.nip_personil1='$nip' or 
                                                b.nip_personil2='$nip' or 
                                                b.nip_personil3='$nip' or 
                                                b.nip_personil4='$nip' or 
                                                b.nip_personil5='$nip')")->row_array();
    }

    public function total_pagu_pokja($thn, $nip)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) AS total 
                                        FROM tender a 
                                            inner join pokja_pemilihan b
                                                on a.kd_pokja = b.kd_pokja
                                        WHERE a.tahun_anggaran='$thn' 
                                        AND (nama_status_tender like '%Aktif' OR 
                                                nama_status_tender like '%Batal' OR 
                                                nama_status_tender like '%Gagal' OR 
                                                nama_status_tender like '%Selesai')
                                        AND (b.nip_personil1='$nip' OR 
                                                b.nip_personil2='$nip' OR 
                                                b.nip_personil3='$nip' OR 
                                                b.nip_personil4='$nip' OR 
                                                b.nip_personil5='$nip')")->row_array();
    }

    public function total_kontrak_pokja($thn, $nip)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.nilai_kontrak),0) AS total 
                                        FROM tender a 
                                            inner join pokja_pemilihan b
                                                on a.kd_pokja = b.kd_pokja
                                        WHERE a.tahun_anggaran='$thn' 
                                        AND (nama_status_tender like '%Aktif' OR 
                                                nama_status_tender like '%Batal' OR 
                                                nama_status_tender like '%Gagal' OR 
                                                nama_status_tender like '%Selesai')
                                        AND (b.nip_personil1='$nip' OR 
                                                b.nip_personil2='$nip' OR 
                                                b.nip_personil3='$nip' OR 
                                                b.nip_personil4='$nip' OR 
                                                b.nip_personil5='$nip')")->row_array();
    }

    public function cek_paket_pp($thn, $status, $nip)
    {
        return $this->db->query("SELECT COUNT(nama_status_nontender) AS total FROM non_tender WHERE tahun_anggaran='$thn' AND nama_status_nontender like '%$status' AND nip_pejabat_pengadaan='$nip'")->row_array();
    }

    public function total_pagu_pp($thn, $nip)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) AS total FROM non_tender WHERE tahun_anggaran='$thn' AND nip_pejabat_pengadaan='$nip' AND (nama_status_nontender like '%Aktif' OR nama_status_nontender like '%Batal' OR nama_status_nontender like '%Gagal' OR nama_status_nontender like '%Selesai')")->row_array();
    }

    public function total_kontrak_pp($thn, $nip)
    {
        return $this->db->query("SELECT  COALESCE(SUM(nilai_kontrak),0) AS total FROM non_tender WHERE tahun_anggaran='$thn' AND nip_pejabat_pengadaan='$nip' AND (nama_status_nontender like '%Aktif' OR nama_status_nontender like '%Batal' OR nama_status_nontender like '%Gagal' OR nama_status_nontender like '%Selesai')")->row_array();
    }

    public function reset_monitoring_personil($personil, $thn)
    {
        $this->db->query("delete from temp_monitoring_personil where thn='$thn' and personil='$personil'");
    }

    public function simpan_monitoring_personil($data)
    {
        extract($data);
        $this->db->query("insert into temp_monitoring_personil(thn,
                                                        kd_pegawai,
                                                        personil,
                                                        aktif,
                                                        batal,
                                                        gagal,
                                                        selesai,
                                                        total_paket,
                                                        total_pagu,
                                                        total_kontrak) 
                        values('$thn',
                                '$kd_pegawai',
                                '$personil',
                                '$aktif',
                                '$batal',
                                '$gagal',
                                '$selesai',
                                '$total_paket',
                                '$total_pagu',
                                '$total_kontrak')");
    }
    // end

    // monitoring penyedia
    public function cek_paket_penyedia($kolom, $table, $thn, $status, $qpenyedia)
    {
        return $this->db->query("SELECT COUNT($kolom) AS total FROM $table WHERE tahun_anggaran='$thn' AND  $kolom like '%$status' AND $qpenyedia")->row_array();
    }

    public function total_pagu_penyedia($pagu, $status, $table, $thn, $qpenyedia)
    {
        return $this->db->query("SELECT COALESCE(SUM($pagu),0) AS total FROM $table WHERE tahun_anggaran='$thn' AND $qpenyedia AND ($status like '%Aktif' OR $status like '%Batal' OR $status like '%Gagal' OR $status like '%Selesai')")->row_array();
    }

    public function total_kontrak_penyedia($kontrak, $status, $table, $thn, $qpenyedia)
    {
        return $this->db->query("SELECT  COALESCE(SUM($kontrak),0) AS total FROM $table WHERE tahun_anggaran='$thn' AND $qpenyedia AND ($status like '%Aktif' OR $status like '%Batal' OR $status like '%Gagal' OR $status like '%Selesai')")->row_array();
    }

    public function reset_monitoring_penyedia($kelompok, $thn)
    {
        $this->db->query("delete from temp_monitoring_penyedia where thn='$thn' and kelompok='$kelompok'");
    }

    public function simpan_monitoring_penyedia($data)
    {
        extract($data);
        $this->db->query("insert into temp_monitoring_penyedia(thn,
                                                        kd_penyedia,
                                                        kelompok,
                                                        aktif,
                                                        batal,
                                                        gagal,
                                                        selesai,
                                                        total_paket,
                                                        total_pagu,
                                                        total_kontrak) 
                        values('$thn',
                                '$kd_penyedia',
                                '$kelompok',
                                '$aktif',
                                '$batal',
                                '$gagal',
                                '$selesai',
                                '$total_paket',
                                '$total_pagu',
                                '$total_kontrak')");
    }
    // end

    // rencana_paket_pengadaan
    public function jenis_pengadaan()
    {
        return $this->db->query("SELECT jenis_pengadaan
                                    FROM rup_penyedia
                                        GROUP BY jenis_pengadaan ASC");
    }

    public function total_jenis_pengadaan($thn, $qnominal, $jenis)
    {
        return $this->db->query("SELECT COUNT(kode_rup) AS total_paket,
                                        COALESCE(SUM(pagu_rup),0) AS total_pagu
                                FROM rup_penyedia
                                WHERE tahun_anggaran='2021'
                                    AND $qnominal
                                    AND jenis_pengadaan='$jenis'")->row_array();
    }

    public function reset_rencana_paket_pengadaan($jenis, $thn)
    {
        $this->db->query("delete from temp_rencana_paket_pengadaan where thn='$thn' and jenis_pengadaan='$jenis'");
    }

    public function simpan_rencana_paket_pengadaan($data)
    {
        extract($data);
        $this->db->query("insert into temp_rencana_paket_pengadaan(thn,
                                                        jenis_pengadaan,
                                                        penyedia_200_paket,
                                                        penyedia_200_pagu,
                                                        penyedia_200_25_paket,
                                                        penyedia_200_25_pagu,
                                                        penyedia_25_50_paket,
                                                        penyedia_25_50_pagu,
                                                        penyedia_50_100_paket,
                                                        penyedia_50_100_pagu,
                                                        penyedia_100_paket,
                                                        penyedia_100_pagu,
                                                        swakelola_paket,
                                                        swakelola_pagu) 
                        values('$thn',
                                '$jenis_pengadaan',
                                '$kelompok_200_paket',
                                '$kelompok_200_pagu',
                                '$kelompok_200_25_paket',
                                '$kelompok_200_25_pagu',
                                '$kelompok_25_50_paket',
                                '$kelompok_25_50_pagu',
                                '$kelompok_50_100_paket',
                                '$kelompok_50_100_pagu',
                                '$kelompok_100_paket',
                                '$kelompok_100_pagu',
                                '$swakelola_paket',
                                '$swakelola_pagu')");
    }
    // end

    // grafik belanja pengadaan
    public function belanja_pengadaan($thn)
    {
        return $this->db->query("SELECT jenis_pengadaan, 
                                        COALESCE(SUM(pagu_rup),0) AS total 
                                    FROM rup_penyedia 
                                    WHERE tahun_anggaran='$thn' 
                                        GROUP BY jenis_pengadaan 
                                            ORDER BY jenis_pengadaan ASC");
    }

    public function reset_belanja_pengadaan($jenis, $thn)
    {
        $this->db->query("delete from grafik_belanja_pengadaan where thn='$thn' and jenis_pengadaan='$jenis'");
    }

    public function simpan_belanja_pengadaan($data)
    {
        extract($data);
        $this->db->query("insert into grafik_belanja_pengadaan(thn,
                                                        jenis_pengadaan,
                                                        total) 
                        values('$thn',
                                '$jenis_pengadaan',
                                '$total')");
    }
    // end

    // grafik rup penyedia
    public function rup_penyedia($thn)
    {
        return $this->db->query("SELECT metode_pemilihan, 
                                        COALESCE(SUM(pagu_rup),0) AS rup_anggaran, 
                                        COUNT(kode_rup) AS rup_paket
                                FROM rup_penyedia 
                                    WHERE tahun_anggaran='$thn'
                                        GROUP BY metode_pemilihan
                                            ORDER BY metode_pemilihan ASC");
    }

    public function realisasi_tender($thn, $metode)
    {
        return $this->db->query("SELECT selesai_paket,selesai_anggaran FROM temp_tender_rekapitulasi_metode 
                                    WHERE thn='$thn'
                                        AND metode='$metode'")->row_array();
    }

    public function realisasi_nontender($thn, $metode)
    {
        return $this->db->query("SELECT selesai_paket,selesai_anggaran FROM temp_nontender_rekapitulasi_metode 
                                    WHERE thn='$thn'
                                        AND metode='$metode'")->row_array();
    }

    public function realisasi_pencatatan_nontender($thn, $metode)
    {
        return $this->db->query("SELECT COUNT(a.kd_rup_paket) AS jml,  COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_nontender a 
                                        inner join rup_penyedia b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn'
                                        AND b.metode_pemilihan='$metode' ")->row_array();
    }

    public function realisasi_epurchasing($thn, $metode)
    {
        return $this->db->query("SELECT COUNT(a.rup_id) AS jml,  
                                        COALESCE(SUM(a.pagu_rup),0) as total
                                    FROM epurchasing a 
                                        inner join rup_penyedia b
                                            on a.rup_id=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.paket_status_str='Paket Selesai'")->row_array();
    }

    public function reset_rup_penyedia($kelompok, $metode, $thn)
    {
        $this->db->query("delete from grafik_rup where thn='$thn' and kelompok='$kelompok' and kategori='$metode'");
    }

    public function simpan_rup_penyedia($data)
    {
        extract($data);
        $this->db->query("insert into grafik_rup(thn,
                                                kelompok,
                                                kategori,
                                                rup_anggaran,
                                                rup_paket,
                                                realisasi_anggaran,
                                                realisasi_paket) 
                        values('$thn',
                                '$kelompok',
                                '$kategori',
                                '$rup_anggaran',
                                '$rup_paket',
                                '$realisasi_anggaran',
                                '$realisasi_paket')");
    }
    // end

    // grafik rup swakelola
    public function rup_swakelola($thn)
    {
        return $this->db->query("SELECT tipe_swakelola, 
                                        COALESCE(SUM(pagu_rup),0) AS rup_anggaran, 
                                        COUNT(kode_rup) AS rup_paket
                                FROM rup_swakelola 
                                    WHERE tahun_anggaran='$thn'
                                        GROUP BY tipe_swakelola
                                            ORDER BY tipe_swakelola ASC");
    }

    public function realisasi_pencatatan_swakelola($thn,$tipe)
    {
        return $this->db->query("SELECT COUNT(a.kd_rup_paket) AS jml,  
                                        COALESCE(SUM(a.pagu),0) as total 
                                    FROM pct_swakelola a 
                                        inner join rup_swakelola b
                                            on a.kd_rup_paket=b.kode_rup
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND b.tipe_swakelola='$tipe'
                                        AND a.status_swakelola_pct='Aktif'")->row_array();
    }

    public function reset_rup_swakelola($kelompok, $tipe, $thn)
    {
        $this->db->query("delete from grafik_rup where thn='$thn' and kelompok='$kelompok' and kategori='$tipe'");
    }

    public function simpan_rup_swakelola($data)
    {
        extract($data);
        $this->db->query("insert into grafik_rup(thn,
                                                kelompok,
                                                kategori,
                                                rup_anggaran,
                                                rup_paket,
                                                realisasi_anggaran,
                                                realisasi_paket) 
                        values('$thn',
                                '$kelompok',
                                '$kategori',
                                '$rup_anggaran',
                                '$rup_paket',
                                '$realisasi_anggaran',
                                '$realisasi_paket')");
    }
    // end
    
    // grafik tender
    public function tender_rekapitulasi_rup_paket_anggaran_grafik($thn)
    {
        return $this->db->query("SELECT metode_pemilihan, COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia 
                                    WHERE tahun_anggaran='$thn' AND penyedia_didalam_swakelola='tidak' 
                                    AND status_aktif='ya' AND status_umumkan='sudah' GROUP BY metode_pemilihan ");
    }

    public function tender_rekapitulasi_total_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu
                                    FROM tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function tender_rekapitulasi_selesai_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu,
                                        COALESCE(SUM(a.nilai_negosiasi),0) as total_nilai_negosiasi
                                    FROM tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_tender='aktif' 
                                            AND a.nilai_negosiasi<>''
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function tender_rekapitulasi_proses_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu
                                    FROM tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_tender='aktif' 
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function tender_rekapitulasi_batal_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu
                                    FROM tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND (a.nama_status_tender='batal' OR a.nama_status_tender='gagal')
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function reset_tender($kelompok, $tipe, $thn)
    {
        $this->db->query("delete from grafik_tender_nontender where thn='$thn' and kelompok='$kelompok' and kategori='$tipe'");
    }

    public function simpan_tender($data)
    {
        extract($data);
        $this->db->query("insert into grafik_tender_nontender(thn,
                                                kelompok,
                                                kategori,
                                                rencana,
                                                total,
                                                selesai,
                                                proses,
                                                batal,
                                                optimalisasi_anggaran,
                                                optimalisasi_persen) 
                        values('$thn',
                                '$kelompok',
                                '$kategori',
                                '$rencana',
                                '$total',
                                '$selesai',
                                '$proses',
                                '$batal',
                                '$optimalisasi_anggaran',
                                '$optimalisasi_persen')");
    }
    // end

    // grafik nontender
    public function nontender_rekapitulasi_rup_paket_anggaran_grafik($thn)
    {
        return $this->db->query("SELECT metode_pemilihan, COUNT(metode_pemilihan) AS jml,  COALESCE(SUM(pagu_rup),0) as total FROM rup_penyedia 
                                    WHERE tahun_anggaran='$thn' 
                                    AND status_aktif='ya' AND status_umumkan='sudah' GROUP BY metode_pemilihan ");
    }

    public function nontender_rekapitulasi_total_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu
                                    FROM non_tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function nontender_rekapitulasi_selesai_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu,
                                        COALESCE(SUM(a.nilai_negosiasi),0) as total_nilai_negosiasi
                                    FROM non_tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode'
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_nontender='aktif' 
                                            AND a.nilai_negosiasi<>''
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function nontender_rekapitulasi_proses_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu
                                    FROM non_tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND a.nama_status_nontender='aktif' 
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function nontender_rekapitulasi_batal_paket_anggaran_grafik($thn, $metode)
    {
        return $this->db->query("SELECT COALESCE(SUM(a.pagu),0) as total_pagu
                                    FROM non_tender a
                                        INNER JOIN rup_penyedia b
                                            ON b.kode_rup=a.kd_rup_paket
                                    WHERE a.tahun_anggaran='$thn' 
                                            AND b.metode_pemilihan='$metode' 
                                            AND b.penyedia_didalam_swakelola='tidak' 
                                            AND b.status_aktif='ya' 
                                            AND b.status_umumkan='sudah' 
                                            AND (a.nama_status_nontender='batal' OR a.nama_status_nontender='gagal')
                                    GROUP BY b.metode_pemilihan")->row_array();
    }

    public function reset_nontender($kelompok, $tipe, $thn)
    {
        $this->db->query("delete from grafik_tender_nontender where thn='$thn' and kelompok='$kelompok' and kategori='$tipe'");
    }

    public function simpan_nontender($data)
    {
        extract($data);
        $this->db->query("insert into grafik_tender_nontender(thn,
                                                kelompok,
                                                kategori,
                                                rencana,
                                                total,
                                                selesai,
                                                proses,
                                                batal,
                                                optimalisasi_anggaran,
                                                optimalisasi_persen) 
                        values('$thn',
                                '$kelompok',
                                '$kategori',
                                '$rencana',
                                '$total',
                                '$selesai',
                                '$proses',
                                '$batal',
                                '$optimalisasi_anggaran',
                                '$optimalisasi_persen')");
    }
    // end

    // mekanisme lainnya
    public function mekanisme_lainnya_perencanaan_pctnontender_mekanisme($query, $thn)
    {
        return $this->db->query("SELECT COUNT(kode_rup) AS total_paket, 
                                COALESCE(SUM(pagu_rup),0) AS total_pagu
                            FROM rup_penyedia
                                WHERE $query AND pagu_rup<'50000000' AND tahun_anggaran='$thn'")->row_array();
    }

    public function mekanisme_lainnya_realisasi_pctnontender_mekanisme($thn)
    {
        return $this->db->query("SELECT COUNT(kd_rup_paket) AS total_paket, 
                                COALESCE(SUM(total_realisasi),0) AS total_pagu
                            FROM pct_nontender
                                WHERE tahun_anggaran='$thn'")->row_array();
    }

    public function mekanisme_lainnya_perencanaan_pctswakelola_mekanisme($thn)
    {
        return $this->db->query("SELECT COUNT(kode_rup) AS total_paket, 
                                COALESCE(SUM(pagu_rup),0) AS total_pagu
                            FROM rup_swakelola
                                WHERE tahun_anggaran='$thn'")->row_array();
    }

    public function mekanisme_lainnya_realisasi_pctswakelola_mekanisme($thn)
    {
        return $this->db->query("SELECT COUNT(kd_rup_paket) AS total_paket, 
                                COALESCE(SUM(pagu),0) AS total_pagu
                            FROM pct_swakelola
                                WHERE tahun_anggaran='$thn'")->row_array();
    }

    public function mekanisme_lainnya_perencanaan_epurchasing_mekanisme($thn)
    {
        return $this->db->query("SELECT COUNT(kode_rup) AS total_paket, 
                                COALESCE(SUM(pagu_rup),0) AS total_pagu
                            FROM rup_penyedia
                                WHERE metode_pemilihan='e-Purchasing' AND tahun_anggaran='$thn'")->row_array();
    }

    public function mekanisme_lainnya_realisasi_epurchasing_mekanisme($thn)
    {
        return $this->db->query("SELECT COUNT(rup_id) AS total_paket, 
                                COALESCE(SUM(total_harga),0) AS total_pagu
                            FROM epurchasing
                                WHERE tahun_anggaran='$thn'")->row_array();
    }

    public function reset_mekanisme_lainnya($mekanisme, $thn)
    {
        $this->db->query("delete from temp_mekanisme_lainnya where thn='$thn' and mekanisme='$mekanisme'");
    }

    public function simpan_mekanisme_lainnya($data)
    {
        extract($data);
        $this->db->query("insert into temp_mekanisme_lainnya(thn,
                                                mekanisme,
                                                perencanaan_paket,
                                                perencanaan_pagu,
                                                realisasi_paket,
                                                realisasi_pagu,
                                                persentase) 
                        values('$thn',
                                '$mekanisme',
                                '$perencanaan_paket',
                                '$perencanaan_pagu',
                                '$realisasi_paket',
                                '$realisasi_pagu',
                                '$persentase')");
    }
    // end

    public function tender_pagu($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total 
                                        FROM tender 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_penetapan_pemenang)>='$dari'
                                                AND date(tgl_penetapan_pemenang)<='$sampai'")->row_array();
    }

    public function nontender_pagu($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total 
                                        FROM non_tender 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_kontrak)>='$dari'
                                                AND date(tgl_kontrak)<='$sampai'")->row_array();
    }

    public function epurchasing_pagu($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu_rup),0) as total 
                                        FROM epurchasing 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tanggal_buat_paket)>='$dari'
                                                AND date(tanggal_buat_paket)<='$sampai'")->row_array();
    }

    public function pct_nontender_pagu($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total 
                                        FROM pct_nontender 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_realisasi)>='$dari'
                                                AND date(tgl_realisasi)<='$sampai'")->row_array();
    }

    public function pct_swakelola_pagu($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT COALESCE(SUM(pagu),0) as total 
                                        FROM pct_swakelola 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_realisasi)>='$dari'
                                                AND date(tgl_realisasi)<='$sampai'")->row_array();
    }

    public function tender_paket($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT pagu 
                                        FROM tender 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_penetapan_pemenang)>='$dari'
                                                AND date(tgl_penetapan_pemenang)<='$sampai'")->num_rows();
    }

    public function nontender_paket($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT pagu 
                                        FROM non_tender 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tanggal_pengumuman_nontender)>='$dari'
                                                AND date(tanggal_pengumuman_nontender)<='$sampai'")->num_rows();
    }

    public function epurchasing_paket($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT pagu_rup 
                                        FROM epurchasing 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tanggal_buat_paket)>='$dari'
                                                AND date(tanggal_buat_paket)<='$sampai'")->num_rows();
    }

    public function pct_nontender_paket($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT pagu 
                                        FROM pct_nontender 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_realisasi)>='$dari'
                                                AND date(tgl_realisasi)<='$sampai'")->num_rows();
    }

    public function pct_swakelola_paket($kode_satker,$dari,$sampai)
    {
        return $this->db->query("SELECT pagu 
                                        FROM pct_swakelola 
                                            WHERE kd_satker='$kode_satker' 
                                                AND date(tgl_realisasi)>='$dari'
                                                AND date(tgl_realisasi)<='$sampai'")->num_rows();
    }
}