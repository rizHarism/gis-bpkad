@extends('adminlte::page')

{{-- @section('title', 'Dashboard | Users') --}}
@section('title', 'Data Dasar | OPD')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <form id="edit-form" method="POST" class="form-horizontal"
                action="{{ isset($edit) ? route('dataopd.update', ['opd' => $edit]) : route('dataopd.store') }}">
                @method('PUT')
                {{ csrf_field() }}
                <h5 class="card-header">Data OPD</h5>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="kode-opd" class="col-sm-2 col-form-label">Kode OPD</label>
                        <div class="col-sm-10">
                            <input type="text" name="kode_opd" class="form-control" id="kode-opd" placeholder="Kode OPD"
                                value="{{ isset($edit) ? $edit['kode_skpd'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama-opd" class="col-sm-2 col-form-label">Nama OPD</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_opd" class="form-control" id="nama-opd" placeholder="Nama Opd"
                                value="{{ isset($edit) ? $edit['nama_skpd'] : '' }}">
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Submit</button>
                    <a href="{{ route('dataopd') }}" class="btn btn-default float-right">Cancel</a>
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
            $("#edit-form").submit(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "{{ isset($edit) ? 'PUT' : 'POST' }}",
                    url: $(this).attr('action'),
                    data: JSON.stringify({
                        nama_opd: $(this).find("input[name='nama_opd']").val(),
                        kode_opd: $(this).find("input[name='kode_opd']").val(),
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
                            var html =
                                "<ul style=justify-content: space-between;'>";
                            for (item in xhr.responseJSON.errors) {
                                if (xhr.responseJSON.errors[item].length) {
                                    for (var i = 0; i < xhr.responseJSON.errors[item]
                                        .length; i++) {
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
                            console.log(html)
                        }
                    }
                });
                return false;
            });
        });
    </script>
@stop
