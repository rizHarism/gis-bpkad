@extends('adminlte::page')

@section('title', 'Dashboard | Simantab')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    {{-- @include('contents.data_dasar_bmd_content') --}}
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <h5 class="card-header">Data Dasar Milik Daerah</h5>
            <div class="card-body">

                <table class="table table-striped table-hover table-bordered order-column" id="master_barang">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>Id Master Barang</th> --}}
                            <th>Kode Barang</th>
                            <th>Nama Master Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/table.css') }}"> --}}
@stop

@section('js')
    {{-- <script src="{{ asset('assets/leaflet/core/leaflet-src.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin//js/L.Control.Layers.Minimap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/Control.MiniMap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Basemaps.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.BetterScale.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/styledLayerControl.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-geoman.min.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.contextmenu.js') }}"></script>
    <script src="{{ asset('assets/inventaris/kib_a.js') }}"></script> --}}
    <script>
        var table = $('#master_barang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/api/masterbarang',
                method: "GET"
            },
            columns: [{
                    data: 'DT_RowIndex'
                },
                // {
                //     data: 'id_barang'
                // },
                {
                    data: 'kode_barang'
                },
                {
                    data: 'nama_barang'
                },

            ],

        });
    </script>
@stop
