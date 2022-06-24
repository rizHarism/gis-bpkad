<?php use SimpleSoftwareIO\QrCode\Facades\QrCode;
?>
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
    {{ dd($kib, $inventaris) }}
    <section class="content mt-5">
        <div class="container-fluid">
            <h6 class="d-flex justify-content-center" style="font-size: 24px !important">
                {{ $inventaris->nama . ' - ' . $inventaris->master_barang->nama_barang }}
            </h6>
            <div class="row mt-4">
                <div class="col-8 border">
                    <div class="mt-2 mb-2" id="map" style="min-height: 500px; height:78vh ;max-height: 1000px"></div>
                </div>
                <div class="col-4 border">

                    <div class="row mt-2 mb-0">
                        <div class="col-3 mt-2 mb-2">
                            <div class="d-flex justify-content-center ms-1">
                                <img src="{{ asset('assets/logo-image/blitar.png') }}" alt="" width="55"
                                    height="70">
                            </div>
                        </div>
                        <div class="col-9 mt-2 mb-2">
                            <h6 class="d-flex justify-content-center fw-bold" style="font-size: 10px !important">PEMERINTAH
                                KOTA BLITAR
                                <h6 class="d-flex justify-content-center fw-bold" style="font-size: 10px !important">BADAN
                                    PENDAPATAN KEUANGAN DAN ASET DAERAH
                                </h6>
                            </h6>
                            <hr class="mt-0 mb-0">
                            <h6 class="d-flex justify-content-center mb-0 mt-1" style="font-size: 10px !important">
                                Jl. Merdeka No.105 Kota Blitar</h6>
                            <h6 class="d-flex justify-content-center mt-0" style="font-size: 10px !important">
                                0342-801919</h6>
                        </div>
                    </div>
                    {{-- <hr class="mt-0"> --}}

                    <table class="table table-sm mt-0" style="font-size: 10px !important">
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
                                Kategori Inventaris
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
                                {{ isset($inventaris->master_barang) && isset($inventaris->no_register) ? $inventaris->master_barang->kode_barang . ' / ' . $inventaris->no_register : '' }}

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
                                {{ isset($inventaris->nilai_aset) ? 'Rp. ' . number_format($inventaris->nilai_aset, 2, ',', '.') : '' }}

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kelurahan / Kecamatan
                            </td>
                            <td>
                                {{ isset($inventaris->kelurahan->nama_kelurahan) && isset($inventaris->kecamatan->nama_kecamatan) ? $inventaris->kelurahan->nama_kelurahan . ' / ' . $inventaris->kecamatan->nama_kecamatan : '' }}

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
                                {{ isset($inventaris->luas) ? number_format($inventaris->luas, 0, ',', '.') . ' Meter Persegi' : '' }}
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
                    <div class="row mt-3">
                        <div class="col-6 border">
                            <div class="visible-print text-center" style="font-size: 10px !important">
                                <p class="mt-2">QR Sertifikat</p>
                                @if (isset($inventaris->document))
                                    {!! QrCode::size(75)->generate(asset('assets/document/' . $inventaris->document->doc_path)) !!}
                                    <p class="mt-2">Scan barcode untuk melihat Sertifikat</p>
                                @else
                                    <p class="mt-0" style="font-size: 60px">X</p>
                                    <p style="font-size: 12px">Sertifikat Aset Belum Tersedia</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-6 border">
                            <div class="visible-print text-center" style="font-size: 10px !important">
                                <p class="mt-2">QR Foto</p>
                                @if (isset($inventaris->galery))
                                    {!! QrCode::size(75)->generate(asset('assets/galery/' . $inventaris->galery->image_path)) !!}
                                    <p class="mt-2">Scan barcode untuk melihat Foto Aset</p>
                                @else
                                    <p class="mt-0" style="font-size: 60px">X</p>
                                    <p style="font-size: 12px">Gambar Aset Belum Tersedia</p>
                                @endif
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
            var map = L.map('map', {
                zoomControl: false,
                contextmenu: false,
            }).setView([-8.098244, 112.165077], 13);
            var esri = L.tileLayer.provider('Esri.WorldImagery', {
                maxZoom: 18
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
            setTimeout(function() {
                window.print();
            }, 1500);

            window.onafterprint = function() {
                window.close()
            };
        });
    </script>
@stop
