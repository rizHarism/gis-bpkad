@extends('adminlte::page')

@section('title', 'Inventaris | Simantab')

@section('content_header')
    {{-- <div class="h1 ">Data Aset Tanah Kota Blitar</div> --}}
    <div class="mb-0"></div>
@stop

@section('content')
    @include('contents.inventaris_kib_a_content')
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
    {{-- <script src="{{ asset('assets/inventaris/kib_a.js') }}"></script> --}}

    <script>
        var sertifikat = function(data, type, full, meta) {
            var status = data == 1 ? "Bersertifikat" : "Belum Bersertifikat";
            // console.log(status);
            return status;
        }

        function rupiah(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1.$2");
            return x;
        }

        // var api = "api/inventaris"

        $(function() {

            var table = $('#inventaris_kib_a').DataTable({
                // processing: true,
                serverSide: true,
                // searchable: false,
                ajax: {
                    url: '/api/getinventaris',
                    method: "GET"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'master_skpd.nama_skpd',
                    },
                    {
                        data: 'master_barang.nama_barang',

                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'status',
                        render: sertifikat
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            var contextButton =
                                "<i class='fas fa-eye' id='contextButton' data-value='" +
                                data +
                                "'></i>";
                            return contextButton;
                        }
                    }
                ],

                columnDefs: [{
                    orderable: false,
                    targets: [0]
                }],

            });


            $.contextMenu({
                selector: '#contextButton',
                trigger: 'left',
                callback: function(key, options) {
                    var value = options.$trigger.data("value")
                    const id = value;
                    console.log(id)
                    // Memanggil Modal Detail Data

                    // function callDetail() {
                    //     // $('#detailModal').modal('show');
                    //     // $('#detailTitle').empty("")
                    //     $('#detailData').empty()

                    //     $.ajax(
                    //         {
                    //             url: api + "/" + id,
                    //             dataType: "json",
                    //             async: false,
                    //             success: function (result) {
                    //                 let inv = result.data
                    //                 $.each(inv, (i, property) => {

                    //                     const sertifikat = (property.status == 1) ? "Bersertifikat" : "Belum Bersertifikat";
                    //                     const hb = property.nilai_aset,
                    //                         na = property.nilai_aset,
                    //                         lt = property.luas,
                    //                         ns = property.nilai_aset
                    //                     console.log(property)
                    //                     // $('#detailTitle').append(property.master_skpd.nama)
                    //                     $('#detailData').append(`
                //                             <table class="table table-striped">
                //                             <tr>
                //                               <th>Pemilik Inventaris </th>
                //                               <td>`+ property.master_skpd.nama + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Nama Inventaris </th>
                //                               <td>`+ property.nama + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Kode Inventaris </th>
                //                               <td>`+ property.master_barang.kode_barang + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Tahun Perolehan :</th>
                //                               <td>` + property.tahun_perolehan + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Harga Beli </th>
                //                               <td>`+ `Rp ` + rupiah(hb) + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Nilai Aset </th>
                //                               <td>`+ `Rp ` + na + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Alamat </th>
                //                               <td>`+ property.alamat + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Luas Tanah </th>
                //                               <td>` + lt + ` Meter Persegi` + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>No Sertifikat </th>
                //                               <td>`+ property.no_dokumen_sertifikat + `</td>
                //                             </tr>

                //                             <tr>
                //                               <th>Status </th>
                //                               <td>`+ sertifikat + `</td>
                //                             </tr>
                //                             <tr>
                //                               <th>Nilai Saat Ini </th>
                //                               <td>`+ `Rp ` + ns + `</td>
                //                             </tr>
                //                         </table>
                //                             `);
                    //                 })
                    //             }
                    //         }
                    //     )
                    // }

                    // Memanggil Modal Detail Data

                    function callMap() {
                        $.ajax({
                            url: "/api/inventaris/" + id,
                            dataType: "json",
                            async: false,
                            success: function(result) {
                                let inv = result.data
                                $.each(inv, (i, property) => {

                                    const sertifikat = (property.status ==
                                            1) ?
                                        "Bersertifikat" :
                                        "Belum Bersertifikat";
                                    const hb = property.nilai_aset,
                                        na = property.nilai_aset,
                                        lt = property.luas,
                                        ns = property.nilai_aset
                                    console.log(property)

                                    if (!property.kecamatan) {
                                        kecamatan = ""
                                    } else {
                                        kecamatan = property.kecamatan
                                            .nama_kecamatan
                                    }

                                    if (!property.kelurahan) {
                                        kelurahan = ""
                                    } else {
                                        kelurahan = property.kelurahan
                                            .nama_kelurahan
                                    }

                                    $('#detailTitle').empty()
                                    $('#detailData').empty()
                                    $('#detailTitle').append(property
                                        .master_skpd
                                        .nama_skpd + " - " + property.nama)
                                    $('#detailData').append(`
                                        <table class="table table-striped">
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
                                          <th>Tahun Perolehan :</th>
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
                                          <th>Koordinat </th>
                                          <td>` + property.geometry.lat + ` / ` + property.geometry.lng + `</td>
                                        </tr>
                                        <tr>
                                          <th>Kelurahan </th>
                                          <td>` + kelurahan +
                                        `</td>
                                        </tr>
                                        <tr>
                                          <th>Kecamatan </th>
                                          <td>` + kecamatan +
                                        `</td>
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

                                    var verifMap = property.geometry
                                    console.log(verifMap)


                                    $('#mapDetail').empty()
                                    $('#mapTittle').empty()
                                    $('#mapTittle').append('Peta Aset  ' +
                                        property
                                        .nama)
                                    $('#mapDetail').html(
                                        `<div id="map" class="" style="height: 500px; width:100%;"></div>`
                                    )

                                    var map = L.map('map').setView([-
                                        8.098611,
                                        112.165278
                                    ], 13);

                                    L.tileLayer(
                                        "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
                                            attribution: "Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community",
                                            maxZoom: 19
                                        }).addTo(map);

                                    L.PM.initialize({
                                        optIn: true

                                    });

                                    if (verifMap) {
                                        map.pm.addControls({
                                            drawMarker: false,
                                            drawCircleMarker: false,
                                            drawPolyline: false,
                                            drawRectangle: false,
                                            drawPolygon: false,
                                            drawCircle: false,
                                            cutPolygon: false,
                                            rotateMode: false,
                                            editControls: true,
                                        });
                                    } else {
                                        map.pm.addControls({
                                            drawMarker: false,
                                            drawCircleMarker: false,
                                            drawPolyline: false,
                                            drawRectangle: false,
                                            drawPolygon: true,
                                            drawCircle: false,
                                            cutPolygon: false,
                                            rotateMode: false,
                                            editControls: false,
                                        });
                                    }


                                    map.on('pm:create', ({
                                        layer
                                    }) => {
                                        layer.on('pm:edit', e => {
                                            console.log(e);
                                            var nf = Intl
                                                .NumberFormat();
                                            var seeArea =
                                                turf.area(
                                                    layer
                                                    .toGeoJSON()
                                                );
                                            var ha =
                                                seeArea /
                                                10000;
                                            var content =
                                                "<table class='table table-striped table-bordered table-sm'>" +
                                                "<tr><th colspan='2'>Luas</th></tr>" +
                                                "<tr><td>" +
                                                nf.format(ha
                                                    .toFixed(
                                                        2)
                                                ) +
                                                " Hektare" +
                                                "</td></tr>" +
                                                "<tr><td>" +
                                                nf.format(
                                                    seeArea
                                                    .toFixed(
                                                        2)
                                                ) +
                                                " Meter²" +
                                                "</td></tr>" +
                                                "</table>"
                                            layer.bindPopup(
                                                content);
                                            console.log(
                                                seeArea);
                                            var g = JSON
                                                .stringify(
                                                    layer
                                                    .toGeoJSON()
                                                )
                                            var g = JSON
                                                .parse(g)
                                            let gdb = JSON
                                                .stringify(g
                                                    .geometry
                                                )

                                        });
                                    });

                                    map.on('pm:create', function(e) {
                                        console.log(e);
                                        var shape = e.shape,
                                            layer = e.layer
                                        var nf = Intl
                                            .NumberFormat();
                                        // alert(turf.area(layer.toGeoJSON()))

                                        console.log(JSON.stringify(
                                            layer
                                            .toGeoJSON()))
                                        if (shape === 'Polygon') {

                                            var seeArea = turf.area(
                                                layer
                                                .toGeoJSON());
                                            var ha = seeArea /
                                                10000;
                                            var content =
                                                "<table class='table table-striped table-bordered table-sm'>" +
                                                "<tr><th colspan='2'>Luas</th></tr>" +
                                                "<tr><td>" +
                                                nf.format(ha
                                                    .toFixed(2)) +
                                                " Hektare" +
                                                "</td></tr>" +
                                                "<tr><td>" +
                                                nf.format(seeArea
                                                    .toFixed(
                                                        2)) +
                                                " Meter²" +
                                                "</td></tr>" +
                                                "</table>"

                                            layer.bindPopup(
                                                content);
                                            var g = JSON.stringify(
                                                layer
                                                .toGeoJSON())
                                            // var g = JSON.parse(g)
                                            // let gdb = JSON.stringify(g.geometry)

                                            // console.log(g)
                                        }

                                    });


                                    // console.log(JSON.stringify(geo));

                                    $('#myModal').modal('show');

                                    $('#myModal').on('shown.bs.modal',
                                        function() {
                                            setTimeout(function() {
                                                map
                                                    .invalidateSize();
                                                if (verifMap ==
                                                    null) {
                                                    // alert('data spatial belum tersedia')
                                                } else {
                                                    var x =
                                                        property
                                                        .geometry
                                                        .polygon
                                                    geo = JSON.parse(x)
                                                    var poly = new L
                                                        .geoJson(geo);
                                                    point = L.marker(
                                                        poly
                                                        .getBounds()
                                                        .getCenter()
                                                    );
                                                    poly.addTo(
                                                        map);
                                                    point.addTo(map)
                                                    var bound = poly
                                                        .getBounds();
                                                    map.fitBounds(
                                                        bound);
                                                    // map.setView(
                                                    //     poly
                                                    //     .getBounds()
                                                    // )
                                                }
                                            }, 500);
                                        });
                                    $('#nav-home-tab').on('click',
                                        function() {
                                            setTimeout(function() {
                                                map
                                                    .invalidateSize();
                                                if (verifMap ==
                                                    null) {
                                                    // alert('data spatial belum tersedia')
                                                } else {
                                                    var x =
                                                        property
                                                        .geometry
                                                        .polygon
                                                    geo = JSON
                                                        .parse(
                                                            x)
                                                    var poly =
                                                        new L
                                                        .geoJson(
                                                            geo)
                                                    point = L
                                                        .marker(
                                                            poly
                                                            .getBounds()
                                                            .getCenter()
                                                        )
                                                    // console.log(point)
                                                    poly.addTo(
                                                        map)
                                                    // point.addTo(map)

                                                    map.setView(
                                                        point
                                                        .getLatLng(),
                                                        18)
                                                }
                                            }, 500);
                                        });
                                    // }
                                })
                            }
                        })
                    }


                    switch (key) {
                        case 'detail':
                            callMap()
                            break
                        case 'edit':
                            // callMap()
                            window.location.href = '/inventaris/edit'
                            break
                        case 'print':
                            row.data().nama_inventaris
                            alert(row.data().nama_inventaris)
                            // $('#editModal').modal('show');
                            break
                        default:
                            break
                    }
                },
                items: {
                    "detail": {
                        name: "Lihat Detail Aset",
                        icon: "delete"
                    },
                    "edit": {
                        name: "Edit Aset",
                        icon: "delete"
                    },
                    "print": {
                        name: "Print Laporan Aset",
                        icon: "delete"
                    },
                }
            })

        });
    </script>
@stop
