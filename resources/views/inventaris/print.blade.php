@extends('adminlte::master_print')

@section('title')
    {{ isset($inventaris) ? $inventaris->nama : 'Tambah Inventaris' }}
@stop

@section('content_header')
    <div class="mt-2"></div>
@stop

@section('body')
    {{-- @include('contents.inventaris_kib_a_edit_content') --}}
    {{-- @import url("another_file.css"); --}}
    {{-- content --}}
    <section class="content mt-5">
        <div class="container">
            <h6 class="d-flex justify-content-center" style="font-size: 24px !important">
                {{ $inventaris->nama . ' - ' . $inventaris->master_barang->nama_barang }}
            </h6>
            <div class="row mt-4">
                <div class="col-8 border">
                    <div class="mt-2 mb-2" id="map" style="min-height: 500px; height:78vh ;max-height: 1000px"></div>
                </div>
                <div class="col-4 border">
                    {{-- <table class="table table-border mt-1">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('assets/logo-image/blitar.png') }}" alt="" width="60"
                                            height="70">
                                    </div>
                                </td>
                                <td>
                                    <h6 class="d-flex justify-content-center" style="font-size: 12px !important">DINAS
                                        PENDAPATAN KEUANGAN
                                        DAN ASET
                                        DAERAH</h6>
                                    <h6 class="d-flex justify-content-center" style="font-size: 10px !important">Kota Blitar
                                    </h6>
                                    <h6 class="d-flex justify-content-center" style="font-size: 10px !important">Alamat :
                                        Jl. Merdeka Kota
                                        Blitar</h6>
                                </td>
                            </tr>
                        </tbody>
                    </table> --}}

                    <div class="row mt-2 ">
                        <div class="col-3 mt-2 mb-2">
                            <div class="d-flex justify-content-center ms-1">
                                <img src="{{ asset('assets/logo-image/blitar.png') }}" alt="" width="55" height="70">
                            </div>
                        </div>
                        <div class="col-9 mt-2 mb-2">
                            <h6 class="d-flex justify-content-center fw-bold" style="font-size: 10px !important">DINAS
                                PENDAPATAN KEUANGAN DAN ASET DAERAH
                            </h6>
                            <h6 class="d-flex justify-content-center" style="font-size: 10px !important">Kota Blitar
                            </h6>
                            <h6 class="d-flex justify-content-center" style="font-size: 10px !important">Alamat :
                                Jl. Merdeka Kota
                                Blitar</h6>
                        </div>
                    </div>
                    <hr>

                    <table class="table table-sm mt-2" style="font-size: 10px !important">
                        <tr>
                            <td>
                                OPD Pengelola
                            </td>
                            <td>
                                {{ isset($inventaris->master_skpd->nama_skpd) ? $inventaris->master_skpd->nama_skpd : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kategori
                            </td>
                            <td>
                                {{ isset($inventaris->master_barang->nama_barang) ? $inventaris->master_barang->nama_barang : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nama Inventaris
                            </td>
                            <td>
                                {{ isset($inventaris->nama) ? $inventaris->nama : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kode Inventaris
                            </td>
                            <td>
                                {{ isset($inventaris->master_barang) && isset($inventaris->no_register)? $inventaris->master_barang->kode_barang . ' / ' . $inventaris->no_register: '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Tahun Perolehan
                            </td>
                            <td>
                                {{ isset($inventaris->tahun_perolehan) ? $inventaris->tahun_perolehan : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nilai Aset
                            </td>
                            <td>
                                {{ isset($inventaris->nilai_aset) ? $inventaris->nilai_aset : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kelurahan / Kecamatan
                            </td>
                            <td>
                                {{ isset($inventaris->kelurahan->nama_kelurahan) && isset($inventaris->kecamatan->nama_kecamatan)? $inventaris->kelurahan->nama_kelurahan . ' / ' . $inventaris->kecamatan->nama_kecamatan: '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Alamat
                            </td>
                            <td>
                                {{ isset($inventaris->alamat) ? $inventaris->alamat : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Koordinat
                            </td>
                            <td>
                                {{ isset($inventaris->geometry) ? $inventaris->geometry->lat . ' , ' . $inventaris->geometry->lng : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Luas Tanah
                            </td>
                            <td>
                                {{ isset($inventaris->luas) ? $inventaris->luas : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                No Sertifikat
                            </td>
                            <td>
                                {{ isset($inventaris->no_dokumen_sertifikat) ? $inventaris->no_dokumen_sertifikat : '' }}
                                <input type="hidden" id="polygon"
                                    value="{{ isset($inventaris->geometry) ? $inventaris->geometry->polygon : '' }}">
                            </td>
                        </tr>
                    </table>
                    <div class="row mt-5">
                        <div class="col-6">
                            <div class="visible-print text-center" style="font-size: 10px !important">
                                @if (isset($inventaris->document))
                                    {!! QrCode::size(75)->generate(asset('assets/document/' . $inventaris->document->doc_path)) !!}
                                @else
                                    {!! QrCode::size(75)->generate(asset('assets/document/default-sertifikat.pdf')) !!}
                                @endif
                                <p class="mt-2">Scan barcode untuk melihat Sertifikat</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="visible-print text-center" style="font-size: 10px !important">
                                @if (isset($inventaris->galery))
                                    {!! QrCode::size(75)->generate(asset('assets/galery/' . $inventaris->galery->image_path)) !!}
                                @else
                                    {!! QrCode::size(75)->generate(asset('assets/galery/default-image.png')) !!}
                                @endif
                                <p class="mt-2">Scan barcode untuk melihat Foto Aset</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
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





        var map = L.map('map', {
            zoomControl: false,
            contextmenu: false,
        }).setView([-8.098244, 112.165077], 13);
        var esri = L.tileLayer.provider('Esri.WorldImagery', {
            maxZoom: 19
        }).addTo(map)


        var geometry = $('#polygon').val();
        // var layer;
        console.log(geometry)
        if (geometry) {

            var geo = JSON.parse(geometry);
            var poly = new L
                .geoJson(geo);
            console.log(geo);


            poly.addTo(
                map);
            var bound = poly
                .getBounds();
            map.fitBounds(
                bound);


        }
    </script>
@stop
