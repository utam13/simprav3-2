<?
class mod_monitoring extends CI_Model
{
    // rincian
    public function rincian($start, $limit, $table, $thn, $qcari, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qkelompok
                                ORDER BY $order ASC LIMIT $start,$limit");
    }

    public function jumlah_rincian($table, $thn, $qcari, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qkelompok
                                ORDER BY $order ASC")->num_rows();
    }
    // end

    // rup penyedia
    public function cek_rup_penyedia($kode)
    {
        return $this->db->query("SELECT kegiatan,program FROM rup_penyedia WHERE kode_rup='$kode'")->row_array();
    }
    // end

    // pegawai
    public function cek_pegawai($kode)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$kode' AND status_ppk='ya'")->row_array();
    }
    // end

    // penyedia
    public function cek_penyedia($kode)
    {
        return $this->db->query("SELECT nama_penyedia,alamat_penyedia,kabupaten_kota FROM penyedia WHERE kd_penyedia='$kode'")->row_array();
    }
    // end

    // realisasi tender
    public function realisasi_tender($kode)
    {
        return $this->db->query("SELECT besar_pembayaran_bap FROM realisasi_tender WHERE kd_tender='$kode'")->row_array();
    }
    // end

    // realisasi non tender
    public function realisasi_nontender($kode)
    {
        return $this->db->query("SELECT besar_pembayaran_bap FROM realisasi_nontender WHERE kd_nontender='$kode'")->row_array();
    }
    // end

    // rincian
    public function rincian_sb($start, $limit, $table, $thn, $qcari, $qanggaran, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qanggaran 
                                AND $qkelompok
                                ORDER BY $order ASC LIMIT $start,$limit");
    }

    public function jumlah_rincian_sb($table, $thn, $qcari, $qanggaran, $qkelompok, $order)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM $table a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' AND $qcari 
                                AND $qanggaran 
                                AND $qkelompok
                                ORDER BY $order ASC")->num_rows();
    }
    // end

    // rincian
    public function daftar($start, $limit, $thn, $qkelompok, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nip_pegawai,b.nama_pegawai
                                FROM temp_monitoring_ppk a 
                                    INNER JOIN pegawai b
                                        on a.kd_pegawai=b.kd_pegawai
                                WHERE a.total_paket<>'0' 
                                    AND a.thn='$thn'
                                    AND $qkelompok 
                                    AND $qcari 
                                ORDER BY b.nip_pegawai ASC 
                                    LIMIT $start,$limit");
    }

    public function jumlah($thn, $qkelompok, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nip_pegawai,b.nama_pegawai
                                FROM temp_monitoring_ppk a 
                                    INNER JOIN pegawai b
                                    on a.kd_pegawai=b.kd_pegawai
                                WHERE a.total_paket<>'0' 
                                    AND a.thn='$thn'
                                    AND $qkelompok
                                    AND $qcari")->num_rows();
    }
    // end

    // ppk
    public function ppk($nip)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$nip'")->row_array();
    }
    // end

    // detail paket
    public function detail($start, $limit, $table, $thn, $qkelompok, $qstatus, $qcari, $orderby)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan 
                                FROM $table a 
                                    inner join satker b
                                        on a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                    AND $qkelompok
                                    AND $qstatus 
                                    AND $qcari 
                                ORDER BY $orderby ASC 
                                    LIMIT $start,$limit");
    }

    public function jumlah_detail($table, $thn, $qkelompok, $qstatus, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan 
                                FROM $table a 
                                    inner join satker b
                                        on a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                        AND $qkelompok
                                        AND $qstatus 
                                        AND $qcari ")->num_rows();
    }
    // end

    // rincian
    public function daftar_personil($start, $limit, $thn, $qpersonil, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nip_pegawai,b.nama_pegawai
                                FROM temp_monitoring_personil a 
                                    INNER JOIN pegawai b
                                        on a.kd_pegawai=b.kd_pegawai
                                WHERE a.total_paket<>'0' 
                                    AND a.thn='$thn'
                                    AND $qpersonil  
                                    AND $qcari 
                                ORDER BY b.nip_pegawai ASC 
                                    LIMIT $start,$limit");
    }

    public function jumlah_personil($thn, $qpersonil, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nip_pegawai,b.nama_pegawai
                                FROM temp_monitoring_personil a 
                                    INNER JOIN pegawai b
                                    on a.kd_pegawai=b.kd_pegawai
                                WHERE a.total_paket<>'0' 
                                    AND a.thn='$thn'
                                    AND $qpersonil 
                                    AND $qcari")->num_rows();
    }
    // end

    // pegawai
    public function pegawai($nip)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$nip'")->row_array();
    }
    // end

    // detail paket
    public function detail_pokja($start, $limit, $thn, $nip, $status, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        c.nama_satker, c.singkatan 
                                    FROM tender a 
                                        inner join pokja_pemilihan b
                                            on a.kd_pokja = b.kd_pokja
                                        inner join satker c
                                            on a.kd_satker=c.kd_satker
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND  a.nama_status_tender like '%$status' 
                                    AND $qcari
                                    AND (b.nip_personil1='$nip' or 
                                            b.nip_personil2='$nip' or 
                                            b.nip_personil3='$nip' or 
                                            b.nip_personil4='$nip' or 
                                            b.nip_personil5='$nip')
                                    ORDER BY a.kd_rup_paket ASC 
                                        LIMIT $start,$limit");
    }

    public function detail_pp($start, $limit, $thn, $nip, $status, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan
                                    FROM non_tender a
                                        inner join satker b
                                            on a.kd_satker=b.kd_satker
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND a.nip_pejabat_pengadaan='$nip'
                                        AND a.nama_status_nontender='$status'
                                        AND $qcari 
                                    ORDER BY a.kd_rup_paket ASC 
                                        LIMIT $start,$limit");
    }

    public function jumlah_detail_pokja($thn, $nip, $status, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        c.nama_satker, c.singkatan 
                                    FROM tender a 
                                        inner join pokja_pemilihan b
                                            on a.kd_pokja = b.kd_pokja
                                        inner join satker c
                                            on a.kd_satker=c.kd_satker
                                    WHERE a.tahun_anggaran='$thn' 
                                    AND  a.nama_status_tender like '%$status' 
                                    AND $qcari
                                    AND (b.nip_personil1='$nip' or 
                                            b.nip_personil2='$nip' or 
                                            b.nip_personil3='$nip' or 
                                            b.nip_personil4='$nip' or 
                                            b.nip_personil5='$nip')")->num_rows();
    }

    public function jumlah_detail_pp($thn, $nip, $status, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan
                                    FROM non_tender a
                                        inner join satker b
                                            on a.kd_satker=b.kd_satker
                                    WHERE a.tahun_anggaran='$thn' 
                                        AND a.nip_pejabat_pengadaan='$nip'
                                        AND a.nama_status_nontender='".$status."'
                                        AND $qcari ")->num_rows();
    }
    // end

    // rincian
    public function rincian_kelkerja($start, $limit, $thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker  
                                    FROM pokja_pemilihan a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                AND $qcari 
                                ORDER BY a.kd_pokja ASC LIMIT $start,$limit");
    }

    public function jumlah_rincian_kelkerja($thn, $qcari)
    {
        return $this->db->query("SELECT a.*, b.nama_satker 
                                    FROM pokja_pemilihan a
                                        INNER JOIN satker b
                                            ON a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                AND $qcari ")->num_rows();
    }
    // end

    // tender
    public function cek_tender($kode)
    {
        return $this->db->query("SELECT nama_paket,ang,pagu,hps,nilai_kontrak,kd_penyedia FROM tender WHERE kd_tender='$kode'")->row_array();
    }
    // end

    // pegawai
    public function cek_pegawai2($kode)
    {
        return $this->db->query("SELECT nama_pegawai FROM pegawai WHERE nip_pegawai='$kode'")->row_array();
    }
    // end

    // provinsi
    public function provinsi()
    {
        return $this->db->query("SELECT provinsi, COUNT(provinsi) AS total 
                                    FROM penyedia 
                                        WHERE provinsi<>'' 
                                    GROUP BY provinsi 
                                        ORDER BY provinsi ASC ");
    }

    // kota
    public function kota($provinsi)
    {
        return $this->db->query("SELECT kabupaten_kota, COUNT(kabupaten_kota) AS total 
                                    FROM penyedia 
                                        WHERE provinsi='$provinsi' 
                                    GROUP BY kabupaten_kota 
                                        ORDER BY kabupaten_kota ASC");
    }

    public function jumlah_kota($provinsi, $qcari)
    {
        return $this->db->query("SELECT kabupaten_kota, COUNT(kabupaten_kota) AS total 
                                    FROM penyedia 
                                        WHERE provinsi='$provinsi' 
                                            AND $qcari
                                    GROUP BY kabupaten_kota ")->num_rows();
    }

    public function daftar_penyedia($start, $limit, $kabupaten_kota, $kelompok, $thn, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.kd_penyedia,b.nama_penyedia
                                FROM temp_monitoring_penyedia a 
                                    INNER JOIN penyedia b
                                    on a.kd_penyedia=b.kd_penyedia
                                WHERE a.thn='$thn'
                                    AND a.kelompok='$kelompok'
                                    AND b.kabupaten_kota='$kabupaten_kota'
                                    AND $qcari 
                                ORDER BY a.total_paket DESC 
                                    LIMIT $start,$limit");
    }

    public function jumlah_penyedia($kabupaten_kota, $kelompok, $thn, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.kd_penyedia,b.nama_penyedia
                                FROM temp_monitoring_penyedia a 
                                    INNER JOIN penyedia b
                                    on a.kd_penyedia=b.kd_penyedia
                                WHERE a.thn='$thn'
                                    AND a.kelompok='$kelompok'
                                    AND b.kabupaten_kota='$kabupaten_kota'
                                    AND $qcari")->num_rows();
    }

    // detail paket
    public function detail_penyedia($start, $limit, $table, $thn, $qkelompok, $qstatus, $qcari, $orderby)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan 
                                FROM $table a 
                                    inner join satker b
                                        on a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                    AND $qkelompok
                                    AND $qstatus 
                                    AND $qcari 
                                ORDER BY $orderby ASC 
                                    LIMIT $start,$limit");
    }

    public function jumlah_detail_penyedia($table, $thn, $qkelompok, $qstatus, $qcari)
    {
        return $this->db->query("SELECT a.*,
                                        b.nama_satker, b.singkatan 
                                FROM $table a 
                                    inner join satker b
                                        on a.kd_satker=b.kd_satker
                                WHERE a.tahun_anggaran='$thn' 
                                        AND $qkelompok
                                        AND $qstatus 
                                        AND $qcari ")->num_rows();
    }
    // end
    
    // penyedia
    public function cek_penyedia2($kode)
    {
        return $this->db->query("SELECT kd_penyedia,nama_penyedia,npwp_penyedia FROM penyedia where kd_penyedia='$kode'")->row_array();
    }
    // end

    // koordinat
    public function cek_koordinat_provinsi($nama)
    {
        return $this->db->query("SELECT latitude, longitude 
                                    FROM provinsi 
                                        WHERE nama='$nama'")->row_array();
    }

    public function koordinat_propinsi()
    {
        return $this->db->query("SELECT a.* 
                                    FROM provinsi a
                                        INNER JOIN penyedia b
                                            on a.nama=b.provinsi 
                                        GROUP BY a.nama 
                                            ORDER BY a.nama ASC");
    }

    public function koordinat_kota($provinsi)
    {
        return $this->db->query("SELECT a.* 
                                    FROM kabupaten_kota a
                                        INNER JOIN penyedia b
                                            on a.nama=b.kabupaten_kota
                                    WHERE b.provinsi='$provinsi'
                                        GROUP BY a.nama 
                                            ORDER BY a.nama ASC");
    }
}