@extends('adminlte::master')

@section('title', 'Peta Sebaran Aset')

@section('content_header')
    {{-- <h1>Dashboard</h1> --}}
@stop

@section('body')
    @include('layouts.navbar_maps')

    <div id="maps"></div>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/leaflet/core/leaflet-src.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Layers.Minimap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/Control.MiniMap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Basemaps.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.BetterScale.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/styledLayerControl.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-geoman.min.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.contextmenu.js') }}"> </script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-sidebar.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-search.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.responsive.popup.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Layers.Tree.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    {{-- <script src="{{ asset('assets/inventaris/maps.js') }}"></script> --}}

    <script>
        $(document).ready(function() {

            $(document).on({
                ajaxStart: function() {
                    $("body").addClass("loading");
                },
                ajaxStop: function() {
                    $("body").removeClass("loading");
                }
            });

            var api = '/api/inventaris'

            $('#inventarisSearch').keyup(function() {
                var query = $(this).val();
                if (query != '') {
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('autocomplete.fetch') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: _token
                        },
                        success: function(data) {
                            $('#inventarisList').fadeIn();
                            $('#inventarisList').html(data);
                            // alert(data)
                        }
                    });
                } else if (query === '') {
                    $('#inventarisList').empty();
                }
            });

            $(document).on('click', 'li', function() {
                $('#inventarisSearch').val($(this).text());
                var q = $(this).val()
                console.log(q)
                if (q !== 0) {
                    map.eachLayer(function(lay) {
                        if (lay.toGeoJSON) {
                            map.removeLayer(lay);
                        }
                    });
                    map.addLayer(batasKepanjenkidul);
                    map.addLayer(batasSukorejo);
                    map.addLayer(batasSananwetan);

                    $.ajax({
                        // async: false,
                        url: '/api/inventaris/' + q,
                        type: 'GET',
                        dataType: 'json',
                        success: function(json) {
                            console.log(json)
                            const x = json.data
                            $.each(x, (i, property) => {
                                console.log(property.geometry.polygon)
                                var polygon = JSON.parse(property.geometry.polygon)
                                var layer = L.geoJSON(polygon, {
                                        style: sertifikatStyle
                                    })
                                    .addTo(map)

                                var minilayer = L.geoJSON(polygon, {
                                    style: sertifikatStyle
                                })

                                map.fitBounds(layer.getBounds())

                                var lat = property.geometry.lat
                                var lng = property.geometry.lng

                                layer.on('click', function() {
                                    const sertifikat = (property
                                            .status == 1) ?
                                        "Bersertifikat" :
                                        "Belum Bersertifikat";
                                    const hb = property
                                        .nilai_aset,
                                        na = property
                                        .nilai_aset,
                                        lt = property
                                        .luas,
                                        ns = property
                                        .nilai_aset
                                    if (!property.document) {
                                        Sertifikat =
                                            `<div>
                                            <iframe src="assets/document/default-sertifikat.pdf" style="width: 100%;height: 70vh; position: relative;"></iframe>
                                            </div>`
                                    } else {
                                        Sertifikat =
                                            `<iframe src="assets/document/` +
                                            property
                                            .document.doc_path +
                                            `" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                    }
                                    $('#sertifikat').empty()
                                    $('#sertifikat').append(Sertifikat)
                                    $('#detailTitle').empty()
                                    $('#detailData').empty()
                                    $('#detailTitle').append(
                                        property.master_skpd
                                        .nama_skpd + " / " +
                                        property.nama)
                                    $('#detailData').append(`
                                                <table class="table table-sm table-striped">
                                                <tr>
                                                  <th>Pemilik Inventaris </th>
                                                  <td>` + property.master_skpd.nama_skpd + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kategori Inventaris </th>
                                                  <td>` + property.master_barang.nama_barang + `</td>
                                                </tr>
                                                  <th>Nama Inventaris </th>
                                                  <td>` + property.nama + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kode Inventaris </th>
                                                  <td>` + property.master_barang.kode_barang + "/" + property
                                        .no_register + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Tahun Perolehan</th>
                                                  <td>` + property.tahun_perolehan + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Nilai Aset </th>
                                                  <td>` + `Rp ` + rupiah(na) + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Alamat </th>
                                                  <td>` + property.alamat + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kelurahan </th>
                                                  <td>` + property.kelurahan.nama_kelurahan + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kecamatan </th>
                                                  <td>` + property.kecamatan.nama_kecamatan + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Koordinat </th>
                                                  <td>` + lat + ` / ` + lng + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Luas Tanah </th>
                                                  <td>` + rupiah(lt) + ` Meter Persegi` + `</td>
                                                </tr>
                                                <tr>
                                                  <th>No Sertifikat </th>
                                                  <td>` + property.no_dokumen_sertifikat + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Status </th>
                                                  <td>` + sertifikat + `</td>
                                                </tr>
                                            </table>
                                                `);
                                    if (!property.galery) {
                                        image =
                                            `<img class="img-fluid" src="assets/galery/default-image.png"></img>`
                                    } else {
                                        image =
                                            `<img class="img-fluid" src="assets/galery/` +
                                            property.galery.image_path +
                                            `"></img>`
                                    }
                                    var content = image +
                                        `<p class="text-center fw-bold m-2 p-0 h7">` +
                                        property
                                        .nama + `</p>
                                                <table class="table table-striped">
                                                <tr>
                                                    <th>Pengelola</th>
                                                    <td>` + property.master_skpd.nama_skpd + `</td>
                                                </tr>

                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>` + property.alamat +
                                        `</td>
                                                </tr>
                                                </table>
                                                <table class="table table-striped">
                                                <tr>
                                                    <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                        property.id +
                                        `)">Print</a></td>
                                                    <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                        property.id + `">Detail</a></td>
                                                </tr>
                                                </table>
                                                <div style="text-align:center">`

                                    var popup = L
                                        .popup()
                                        .setContent(
                                            content)

                                    layer.bindPopup(popup)
                                        .openPopup();

                                    $('#detailModal').on('shown.bs.modal',
                                        function() {
                                            console.log('sasa')
                                            setTimeout(function() {
                                                minimap
                                                    .invalidateSize();

                                                minilayer.addTo(
                                                    minimap);
                                                minimap.fitBounds(
                                                    minilayer
                                                    .getBounds()
                                                );

                                            }, 500);
                                        });
                                });

                            })
                            // callResponse(x);
                        }
                    });
                    $('#inventarisList').fadeOut();
                }
            });

        });

        function rupiah(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1.$2");
            return x;
        }


        var map = L.map('maps', {
            zoomControl: false,
            contextmenu: false,
            contextmenuWidth: 140,
            contextmenuItems: [{
                text: 'Show coordinates',
                callback: showCoordinates
            }, {
                text: 'Center map here',
                callback: centerMap
            }, '-', {
                text: 'Zoom in',
                icon: 'images/zoom-in.png',
                callback: zoomIn
            }, {
                text: 'Zoom out',
                icon: 'images/zoom-out.png',
                callback: zoomOut
            }]
        }).setView([-8.098244, 112.165077], 13);

        var minimap = L.map('minimap', {
            zoomControl: false,
            contextmenu: false,
        }).setView([-8.098244, 112.165077], 13);

        var miniesri = L.tileLayer.provider('Esri.WorldImagery', {
            maxZoom: 19
        }).addTo(minimap);



        var osm = L.tileLayer.provider('OpenStreetMap.Mapnik', {
            maxZoom: 19
        });
        var esri = L.tileLayer.provider('Esri.WorldImagery', {
            maxZoom: 19
        }).addTo(map);



        // var basemaps = [esri, osm]
        var basemaps = {
            label: 'Peta Base',
            children: [{
                    label: 'Satelit',
                    layer: esri
                },
                {
                    label: 'OpenStreetMap',
                    layer: osm
                },
            ]
        }

        // L.PM.setOptIn(true);



        // L.control.basemaps({
        //     basemaps: basemaps,
        //     position: "bottomright"
        // }).addTo(map);

        var batasKota = {
            "color": "#ffe312",
            "weight": 2,
            "opacity": 1
        };

        var batasSananwetan = new L.GeoJSON.AJAX('assets/leaflet/geojson/batas_sananwetan.json', {
            style: batasKota,
            pmIgnore: true
        });
        var batasKepanjenkidul = new L.GeoJSON.AJAX('assets/leaflet/geojson/batas_kepanjenkidul.json', {
            style: batasKota,
            pmIgnore: true
        });
        var batasSukorejo = new L.GeoJSON.AJAX('assets/leaflet/geojson/batas_sukorejo.json', {
            style: batasKota,
            pmIgnore: true
        });
        batasSananwetan.addTo(map)
        batasKepanjenkidul.addTo(map)
        batasSukorejo.addTo(map)

        var p1 = new L.GeoJSON(null);
        var p2 = new L.GeoJSON(null);
        var p3 = new L.GeoJSON(null);
        var p4 = new L.GeoJSON(null);




        var sertifikatStyle = {
            "color": "#ff7700",
            "weight": 5,
            "opacity": 1
        };
        var nonSertifikatStyle = {
            "color": "#ff7700",
            "weight": 1,
            "opacity": 1
        };

        function getAsetSertifikat(kecamatan) {
            $.ajax({
                url: '/api/' + kecamatan + '/getgeometry',
                dataType: "json",
                async: false,
                success: function(result) {

                    let inv = result.data
                    $.each(inv, (i, property) => {
                        var id = property.id
                        var geo = property.geometry.polygon
                        var lat = property.geometry.lat
                        var lng = property.geometry.lng

                        var status = property.status
                        if (status == 1) {
                            var x = JSON.parse(geo)
                            // var lat = JSON.parse(geo.lat)
                            // var lng = JSON.parse(geo.lng)
                            console.log(lat)
                            var layer = L.geoJSON(x, {
                                style: sertifikatStyle
                            })
                            layer.addTo(map)
                            layer.on('click', function() {

                                const sertifikat = (property
                                        .status == 1) ?
                                    "Bersertifikat" :
                                    "Belum Bersertifikat";
                                const hb = property
                                    .nilai_aset,
                                    na = property
                                    .nilai_aset,
                                    lt = property
                                    .luas,
                                    ns = property
                                    .nilai_aset
                                if (!property.document) {
                                    Sertifikat =
                                        `<iframe src="assets/document/default-sertifikat.pdf" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                } else {
                                    Sertifikat = `<iframe src="assets/document/` +
                                        property
                                        .document.doc_path +
                                        `" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                }
                                $('#sertifikat').empty()
                                $('#sertifikat').append(Sertifikat)
                                $('#detailTitle').empty()
                                $('#detailData').empty()
                                $('#detailTitle').append(
                                    property.master_skpd
                                    .nama_skpd + " / " + property
                                    .nama)
                                $('#detailData').append(`
                                                    <table class="table table-sm table-striped">
                                                    <tr>
                                                      <th>Pemilik Inventaris </th>
                                                      <td>` + property.master_skpd.nama_skpd + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Nama Inventaris </th>
                                                      <td>` + property.nama + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Kode Inventaris </th>
                                                      <td>` + property.master_barang.kode_barang + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Tahun Perolehan</th>
                                                      <td>` + property.tahun_perolehan + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Nilai Aset </th>
                                                      <td>` + `Rp ` + rupiah(na) + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Alamat </th>
                                                      <td>` + property.alamat + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Kelurahan </th>
                                                      <td>` + property.kelurahan.nama_kelurahan + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Kecamatan </th>
                                                      <td>` + property.kecamatan.nama_kecamatan + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Latitude / longitude </th>
                                                      <td>` + lat + ` / ` + lng + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>Luas Tanah </th>
                                                      <td>` + lt + ` Meter Persegi` + `</td>
                                                    </tr>
                                                    <tr>
                                                      <th>No Sertifikat </th>
                                                      <td>` + property.no_dokumen_sertifikat + `</td>
                                                    </tr>

                                                    <tr>
                                                      <th>Status </th>
                                                      <td>` + sertifikat + `</td>
                                                    </tr>
                                                </table>
                                                    `);
                                if (!property.galery) {
                                    image =
                                        `<img class="img-fluid" src="assets/galery/default-image.png"></img>`
                                } else {
                                    image =
                                        `<img class="img-fluid" src="assets/galery/` +
                                        property.galery.image_path +
                                        `"></img>`
                                }

                                var content = image +
                                    `<p class="text-center fw-bold m-2 p-0 h7">` +
                                    property
                                    .nama + `</p><table class="table table-striped">
                                                    <tr>
                                                        <th>Pengelola</th>
                                                        <td>` + property.master_skpd.nama_skpd + `</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Alamat</th>
                                                        <td>` + property.alamat +
                                    `</td>
                                                    </tr>
                                                    </table>
                                                    <table class="table table-striped">
                                                <tr>
                                                    <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                    property.id +
                                    `)">Print</a></td>
                                                    <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                    property.id + `">Detail</a></td>
                                                </tr>
                                                </table>
                                                <div style="text-align:center">`

                                var popup = L.popup()
                                    .setContent(
                                        content)

                                layer.bindPopup(popup)
                                    .openPopup();
                            });

                            map.on('overlayremove', function(eventLayer) {
                                if (eventLayer.name === "5") {
                                    map.removeLayer(layer)
                                }
                                if (eventLayer.name === "4") {
                                    map.removeLayer(layer)
                                }
                                if (eventLayer.name === "3") {
                                    map.removeLayer(layer)
                                }
                            });
                        }
                    })
                }
            })

        };



        function getAsetNonSertifikat() {
            $.ajax({

                url: '/api/inventaris',
                dataType: "json",
                async: false,
                success: function(result) {

                    let inv = result.data
                    $.each(inv, (i, property) => {
                        var id = property.id
                        var geo = property.geometry
                        var status = property.status
                        if (geo !== null && status == 0) {
                            b
                            var x = JSON.parse(geo)
                            x.properties["id"] = id
                            var layer = L.geoJSON(x, {
                                style: nonSertifikatStyle
                            })
                            layer.addTo(map)
                            layer.on('click', function() {
                                function callDetail() {
                                    $('#detailModal').modal('show');
                                    $('#detailTitle').empty("")
                                    $('#detailData').empty()

                                    $.ajax({
                                        url: '/api/inventaris/' + id,
                                        dataType: "json",
                                        async: false,
                                        success: function(result) {
                                            let inv = result.data
                                            $.each(inv, (i, property) => {

                                                const sertifikat = (
                                                        property
                                                        .status == 1) ?
                                                    "Bersertifikat" :
                                                    "Belum Bersertifikat";
                                                const hb = property
                                                    .nilai_aset,
                                                    na = property
                                                    .nilai_aset,
                                                    lt = property
                                                    .luas,
                                                    ns = property
                                                    .nilai_aset

                                                $('#detailTitle')
                                                    .append(
                                                        'Aset Milik' +
                                                        ' ' +
                                                        property
                                                        .master_skpd
                                                        .nama_skpd)
                                                $('#detailData').append(`
                                        <table class="table table-sm table-striped">
                                        <tr>
                                          <th>Pemilik Inventaris </th>
                                          <td>` + property.master_skpd.nama_skpd + `</td>
                                        </tr>
                                        <tr>
                                          <th>Nama Inventaris </th>
                                          <td>` + property.nama + `</td>
                                        </tr>
                                        <tr>
                                          <th>Kode Inventaris </th>
                                          <td>` + property.master_barang.kode_barang + `</td>
                                        </tr>
                                        <tr>
                                          <th>Tahun Perolehan</th>
                                          <td>` + property.tahun_perolehan + `</td>
                                        </tr>
                                        <tr>
                                          <th>Harga Beli </th>
                                          <td>` + `Rp ` + rupiah(hb) + `</td>
                                        </tr>
                                        <tr>
                                          <th>Nilai Aset </th>
                                          <td>` + `Rp ` + rupiah(na) + `</td>
                                        </tr>
                                        <tr>
                                          <th>Alamat </th>
                                          <td>` + property.alamat + `</td>
                                        </tr>
                                        <tr>
                                          <th>Luas Tanah </th>
                                          <td>` + lt + ` Meter Persegi` + `</td>
                                        </tr>
                                        <tr>
                                          <th>No Sertifikat </th>
                                          <td>` + property.no_dokumen_sertifikat + `</td>
                                        </tr>
                                        <tr>
                                          <th>Status </th>
                                          <td>` + sertifikat + `</td>
                                        </tr>
                                        <tr>
                                          <th>Nilai Saat Ini </th>
                                          <td>` + `Rp ` + rupiah(ns) + `</td>
                                        </tr>
                                    </table>
                                        `);
                                            })
                                        }
                                    })
                                }
                                callDetail()
                            });
                            map.on('overlayremove', function(eventLayer) {
                                if (eventLayer.name === " Tanah Non Sertifikat") {
                                    map.removeLayer(layer)
                                }
                            });
                        }
                    })
                }
            })

        };

        // map.on('overlayadd', function(eventLayer) {
        //     if (eventLayer.name === "5") {
        //         getAsetSertifikat(3);
        //     }
        //     if (eventLayer.name === "4") {
        //         getAsetSertifikat(2);
        //     }
        //     if (eventLayer.name === "3") {
        //         getAsetSertifikat(1);
        //     }
        //     if (eventLayer.name === "Tanah Non Sertifikat") {
        //         getAsetNonSertifikat();
        //     }
        // });

        // control.addTo(map)
        L.control.betterscale().addTo(map);


        map.on('pm:create', (e) => {
            var layer = e.layer,
                shape = e.shape,
                nf = Intl.NumberFormat();


            // console.log(shape);
            if (shape === 'Line') {

                var seeArea = turf.length(layer.toGeoJSON());
                console.log(seeArea)
                console.log(layer)
                var meter = seeArea * 1000;
                var kilometer = seeArea;
                console.log(meter)
                console.log(kilometer)
                if (meter < 1000) {
                    layer.bindPopup("Jarak " + nf.format(meter.toFixed(2)) + " Meter");
                } else {
                    layer.bindPopup("Jarak " + nf.format(kilometer.toFixed(2)) + " Kilometer");
                }
                var g = JSON.stringify(layer.toGeoJSON())

            }

            if (shape === 'Circle') {
                // e.radius
                if (e.marker._mRadius < 1000) {
                    layer.bindPopup("Radius " + nf.format(e.marker._mRadius.toFixed(2)) + " Meter");
                } else {
                    layer.bindPopup("Radius " + nf.format((e.marker._mRadius / 1000).toFixed(2)) + " Kilometer");
                }
                var g = JSON.stringify(layer.toGeoJSON())

            }

            console.log(JSON.stringify(layer.toGeoJSON()))
        })
        // membuat control sendiri

        L.Control.Watermark = L.Control.extend({
            onAdd: function(map) {
                var img = L.DomUtil.create('img')
                img.src = 'assets/logo-image/logo-center-bpkad-yellow.png'
                img.style.width = '400px'
                // img.style.margin = '50px'

                return img;
            },

            onRemove: function(map) {
                // Nothing to do here
            }
        });

        L.control.watermark = function(opts) {
            return new L.Control.Watermark(opts);
        }

        L.control.watermark({
            position: 'topleft'
        }).addTo(map);

        L.control.zoom().addTo(map)
        map.pm.addControls({
            drawMarker: false,
            drawCircleMarker: false,
            drawPolyline: true,
            drawRectangle: false,
            drawPolygon: false,
            drawCircle: true,
            cutPolygon: false,
            rotateMode: false,
            editControls: false,
        });


        // context menu

        function showCoordinates(e) {
            alert(e.latlng);
        }

        function centerMap(e) {
            map.panTo(e.latlng);
        }

        function zoomIn(e) {
            map.zoomIn();
        }

        function zoomOut(e) {
            map.zoomOut();
        }

        // sidebar v2
        var sidebar = L.control.sidebarV2('sidebarV2', {
            position: "right"
        }).addTo(map);

        //leaflet search

        function searchByAjax(text, callResponse) //callback for 3rd party ajax requests
        {
            var polygonSearch = null;
            var q = text
            return $.ajax({
                async: false,
                url: '/api/inventaris/' + q +
                    '/search',
                type: 'GET',
                dataType: 'json',
                success: function(json) {
                    const x = json.data
                    $.each(x, (i, property) => {
                        // polygonSearch = property.geometry.polygon;
                        // polygonSearch.addTo(map)
                        // console.log(polygonSearch)
                        property.point = [property.geometry.lat, property.geometry.lng]
                        property['name'] = property.master_skpd.nama_skpd + " - " + property.nama
                    })
                    callResponse(x);
                }
            });
            return polygonSearch;
            console.log(polygonSearch);
            // alert(polygonSearch);
        };

        var searchControl = new L.Control.Search({
            sourceData: searchByAjax,
            // layer: polygonSearch,
            propertyLoc: 'point',
            propertyName: 'name',
            filterData: function(text, records) {
                return (records);
            },
            text: 'Lokasi',
            markerLocation: true,
        })

        // map.addControl(searchControl); //inizialize search control

        //control layer tree overlay

        var overlaysTree = [{
                label: 'Wilayah Administrasi',
                // selectAllCheckbox: 'Un/select all',
                children: [{
                    label: 'Kota Blitar',
                    selectAllCheckbox: true,
                    children: [{
                        label: 'Sananwetan',
                        layer: batasSananwetan
                    }, {
                        label: 'Kepanjen Kidul',
                        // selectAllCheckbox: true,
                        layer: batasKepanjenkidul
                    }, {
                        label: 'Sukorejo',
                        // selectAllCheckbox: 'De/seleccionar todo',
                        layer: batasSukorejo
                    }]
                }]
            },
            // { label: ' ' },
            // {
            //     label: '-----------------------------------------------------------'
            // },
            // // { label: '<hr class="solid">' },
            // {
            //     label: 'Aset Tanah',
            //     // selectAllCheckbox: 'Un/select all',
            //     children: [{
            //             label: 'Bersertifikat',
            //             selectAllCheckbox: true,
            //             collapsed: true,
            //             children: [{
            //                 label: 'Sananwetan',
            //                 layer: L.marker([52.5162542, 13.3776805])
            //             }, {
            //                 label: 'Kepanjenkidul',
            //                 layer: L.marker([52.5162542, 13.3776805])
            //             }, {
            //                 label: 'Sukorejo',
            //                 layer: L.marker([52.5162542, 13.3776805])
            //             }]
            //         },
            //         {
            //             label: 'Non Sertifikat',
            //             selectAllCheckbox: true,
            //             collapsed: true,
            //             children: [{
            //                 label: 'Sananwetan',
            //                 layer: L.marker([52.5162542, 13.3776805])
            //             }, {
            //                 label: 'Kepanjenkidul',
            //                 layer: L.marker([52.5162542, 13.3776805])
            //             }, {
            //                 label: 'Sukorejo',
            //                 layer: L.marker([52.5162542, 13.3776805])
            //             }]
            //         }
            //     ],


            // }
        ];

        var options = {
            collapsed: false
        }

        var layerControlOverlay = L.control.layers.tree(basemaps, overlaysTree, options = {
            collapsed: false
        }).addTo(map);

        // var layerControlBasemap = L.control.layers.minimap(basemaps = {
        //     esri,
        //     osm
        // }, null, options = {
        //     collapsed: false,
        //     // position: topright
        //     topPadding: 100
        // }).addTo(map);

        var htmlObjectOverlay = layerControlOverlay.getContainer();
        // var htmlObjectBasemap = layerControlBasemap.getContainer();
        var a = document.getElementById('layers');
        // var htmlSearch = search.getContainer();
        // var b = document.getElementById('query');

        function setParentLayer(el, newParent) {
            newParent.appendChild(el);
        }
        // setParentLayer(htmlObjectBasemap, a);
        setParentLayer(htmlObjectOverlay, a);

        // ambil data skpd untuk query pencarian
        function skpd() {

            $.ajax({
                type: "GET",
                url: '/api/skpd',
                dataType: "json",
                success: function(skpdData) {
                    var skpd = skpdData.data,
                        listItems = ""
                    $.each(skpd, (i, property) => {

                        listItems += "<option value='" + property.id_skpd + "'>" + property
                            .nama_skpd +
                            "</option>"
                    })
                    $("#dataSkpd").append(listItems);
                }
            });
        }
        skpd();

        function myPrint(id) {
            window.open('/inventaris/' + id + '/print',
                '',
                'width=1200,height=600');
        }

        function kelurahan() {
            $.ajax({
                type: "GET",
                url: '/api/kelurahan',
                dataType: "json",
                success: function(kelData) {
                    var kelurahan = kelData.data,
                        listItems = ""
                    $.each(kelurahan, (i, property) => {
                        // console.log(property.id_kelurahan)
                        // console.log(property.nama_kelurahan)
                        listItems += "<option value='" + property.id_kelurahan + "'>" + property
                            .nama_kelurahan +
                            "</option>"
                    })
                    $("#data_kelurahan").append(listItems);
                }
            });
        }
        kelurahan();

        $("input[name='varQuery']").change(function() {
            // Do something interesting here
            $('#varChange').empty();

            if ($(this).val() === 'opd') {
                skpd();
                $('#varChange').append(`
                <label for="">Pilih OPD</label>
                <select class="form-select form-control-sm fw-bold" aria-label="Default select example"
                            id="dataSkpd">
                            <option selected>Semua OPD</option>
                        </select>`);
            } else {
                $('#varChange').append(
                    `<label for="">Nomor Sertifikat</label>
                    <input class=" form-control form-control-sm fw-bold noSertifikat" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="noSertifikat"
                            id="noSertifikat" maxlength="5" placeholder="masukkan 5 digit terakhir sertifikat" required>`
                );
            };

        });

        // query pencarian
        $("#queryGeom").on('submit', function(e) {

            // $(document).on({
            //     ajaxStart: function() {
            //         $("body").addClass("loading");
            //     },
            //     ajaxStop: function() {
            //         $("body").removeClass("loading");
            //     }


            // console.log(e)

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var search = $('input[name="varQuery"]:checked').val();
            // var status = $('input[name="status"]:checked').val();
            var status = 1;
            var kelurahan = $('#data_kelurahan').val();
            var skpd = $('#dataSkpd').val();
            var sertifikat = $('#noSertifikat').val();
            var urlSkpd = "api/inventaris/" + status + "/" + kelurahan + "/" + skpd + "/queryskpd"
            if (!sertifikat) {
                var urlSertifikat = "api/inventaris/" + status + "/" + kelurahan + "/0/querysertifikat"
            } else {
                var urlSertifikat = "api/inventaris/" + status + "/" + kelurahan + "/" + sertifikat +
                    "/querysertifikat"
            }
            // console.log(urlSertifikat)

            // console.log(search, status, skpd, kelurahan)
            // console.log(urlSkpd)

            map.eachLayer(function(lay) {
                if (lay.toGeoJSON) {
                    map.removeLayer(lay);
                }

            });

            map.addLayer(batasKepanjenkidul);
            map.addLayer(batasSukorejo);
            map.addLayer(batasSananwetan);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                type: "POST",
                url: (search == 'opd') ? urlSkpd : urlSertifikat,
                dataType: "json",
                success: function(q) {
                    // if q =
                    var geom = q.data
                    console.log(geom.length)
                    var layerAll = L.featureGroup();
                    var pointAll = L.featureGroup();
                    // console.log(geom.data)
                    if (geom === 0) {
                        swal.fire(
                            'Data tidak ditemukan',
                            'Data yang anda kirimkan tidak valid',
                            'warning'
                        );
                    } else if (geom.length === 0) {
                        swal.fire(
                            'Data tidak ditemukan',
                            'Data yang anda kirimkan tidak valid',
                            'warning'
                        );
                    } else {

                        $.each(geom, (i, property) => {

                            var id = property.id
                            var geo = property.geometry.polygon
                            var lat = property.geometry.lat
                            var lng = property.geometry.lng

                            function myPrint() {
                                window.open('/inventaris/' + id + '/print',
                                    '',
                                    'width=1200,height=600');
                            }

                            x = JSON.parse(geo)
                            console.log(x)
                            var layer = L.geoJSON(x, {
                                style: sertifikatStyle,
                                // className: 'blinking'
                            });
                            var minilayer = L.geoJSON(x, {
                                style: sertifikatStyle,
                                // className: 'blinking'
                            });

                            layer.addTo(layerAll);

                            layer.on('click', function() {
                                const sertifikat = (property
                                        .status == 1) ?
                                    "Bersertifikat" :
                                    "Belum Bersertifikat";
                                const hb = property
                                    .nilai_aset,
                                    na = property
                                    .nilai_aset,
                                    lt = property
                                    .luas,
                                    ns = property
                                    .nilai_aset
                                if (!property.document) {
                                    Sertifikat =
                                        `<iframe src="assets/document/default-sertifikat.pdf" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                } else {
                                    Sertifikat = `<iframe src="assets/document/` +
                                        property
                                        .document.doc_path +
                                        `" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                }
                                $('#sertifikat').empty()
                                $('#sertifikat').append(Sertifikat)
                                $('#detailTitle').empty()
                                $('#detailData').empty()
                                $('#detailTitle').append(
                                    property.master_skpd
                                    .nama_skpd + " / " +
                                    property.nama)
                                $('#detailData').append(`
                                                <table class="table table-sm table-striped">
                                                <tr>
                                                  <th>Pemilik Inventaris </th>
                                                  <td>` + property.master_skpd.nama_skpd + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kategori Inventaris </th>
                                                  <td>` + property.master_barang.nama_barang + `</td>
                                                </tr>
                                                  <th>Nama Inventaris </th>
                                                  <td>` + property.nama + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kode Inventaris </th>
                                                  <td>` + property.master_barang.kode_barang + "/" + property
                                    .no_register + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Tahun Perolehan</th>
                                                  <td>` + property.tahun_perolehan + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Nilai Aset </th>
                                                  <td>` + `Rp ` + rupiah(na) + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Alamat </th>
                                                  <td>` + property.alamat + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kelurahan </th>
                                                  <td>` + property.kelurahan.nama_kelurahan + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Kecamatan </th>
                                                  <td>` + property.kecamatan.nama_kecamatan + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Koordinat </th>
                                                  <td>` + lat + ` / ` + lng + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Luas Tanah </th>
                                                  <td>` + rupiah(lt) + ` Meter Persegi` + `</td>
                                                </tr>
                                                <tr>
                                                  <th>No Sertifikat </th>
                                                  <td>` + property.no_dokumen_sertifikat + `</td>
                                                </tr>
                                                <tr>
                                                  <th>Status </th>
                                                  <td>` + sertifikat + `</td>
                                                </tr>
                                            </table>
                                                `);
                                if (!property.galery) {
                                    image =
                                        `<img class="img-fluid" src="assets/galery/default-image.png"></img>`
                                } else {
                                    image =
                                        `<img class="img-fluid" src="assets/galery/` +
                                        property.galery.image_path + `"></img>`
                                }
                                var content = image +
                                    `<p class="text-center fw-bold m-2 p-0 h7">` +
                                    property
                                    .nama + `</p>
                                                <table class="table table-striped">
                                                <tr>
                                                    <th>Pengelola</th>
                                                    <td>` + property.master_skpd.nama_skpd + `</td>
                                                </tr>

                                                <tr>
                                                    <th>Alamat</th>
                                                    <td>` + property.alamat +
                                    `</td>
                                                </tr>
                                                </table>
                                                <table class="table table-striped">
                                                <tr>
                                                    <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                    property.id +
                                    `)">Print</a></td>
                                                    <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                    property.id + `">Detail</a></td>
                                                </tr>
                                                </table>
                                                <div style="text-align:center">
                                                `


                                var popup = L
                                    .popup()
                                    .setContent(
                                        content)

                                layer.bindPopup(popup)
                                    .openPopup();

                                $('#detailModal').on('shown.bs.modal',
                                    function() {
                                        console.log('shown')
                                        setTimeout(function() {
                                            minimap.invalidateSize();
                                            minilayer.addTo(minimap);
                                            minimap.fitBounds(minilayer
                                                .getBounds());

                                        }, 500);
                                    });
                                $('#detailModal').on('hidden.bs.modal',
                                    function() {
                                        console.log('hidden');
                                        console.log(minilayer)
                                        // minimap.removeLayer(lay);
                                    });

                            });
                        })
                        layerAll.addTo(map);
                        // pointAll.addTo(map);
                        map.fitBounds(layerAll.getBounds());
                        // setInterval(function() {
                        //     map.removeLayer(pointAll);
                        // }, 10520);
                    }
                }
            });

            // menghapus layer yang ada di peta
            $("#clear").on('click', function(e) {
                map.eachLayer(function(lay) {
                    if (lay.toGeoJSON) {
                        map.removeLayer(lay);
                    }

                });

                map.addLayer(batasKepanjenkidul);
                map.addLayer(batasSukorejo);
                map.addLayer(batasSananwetan);
            })

        });
    </script>
@stop
