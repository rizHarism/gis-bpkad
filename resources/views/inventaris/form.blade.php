@extends('adminlte::page')

@section('title', 'Data Aset | Aset Tanah')

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
                    <h5 class="card-header">{{ isset($edit) ? 'Edit - ' . $edit['nama'] : 'Tambah Data KIB A ' }}
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-0 fw-normal">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="container-fluid ms-3">
                                            <div class="row">
                                                <div class="col-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic m">Nama Aset
                                                        :</label>
                                                    <input type="text" class="form-control" name="nama_inventaris"
                                                        id="nama_inventaris" placeholder=""
                                                        value="{{ $edit['nama'] ?? '' }}">
                                                    {{-- <input type="hidden" class="form-control " name="jenis_inventaris"
                                                    id="jenis_inventaris" placeholder="" value="A"> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">OPD Pengelola
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
                                                    <label for="" class="form-label mb-0 fst-italic">Kategori Aset
                                                        :</label>
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
                                                    <label for="" class="form-label mb-0 fst-italic">Nilai Aset
                                                        :</label>
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
                                                <div class="col-md-5 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Status
                                                        Sertifikat
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
                                                <div class="col-md-5 mb-2 noSertifikat">
                                                    <label for="" class="form-label mb-0 fst-italic">No Sertifikat
                                                        :</label>
                                                    <input type="text" class="form-control " name="no_sertifikat"
                                                        id="no_sertifikat" placeholder=""
                                                        value="{{ $edit['no_dokumen_sertifikat'] ?? '' }}">
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">No Register
                                                        :</label>
                                                    <input type="text" class="form-control " name="noRegister"
                                                        id="noRegister" placeholder=""
                                                        value="{{ $edit['no_register'] ?? '' }}">
                                                </div>
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Luas
                                                        (M<sup>2</sup>)
                                                        :</label>
                                                    <input type="text" class="form-control " name="luas"
                                                        id="luas" placeholder=""
                                                        value="{{ $edit['luas'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Alamat
                                                        :</label>
                                                    <input type="text" class="form-control " name="alamat"
                                                        id="alamat" placeholder=""
                                                        value="{{ $edit['alamat'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kelurahan
                                                        :</label>
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
                                                <div class="col-md-5 mb-2 ">
                                                    <label for="" class="form-label mb-0 fst-italic ">Kecamatan
                                                        :</label>
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

                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic m">Lat
                                                        :</label>
                                                    <input type="text" class="form-control " name="lat"
                                                        id="lat" placeholder=""
                                                        value="{{ isset($edit->geometry) ? $edit->geometry->lat : '' }}"
                                                        disabled>
                                                    {{-- </div> --}}
                                                </div>
                                                <div class="col-md-5">
                                                    {{-- <div class="mb-2 me-5" style="width: 10vw"> --}}
                                                    <label for="" class="form-label mb-0 fst-italic">Long
                                                        :</label>
                                                    <input type="text" class="form-control " name="lng"
                                                        id="lng" placeholder=""
                                                        value="{{ isset($edit->geometry) ? $edit->geometry->lng : '' }}"
                                                        disabled>
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 ">
                                                    <label for="" class="form-label mb-0 fst-italic">Geometri
                                                        :</label>
                                                    <textarea class="form-control" name="geometry" id="geometry" rows="3" name="geometry" disabled>{{ isset($edit->geometry) ? $edit->geometry->polygon : '' }}</textarea>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-10 mb-2  ">
                                                    <label for="" class="form-label mb-0 fst-italic">Foto : <span
                                                            style="font-size: 11px">(*type file
                                                            jpg,jpeg,png)</span></label>
                                                    <input type="file" name="image" id="image"
                                                        class="form-control" accept="image/png, image/jpg, image/jpeg">

                                                    <span
                                                        style="font-size: 10px">{{ isset($edit->galery) ? ' -Kosongkan form jika tidak ingin merubah foto' : '' }}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 mb-2 me-5 documentSertifikat">
                                                    <label for="" class="form-label mb-0 fst-italic">Dokumen :
                                                        <span style="font-size: 11px;">(*type file pdf)</span></label>
                                                    <input type="file" name="document" id="document"
                                                        class="form-control" accept="application/pdf">
                                                    <span
                                                        style="font-size: 10px">{{ isset($edit->document) ? 'Kosongkan form jika tidak ingin merubah dokumen' : '' }}</span>
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
                                        <div id="map" style="min-height: 500px; height:64vh ;max-height: 1000px">
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span style="font-style: italic">Preview Foto Gedung:</span>
                                                <div class="ratio ratio-16x9 img-wrap">
                                                    <span id="delete-foto"
                                                        class="{{ isset($edit->galery) ? 'close' : '' }}">&nbsp;<i
                                                            class="delete-button fas fa-times"></i>&nbsp;</span>
                                                    <img id="foto-preview" data-id="foto"
                                                        src="{{ isset($edit->galery) ? asset('assets/galery/' . $edit->galery->image_path) : asset('assets/galery/default-image.png') }}"
                                                        alt="">
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 documentPreview">
                                                <span style="font-style: italic">Preview Sertifikat :</span>
                                                <div class="ratio ratio-16x9 img-wrap">
                                                    <span id="delete-sertifikat"
                                                        class="{{ isset($edit->document) ? 'close' : '' }}">&nbsp;<i
                                                            class="delete-button fas fa-times"></i>&nbsp;</span>
                                                    <iframe id="doc-preview" data-id="sertifikat"
                                                        src="{{ isset($edit->document) ? asset('assets/document/' . $edit->document->doc_path) : asset('assets/document/default-sertifikat.pdf') }}"></iframe>
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
    <style>
        .img-wrap {
            position: relative;
            display: inline-block;
            border: black;
            font-size: 0;
        }

        .img-wrap .close {
            position: absolute;
            top: 0px;
            right: 5px;
            z-index: 100;
            background-color: white;
            padding: 2px 2px 2px;
            color: rgb(236, 13, 13);
            font-weight: bold;
            cursor: pointer;
            opacity: 0.1;
            text-align: right;
            font-size: 25px;
            line-height: 10px;
            border-radius: 0%;
        }

        .img-wrap:hover .close {
            opacity: 1;
        }
    </style>
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

        //enable-disabled select status change
        $('#status').change(function() {

            var status_value = $(this).val();
            console.log(status_value)
            if (status_value == '' || status_value == '0') {
                // $('#no_sertifikat').attr('disabled', 'disabled');
                // $('#document').attr('disabled', 'disabled');
                $('.noSertifikat').hide();
                $('.documentSertifikat').hide();
                $('.documentPreview').hide();
            } else {
                $('.noSertifikat').show()
                $('.documentSertifikat').show()
                $('.documentPreview').show()
            }

        }).trigger("change");

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
            $('#delete-foto').addClass('close');
        }

        function changeDocument(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    // $('#foto-preview').attr('class', 'img-thumbnail');
                    $('#doc-preview').attr('src', e.target.result);
                    // $('#avatar-image2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
            $('#delete-sertifikat').addClass('close');
        }

        function defaultFoto() {
            $('#foto-preview').attr('src', '{{ asset('assets/galery/default-image.png') }}');
            $('#delete-foto').removeClass('close');
            $("#image").val("")
        }

        function defaultSertifikat() {
            $('#doc-preview').attr('src', '{{ asset('assets/document/default-sertifikat.pdf') }}');
            $('#delete-sertifikat').removeClass('close');
            $("#document").val("")
        }

        $('.delete-button').on('click', function() {
            var id = $(this).closest('.img-wrap').find('img').data('id');
            if (!id) {
                id = "Sertifikat"
            } else {
                id = "Gambar"
            }
            swal.fire({
                title: 'Hapus ' + id + ' Tanah?',
                // html: '',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                console.log(result)
                if (result.isConfirmed) {
                    (id == 'Gambar') ? defaultFoto(): defaultSertifikat();
                };
            });

        });

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
        $("#document").change(function() {
            var ext = $('#document').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['pdf']) == -1) {
                swal.fire({
                    title: 'Error',
                    html: 'File Sertifikat harus berupa PDF',
                    icon: 'warning',
                });
                $("#document").val("")
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



        map.on('pm:create', (e) => {
            var layer = e.layer,
                shape = e.shape,
                nf = Intl.NumberFormat();
            // console.log(layer)
            if (shape === 'Polygon') {
                // getGeomanDrawLayers(layer);
                var extract = layer.toGeoJSON().geometry
                var geo = layer.toGeoJSON();
                var polygon = new L
                    .geoJson(geo);
                console.log(layer);
                console.log(polygon);
                point = L.marker(
                    polygon
                    .getBounds()
                    .getCenter()
                );
                var polygon = JSON.stringify(extract);
                // console.log(point)
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
            $('#lat').val('')
            $('#lng').val('')
        })
    </script>
@stop
