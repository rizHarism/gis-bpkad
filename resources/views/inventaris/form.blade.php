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
                <form id="edit-form" method="POST" class="form-horizontal" name="invent"
                    action="{{ isset($edit) ? route('inventaris.update', ['id' => $edit]) : route('inventaris.store') }}"
                    enctype="multipart/form-data">
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
                                                    <input type="text" class="form-control" name="nama_inventaris"
                                                        id="nama_inventaris" placeholder=""
                                                        value="{{ $edit['nama'] ?? '' }}">
                                                    {{-- <input type="hidden" class="form-control " name="jenis_inventaris"
                                                        id="jenis_inventaris" placeholder="" value="A"> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 mb-2">
                                                    <label for="" class="form-label mb-0 fst-italic">Tahun Perolehan
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="tahun" id="tahun">
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
                                                        name="status" id="status">
                                                        <option value="">-- Pilih Status Sertifikat --</option>
                                                        <option value="1"
                                                            {{ isset($edit) && $edit['status'] == 1 ? 'selected="selected"' : '' }}>
                                                            Bersertifikat</option>
                                                        <option value="0"
                                                            {{ isset($edit) && $edit['status'] == 0 ? 'selected="selected"' : '' }}>
                                                            Belum Bersertifikat</option>
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
                                                    <label for="" class="form-label mb-0 fst-italic ">No Register :</label>
                                                    <input type="text" class="form-control " name="noRegister"
                                                        id="noRegister" placeholder=""
                                                        value="{{ $edit['no_register'] ?? '' }} ">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Alamat :</label>
                                                    <input type="text" class="form-control " name="alamat" id="alamat"
                                                        placeholder="" value="{{ $edit['alamat'] ?? '' }} ">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kelurahan :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="kelurahan" id="kelurahan">
                                                        <option>-- Pilih Kelurahan --</option>
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
                                                        name="kecamatan" id="kecamatan">
                                                        <option>-- Pilih Kecamatan --</option>
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
                                                        name="skpd" id="skpd">
                                                        <option>-- Pilih OPD Pengelola --</option>
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
                                                        name="barang" id="barang">
                                                        <option>-- Pilih Kategori Aset --</option>
                                                        @foreach ($barang as $_barang)
                                                            <option value="{{ $_barang['id_barang'] }}"
                                                                {{ isset($edit) && $edit['master_barang_id'] == $_barang['id_barang'] ? 'selected="selected"' : '' }}>
                                                                {{ $_barang['nama_barang'] ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic m">Lat :</label>
                                                    <input type="text" class="form-control " name="lat" id="lat"
                                                        placeholder="" value="@if (isset($edit))@foreach ($geometry as $_geometry){{ $_geometry['lat'] ?? '' }}@endforeach @endif">
                                                    {{-- </div> --}}
                                                </div>
                                                <div class="col-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic">Long :</label>
                                                    <input type="text" class="form-control " name="lng" id="lng"
                                                        placeholder="" value="@if (isset($edit))@foreach ($geometry as $_geometry){{ $_geometry['lng'] ?? '' }}@endforeach @endif">
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Geometry :</label>
                                                    <textarea class="form-control" name="geometry" id="geometry" rows="3"
                                                        name="geometry">@if (isset($edit))@foreach ($geometry as $_geometry){{ $_geometry['polygon'] ?? '' }}@endforeach @endif</textarea>
                                                </div>
                                            </div>

                                            {{-- <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Photo :</label>
                                                    <div class="input-group control-group img_div form-group">
                                                        <input type="file" name="image[]" class="form-control">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-success btn-add-more" type="button"><i
                                                                    class="glyphicon glyphicon-plus"></i> +</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="clone hide " style="display: none;">
                                                    <div class="control-group input-group form-group">
                                                        <input type="file" name="image[]" class="form-control">
                                                        <div class="input-group-btn">
                                                            <button class="btn btn-danger btn-remove" type="button"><i
                                                                    class="glyphicon glyphicon-remove"></i> -</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Photo :</label>
                                                    {{-- <div class="input-group control-group form-group"> --}}
                                                    <input type="file" name="image" id="image" class="form-control"
                                                        accept="image/*">
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Document :</label>
                                                    {{-- <div class="input-group control-group form-group"> --}}
                                                    <input type="file" name="document" id="document" class="form-control"
                                                        accept="application/pdf">
                                                    {{-- </div> --}}
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
                                <a href="{{ route('inventaris_kib_a') }}" class="btn btn-default float-right">Cancel</a>
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
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".btn-add-more").click(function() {
                var html = $(".clone").html();
                $(".img_div").after(html);
            });
            $("body").on("click", ".btn-remove", function() {
                $(this).parents(".control-group").remove();
            });
        });

        $(function() {
            $("#edit-form").submit(function() {

                var formData = new FormData;
                var putMethod = '{{ isset($edit) }}'

                formData.append('nama_inventaris', $("#nama_inventaris").val());
                formData.append('tahun', $("#tahun").val());
                formData.append('nilai_aset', $("#value_nilai_aset").val());
                formData.append('luas', $("#luas").val());
                formData.append('status', $("#status").val());
                formData.append('no_register', $("#noRegister").val());
                formData.append('alamat', $("#alamat").val());
                formData.append('kelurahan', $("#kelurahan").val());
                formData.append('kecamatan', $("#kecamatan").val());
                formData.append('no_sertifikat', $("#no_sertifikat").val());
                formData.append('skpd', $("#skpd").val());
                formData.append('barang', $("#barang").val());
                formData.append('polygon', $("#geometry").val());
                formData.append('lat', $("#lat").val());
                formData.append('lng', $("#lng").val());
                formData.append('image', $('input[type=file]')[0].files[0]);
                formData.append('document', $('input[type=file]')[1].files[0]);

                if (putMethod) {
                    formData.append('_method', 'PUT')
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        // 'Content-Type': 'application/json',
                    },
                    // type: "{{ isset($edit) ? 'PUT' : 'POST' }}",
                    type: "POST",
                    // url: "{{ route('inventaris.store') }}",
                    url: $(this).attr('action'),
                    data: formData,

                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        console.log(data);
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
                                "<ul style='justify-content: space-between;'>";
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
        if (geometry !== " " && geometry !== "") {

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
                $('#lng').val(point.toGeoJSON().geometry.coordinates[0])
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
                $('#lat').val(point.toGeoJSON().geometry.coordinates[1])
                $('#lng').val(point.toGeoJSON().geometry.coordinates[0])

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
                $('#lat').val(point.toGeoJSON().geometry.coordinates[1])
                $('#lng').val(point.toGeoJSON().geometry.coordinates[0])

            });
        });

        map.on('pm:remove', (e) => {
            $('#geometry').val('')
        })
    </script>
@stop
