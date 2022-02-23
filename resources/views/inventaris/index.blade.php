@extends('adminlte::page')

@section('title', 'Data Aset | Aset Tanah')

@section('content_header')
    {{-- <div class="h1 ">Data Aset Tanah Kota Blitar</div> --}}
    <div class="mb-0"></div>
@stop

@section('content')
    {{-- @include('contents.inventaris_kib_a_content') --}}
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <h5 class="card-header">Data Aset Tanah Kota Blitar</h5>
            <div class="card-body">
                <a href="{{ route('inventaris.create') }}" class="btn btn-primary">+ Inventaris</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type=radio class="filter" name="status" value="all" id="im" checked="checked"><label
                    for="im">&nbsp; Seluruh Aset
                    &nbsp;
                    &nbsp;</label>
                <input type=radio class="filter" name="status" value="1" id="gm"><label for="gm">&nbsp; Aset
                    Bersertifikat
                    &nbsp;&nbsp;</label>
                <input type=radio class="filter" name="status" value="0" id="am"><label for="am">&nbsp; Aset Non
                    Sertifikat
                    &nbsp;&nbsp;</label>

                <hr />
                <table class="table table-striped table-hover table-bordered order-column table-sm" id="inventaris_kib_a">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th id="aksi">Aksi</th> --}}
                            <th>Aksi</th>
                            <th>SKPD Pengelola</th>
                            {{-- <th>Kode Inventaris</th> --}}
                            <th>Nama Inventaris</th>
                            <th>Jenis Inventaris</th>
                            <th>No. Sertifikat</th>
                            <th>Alamat</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailTitle">Inventaris Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- tabs --}}
                    <div class="container-fluid">
                        <div class="card">
                            {{-- <h5 class="card-header">Featured</h5> --}}
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Peta</button>
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-profile" type="button" role="tab"
                                            aria-controls="nav-profile" aria-selected="false">Detail</button>
                                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-contact" type="button" role="tab"
                                            aria-controls="nav-contact" aria-selected="false">Dokumen</button>
                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <div class="mt-2" id="mapDetail">
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <div class="mt-2" id="detailData">
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                        aria-labelledby="nav-contact-tab">
                                        <div class="mt-2" id="dokumen">
                                            <div class="row">
                                                <div class="col-6" id="document"></div>
                                                <div class="col-6" id="image"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container-fluid">

                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="..." class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="..." class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="..." class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div> --}}

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
    {{-- swall --}}
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    {{-- <script src="{{ asset('assets/inventaris/kib_a.js') }}"></script> --}}

    <script>
        //call loader
        $(document).on({
            ajaxStart: function() {
                $("body").addClass("loading");
            },
            ajaxStop: function() {
                $("body").removeClass("loading");
            }
        });

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
                responsive: true,
                // "scrollX": true,
                "autoWidth": true,
                ajax: {
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: '/api/getinventaris',
                    method: "GET"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            var contextButton =
                                "<i class='fas fa-bars' id='contextButton' data-value='" +
                                data +
                                "'></i>";
                            return contextButton;
                        }
                    },
                    {
                        data: 'master_skpd.nama_skpd',
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'master_barang.nama_barang',

                    },
                    {
                        data: 'no_dokumen_sertifikat',

                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'status',
                        render: sertifikat
                    },
                ],

                columnDefs: [{
                    orderable: false,
                    targets: [0]
                }],

            });

            // $('input:radio').on('change', function() {
            //     //build a regex filter string with an or(|) condition
            //     console.log($(this).val())


            // });

            $('input:radio').on('change', function() {
                // var i = $(this).attr('data-column');
                var v = $(this).val();
                console.log(v)
                // console.log(table.columns(8).search(v).draw())
                if ((v == 0) || (v == 1)) {
                    table.columns(7).search(v).draw();
                } else if (v === 'all') {
                    table.columns(7).search('').draw();
                }
            });

            $.contextMenu({
                selector: '#contextButton',
                trigger: 'left',
                callback: function(key, options) {
                    var value = options.$trigger.data("value");
                    const id = value;

                    function callMap() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
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

                                    var verifMap = property.geometry
                                    console.log(verifMap)

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

                                    if (!property.galery) {
                                        image = "Photo Lokasi Belum Tersedia"
                                    } else {
                                        image =
                                            `</div><img class="img-fluid" src="assets/galery/` +
                                            property.galery.image_path +
                                            `"></img></div>`
                                    }
                                    if (!property.document) {
                                        doc = "File Sertifikat Belum Tersedia"
                                    } else {
                                        doc = `<div class="ratio ratio-16x9">
                                            <iframe src= "assets/document/` +
                                            property.document.doc_path + `"></iframe>
                                        </div>`
                                    }

                                    $('#detailTitle').empty()
                                    $('#detailData').empty()
                                    $('#image').empty()
                                    $('#image').append(image);
                                    $('#document').empty()
                                    $('#document').append(doc);
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
                                        </tr>` + (verifMap ? `
                                        <tr>
                                          <th>Koordinat </th>
                                          <td>` + property.geometry.lat + ` / ` + property.geometry.lng + `</td>
                                        </tr>` :
                                            ``) +
                                        `<tr>
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




                                    $('#mapDetail').empty()
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
                                            editControls: false,
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
                                                    // alert(
                                                    //     'data spatial belum tersedia'
                                                    // )
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
                                                    map.setView(
                                                        point
                                                        .getLatLng(),
                                                        19)
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
                            window.location.href = '/inventaris/' + id + '/edit'
                            break
                        case 'print':
                            // $.getJSON('api/inventaris/' + id, (result) => {
                            //     let property = result.data[0];
                            //     console.log(property.nama)
                            // });
                            myWindow = window.open('/inventaris/' + id + '/print', '',
                                'width=1200,height=600');

                            // setTimeout(function() {
                            //     myWindow.print();
                            // }, 500);
                            // setTimeout(window.close, 0);
                            // window.onfocus = function() {
                            //     setTimeout(function() {
                            //         mywindow.close();
                            //     }, 500);
                            // }
                            // myWindow.write('/inventaris/' + id +'/print') //= '/inventaris/' + id + '/print'
                            break
                        case 'delete':
                            $.getJSON('api/inventaris/' + id, (result) => {
                                let property = result.data[0];
                                var confirmNama = property.nama
                                Swal.fire({
                                    title: 'Hapus Inventaris ' +
                                        confirmNama,
                                    text: ' Apakah Anda yakin ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Ya, Hapus',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            type: "DELETE",
                                            url: "inventaris/" + id,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            success: (data) => {
                                                alert(data);
                                                console.log(data);
                                                // Swal.fire(
                                                //     'Terhapus!',
                                                //     confirmNama +
                                                //     'Berhasil dihapus',
                                                //     'success',
                                                // );
                                                table.draw();
                                            },
                                            error: (xhr, ajaxOptions,
                                                thrownError) => {
                                                alert(xhr.responseJSON
                                                    .message);
                                                if (xhr.responseJSON
                                                    .hasOwnProperty(
                                                        'errors')) {
                                                    for (item in xhr
                                                        .responseJSON.errors
                                                    ) {
                                                        if (xhr.responseJSON
                                                            .errors[item]
                                                            .length) {
                                                            for (var i =
                                                                    0; i <
                                                                xhr
                                                                .responseJSON
                                                                .errors[
                                                                    item]
                                                                .length; i++
                                                            ) {
                                                                alert(xhr
                                                                    .responseJSON
                                                                    .errors[
                                                                        item
                                                                    ]
                                                                    [i]);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                        // Swal.fire(
                                        //     title: 'Terhapus!',
                                        //     text: 'Berhasil dihapus',
                                        //     icon: 'success'
                                        // );
                                    };
                                })
                            });

                            // console.log(confirmNama);




                            // Swal.fire('Any fool can use a computer')
                            break
                        default:
                            break
                    }
                },
                items: {
                    "detail": {
                        name: "Lihat Detail Aset",
                        icon: "fas fa-eye"
                    },
                    "edit": {
                        name: "Edit Aset",
                        icon: "fas fa-edit"
                    },
                    "print": {
                        name: "Print Laporan Aset",
                        icon: "fas fa-print"
                    },
                    "delete": {
                        name: "Hapus Data Aset",
                        icon: "fas fa-trash-alt"
                    },
                }
            })

        });
    </script>
@stop
