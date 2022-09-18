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
                    zoomType: 'xy'
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
                yAxis: [{ // Primary yAxis
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
                }, { // Secondary yAxis
                    title: {
                        text: 'Paket',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} paket',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true,
                }],
                tooltip: {
                    shared: true
                },
                series: [{
                    name: 'RUP (Anggaran)',
                    type: 'spline',
                    data: response[0].rup_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                }, {
                    name: 'RUP (Paket)',
                    type: 'spline',
                    yAxis: 1,
                    data: response[0].rup_paket,
                    tooltip: {
                        valueSuffix: ' paket'
                    }
            
                },{
                    name: 'Realisasi (Anggaran)',
                    type: 'spline',
                    data: response[0].realisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                }, {
                    name: 'Realisasi (Paket)',
                    type: 'spline',
                    yAxis: 1,
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
                    zoomType: 'xy'
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
                yAxis: [{ // Primary yAxis
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
                }, { // Secondary yAxis
                    title: {
                        text: 'Paket',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} paket',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true,
                }],
                tooltip: {
                    shared: true
                },
                series: [{
                    name: 'RUP (Anggaran)',
                    type: 'spline',
                    data: response[0].rup_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                }, {
                    name: 'RUP (Paket)',
                    type: 'spline',
                    yAxis: 1,
                    data: response[0].rup_paket,
                    tooltip: {
                        valueSuffix: ' paket'
                    }
            
                },{
                    name: 'Realisasi (Anggaran)',
                    type: 'spline',
                    data: response[0].realisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                }, {
                    name: 'Realisasi (Paket)',
                    type: 'spline',
                    yAxis: 1,
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
                    zoomType: 'xy'
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
                yAxis: [{ // Primary yAxis
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
                }, { // Secondary yAxis
                    title: {
                        text: 'Persentase',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} %',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true,
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom',
                    itemMarginTop: 5,
                    itemMarginBottom: 5,
                    floating: false,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || // theme
                        'rgba(255,255,255,0.25)'
                },
                series: [{
                    name: 'Rencana',
                    type: 'spline',
                    data: response[0].rencana,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Total Tender',
                    type: 'spline',
                    data: response[0].total,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Proses',
                    type: 'spline',
                    data: response[0].proses,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Selesai',
                    type: 'spline',
                    data: response[0].selesai,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Batal',
                    type: 'spline',
                    data: response[0].batal,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (Anggaran)',
                    type: 'spline',
                    data: response[0].optimalisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (persen)',
                    type: 'spline',
                    yAxis: 1,
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
                    zoomType: 'xy'
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
                yAxis: [{ // Primary yAxis
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
                }, { // Secondary yAxis
                    title: {
                        text: 'Persentase',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value} %',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true,
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom',
                    itemMarginTop: 5,
                    itemMarginBottom: 5,
                    floating: false,
                    backgroundColor:
                        Highcharts.defaultOptions.legend.backgroundColor || // theme
                        'rgba(255,255,255,0.25)'
                },
                series: [{
                    name: 'Rencana',
                    type: 'spline',
                    data: response[0].rencana,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Total Tender',
                    type: 'spline',
                    data: response[0].total,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Proses',
                    type: 'spline',
                    data: response[0].proses,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Selesai',
                    type: 'spline',
                    data: response[0].selesai,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Tender Batal',
                    type: 'spline',
                    data: response[0].batal,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (Anggaran)',
                    type: 'spline',
                    data: response[0].optimalisasi_anggaran,
                    tooltip: {
                        valueSuffix: ' M'
                    }
            
                },{
                    name: 'Optimalisasi (persen)',
                    type: 'spline',
                    yAxis: 1,
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

