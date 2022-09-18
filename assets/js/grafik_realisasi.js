function grafik_rekap(tahun) {
    $.ajax({
        url: serverloc + '/realisasi/rekap/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            let categories = new Array();
            let belanja_pengadaan_anggaran_grafik = new Array();
            let realisasi_kontrak_anggaran_grafik = new Array();
            let paket_selesai_anggaran_grafik = new Array();

            $.each(response, function (i, field) {
                $.each(field.baris, function (i, baris) {
                    categories.push(baris.singkatan);
                    belanja_pengadaan_anggaran_grafik.push(parseFloat(baris.belanja_pengadaan_anggaran_grafik));
                    realisasi_kontrak_anggaran_grafik.push(parseFloat(baris.realisasi_kontrak_anggaran_grafik));
                    paket_selesai_anggaran_grafik.push(parseFloat(baris.paket_selesai_anggaran_grafik));
                });
            })

            Highcharts.chart('rekap_body', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: categories,
                    crosshair: true
                },
                yAxis: { 
                    title: {
                        text: 'Anggaran (Rp)',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value} M',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    }
                },
                tooltip: {
                    shared: true,
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                    }
                },
                series: [{
                    name: "Belanja Pengadaan",
                    data: belanja_pengadaan_anggaran_grafik,
                }, {
                    name: "Realisasi Kontrak",
                    data: realisasi_kontrak_anggaran_grafik,
                },{
                    name: "Paket Selesai",
                    data: paket_selesai_anggaran_grafik,
                }]
            });
        },
        complete: function(){
            
        }
    });
}


function grafik_triwulan(tahun) {
    $.ajax({
        url: serverloc + '/realisasi/rekap_triwulan/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            let categories = new Array();
            let triwulan1_pagu_grafik = new Array();
            let triwulan2_pagu_grafik = new Array();
            let triwulan3_pagu_grafik = new Array();
            let triwulan4_pagu_grafik = new Array();

            $.each(response, function (i, field) {
                $.each(field.baris, function (i, baris) {
                    categories.push(baris.singkatan);
                    triwulan1_pagu_grafik.push(parseFloat(baris.triwulan1_pagu_grafik));
                    triwulan2_pagu_grafik.push(parseFloat(baris.triwulan2_pagu_grafik));
                    triwulan3_pagu_grafik.push(parseFloat(baris.triwulan3_pagu_grafik));
                    triwulan4_pagu_grafik.push(parseFloat(baris.triwulan4_pagu_grafik));
                });
            })

            Highcharts.chart('triwulan_body', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    categories: categories,
                    crosshair: true
                },
                yAxis: { 
                    title: {
                        text: 'Pagu (Rp)',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    labels: {
                        format: '{value} M',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    }
                },
                tooltip: {
                    shared: true,
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        // dataLabels: {
                        //     enabled: true
                        // }
                    }
                },
                series: [{
                    name: "Triwulan I",
                    data: triwulan1_pagu_grafik,
                }, {
                    name: "Triwulan II",
                    data: triwulan2_pagu_grafik,
                },{
                    name: "Triwulan III",
                    data: triwulan3_pagu_grafik,
                }, {
                    name: "Triwulan IV",
                    data: triwulan4_pagu_grafik,
                }]
            });
        },
        complete: function(){
            
        }
    });
}