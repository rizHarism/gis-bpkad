@extends('adminlte::page')

@section('title', 'Data Aset | Aset Gedung')

@section('content_header')
    <div class="mt-2"></div>
@stop

@section('content')
    {{-- @include('contents.inventaris_kib_a_edit_content') --}}
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <form id="edit-form" method="POST" class="form-horizontal" name="invent"
                    action="{{ isset($edit) ? route('inventarisgedung.update', ['id' => $edit]) : route('inventarisgedung.store') }}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    {{ csrf_field() }}
                    <h5 class="card-header">{{ isset($edit) ? 'Edit - ' . $edit['nama'] : 'Tambah Inventaris Gedung' }}
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-0 fw-normal">
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
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">SKPD Pengelola
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="skpd" id="skpd">
                                                        <option value="">-- Pilih OPD Pengelola --</option>
                                                        @foreach ($skpd as $_skpd)
                                                            <option value="{{ $_skpd['id_skpd'] }}"
                                                                {{ isset($edit) && $edit['skpd_id'] == $_skpd['id_skpd'] ? 'selected="selected"' : '' }}>
                                                                {{ $_skpd['nama_skpd'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Kategori Aset :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="barang" id="barang">
                                                        <option value="">-- Pilih Kategori Aset --</option>
                                                        @foreach ($barang as $_barang)
                                                            <option value="{{ $_barang['id_barang'] }}"
                                                                {{ isset($edit) && $edit['master_barang_id'] == $_barang['id_barang'] ? 'selected="selected"' : '' }}>
                                                                {{ $_barang['nama_barang'] ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 mb-2">
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
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Nilai Aset :</label>
                                                    {{-- <input type="text" class="form-control " id="nilai_aset"
                                                    placeholder=""
                                                    value="{{ isset($edit) ? number_format($edit['nilai_aset'], 2, ',', '.') : '' }}"> --}}
                                                    <input type="text" class="form-control " id="value_nilai_aset"
                                                        name="value_nilai_aset" placeholder=""
                                                        value="{{ $edit['nilai_aset'] ?? '' }}">
                                                    {{-- value="{{ number_format($edit['nilai_aset'], 2, ',', '.') ?? ''
                                                }}"> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">No Register :</label>
                                                    <input type="text" class="form-control " name="noRegister"
                                                        id="noRegister" placeholder=""
                                                        value="{{ $edit['no_register'] ?? '' }}">
                                                </div>

                                                <div class="col-md-3 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Luas (M<sup>2</sup>)
                                                        :</label>
                                                    <input type="text" class="form-control " name="luas" id="luas"
                                                        placeholder="" value="{{ $edit['luas'] ?? '' }}">
                                                </div>

                                                <div class="col-md-2 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kode Gedung
                                                        :</label>
                                                    <input type="text" class="form-control " name="kodeGedung"
                                                        id="kodeGedung" placeholder=""
                                                        value="{{ $edit['kode_gedung'] ?? '' }}">
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Status Gedung
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="status" id="status">
                                                        <option value="">-- Pilih Status Gedung --</option>
                                                        <option value="Pemda"
                                                            {{ isset($edit) && $edit['status'] == 'Pemda' ? 'selected="selected"' : '' }}>
                                                            Pemda</option>
                                                        <option value="Bukan Pemda"
                                                            {{ isset($edit) && $edit['status'] == 'Bukan Pemda' ? 'selected="selected"' : '' }}>
                                                            Bukan Pemda</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kondisi Gedung
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="kondisiBangunan" id="kondisiBangunan">
                                                        <option value="">-- Pilih Kondisi Gedung --</option>
                                                        <option value="B"
                                                            {{ isset($edit) && $edit['kondisi_bangunan'] == 'B' ? 'selected="selected"' : '' }}>
                                                            Baik</option>
                                                        <option value="RR"
                                                            {{ isset($edit) && $edit['kondisi_bangunan'] == 'RR' ? 'selected="selected"' : '' }}>
                                                            Rusak Ringan</option>
                                                        <option value="RB"
                                                            {{ isset($edit) && $edit['kondisi_bangunan'] == 'RB' ? 'selected="selected"' : '' }}>
                                                            Rusak Berat</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Jenis Konstruksi
                                                        :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="jenisBangunan" id="jenisBangunan">
                                                        <option value="">-- Pilih Jenis Konstruksi --</option>
                                                        <option value="BTK"
                                                            {{ isset($edit) && $edit['jenis_bangunan'] == 'BTK' ? 'selected="selected"' : '' }}>
                                                            Bertingkat</option>
                                                        <option value="TTK"
                                                            {{ isset($edit) && $edit['jenis_bangunan'] == 'TTK' ? 'selected="selected"' : '' }}>
                                                            Tidak Bertingkat</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic ">
                                                    </label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="jenisKonstruksi" id="jenisKonstruksi">
                                                        <option value="">-- Pilih Bahan Konstuksi --</option>
                                                        <option value="BTN"
                                                            {{ isset($edit) && $edit['jenis_konstruksi'] == 'BTN' ? 'selected="selected"' : '' }}>
                                                            Beton</option>
                                                        <option value="BBTN"
                                                            {{ isset($edit) && $edit['jenis_kosntruksi'] == 'BBTN' ? 'selected="selected"' : '' }}>
                                                            Bukan Beton</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Alamat :</label>
                                                    <input type="text" class="form-control " name="alamat" id="alamat"
                                                        placeholder="" value="{{ $edit['alamat'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kelurahan :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="kelurahan" id="kelurahan">
                                                        <option value="">-- Pilih Kelurahan --</option>
                                                        @foreach ($kelurahan as $_kelurahan)
                                                            <option value="{{ $_kelurahan['id_kelurahan'] }}"
                                                                {{ isset($edit) && $edit['kelurahan_id'] == $_kelurahan['id_kelurahan'] ? 'selected="selected"' : '' }}>
                                                                {{ $_kelurahan['nama_kelurahan'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kecamatan :</label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="kecamatan" id="kecamatan">
                                                        <option value="">-- Pilih Kecamatan --</option>
                                                        @foreach ($kecamatan as $_kecamatan)
                                                            <option value="{{ $_kecamatan['id_kecamatan'] }}"
                                                                {{ isset($edit) && $edit['kecamatan_id'] == $_kecamatan['id_kecamatan'] ? 'selected="selected"' : '' }}>
                                                                {{ $_kecamatan['nama_kecamatan'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label for="" class="form-label mb-0 fst-italic">No Sertifikat :</label>
                                                    <input type="text" class="form-control " name="no_sertifikat"
                                                        id="no_sertifikat" placeholder=""
                                                        value="{{ $edit['no_dokumen_sertifikat'] ?? '' }}">
                                                </div>
                                            </div> --}}

                                            <div class="row mb-2">
                                                <div class="col-md-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic m">Lat :</label>
                                                    <input type="text" class="form-control " name="lat" id="lat"
                                                        placeholder=""
                                                        value="{{ isset($edit->geometry) ? $edit->geometry->lat : '' }}">
                                                    {{-- </div> --}}
                                                </div>
                                                <div class="col-md-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic">Long :</label>
                                                    <input type="text" class="form-control " name="lng" id="lng"
                                                        placeholder=""
                                                        value="{{ isset($edit->geometry) ? $edit->geometry->lng : '' }}">
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Geometri :</label>
                                                    <textarea class="form-control" name="geometry" id="geometry" rows="3" name="geometry"
                                                        disabled>{{ isset($edit->geometry) ? $edit->geometry->polygon : '' }}</textarea>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic">Foto :</label>
                                                    <input type="file" name="image" id="image" class="form-control"
                                                        accept="image/png, image/jpg, image/jpeg">
                                                    <span
                                                        style="font-size: 10px">{{ isset($edit->galery) ? 'Kosongkan form jika tidak ingin merubah foto gedung' : '' }}</span>
                                                </div>
                                                <div class="col-md-5 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Dokumen :</label>
                                                    <input type="file" name="penanda" id="penanda" class="form-control"
                                                        accept="image/png, image/jpg, image/jpeg">
                                                    <span
                                                        style="font-size: 10px">{{ isset($edit->document) ? 'Kosongkan form jika tidak ingin merubah foto penanda' : '' }}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                {{-- <div class="col-md-5 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Dokumen :</label>
                                                    <input type="file" name="document" id="document" class="form-control"
                                                        accept="application/pdf">
                                                    <span
                                                        style="font-size: 10px">{{ isset($edit->document) ? 'Kosongkan form jika tidak ingin merubah dokumen' : '' }}</span>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 justify-items-end">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="mb-0" style="font-style: italic">Preview Peta :</span>
                                        <div id="map" style="min-height: 500px; height:64vh ;max-height: 1000px"></div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span style="font-style: italic">Preview Foto Gedung:</span>
                                                <div class="ratio ratio-16x9">
                                                    <img id="foto-preview" class=""
                                                        src="{{ isset($edit->galery) ? asset('assets/galery/' . $edit->galery->image_path) : asset('assets/galery/default-image.png') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <span style="font-style: italic">Preview Penanda Gedung:</span>
                                                <div class="ratio ratio-16x9">
                                                    <img id="penanda-preview"
                                                        src="{{ isset($edit->document) ? asset('assets/document/' . $edit->document->doc_path) : asset('assets/galery/default-image.png') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <hr> --}}
                                <div class="me-3 mt-3" style="text-align: right">
                                    {{-- <a href="#" class="btn btn-secondary mt-5 ms-auto">Batal</a>
                            &nbsp; --}}
                                    <button type="submit" class="btn btn-info float-right">Simpan</button>

                                    <a href="{{ route('inventaris_kib_a') }}"
                                        class="btn btn-default float-right me-3">Batal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <script></script>

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
        $(document).on({
            ajaxStart: function() {
                $("body").addClass("loading");
            },
            ajaxStop: function() {
                $("body").removeClass("loading");
            }
        });

        //change Foto preview
        function changeFoto(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // $('#foto-preview').attr('class', 'img-thumbnail');
                    $('#foto-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function changeDocument(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // $('#foto-preview').attr('class', 'img-thumbnail');
                    $('#penanda-preview').attr('src', e.target.result);
                    // $('#avatar-image2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }



        $("#image").change(function() {
            var ext = $('#image').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                // alert('invalid extension!');
                swal.fire({
                    title: 'Error',
                    html: 'File Foto harus berupa Gambar',
                    icon: 'warning',
                });
                $("#image").val("")
            } else {
                changeFoto(this);
            }
        });
        $("#penanda").change(function() {
            var ext = $('#penanda').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                swal.fire({
                    title: 'Error',
                    html: 'File Foto harus berupa Gambar',
                    icon: 'warning',
                });
                $("#penanda").val("")
            } else {
                changeDocument(this);
            }
        });
        // $(document).ready(function() {
        //     $(".btn-add-more").click(function() {
        //         var html = $(".clone").html();
        //         $(".img_div").after(html);
        //     });
        //     $("body").on("click", ".btn-remove", function() {
        //         $(this).parents(".control-group").remove();
        //     });
        // });

        $(function() {
            $("#edit-form").submit(function() {

                let ms = new Date().getMilliseconds()
                let kode = $("#kodeGedung").val()
                let generate = Math.floor(ms + Math.random() * 90000) + kode
                var formData = new FormData;
                var putMethod = '{{ isset($edit) }}'


                formData.append('id_inventaris', generate);
                formData.append('nama_inventaris', $("#nama_inventaris").val());
                formData.append('tahun', $("#tahun").val());
                formData.append('nilai_aset', $("#value_nilai_aset").val());
                formData.append('luas', $("#luas").val());
                formData.append('kode_gedung', $("#kodeGedung").val());
                formData.append('status', $("#status").val());
                formData.append('no_register', $("#noRegister").val());
                formData.append('kondisi_bangunan', $("#kondisiBangunan").val());
                formData.append('jenis_bangunan', $("#jenisBangunan").val());
                formData.append('jenis_konstruksi', $("#jenisKonstruksi").val());
                formData.append('alamat', $("#alamat").val());
                formData.append('kelurahan', $("#kelurahan").val());
                formData.append('kecamatan', $("#kecamatan").val());
                // formData.append('no_sertifikat', $("#no_sertifikat").val());
                formData.append('skpd', $("#skpd").val());
                formData.append('barang', $("#barang").val());
                formData.append('polygon', $("#geometry").val());
                formData.append('lat', $("#lat").val());
                formData.append('lng', $("#lng").val());
                formData.append('image', $('input[type=file]')[0].files[0]);
                formData.append('penanda', $('input[type=file]')[1].files[0]);

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

        //add pm
        L.PM.initialize({
            optIn: true
        });

        var batasKota = {
            "color": "#ffe312",
            "weight": 2,
            "opacity": 1
        };

        var batasSananwetan = new L.GeoJSON.AJAX("{{ asset('assets/leaflet/geojson/sananwetan.geojson') }}", {
            style: batasKota,
            pmIgnore: true
        });
        var batasKepanjenkidul = new L.GeoJSON.AJAX("{{ asset('assets/leaflet/geojson/kepanjenkidul.geojson') }}", {
            style: batasKota,
            pmIgnore: true
        });
        var batasSukorejo = new L.GeoJSON.AJAX("{{ asset('assets/leaflet/geojson/sukorejo.geojson') }}", {
            style: batasKota,
            pmIgnore: true
        });
        batasSananwetan.addTo(map);
        batasKepanjenkidul.addTo(map);
        batasSukorejo.addTo(map);



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
        map.pm.setLang('id')

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
            // point.addTo(map)
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

        // ----- PERCOBAAN ADD MULTIPOLYGON LEAFLET GEOMAN -------

        var multiPoly = [];

        map.on('pm:create', (e) => {
            var layer = e.layer,
                shape = e.shape,
                nf = Intl.NumberFormat();
            // console.log(layer.toGeoJSON())
            // if (shape === 'Polygon') {

            var extract = layer.toGeoJSON().geometry.coordinates
            var geo = layer.toGeoJSON();
            var polygon = new L
                .geoJson(geo);
            multiPoly.push(extract)
            console.log(JSON.stringify(extract));
            console.log(JSON.stringify(multiPoly));
            var multy = L.polygon(multiPoly).toGeoJSON().geometry
            console.log(JSON.stringify(multy));


            // console.log(multy.toGeoJSON().geometry);
            point = L.marker(
                polygon
                .getBounds()
                .getCenter()
            );
            var polygon = JSON.stringify(extract);
            // console.log(point)
            // $('#geometry').val(JSON.stringify(multy))
            $('#lat').val(point.toGeoJSON().geometry.coordinates[1])
            $('#lng').val(point.toGeoJSON().geometry.coordinates[0])

            // }
            L.geoJson(multy).addTo(map)
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
            $('#lat').val('')
            $('#lng').val('')
        })
    </script>
@stop
