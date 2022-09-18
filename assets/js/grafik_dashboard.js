function belanja_pengadaan(tahun) {
    $.ajax({
        // url: serverloc + '/json/grafik_belanja_pengadaan_apbd_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/belanja_pengadaan/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            Highcharts.chart('grafik_belanja_pengadaan_apbd_kota_balikpapan_body', {
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
                    type: 'category',
                    labels: {
                        style: {
                            fontSize: '9pt',
                            fontFamily: 'tahoma'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Anggaran (Rp)'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    column: {
						pointPadding: 0.2,
						borderWidth: 0,
						cursor: 'pointer'
					},
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y} M'
                        }
                    }
                },
                tooltip: {
                    headerFormat: '',
                    pointFormat: '{point.name}: <b>{point.y}</b> M<br/>'
                },
                series: [
                    {
                        colorByPoint: true,
                        data: response
                    }
                ]
            });
        },
        complete: function(){
            $('#grafik_belanja_pengadaan_apbd_kota_balikpapan .overlay').hide();
        }
    });
}

function rup_penyedia(tahun) {
    $.ajax({
        // url: serverloc + '/json/grafik_rup_penyedia_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/rup_penyedia/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            Highcharts.chart('rup_penyedia_body', {
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
                    categories: response[0].kategori,
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
                series: [{
                    name: 'RUP (Anggaran)',
                    data: response[0].rup_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
                }, {
                    name: 'RUP (Paket)',
                    data: response[0].rup_paket,
                    tooltip: {
                        valueSuffix: ' M'
                    }
                },{
                    name: 'Realisasi (Anggaran)',
                    data: response[0].realisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
                }, {
                    name: 'Realisasi (Paket)',
                    data: response[0].realisasi_paket,
                    tooltip: {
                        valueSuffix: ' M'
                    }
                }]
            });
        },
        complete: function(){
            $('#rup .overlay').hide();
        }
    });
}

function rup_swakelola(tahun) {
    $.ajax({
        // url: serverloc + '/json/grafik_rup_swakelola_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/rup_swakelola/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            Highcharts.chart('rup_swakelola_body', {
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
                    categories: response[0].kategori,
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
                    shared: true
                },
                series: [{
                    name: 'RUP (Anggaran)',
                    data: response[0].rup_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                }, {
                    name: 'RUP (Paket)',
                    data: response[0].rup_paket,
                    tooltip: {
                        valueSuffix: ' paket'
                    }
            
                },{
                    name: 'Realisasi (Anggaran)',
                    data: response[0].realisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                }, {
                    name: 'Realisasi (Paket)',
                    data: response[0].realisasi_paket,
                    tooltip: {
                        valueSuffix: ' paket'
                    }
            
                }]
            });
        },
        complete: function(){
            $('#rup .overlay').hide();
        }
    });
}

function tender(tahun) {
    $.ajax({
        // url: serverloc + '/json/grafik_tender_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/tender/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            Highcharts.chart('tender_body', {
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
                    categories: response[0].kategori,
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
                    shared: true
                },
                series: [{
                    name: 'Rencana',
                    data: response[0].rencana,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Total Tender',
                    data: response[0].total,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Proses',
                    data: response[0].proses,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Selesai',
                    data: response[0].selesai,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Batal',
                    data: response[0].batal,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (Anggaran)',
                    data: response[0].optimalisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (persen)',
                    data: response[0].optimalisasi_persen,
                    tooltip: {
                        valueSuffix: ' %'
                    }
            
                }]
            });
        },
        complete: function(){
            $('#tender .overlay').hide();
        }
    });
}

function nontender(tahun) {
    $.ajax({
        // url: serverloc + '/json/grafik_nontender_'+tahun+'.json?rand_v=' + Math.random(),
        url: serverloc + '/dashboard/nontender/'+tahun,
        type: 'get',
        dataType: 'JSON',
        success: function (response) {
            console.log(response);

            Highcharts.chart('nontender_body', {
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
                    categories: response[0].kategori,
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
                    shared: true
                },
                series: [{
                    name: 'Rencana',
                    data: response[0].rencana,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Total Tender',
                    data: response[0].total,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Proses',
                    data: response[0].proses,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Selesai',
                    data: response[0].selesai,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Batal',
                    data: response[0].batal,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (Anggaran)',
                    data: response[0].optimalisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (persen)',
                    data: response[0].optimalisasi_persen,
                    tooltip: {
                        valueSuffix: ' %'
                    }
            
                }]
            });
        },
        complete: function(){
            $('#nontender .overlay').hide();
        }
    });
}

