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
                    labels: ['Bersertifikat', 'Belum Bersertifikat'],
                    datasets: [{
                        label: '# of Votes',
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
                            position: 'left',
                            labels: {
                                font: {
                                    size: 16
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
                    labels: ['Terpetakan', 'Belum Terpetakan'],
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
                            position: 'left',
                            labels: {
                                font: {
                                    size: 16
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
                    labels: ['Belum Terinventaris', 'Terinventaris'],
                    datasets: [{
                        label: '# of Votes',
                        data: [data.aset_gedung - data.aset_gedung_terinvetaris, data
                            .aset_gedung_terinvetaris
                        ],
                        backgroundColor: [
                            '#e33642',
                            '#3fa123',

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
                            position: 'left',
                            labels: {
                                font: {
                                    size: 16
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
                    labels: ['Terpetakan', 'Belum Terpetakan'],
                    datasets: [{
                        label: '# of Votes',
                        data: [data.aset_gedung_terinvetaris, data.aset_gedung_terinvetaris - data
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
                            position: 'left',
                            labels: {
                                font: {
                                    size: 16
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
