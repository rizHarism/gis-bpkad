@extends('adminlte::page')

{{-- @section('title', 'Dashboard | Users') --}}
@section('title', 'Data Dasar | BMD')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <form id="form" method="POST" class="form-horizontal"
                action="{{ isset($edit) ? route('bmd.update', ['bmd' => $edit]) : route('bmd.store') }}">
                @method('PUT')
                {{ csrf_field() }}
                <h5 class="card-header">Data Dasar Barang Milik Daerah</h5>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="kode-barang" class="col-sm-2 col-form-label">Kode Barang</label>
                        <div class="col-sm-10">
                            <input type="text" name="kode_barang" class="form-control" id="kode-barang"
                                placeholder="Kode Barang" value="{{ isset($edit) ? $edit['kode_barang'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama-barang" class="col-sm-2 col-form-label">Nama Barang</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_barang" class="form-control" id="nama-barang"
                                placeholder="Nama Barang" value="{{ isset($edit) ? $edit['nama_barang'] : '' }}">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Simpan</button>
                    <a href="{{ route('datadasarbmd') }}" class="btn btn-default float-right">Batal</a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/table.css') }}"> --}}
@stop

@section('js')
    <script src="{{ asset('assets/leaflet/core/leaflet-src.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin//js/L.Control.Layers.Minimap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/Control.MiniMap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Basemaps.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.BetterScale.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/styledLayerControl.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-geoman.min.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.contextmenu.js') }}"></script>
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    <script>
        $(function() {
            $("#form").submit(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "{{ isset($edit) ? 'PUT' : 'POST' }}",
                    url: $(this).attr('action'),
                    data: JSON.stringify({
                        kode_barang: $(this).find("input[name='kode_barang']").val(),
                        nama_barang: $(this).find("input[name='nama_barang']").val(),
                    }),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        // alert(data);
                        swal.fire({
                            title: 'Berhasil',
                            text: data,
                            icon: 'success',
                        }).then(function() {
                            window.location = document.referrer;
                        });
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        // alert(xhr.responseJSON.message);
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            var html = "<ul>";
                            for (item in xhr.responseJSON.errors) {
                                if (xhr.responseJSON.errors[item].length) {
                                    for (var i = 0; i < xhr.responseJSON.errors[item]
                                        .length; i++) {
                                        // alert(xhr.responseJSON.errors[item][i]);
                                        html += "<li class='dropdown-item'>" +
                                            "<i class='fas fa-times' style='color: red;'></i> &nbsp&nbsp&nbsp&nbsp" +
                                            xhr
                                            .responseJSON
                                            .errors[item][i] +
                                            "</li>"
                                    }
                                }
                            }
                            html += '</ul>';
                            swal.fire({
                                title: 'Error',
                                html: html,
                                icon: 'warning',
                            });
                        }
                    }
                });
                return false;
            });
        });
    </script>
@stop
