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
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.contextmenu.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-sidebar.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-search.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.responsive.popup.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Layers.Tree.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.zoomhome.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/inventaris/maps.js') }}"></script> --}}

    <script>
        // change avatar image

        function changeAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#avatar-image').attr('src', e.target.result);
                    $('#avatar-image2').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file-input").change(function() {
            var ext = $('#file-input').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
                // alert('invalid extension!');
                $('#editProfile').hide();
                swal.fire({
                    title: 'Error',
                    html: 'Foto Profile harus berupa Gambar',
                    icon: 'warning',
                }).then(function() {
                    $('#editProfile').show();
                })


                $("#file-input").val("")
            } else {
                changeAvatar(this);
            }

        });

        function defaultAvatar() {
            $('#avatar-image').attr('src', '{{ asset('assets/avatar/' . Auth::user()->avatar) }}');
            $('#avatar-image2').attr('src', '{{ asset('assets/avatar/' . Auth::user()->avatar) }}');
        }

        $(function() {
            $("#editProfile-form").submit(function() {

                // $("#editProfile").toggle()
                $("#editProfile").hide();
                // $("#editProfile").modal('toggle')
                var formData = new FormData;
                // var putMethod = '{{ isset($edit) }}'

                formData.append('username', $("#username").val());
                formData.append('password', $("#password").val());
                formData.append('avatar', $('input[type=file]')[0].files[0]);
                formData.append('_method', 'PUT')
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
                            window.location.reload() // = document.referrer;
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
    </script>

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
                // console.log(q)
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
                            // console.log(json)
                            const x = json.data
                            $.each(x, (i, property) => {
                                // console.log(property.geometry.polygon)
                                var polygon = JSON.parse(property.geometry.polygon)
                                var layer = L.geoJSON(polygon, {
                                        style: sertifikatStyle,
                                        pmIgnore: true
                                    })
                                    .addTo(map)

                                var minilayer = L.geoJSON(polygon, {
                                    style: sertifikatStyle,
                                    pmIgnore: true
                                })

                                map.fitBounds(layer.getBounds())

                                var lat = property.geometry.lat
                                var lng = property.geometry.lng
                                var coordinates = "'" + lat + "," + lng + "'";

                                layer.on('click', function() {
                                    minimap.eachLayer(function(lay) {
                                        if (lay.toGeoJSON) {
                                            minimap.removeLayer(lay);
                                        }

                                    });
                                    var mini = (JSON.parse(property.geometry
                                        .polygon));
                                    minilayer = L.geoJSON(mini, {
                                        style: sertifikatStyle,
                                        pmIgnore: true
                                    });
                                    minilayer.addTo(minimap);

                                    // console.log(minilayer)
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
                                                  <th>Pengelola Inventaris </th>
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
                                                  <td><a href='#' onclick="gMaps(` + coordinates + `)">` + lat +
                                        ` / ` + lng + `</a></td>
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
                                                    <td>` + property.alamat + `</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="text-align:center"> <a href=# onclick="gMaps(` +
                                        coordinates +
                                        `)"> <i class="fas fa-map-marker-alt"></i> Buka di Maps </a></td>
                                                </tr>
                                                </table>
                                                <table class="table table-striped mt-0">
                                                <tr>
                                                    <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                        '\'tanah\'' +
                                        ',' +
                                        property.id +
                                        `)"><i class="fas fa-print"></i> Print</a></td>
                                                    <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                        property.id + `"> <i class="fas fa-info-circle"></i> Detail</a></td>
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
                                            // console.log('sasa')
                                            setTimeout(function() {
                                                minimap
                                                    .invalidateSize();
                                                minimap.fitBounds(
                                                    minilayer
                                                    .getBounds()
                                                );

                                            }, 500);
                                            // console.log(minilayer);
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
            label: 'Peta Dasar',
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


        var batasKota = {
            "color": "#ffe312",
            "weight": 2,
            "opacity": 1
        };

        var batasSananwetan = new L.GeoJSON.AJAX('assets/leaflet/geojson/sananwetan.geojson', {
            style: batasKota,
            pmIgnore: true
        });
        var batasKepanjenkidul = new L.GeoJSON.AJAX('assets/leaflet/geojson/kepanjenkidul.geojson', {
            style: batasKota,
            pmIgnore: true
        });
        var batasSukorejo = new L.GeoJSON.AJAX('assets/leaflet/geojson/sukorejo.geojson', {
            style: batasKota,
            pmIgnore: true
        });
        var asetTanah = new L.GeoJSON.AJAX('/api/getinventarisgedung', {
            style: batasKota,
            pmIgnore: true
        });
        var asetGedung = new L.GeoJSON.AJAX('/api/getinventarisgedung', {
            style: batasKota,
            pmIgnore: true
        });
        batasSananwetan.addTo(map)
        batasKepanjenkidul.addTo(map)
        batasSukorejo.addTo(map)






        var sertifikatStyle = {
            "color": "#ff7700",
            "weight": 2,
            "opacity": 1
        };
        var gedungStyle = {
            "color": "#ff4040",
            "weight": 2,
            "opacity": 1
        };
        var nonSertifikatStyle = {
            "color": "#ff7700",
            "weight": 1,
            "opacity": 1
        };


        L.control.betterscale().addTo(map);


        map.on('pm:create', (e) => {
            var layer = e.layer,
                shape = e.shape,
                nf = Intl.NumberFormat();


            // console.log(shape);
            if (shape === 'Polygon') {

                var seeArea = turf.area(layer.toGeoJSON());
                // console.log(seeArea)
                console.log(JSON.stringify(layer.toGeoJSON()))
                var ha = seeArea / 10000;
                var mPersegi = seeArea;
                // console.log(ha)
                // console.log(mPersegi)
                if (mPersegi > 10000) {
                    layer.bindPopup("Luas " + nf.format(ha.toFixed(2)) + " Ha");
                } else {
                    layer.bindPopup("Luas " + nf.format(mPersegi.toFixed(2)) + " Meter²");
                }
                var g = JSON.stringify(layer.toGeoJSON())

            }

            if (shape === 'Line') {

                var seeArea = turf.length(layer.toGeoJSON());
                // console.log(seeArea)
                // console.log(layer)
                var meter = seeArea * 1000;
                var kilometer = seeArea;
                // console.log(meter)
                // console.log(kilometer)
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

            // console.log(JSON.stringify(layer.toGeoJSON()))
        })
        // membuat control sendiri

        L.Control.Watermark = L.Control.extend({
            onAdd: function(map) {
                var img = L.DomUtil.create('img')
                img.src = 'assets/logo-image/logo-center-bpkad-yellow.png'
                img.style.width = '400px'
                img.class = 'img-fluid'
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

        // L.control.zoom().addTo(map)
        // zoom home
        var zoomHome = L.Control.zoomHome({
            zoomHomeIcon: 'dot-circle',

        });
        zoomHome.addTo(map);

        map.pm.addControls({
            drawMarker: false,
            drawCircleMarker: false,
            drawPolyline: true,
            drawRectangle: false,
            drawPolygon: true,
            drawCircle: true,
            cutPolygon: false,
            rotateMode: false,
            editControls: true,
            dragMode: false,
            editMode: false,
            removalMode: true
        });

        map.pm.setLang('id')


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
                        property.point = [property.geometry.lat, property.geometry.lng]
                        property['name'] = property.master_skpd.nama_skpd + " - " + property.nama
                    })
                    callResponse(x);
                }
            });
            return polygonSearch;
            // console.log(polygonSearch);
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



        //control layer tree overlay

        var overlaysTree = [{
                label: 'Wilayah Administrasi',

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

            {
                label: 'Barang Milik Daerah',

                children: [{
                    label: 'BMD Kota',
                    // selectAllCheckbox: true,
                    children: [{
                        label: 'Aset Tanah',
                        layer: asetTanah
                    }, {
                        label: 'Aset Gedung',
                        layer: asetGedung
                    }]
                }]
            },

        ];
        // memanggil geojson tanah dan bangunan checkbox
        var layerTanahGabungan = L.layerGroup();
        var layerGedungGabungan = L.layerGroup();
        // var layerTanahGabungan = "";
        // var layerGedungGabungan = "";

        map.on('overlayadd', function(eventLayer) {
            console.log(eventLayer.name)
            // layerTanahGabungan.remove()
            if (eventLayer.name === '5') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "POST",
                    url: "/api/inventaris/Semua Kelurahan/Semua OPD/queryskpd",
                    dataType: "json",
                    success: function(q) {
                        // if q =
                        var geom = q.data
                        console.log(geom);
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
                                var kib = 'tanah'
                                var id = property.id
                                var geo = property.geometry.polygon
                                var lat = property.geometry.lat
                                var lng = property.geometry.lng
                                var coordinates = "'" + lat + "," + lng + "'";

                                function myPrint() {
                                    window.open('/inventaris/' + '\'tanah\'' + '/' + id +
                                        '/print',
                                        '',
                                        'width=1200,height=600');
                                }

                                x = JSON.parse(geo)
                                var layer = L.geoJSON(x, {
                                    style: sertifikatStyle,
                                    pmIgnore: true
                                })
                                // .addTo(map);
                                // var minilayer = L.geoJSON(x, {
                                //     style: sertifikatStyle,
                                //     pmIgnore: true
                                // });

                                layer.addTo(layerTanahGabungan);

                                layerTanahGabungan.addTo(map);

                                layer.on('click', function() {
                                    var minilayer = '';
                                    minimap.eachLayer(function(lay) {
                                        if (lay.toGeoJSON) {
                                            minimap.removeLayer(lay);
                                        }

                                    });
                                    var mini = (JSON.parse(property.geometry.polygon));
                                    minilayer = L.geoJSON(mini, {
                                        style: sertifikatStyle,
                                        pmIgnore: true
                                    });
                                    minilayer.addTo(minimap);

                                    // console.log(minilayer)
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
                                                  <th>Pengelola Inventaris </th>
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
                                                  <td><a href='#' onclick="gMaps(` + coordinates + `)">` + lat +
                                        ` / ` + lng + `</a></td>
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
                                    var kib = "tanah";
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
                                                <tr>
                                                    <td colspan="2" style="text-align:center"> <a href=# onclick="gMaps(` +
                                        coordinates +
                                        `)"><i class="fas fa-map-marker-alt"></i> Buka Maps </a></td>
                                                </tr>
                                                </table>
                                                <table class="table table-striped">
                                                <tr>
                                                    <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                        '\'tanah\'' +
                                        ',' +
                                        property.id +
                                        `)"><i class="fas fa-print"></i> Print</a></td>
                                                    <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                        property.id + `"></i><i class="fas fa-info-circle"></i> Detail</a></td>
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

                                            setTimeout(function() {
                                                minimap.invalidateSize();
                                                minimap.fitBounds(minilayer
                                                    .getBounds());
                                            }, 1000);

                                        });
                                });
                            })
                            // layer.addTo(map);
                            // pointAll.addTo(map);
                            // map.fitBounds(layerAll.getBounds());
                            // setInterval(function() {
                            //     map.removeLayer(pointAll);
                            // }, 10520);

                        }
                        // console.log(sertifikatStyle['opacity'] = 0.1)
                    }
                });
            }

            if (eventLayer.name === '6') {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "POST",
                    url: "/api/inventarisgedung/Semua OPD/queryskpdgedung",
                    dataType: "json",
                    success: function(q) {
                        var geom = q.data
                        console.log(geom);
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
                                var geo = property.geometry
                                var lat = property.geometry
                                var lng = property.geometry
                                var layer;
                                var minilayer;
                                $.each(geo, (i, prop) => {
                                    console.log(prop)
                                    console.log(i)
                                    x = JSON.parse(prop.polygon)
                                    var coordinates = "'" + prop.lat + "," + prop.lng +
                                        "'";
                                    layer = L.geoJSON(x, {
                                        style: gedungStyle,
                                        pmIgnore: true
                                    })
                                    minilayer = L.geoJSON(x, {
                                        style: gedungStyle,
                                        pmIgnore: true
                                    });
                                    layer.addTo(layerGedungGabungan);
                                    layer.bindTooltip(property.kode_gedung, {
                                        permanent: false,
                                        direction: "center"
                                    })
                                    layerGedungGabungan.addTo(map)
                                    layer.on('click', function() {
                                        var minilayer = '';
                                        minimap.eachLayer(function(lay) {
                                            if (lay.toGeoJSON) {
                                                minimap.removeLayer(
                                                    lay);
                                            }

                                        });
                                        var mini = (JSON.parse(prop
                                            .polygon));
                                        minilayer = L.geoJSON(mini, {
                                            style: gedungStyle,
                                            pmIgnore: true
                                        });
                                        minilayer.addTo(minimap);


                                        const hb = property
                                            .nilai_aset,
                                            na = property
                                            .nilai_aset,
                                            lt = property
                                            .luas,
                                            ns = property
                                            .nilai_aset
                                        if (!property.document) {
                                            penanda =
                                                // `<iframe src="assets/document/default-sertifikat.pdf" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                                `<img class="img-fluid" src="assets/galery/default-image.png" style="height:30vh;width:100%"></img>`
                                        } else {
                                            penanda =
                                                `<img class="img-fluid" src="assets/document/` +
                                                property
                                                .document.doc_path +
                                                `" style="height:30vh;width:100%">`
                                        }
                                        if (!property.galery) {
                                            image =
                                                `<img src="assets/galery/default-image.png" style="height:30vh;width:100%"></img>`
                                        } else {
                                            image =
                                                `<img class="img-fluid" src="assets/galery/` +
                                                property.galery.image_path +
                                                `" style="height:30vh;width:100%"></img>`
                                        }
                                        $('#sertifikat').empty()
                                        if (property.pemeliharaan.length == 0) {
                                            pemeliharaan = ""
                                        } else {
                                            pemeliharaan = `
                                        <div class="container" style="display:block; overflow-x: auto; height:25vh" >
                                            <table id="pemeliharaan" class="table table-sm table-strip" style="width:100%; height:25vh;overflow-y:scroll">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Pemeliharaan</th>
                                                    <th scope="col">Tahun</th>
                                                    <th scope="col">Nilai</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>`
                                        }
                                        var trHTML = "";
                                        $.each(property.pemeliharaan, function(
                                            i, item) {
                                            console.log(item
                                                .nama_pemeliharaan);
                                            trHTML += '<tr><td>' + item
                                                .nama_pemeliharaan +
                                                '</td><td>' +
                                                item
                                                .tahun_pemeliharaan +
                                                '</td><td>' + item
                                                .nilai_aset +
                                                '</td></tr>';
                                        });
                                        console.log(trHTML)



                                        $('#sertifikat').append(
                                            `<div class="row h-25 d-flex justify-content-center align-self-start">
                                        <div class="h-25 col-md-10">
                                            ` + image + `
                                        </div>
                                        </div>

                                        <div class="row h-25 d-flex justify-content-center align-self-start mt-2" >
                                        <div class=" h-25 col-md-10" style="">
                                            ` + penanda + `
                                        </div>

                                        </div>
                                        </div>
                                        <div class="row d-flex justify-content-center mt-2" >
                                        <div class=" col-md" style="">
                                            ` + pemeliharaan + `
                                        </div>

                                        </div>
                                        </div>`
                                        )
                                        $('#pemeliharaan').append(trHTML);
                                        $('#detailTitle').empty()
                                        $('#detailData').empty()
                                        $('#detailTitle').append(
                                            property.master_skpd
                                            .nama_skpd + " / " +
                                            property.nama)
                                        if (!property.kecamatan) {
                                            kecamatan = '-'
                                        } else {
                                            kecamatan = property.kecamatan
                                                .nama_kecamatan
                                        }
                                        if (!property.kelurahan) {
                                            kelurahan = '-'
                                        } else {
                                            kelurahan = property.kelurahan
                                                .nama_kelurahan
                                        }
                                        if (!property.master_barang) {
                                            nama_barang = '-'
                                            kode_barang = '-'
                                        } else {
                                            nama_barang = property.master_barang
                                                .nama_barang
                                            kode_barang = property.master_barang
                                                .kode_barang
                                        }
                                        if (property.kondisi_bangunan == 'B') {
                                            kondisi_bangunan = 'Baik'
                                        } else if (property.kondisi_bangunan ==
                                            'RR') {
                                            kondisi_bangunan = 'Rusak Ringan'
                                        } else if (property.kondisi_bangunan ==
                                            'RB') {
                                            kondisi_bangunan = 'Rusak Berat'
                                        } else {
                                            kondisi_bangunan = '-'
                                        }
                                        if (property.jenis_bangunan == 'BTK') {
                                            jenis_bangunan = 'Bertingkat'
                                        } else if (property.jenis_bangunan ==
                                            'TTK') {
                                            jenis_bangunan = 'Tidak Bertingkat'
                                        } else {
                                            jenis_bangunan = '-'
                                        }
                                        if (property.jenis_konstruksi ==
                                            'BTN') {
                                            jenis_konstruksi = 'Beton'
                                        } else if (property.jenis_konstruksi ==
                                            'BBTN') {
                                            jenis_konstruksi = 'Bukan Beton'
                                        } else {
                                            jenis_konstruksi = '-'
                                        }
                                        $('#detailData').append(`
                                            <table class="table table-sm table-striped">
                                            <tr>
                                            <th>Pengelola Inventaris </th>
                                            <td>` + property.master_skpd.nama_skpd + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kategori Inventaris </th>
                                            <td>` + nama_barang + `</td>
                                            </tr>
                                            <th>Nama Inventaris </th>
                                            <td>` + property.nama + `</td>
                                            </tr>
                                            <th>Kode Gedung </th>
                                            <td>` + property.kode_gedung + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kode Inventaris </th>
                                            <td>` + kode_barang + "/" + property
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
                                            <td>` + kelurahan + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kecamatan </th>
                                            <td>` + kelurahan + `</td>
                                            </tr>
                                            <tr>
                                            <th>Koordinat </th>
                                            <td><a href='#' onclick="gMaps(` + coordinates + `)">` + prop.lat +
                                            ` / ` + prop.lng + `</a></td>
                                            </tr>
                                            <tr>
                                            <th>Luas Bangunan </th>
                                            <td>` + rupiah(lt) + ` Meter Persegi` + `</td>
                                            </tr>
                                            <tr>
                                            <th>Status </th>
                                            <td>` + property.status + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kondisi  </th>
                                            <td>` + kondisi_bangunan + `</td>
                                            </tr>
                                            <tr>
                                            <th>Konstruksi </th>
                                            <td>` + jenis_bangunan + " / " + jenis_konstruksi + `</td>
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
                                        <th>Kode</th>
                                        <td>` + property.kode_gedung + `</td>
                                        </tr>
                                        <tr>
                                        <th>Pengelola</th>
                                        <td>` + property.master_skpd.nama_skpd + `</td>
                                        </tr>

                                        <tr>
                                        <th>Alamat</th>
                                        <td>` + property.alamat +
                                            `</td>
                                        </tr>
                                        <tr>
                                        <td colspan="2" style="text-align:center"> <a href=# onclick="gMaps(` +
                                            coordinates +
                                            `)"><i class="fas fa-map-marker-alt"></i> Buka Maps </a></td>
                                        </tr>
                                        </table>
                                        <table class="table table-striped">
                                        <tr>
                                        <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                            '\'bangunan\'' +
                                            ',' +
                                            property.id +
                                            `)"><i class="fas fa-print"></i> Print</a></td>
                                        <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                            property.id + `"></i><i class="fas fa-info-circle"></i> Detail</a></td>
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

                                                setTimeout(function() {
                                                    minimap
                                                        .invalidateSize();
                                                    minimap
                                                        .fitBounds(
                                                            minilayer
                                                            .getBounds()
                                                        );
                                                }, 1000);

                                            }
                                        );
                                    });
                                });
                            })
                        }
                    }
                });
            }
        });

        map.on('overlayremove', function(eventLayer) {
            if (eventLayer.name === '5') {
                // map.removeLayer(layerTanahGabungan);
                layerTanahGabungan.clearLayers()

            }
            if (eventLayer.name === '6') {
                // map.removeLayer(layerGedungGabungan)
                layerGedungGabungan.clearLayers()
            }
        });

        var options = {
            collapsed: false
        }

        var layerControlOverlay = L.control.layers.tree(basemaps, overlaysTree, options = {
            collapsed: false
        }).addTo(map);



        var htmlObjectOverlay = layerControlOverlay.getContainer();

        var a = document.getElementById('layers');


        function setParentLayer(el, newParent) {
            newParent.appendChild(el);
        }
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
                    $("#dataSkpd2").append(listItems);
                    // $("#dataSkpd").trigger("change");
                }
            });
        }
        skpd();

        function myPrint(kib, id) {
            window.open('/inventaris/' + kib + '/' + id + '/print',
                '',
                'width=1200,height=600');
        }

        function gMaps(c) {
            // console.log(c)
            url = "https://www.google.com/maps/search/" + c;
            window.open(url, '_blank');
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
                            id="noSertifikat" maxlength="5" placeholder="Masukkan 5 digit terakhir sertifikat" required>`
                );
            };

        });

        // query pencarian tanah
        $("#queryGeom").on('submit', function(e) {
            layerAll = L.featureGroup();
            e.preventDefault(); // avoid to execute the actual submit of the form.
            // map.removeLayer();
            var search = $('input[name="varQuery"]:checked').val();
            // var status = $('input[name="status"]:checked').val();
            // var status = 1;
            var kelurahan = $('#data_kelurahan').val();
            var skpd = $('#dataSkpd').val();
            var sertifikat = $('#noSertifikat').val();
            var urlSkpd = "api/inventaris/" + kelurahan + "/" + skpd + "/queryskpd"
            if (!sertifikat) {
                var urlSertifikat = "api/inventaris/" + kelurahan + "/0/querysertifikat"
            } else {
                var urlSertifikat = "api/inventaris/" + kelurahan + "/" + sertifikat +
                    "/querysertifikat"
            }

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
                    console.log(geom);
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
                            var kib = 'tanah'
                            var id = property.id
                            var geo = property.geometry.polygon
                            var lat = property.geometry.lat
                            var lng = property.geometry.lng
                            var coordinates = "'" + lat + "," + lng + "'";

                            function myPrint() {
                                window.open('/inventaris/' + '\'tanah\'' + '/' + id + '/print',
                                    '',
                                    'width=1200,height=600');
                            }

                            x = JSON.parse(geo)
                            var layer = L.geoJSON(x, {
                                style: sertifikatStyle,
                                pmIgnore: true
                            }).addTo(map);
                            // var minilayer = L.geoJSON(x, {
                            //     style: sertifikatStyle,
                            //     pmIgnore: true
                            // });

                            layer.addTo(layerAll);

                            layer.on('click', function() {
                                var minilayer = '';
                                minimap.eachLayer(function(lay) {
                                    if (lay.toGeoJSON) {
                                        minimap.removeLayer(lay);
                                    }

                                });
                                var mini = (JSON.parse(property.geometry.polygon));
                                minilayer = L.geoJSON(mini, {
                                    style: sertifikatStyle,
                                    pmIgnore: true
                                });
                                minilayer.addTo(minimap);

                                // console.log(minilayer)
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
                                                  <th>Pengelola Inventaris </th>
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
                                                  <td><a href='#' onclick="gMaps(` + coordinates + `)">` + lat +
                                    ` / ` + lng + `</a></td>
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
                                                <tr>
                                                    <td colspan="2" style="text-align:center"> <a href=# onclick="gMaps(` +
                                    coordinates +
                                    `)"><i class="fas fa-map-marker-alt"></i> Buka Maps </a></td>
                                                </tr>
                                                </table>
                                                <table class="table table-striped">
                                                <tr>
                                                    <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                    '\'tanah\'' +
                                    ',' +
                                    property.id +
                                    `)"><i class="fas fa-print"></i> Print</a></td>
                                                    <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                    property.id + `"></i><i class="fas fa-info-circle"></i> Detail</a></td>
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

                                        setTimeout(function() {
                                            minimap.invalidateSize();
                                            minimap.fitBounds(minilayer
                                                .getBounds());
                                        }, 1000);

                                    });
                            });
                        })
                        // layer.addTo(map);
                        // pointAll.addTo(map);
                        map.fitBounds(layerAll.getBounds());
                        // setInterval(function() {
                        //     map.removeLayer(pointAll);
                        // }, 10520);

                    }
                    // console.log(sertifikatStyle['opacity'] = 0.1)
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

        // query pencarian gedung

        $("#queryGeomGedung").on('submit', function(e) {
            layerAll = L.featureGroup();
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var skpd = $('#dataSkpd2').val();
            console.log(skpd)
            var urlSkpd = "api/inventarisgedung/" + skpd + "/queryskpdgedung"
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
                url: urlSkpd,
                dataType: "json",
                success: function(q) {
                    layerGedungGabungan.clearLayers();
                    var geom = q.data
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
                            var geo = property.geometry
                            var lat = property.geometry
                            var lng = property.geometry
                            var layer;
                            var minilayer;
                            $.each(geo, (i, prop) => {
                                // console.log(prop)
                                // console.log(i)
                                x = JSON.parse(prop.polygon)
                                var coordinates = "'" + prop.lat + "," + prop.lng +
                                    "'";
                                layer = L.geoJSON(x, {
                                    style: gedungStyle,
                                    pmIgnore: true
                                })
                                minilayer = L.geoJSON(x, {
                                    style: gedungStyle,
                                    pmIgnore: true
                                });
                                layer.bindTooltip(property.kode_gedung, {
                                    permanent: false,
                                    direction: "center"
                                })
                                layer.addTo(layerGedungGabungan);
                                layerGedungGabungan.addTo(map)
                                layer.addTo(layerAll);
                                // layerAll.addTo(map)
                                layer.on('click', function() {
                                    var minilayer = '';
                                    minimap.eachLayer(function(lay) {
                                        if (lay.toGeoJSON) {
                                            minimap.removeLayer(
                                                lay);
                                        }

                                    });
                                    var mini = (JSON.parse(prop
                                        .polygon));
                                    minilayer = L.geoJSON(mini, {
                                        style: gedungStyle,
                                        pmIgnore: true
                                    });
                                    minilayer.addTo(minimap);


                                    const hb = property
                                        .nilai_aset,
                                        na = property
                                        .nilai_aset,
                                        lt = property
                                        .luas,
                                        ns = property
                                        .nilai_aset
                                    if (!property.document) {
                                        penanda =
                                            // `<iframe src="assets/document/default-sertifikat.pdf" style="width: 100%;height: 70vh; position: relative;"></iframe>`
                                            `<img class="img-fluid" src="assets/galery/default-image.png" style="height:30vh;width:100%"></img>`
                                    } else {
                                        penanda =
                                            `<img class="img-fluid" src="assets/document/` +
                                            property
                                            .document.doc_path +
                                            `" style="height:30vh;width:100%">`
                                    }
                                    if (!property.galery) {
                                        image =
                                            `<img src="assets/galery/default-image.png" style="height:30vh;width:100%"></img>`
                                    } else {
                                        image =
                                            `<img class="img-fluid" src="assets/galery/` +
                                            property.galery.image_path +
                                            `" style="height:30vh;width:100%"></img>`
                                    }
                                    $('#sertifikat').empty()
                                    if (property.pemeliharaan.length == 0) {
                                        pemeliharaan = ""
                                    } else {
                                        pemeliharaan = `
                                        <div class="container" style="display:block; overflow-x: auto; height:25vh" >
                                            <table id="pemeliharaan" class="table table-sm table-strip" style="width:100%; height:25vh;overflow-y:scroll">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Pemeliharaan</th>
                                                    <th scope="col">Tahun</th>
                                                    <th scope="col">Nilai</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>`
                                    }
                                    var trHTML = "";
                                    $.each(property.pemeliharaan, function(
                                        i, item) {
                                        console.log(item
                                            .nama_pemeliharaan);
                                        trHTML += '<tr><td>' + item
                                            .nama_pemeliharaan +
                                            '</td><td>' +
                                            item
                                            .tahun_pemeliharaan +
                                            '</td><td>' + item
                                            .nilai_aset +
                                            '</td></tr>';
                                    });
                                    console.log(trHTML)



                                    $('#sertifikat').append(
                                        `<div class="row h-25 d-flex justify-content-center align-self-start">
                                        <div class="h-25 col-md-10">
                                            ` + image + `
                                        </div>
                                        </div>

                                        <div class="row h-25 d-flex justify-content-center align-self-start mt-2" >
                                        <div class=" h-25 col-md-10" style="">
                                            ` + penanda + `
                                        </div>

                                        </div>
                                        </div>
                                        <div class="row d-flex justify-content-center mt-2" >
                                        <div class=" col-md" style="">
                                            ` + pemeliharaan + `
                                        </div>

                                        </div>
                                        </div>`
                                    )
                                    $('#pemeliharaan').append(trHTML);
                                    $('#detailTitle').empty()
                                    $('#detailData').empty()
                                    $('#detailTitle').append(
                                        property.master_skpd
                                        .nama_skpd + " / " +
                                        property.nama)
                                    if (!property.kecamatan) {
                                        kecamatan = '-'
                                    } else {
                                        kecamatan = property.kecamatan
                                            .nama_kecamatan
                                    }
                                    if (!property.kelurahan) {
                                        kelurahan = '-'
                                    } else {
                                        kelurahan = property.kelurahan
                                            .nama_kelurahan
                                    }
                                    if (!property.master_barang) {
                                        nama_barang = '-'
                                        kode_barang = '-'
                                    } else {
                                        nama_barang = property.master_barang
                                            .nama_barang
                                        kode_barang = property.master_barang
                                            .kode_barang
                                    }
                                    if (property.kondisi_bangunan == 'B') {
                                        kondisi_bangunan = 'Baik'
                                    } else if (property.kondisi_bangunan ==
                                        'RR') {
                                        kondisi_bangunan = 'Rusak Ringan'
                                    } else if (property.kondisi_bangunan ==
                                        'RB') {
                                        kondisi_bangunan = 'Rusak Berat'
                                    } else {
                                        kondisi_bangunan = '-'
                                    }
                                    if (property.jenis_bangunan == 'BTK') {
                                        jenis_bangunan = 'Bertingkat'
                                    } else if (property.jenis_bangunan ==
                                        'TTK') {
                                        jenis_bangunan = 'Tidak Bertingkat'
                                    } else {
                                        jenis_bangunan = '-'
                                    }
                                    if (property.jenis_konstruksi ==
                                        'BTN') {
                                        jenis_konstruksi = 'Beton'
                                    } else if (property.jenis_konstruksi ==
                                        'BBTN') {
                                        jenis_konstruksi = 'Bukan Beton'
                                    } else {
                                        jenis_konstruksi = '-'
                                    }
                                    $('#detailData').append(`
                                            <table class="table table-sm table-striped">
                                            <tr>
                                            <th>Pengelola Inventaris </th>
                                            <td>` + property.master_skpd.nama_skpd + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kategori Inventaris </th>
                                            <td>` + nama_barang + `</td>
                                            </tr>
                                            <th>Nama Inventaris </th>
                                            <td>` + property.nama + `</td>
                                            </tr>
                                            <th>Kode Gedung </th>
                                            <td>` + property.kode_gedung + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kode Inventaris </th>
                                            <td>` + kode_barang + "/" + property
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
                                            <td>` + kelurahan + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kecamatan </th>
                                            <td>` + kelurahan + `</td>
                                            </tr>
                                            <tr>
                                            <th>Koordinat </th>
                                            <td><a href='#' onclick="gMaps(` + coordinates + `)">` + prop.lat +
                                        ` / ` + prop.lng + `</a></td>
                                            </tr>
                                            <tr>
                                            <th>Luas </th>
                                            <td>` + rupiah(lt) + ` Meter Persegi` + `</td>
                                            </tr>
                                            <tr>
                                            <th>Status </th>
                                            <td>` + property.status + `</td>
                                            </tr>
                                            <tr>
                                            <th>Kondisi </th>
                                            <td>` + kondisi_bangunan + `</td>
                                            </tr>
                                            <tr>
                                            <th>Konstruksi </th>
                                            <td>` + jenis_bangunan + " / " + jenis_konstruksi + `</td>
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
                                        <th>Kode</th>
                                        <td>` + property.kode_gedung + `</td>
                                        </tr>
                                        <tr>
                                        <th>Pengelola</th>
                                        <td>` + property.master_skpd.nama_skpd + `</td>
                                        </tr>

                                        <tr>
                                        <th>Alamat</th>
                                        <td>` + property.alamat +
                                        `</td>
                                        </tr>
                                        <tr>
                                        <td colspan="2" style="text-align:center"> <a href=# onclick="gMaps(` +
                                        coordinates +
                                        `)"><i class="fas fa-map-marker-alt"></i> Buka Maps </a></td>
                                        </tr>
                                        </table>
                                        <table class="table table-striped">
                                        <tr>
                                        <td style="text-align:center"><a class="" href="#" onclick="myPrint(` +
                                        '\'bangunan\'' +
                                        ',' +
                                        property.id +
                                        `)"><i class="fas fa-print"></i> Print</a></td>
                                        <td style="text-align:center"><a class="" id="openModal" href="#"  data-target="#detailModal" data-toggle="modal" data-value"` +
                                        property.id + `"></i><i class="fas fa-info-circle"></i> Detail</a></td>
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

                                            setTimeout(function() {
                                                minimap
                                                    .invalidateSize();
                                                minimap
                                                    .fitBounds(
                                                        minilayer
                                                        .getBounds()
                                                    );
                                            }, 1000);

                                        }
                                    );
                                });
                            });
                            map.fitBounds(layerAll.getBounds());
                        })

                    }
                }
            });

            // menghapus layer yang ada di peta
            $("#clearGedung").on('click', function(e) {
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

        //update opacity layer
    </script>
@stop
