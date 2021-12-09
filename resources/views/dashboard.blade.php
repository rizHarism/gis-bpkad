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

            // pie chart aset sertifikat

            const allSertifikat = new Chart(pieAll, {
                type: 'pie',
                data: {
                    labels: ['Bersertifikat', 'Belum Bersertifikat'],
                    datasets: [{
                        label: '# of Votes',
                        data: [data.bersertifikat, data.tidak_bersertifikat],
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

            // count aset terpetakan

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
        });

        // count yang sudah terpetakan
    </script>

@stop
