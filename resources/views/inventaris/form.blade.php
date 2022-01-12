@extends('adminlte::page')

@section('title')
    {{ isset($edit) ? 'Edit Inventaris | Simantab' : 'Tambah Inventaris' }}
@stop

@section('content_header')
    <div class="mt-2"></div>
@stop

@section('content')
    {{-- @include('contents.inventaris_kib_a_edit_content') --}}
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form id="edit-form" method="POST" class="form-horizontal"
                    action="{{ isset($edit) ? route('inventaris.update', ['id' => $edit]) : route('inventaris.store') }}">
                    @method('PUT')
                    {{ csrf_field() }}
                    <h5 class="card-header">{{ isset($edit) ? 'Edit - ' . $edit['nama'] : 'Tambah Inventaris' }}
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5 mb-0 fw-normal">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="container-fluid ms-3">
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic m">Nama Aset :</label>
                                                    <input type="text" class="form-control " name="nama_inventaris"
                                                        id="nama_inventaris" placeholder=""
                                                        value="{{ $edit['nama'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 mb-2">
                                                    <label for="" class="form-label mb-0 fst-italic">Tahun Perolehan
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="tahun">
                                                        {{ $last = date('Y') - 120 }}
                                                        {{ $now = date('Y') }}

                                                        @for ($i = $now; $i >= $last; $i--)
                                                            <option value="{{ $i }}"
                                                                {{ isset($edit) && $i == $edit['tahun_perolehan'] ? 'selected="selected"' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Nilai Aset :</label>
                                                    {{-- <input type="text" class="form-control " id="nilai_aset"
                                            placeholder=""
                                            value="{{ isset($edit) ? number_format($edit['nilai_aset'], 2, ',', '.') : '' }}"> --}}
                                                    <input type="text" class="form-control " id="value_nilai_aset"
                                                        name="value_nilai_aset" placeholder=""
                                                        value="{{ $edit['nilai_aset'] ?? '' }}">
                                                    {{-- value="{{ number_format($edit['nilai_aset'], 2, ',', '.') ?? '' }}"> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Status Sertifikat
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="status">
                                                        <option value="1">Bersertifikat</option>
                                                        <option value="0">TIdak Bersertifikat</option>
                                                    </select>
                                                </div>
                                                <div class="col-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Luas (M<sup>2</sup>)
                                                        :</label>
                                                    <input type="text" class="form-control " name="luas" id="luas"
                                                        placeholder="" value="{{ $edit['luas'] ?? '' }} ">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Alamat :</label>
                                                    <input type="text" class="form-control " name="alamat"
                                                        id="exampleFormControlInput1" placeholder=""
                                                        value="{{ $edit['alamat'] ?? '' }} ">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kelurahan :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="kelurahan">
                                                        @foreach ($kelurahan as $_kelurahan)
                                                            <option value="{{ $_kelurahan['id_kelurahan'] }}"
                                                                {{ isset($edit) && $edit['kelurahan_id'] == $_kelurahan['id_kelurahan'] ? 'selected="selected"' : '' }}>
                                                                {{ $_kelurahan['nama_kelurahan'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kecamatan :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="kecamatan">
                                                        @foreach ($kecamatan as $_kecamatan)
                                                            <option value="{{ $_kecamatan['id_kecamatan'] }}"
                                                                {{ isset($edit) && $edit['kecamatan_id'] == $_kecamatan['id_kecamatan'] ? 'selected="selected"' : '' }}>
                                                                {{ $_kecamatan['nama_kecamatan'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 mb-2">
                                                    <label for="" class="form-label mb-0 fst-italic">No Sertifikat :</label>
                                                    <input type="text" class="form-control " name="no_sertifikat"
                                                        id="no_sertifikat" placeholder=""
                                                        value="{{ $edit['no_dokumen_sertifikat'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">SKPD Pengelola
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="skpd">
                                                        @foreach ($skpd as $_skpd)
                                                            <option value="{{ $_skpd['id_skpd'] }}"
                                                                {{ isset($edit) && $edit['skpd_id'] == $_skpd['id_skpd'] ? 'selected="selected"' : '' }}>
                                                                {{ $_skpd['nama_skpd'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Kategori Aset :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="barang">
                                                        @foreach ($barang as $_barang)
                                                            <option value="{{ $_barang['id_barang'] }}"
                                                                {{ isset($edit) && $edit['master_barang_id'] == $_barang['id_barang'] ? 'selected="selected"' : '' }}>
                                                                {{ $_barang['nama_barang'] ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic m">Lat :</label>
                                                    <input type="text" class="form-control " name="lat" id="lat"
                                                        placeholder="" value="@if (isset($edit))@foreach ($geometry as $_geometry){{ $_geometry['lat'] ?? '' }}@endforeach @endif">
                                                    {{-- </div> --}}
                                                </div>
                                                <div class="col-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic m">Long :</label>
                                                    <input type="text" class="form-control " name="long" id="long"
                                                        placeholder="" value="@if (isset($edit))@foreach ($geometry as $_geometry){{ $_geometry['lng'] ?? '' }}@endforeach @endif">
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Geometry :</label>
                                                    <textarea class="form-control" id="geometry" rows="3"
                                                        name="geometry">@if (isset($edit))@foreach ($geometry as $_geometry){{ $_geometry['polygon'] ?? '' }}@endforeach @endif</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7 justify-items-end">
                                <div class="card">
                                    <div class="card-body">
                                        <div id="map" style="min-height: 500px; height:78vh ;max-height: 1000px"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="me-5" style="text-align: right">
                                {{-- <a href="#" class="btn btn-secondary mt-5 ms-auto">Batal</a>
                                &nbsp; --}}
                                <button type="submit" class="btn btn-info float-right">Submit</button>
                                <a href="{{ route('users.index') }}" class="btn btn-default float-right">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <script>

    </script>

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
    <script>
        $(function() {
            $("#edit-form").submit(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "{{ isset($edit) ? 'PUT' : 'POST' }}",
                    // url: $(this).attr('action'),
                    url: "{{ route('inventaris.store') }}",
                    data: JSON.stringify({
                        nama: $(this).find("input[name='nama_inventaris']").val(),
                        tahun: $(this).find("select[name='tahun']").val(),
                        nilai: $(this).find("input[name='value_nilai_aset']").val(),
                        luas: $(this).find("input[name='luas']").val(),
                        status: $(this).find("select[name='status']").val(),
                        alamat: $(this).find("input[name='alamat']").val(),
                        kelurahan: $(this).find("select[name='kelurahan']").val(),
                        kecamatan: $(this).find("select[name='kecamatan']").val(),
                        no_sertifikat: $(this).find("input[name='no_sertifikat']").val(),
                        skpd: $(this).find("select[name='skpd']").val(),
                        barang: $(this).find("select[name='barang']").val(),
                        geometry: $(this).find("textarea[name='geomerty']").val(),

                    }),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        alert(data);
                        window.location = document.referrer;
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        // alert(xhr.responseJSON.message);
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            for (item in xhr.responseJSON.errors) {
                                if (xhr.responseJSON.errors[item].length) {
                                    for (var i = 0; i < xhr.responseJSON.errors[item]
                                        .length; i++) {
                                        alert(xhr.responseJSON.errors[item][i]);
                                    }
                                }
                            }
                        }
                    }
                });
                return false;
            });
        });



        var map = L.map('map', {
            zoomControl: false,
            contextmenu: false,
        }).setView([-8.098244, 112.165077], 13);
        var esri = L.tileLayer.provider('Esri.WorldImagery', {
            maxZoom: 19
        }).addTo(map)

        L.PM.initialize({
            optIn: true
        });

        map.pm.addControls({
            drawMarker: false,
            drawCircleMarker: false,
            drawPolyline: false,
            drawRectangle: false,
            drawPolygon: true,
            drawCircle: false,
            cutPolygon: false,
            rotateMode: false,
            editControls: true,
        });

        var geometry = $('#geometry').val();
        // var layer;
        console.log(geometry)
        if (geometry) {

            var geo = JSON.parse(geometry);
            var poly = new L
                .geoJson(geo);
            console.log(geo);
            point = L.marker(
                poly
                .getBounds()
                .getCenter()
            );

            console.log(point.toGeoJSON().geometry.coordinates[0])
            console.log(point.toGeoJSON().geometry.coordinates[1])

            poly.addTo(
                map);
            point.addTo(map)
            var bound = poly
                .getBounds();
            map.fitBounds(
                bound);

            poly.on('pm:edit', ({
                layer
            }) => {
                // var coords = lyr.getLatLngs();
                // var polyedit = lyr.toGeoJSON();
                console.log(JSON.stringify(layer.toGeoJSON().geometry));
                var geo = layer.toGeoJSON();
                var polygon = new L
                    .geoJson(geo);
                console.log(polygon);
                point = L.marker(
                    polygon
                    .getBounds()
                    .getCenter()
                );
                $('#geometry').val(JSON.stringify(layer.toGeoJSON().geometry))
                $('#lat').val(point.toGeoJSON().geometry.coordinates[1])
                $('#long').val(point.toGeoJSON().geometry.coordinates[0])
                // console.log(polyedit);
                // console.log(point.toGeoJSON().geometry.coordinates[0])
                // console.log(point.toGeoJSON().geometry.coordinates[1])
            })

        }



        map.on('pm:create', (e) => {
            var layer = e.layer,
                shape = e.shape,
                nf = Intl.NumberFormat();
            // console.log(layer)
            if (shape === 'Polygon') {

                var extract = layer.toGeoJSON().geometry
                var geo = layer.toGeoJSON();
                var polygon = new L
                    .geoJson(geo);
                console.log(polygon);
                point = L.marker(
                    polygon
                    .getBounds()
                    .getCenter()
                );
                var polygon = JSON.stringify(extract);
                console.log(point)
                $('#geometry').val(polygon)
                $('#lat').val(point.toGeoJSON().geometry.coordinates[0])
                $('#long').val(point.toGeoJSON().geometry.coordinates[1])

            }

        })

        map.on('pm:create', ({
            layer
        }) => {
            layer.on('pm:edit', e => {
                console.log(e);

                var extract = layer.toGeoJSON().geometry
                var geo = layer.toGeoJSON();
                var polygon = new L
                    .geoJson(geo);
                console.log(polygon);
                point = L.marker(
                    polygon
                    .getBounds()
                    .getCenter()
                );
                var polygon = JSON.stringify(extract);
                console.log(point)
                $('#geometry').val(polygon);
                $('#lat').val(point.toGeoJSON().geometry.coordinates[0])
                $('#long').val(point.toGeoJSON().geometry.coordinates[1])

            });
        });

        map.on('pm:remove', (e) => {
            $('#geometry').val('')
        })
    </script>
@stop
