@extends('adminlte::page')

@section('title', 'Data Aset | Aset Bangunan')

@section('content_header')
    {{-- <div class="h1 ">Data Aset Tanah Kota Blitar</div> --}}
    <div class="mb-0"></div>
@stop

@section('content')
    {{-- @include('contents.inventaris_kib_a_content') --}}
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <h5 class="card-header">Data Aset Gedung Kota Blitar</h5>
            <div class="card-body">
                <a href="{{ route('inventarisgedung.create') }}" class="btn btn-primary">+ Inventaris Gedung</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type=radio class="filter" name="status" value="all" id="im" checked="checked"><label
                    for="im">&nbsp; Seluruh Aset
                    &nbsp;
                    &nbsp;</label>
                <input type=radio class="filter" name="status" value="1" id="gm"><label for="gm">&nbsp;
                    Aset
                    Bersertifikat
                    &nbsp;&nbsp;</label>
                <input type=radio class="filter" name="status" value="0" id="am"><label for="am">&nbsp;
                    Aset Non
                    Sertifikat
                    &nbsp;&nbsp;</label>

                <hr />
                <table class="table table-striped table-hover table-bordered order-column table-sm" id="inventaris_kib_c"
                    style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th id="aksi">Aksi</th> --}}
                            <th>Aksi</th>
                            <th>SKPD Pengelola</th>
                            {{-- <th>Kode Inventaris</th> --}}
                            <th>Nama Inventaris</th>
                            <th>Jenis Inventaris</th>
                            {{-- <th>No. Sertifikat</th> --}}
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Pemeliharaan</th>
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
                                            data-bs-target="#nav-home" type="button" role="tab"
                                            aria-controls="nav-home" aria-selected="true">Peta</button>
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

    <div class="modal fade" id="edit-pemeliharaan" tabindex="-1" aria-labelledby="editPemeliharaan" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-pemeliharaan-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pemeliharaan-title">Edit Pemeliharaan</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="mode-input">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="id-pemeliharaan">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="id-inventaris">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nama Pemeliharaan :</label>
                            <input type="text" class="form-control" id="nama-pemeliharaan">
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Tahun Pemeliharaan:</label>
                            {{-- <input type="text" class="form-control" id="tahun-pemeliharaan"> --}}
                            <select class="form-select" aria-label="Default select example" name="tahun-pemeliharaan"
                                id="tahun-pemeliharaan">
                                {{ $last = date('Y') - 120 }}
                                {{ $now = date('Y') }}

                                @for ($i = $now; $i >= $last; $i--)
                                    <option value="{{ $i }}" {{-- {{ isset($edit) && $i == $edit['tahun_perolehan'] ? 'selected="selected"' : $now }} --}}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Nilai Pemeliharaan :</label>
                            <input type="text" class="form-control" id="nilai-pemeliharaan">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" id="submit-button" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

    <script type="text/javascript">
        //call loader
        $(document).on({
            ajaxStart: function() {
                $("body").addClass("loading");
            },
            ajaxStop: function() {
                $("body").removeClass("loading");
            }
        });

        // var sertifikat = function(data, type, full, meta) {
        //     var status = data == 1 ? "Bersertifikat" : "Belum Bersertifikat";
        //     // console.log(status);
        //     return status;
        // }

        function rupiah(x) {
            x = x.toString();
            var pattern = /(-?\d+)(\d{3})/;
            while (pattern.test(x))
                x = x.replace(pattern, "$1.$2");
            return x;
        }

        function updatePml(id, tahun, nilai, nama, idInventaris) {
            $('#mode-input').val('edit')
            $('#id-pemeliharaan').val(id)
            $('#id-inventaris').val(idInventaris)
            $('#nama-pemeliharaan').val(nama)
            $('#tahun-pemeliharaan').val(tahun)
            $('#nilai-pemeliharaan').val(nilai)
        }

        function createPml(idInventaris) {
            var tahunSekarang = new Date().getFullYear()
            $('#mode-input').val('create')
            $('#id-pemeliharaan').val('')
            $('#id-inventaris').val(idInventaris)
            $('#nama-pemeliharaan').val('')
            $('#tahun-pemeliharaan').val(tahunSekarang)
            $('#nilai-pemeliharaan').val('')
        }
        // var api = "api/inventaris"
        $(function() {

            function format(d) {
                // `d` is the original data object for the row
                console.log(d.id_inventaris);
                console.log(d.pemeliharaan.length);
                var pml = ''; //just a variable to construct
                // var idInventaris = '';
                // var tahun = ''; //just a variable to construct
                $.each($(d.pemeliharaan), function(key) {
                    // console.log(d.pemeliharaan[key])
                    var id = d.pemeliharaan[key].id
                    var idInventaris = d.pemeliharaan[key].inventaris_id
                    var nama = d.pemeliharaan[key].nama_pemeliharaan
                    var tahun = d.pemeliharaan[key].tahun_pemeliharaan
                    var nilai = d.pemeliharaan[key].nilai_aset
                    console.log(idInventaris)
                    pml += '<tr>' +
                        '<td>#</td>' +
                        '<td>' + d.pemeliharaan[key].nama_pemeliharaan + '</td><td>' + d
                        .pemeliharaan[key].tahun_pemeliharaan +
                        '</td><td> Rp.' + rupiah(d.pemeliharaan[key].nilai_aset) +
                        // '</td><td> <a href="#editPemeliharaan" data-toggle="modal" id="open-pemeliharaan" class="btn btn-success btn-sm" data-send="' +
                        // d.pemeliharaan[key].nilai_aset +
                        // '" data-target="#editPemeliharaan"><i class="fas fa-edit fa-xs"></i></a> ' +
                        '</td><td> <a href="#editPemeliharaan" onclick="updatePml(' + id + ',' + tahun +
                        ',' + nilai +
                        ',\'' + nama +
                        '\',\'' + idInventaris +
                        '\')" data-toggle="modal" id="open-pemeliharaan" class="btn btn-success btn-sm" data-target="#edit-pemeliharaan"><i class="fas fa-edit fa-xs"></i></a> ' +
                        ' ' +
                        ' <a href=# class="btn btn-danger btn-sm" onclick="deletePml(' + id + ',\'' + nama +
                        '\')"><i class="fas fa-trash fa-xs"></i></a></td>' +
                        '</tr>';
                })
                // `d` is the original data object for the row
                if (d.pemeliharaan.length == 0) {
                    // var kosong = 0;
                    return '<table class="table table-success table-hover " style="text-align: center;">' +
                        '<thead>' +
                        // '<th>Tidak ada Data Pemeliharaan</th>' +
                        '<th>Tidak ada Data Pemeliharaan &nbsp <a href="#tambahPemeliharaan" onclick="createPml(\'' +
                        d
                        .id_inventaris +
                        '\')" data-toggle="modal" class="btn btn-primary btn-sm" data-target="#edit-pemeliharaan">+ Data</a></th>' +
                        '</thead></table>';
                } else {
                    return '<table class="table table-success table-hover ">' +
                        '<thead>' +
                        '<th>#</th>' +
                        '<th>Nama Pemeliharaan</th>' +
                        '<th>Tahun</th>' +
                        '<th>Nilai</th>' +
                        '<th><a href="#tambahPemeliharaan" onclick="createPml(\'' + d.id_inventaris +
                        '\')" data-toggle="modal" class="btn btn-primary btn-sm" data-target="#edit-pemeliharaan">+ Data</a></th>' +
                        '</thead><tbody>' +
                        pml +
                        '</tbody></table>';
                }

            }

            var table = $('#inventaris_kib_c').DataTable({
                // processing: true,
                serverSide: true,
                responsive: true,
                // "scrollX": true,
                "autoWidth": true,
                ajax: {
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: '/api/getinventarisgedung',
                    method: "GET"
                },
                columns: [{
                        "width": "2%",
                        data: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        "width": "3%",
                        data: 'id',
                        render: function(data) {
                            var contextButton =
                                "<i class='fas fa-bars' id='contextButton' data-value='" +
                                data +
                                "'></i>";
                            return contextButton;
                        },
                        searchable: false
                    },
                    {
                        "width": "15%",
                        data: 'master_skpd.nama_skpd',
                        searchable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        "width": "15%",
                        data: 'master_barang',
                        render: function(data) {
                            return data === null ? "" : data.nama_barang
                        },
                        searchable: false

                    },
                    {
                        "width": "20%",
                        data: 'alamat',
                        searchable: false
                    },
                    {
                        "width": "5%",
                        data: 'status',
                        serarchable: false
                        // render: sertifikat
                    },
                    {
                        "width": "5%",
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        searchable: false
                    },
                ],

                columnDefs: [{
                    orderable: false,
                    targets: [0]
                }],

            });

            $('#inventaris_kib_c tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });

            // get data for modal

            // $(document).ready(function() {
            //     $("#open-pemeliharaan").click(function() {
            //         console.log('tes')
            //         // console.log($(this).data('send'))
            //         // $('#order-id').html($(this).data('id'));

            //         // $('#prod-id').html($(this).data('prod-id'));
            //         // $('#sell-id').html($(this).data('sell-id'));

            //         // show Modal
            //         $('#editPemeliharaan').modal('show');
            //     });
            // });

            // $('input:radio').on('change', function() {
            //     //build a regex filter string with an or(|) condition
            //     console.log($(this).val())


            // });

            // $('input:radio').on('change', function() {
            //     // var i = $(this).attr('data-column');
            //     var v = $(this).val();
            //     console.log(v)
            //     // console.log(table.columns(8).search(v).draw())
            //     if ((v == 0) || (v == 1)) {
            //         table.columns(7).search(v).draw();
            //     } else if (v === 'all') {
            //         table.columns(7).search('').draw();
            //     }
            // });

            $.contextMenu({
                selector: '#contextButton',
                trigger: 'left',
                callback: function(key, options) {
                    var value = options.$trigger.data("value");
                    const id = value;
                    console.log(id);

                    function callMap() {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url: "/api/inventarisgedung/" + id,
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

                                    var verifMap = property.geometry.length
                                    console.log(verifMap)

                                    if (!property.kecamatan) {
                                        kecamatan = ""
                                    } else {
                                        kecamatan = property.kecamatan
                                            .nama_kecamatan
                                    }
                                    if (!property.master_barang) {
                                        kode_barang = ""
                                    } else {
                                        kode_barang = property.master_barang
                                            .kode_barang
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
                                            `</div><img class="img-fluid" src="/assets/galery/` +
                                            property.galery.image_path +
                                            `"></img></div>`
                                    }
                                    if (!property.document) {
                                        doc = "File Sertifikat Belum Tersedia"
                                    } else {
                                        doc = `<div>
                                            <img class="img-fluid" src= "/assets/document/` +
                                            property.document.doc_path + `"></img>
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
                                          <td>` + kode_barang + `</td>
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
                                        </tr>` + (verifMap > 0 ? `
                                        <tr>
                                          <th>Koordinat </th>
                                          <td>` + property.geometry[0].lat + ` / ` + property.geometry[0].lng + `</td>
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
                                          <th>Status </th>
                                          <td>` + property.status + `</td>
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

                                    var batasKota = {
                                        "color": "#ffe312",
                                        "weight": 2,
                                        "opacity": 1
                                    };

                                    var batasSananwetan = new L.GeoJSON.AJAX(
                                        "{{ asset('assets/leaflet/geojson/sananwetan.geojson') }}", {
                                            style: batasKota,
                                            pmIgnore: true
                                        });
                                    var batasKepanjenkidul = new L.GeoJSON.AJAX(
                                        "{{ asset('assets/leaflet/geojson/kepanjenkidul.geojson') }}", {
                                            style: batasKota,
                                            pmIgnore: true
                                        });
                                    var batasSukorejo = new L.GeoJSON.AJAX(
                                        "{{ asset('assets/leaflet/geojson/sukorejo.geojson') }}", {
                                            style: batasKota,
                                            pmIgnore: true
                                        });
                                    batasSananwetan.addTo(map);
                                    batasKepanjenkidul.addTo(map);
                                    batasSukorejo.addTo(map);



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
                                                        .geometry[0]
                                                        .polygon
                                                    geo = JSON
                                                        .parse(x)
                                                    var poly = new L
                                                        .geoJson(
                                                            geo);
                                                    point = L
                                                        .marker(
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
                                                        .geometry[0]
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
                            window.location.href = '/inventaris/gedung/' + id + '/edit'
                            break
                        case 'print':
                            // $.getJSON('api/inventaris/' + id, (result) => {
                            //     let property = result.data[0];
                            //     console.log(property.nama)
                            // });
                            var kib = 'bangunan';
                            myWindow = window.open('/inventaris/' + kib + '/' + id + '/print', '',
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
                            $.getJSON('/api/inventarisgedung/' + id, (result) => {
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
                                            url: "/inventaris/gedung/" + id,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            success: (data) => {
                                                // alert(data);
                                                console.log(data);
                                                Swal.fire(
                                                    'Terhapus!',
                                                    confirmNama +
                                                    'Berhasil dihapus',
                                                    'success',
                                                );
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
                                                        .responseJSON
                                                        .errors
                                                    ) {
                                                        if (xhr
                                                            .responseJSON
                                                            .errors[
                                                                item]
                                                            .length) {
                                                            for (var i =
                                                                    0; i <
                                                                xhr
                                                                .responseJSON
                                                                .errors[
                                                                    item
                                                                ]
                                                                .length; i++
                                                            ) {
                                                                alert(xhr
                                                                    .responseJSON
                                                                    .errors[
                                                                        item
                                                                    ]
                                                                    [
                                                                        i
                                                                    ]
                                                                );
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

        $(function() {
            $("#edit-pemeliharaan").submit(function() {
                // let ms = new Date().getMilliseconds()
                // let kode = $("#kodeGedung").val()
                // let generate = Math.floor(ms + Math.random() * 90000) + kode
                // var formData = new FormData;
                var modeInput = $("#mode-input").val()
                var id = $("#id-pemeliharaan").val()
                var url = '/inventaris/gedung/pemeliharaan/store'
                var formData = new FormData
                console.log(modeInput)

                formData.append('id', $("#id-pemeliharaan").val());
                formData.append('id_inventaris', $("#id-inventaris").val());
                formData.append('nama', $("#nama-pemeliharaan").val());
                formData.append('tahun', $("#tahun-pemeliharaan").val());
                formData.append('nilai', $("#nilai-pemeliharaan").val());

                if (modeInput == 'edit') {
                    formData.append('_method', 'PUT')
                    url = '/inventaris/gedung/pemeliharaan/' + id + '/update'
                } else {
                    formData.append('_method', 'POST')
                }
                console.log(url)
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        // 'Content-Type': 'application/json',
                    },
                    // type: "{{ isset($edit) ? 'PUT' : 'POST' }}",
                    type: "POST",
                    // url: "{{ route('inventaris.store') }}",
                    url: url,
                    data: formData,

                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        console.log(data);
                        // $('#edit-pemeliharaan').hide()
                        $('#edit-pemeliharaan').hide();
                        $('.modal-backdrop').remove();
                        $('#open-pemeliharaan').click();
                        swal.fire({
                            title: 'Berhasil',
                            text: data,
                            icon: 'success',
                        }).then(function() {
                            // window.location = document.referrer;
                            $('#inventaris_kib_c').DataTable().ajax.reload(null,
                                false)
                            // $('#inventaris_kib_c').DataTable().draw()
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

                // $('#myModal').modal('hide');
                // $("body").removeClass('modal-open');
                // $('.modal-backdrop').remove();
                // $('.modal-backdrop').add();
                // $(document.body).addClass('modal-open');
                return false;
            });
        });

        function deletePml(id, nama) {
            Swal.fire({
                title: 'Hapus Pemeliharaan ' +
                    nama,
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
                        url: "/inventaris/gedung/" + id + "/pemeliharaan",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            // alert(data);
                            // console.log(data);
                            Swal.fire(
                                'Terhapus!',
                                nama +
                                'Berhasil dihapus',
                                'success',
                            );
                            $('#inventaris_kib_c').DataTable().ajax.reload(null, false)
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
        }
    </script>
@stop
