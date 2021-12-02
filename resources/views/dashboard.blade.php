@extends('adminlte::page')

@section('title', 'Dashboard | Simantab')

@section('content_header')
    <h1>Total Aset Kota Blitar</h1>
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
        var api = 'http://127.0.0.1:8000/api'

        function allAset() {
            $.getJSON(api + '/inventaris/dashboard', (data) => {
                let allAset = data.total_aset;
                let sertifikat = data.bersertifikat;
                let nonSertifikat = data.tidak_bersertifikat;
                console.log(allAset, sertifikat, nonSertifikat);


                $('#all_aset').html('')
                $('#all_aset').append(allAset)
                $('#bersertifikat').html('')
                $('#bersertifikat').append(sertifikat)
                $('#non_sertifikat').html('')
                $('#non_sertifikat').append(nonSertifikat)

            })
        };

        allAset();
    </script>
@stop
