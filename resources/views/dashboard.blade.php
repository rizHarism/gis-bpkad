@extends('adminlte::page')

@section('title', 'Dashboard | Simantab')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    @include('contents.dashboard_content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
        // var api = 'http://127.0.0.1:8000/api'

        var allAset;
        let sertifikat;
        let nonSertifikat;
        $.getJSON('api/inventaris/dashboard', (data) => {
            // console.log(allAset, sertifikat, nonSertifikat);
            allAset = data.total_aset;
            sertifikat = data.bersertifikat;
            nonSertifikat = data.tidak_bersertifikat;

            $('#all_aset').html('')
            $('#all_aset').append(allAset)
            $('#bersertifikat').html('')
            $('#bersertifikat').append(sertifikat)
            $('#non_sertifikat').html('')
            $('#non_sertifikat').append(nonSertifikat)
            $('#all_aset_gedung').html('')
            $('#all_aset_gedung').append(data.aset_gedung)
            $('#aset_gedung_terdata').html('')
            $('#aset_gedung_terdata').append(data.aset_gedung_terinvetaris)
            $('#aset_gedung_terpetakan').html('')
            $('#aset_gedung_terpetakan').append(data.aset_gedung_terpetakan)
        })

        // };
        // countInventaris()
        console.log(allAset)
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.1/chart.js"></script>
    <script src="https://unpkg.com/chart.js-plugin-labels-dv/dist/chartjs-plugin-labels.min.js"></script>

    <script>
        $.getJSON('api/inventaris/dashboard', (data) => {

            const pieAll = $('#allsertifikat');
            const countMap = $('#mapped');
            const gedungTerinventaris = $('#asetGedungTerinventaris');
            const gedungTerpetakan = $('#asetGedungTerpetakan');

            // pie chart aset sertifikat
            const allaset = new Chart(pieAll, {
                type: 'pie',
                data: {
                    labels: ['Bersertifikat : ' + data.bersertifikat, 'Belum Bersertifikat : ' + data
                        .tidak_bersertifikat
                    ],
                    datasets: [{
                        label: [data.bersertifikat, data.tidak_bersertifikat],
                        data: [data.bersertifikat, data
                            .tidak_bersertifikat
                        ],
                        backgroundColor: [
                            '#3fa123',
                            '#e33642',

                        ],
                        borderColor: [
                            '#fff',

                        ],
                        // borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        labels: {
                            // render: 'value',
                            fontSize: 14
                        },
                        legend: {
                            position: 'bottom',
                            // align: 'start',
                            labels: {
                                font: {
                                    size: 16,
                                }
                            }
                        },
                        tooltip: {
                            // enabled: false,
                            callbacks: {
                                label: function(data) {
                                    // let label = context.dataset.label || '';
                                    console.log(data)
                                    var result = (data.dataIndex == 0) ? 'Bersertifikat : ' + data
                                        .parsed : 'Belum bersertifikat : ' + data.parsed;
                                    return result;
                                }
                            }
                        }
                    }
                    // option of cart
                }
            });

            const mapped = new Chart(countMap, {
                type: 'pie',
                data: {
                    labels: ['Terpetakan : ' + data.terpetakan, 'Belum Terpetakan : ' + data
                        .belum_terpetakan
                    ],
                    datasets: [{
                        label: '# of Votes',
                        data: [data.terpetakan, data.belum_terpetakan],
                        backgroundColor: [
                            '#3fa123',
                            '#edd434',

                        ],
                        borderColor: [
                            '#fff',

                        ],
                        // borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        labels: {
                            // render: 'value',
                            fontSize: 14
                        },
                        legend: {
                            position: 'bottom',
                            // align: 'start',
                            labels: {
                                font: {
                                    size: 16,
                                    textAlign: 'left',
                                }
                            }
                        },
                        tooltip: {
                            // enabled: false,
                            callbacks: {
                                label: function(data) {
                                    // let label = context.dataset.label || '';
                                    console.log(data)
                                    var result = (data.dataIndex == 0) ? 'Terpetakan : ' + data
                                        .parsed : 'Belum terpetakan : ' + data.parsed;
                                    return result;
                                }
                            }
                        }
                    }
                    // option of cart
                }
            });
            // pie chart aset Bangunan
            const gedungTerinvent = new Chart(gedungTerinventaris, {
                type: 'pie',
                data: {
                    labels: ['Teridentifikasi : ' + data.aset_gedung_terinvetaris,
                        'Belum Teridentifikasi : ' +
                        (data.aset_gedung - data
                            .aset_gedung_terinvetaris)
                    ],
                    datasets: [{
                        label: '# of Votes',
                        data: [data.aset_gedung_terinvetaris, data.aset_gedung - data
                            .aset_gedung_terinvetaris
                        ],
                        backgroundColor: [
                            '#3fa123',
                            '#e33642',

                        ],
                        borderColor: [
                            '#fff',

                        ],
                        // borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        labels: {
                            // render: 'value',
                            fontSize: 14
                        },
                        legend: {
                            position: 'bottom',
                            // align: 'start',
                            labels: {
                                font: {
                                    size: 16,
                                    textAlign: 'left',
                                }
                            }
                        },
                        tooltip: {
                            // enabled: false,
                            callbacks: {
                                label: function(data) {
                                    // let label = context.dataset.label || '';
                                    console.log(data)
                                    var result = (data.dataIndex == 0) ? 'Teridentifikasi : ' + data
                                        .parsed : 'Belum Teridentifikasi : ' + data.parsed;
                                    return result;
                                }
                            }
                        }
                    }
                    // option of cart
                }
            });

            // count aset terpetakan

            const terpetakan = new Chart(gedungTerpetakan, {
                type: 'pie',
                data: {
                    labels: ['Terpetakan : ' + data.aset_gedung_terpetakan, 'Belum Terpetakan : ' + (data
                        .aset_gedung - data.aset_gedung_terpetakan)],
                    datasets: [{
                        label: '# of Votes',
                        data: [data.aset_gedung_terpetakan, data.aset_gedung - data
                            .aset_gedung_terpetakan
                        ],
                        backgroundColor: [
                            '#3fa123',
                            '#edd434',

                        ],
                        borderColor: [
                            '#fff',

                        ],
                        // borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        labels: {
                            // render: 'value',
                            fontSize: 14
                        },
                        legend: {
                            position: 'bottom',
                            // align: 'start',
                            labels: {
                                font: {
                                    size: 16,
                                    textAlign: 'left',
                                }
                            }
                        },
                        tooltip: {
                            // enabled: false,
                            callbacks: {
                                label: function(data) {
                                    // let label = context.dataset.label || '';
                                    console.log(data)
                                    var result = (data.dataIndex == 0) ? 'Terpetakan : ' + data
                                        .parsed : 'Belum Terpetakan : ' + data.parsed;
                                    return result;
                                }
                            }
                        }
                    }
                    // option of cart
                }
            });
        });

        // count yang sudah terpetakan
    </script>

@stop
