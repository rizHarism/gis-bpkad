var sertifikat = function (data, type, full, meta) {
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

var api = "http://127.0.0.1:8000/api/inventaris"

$(function () {

    var table = $('#inventaris_kib_a').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'http://127.0.0.1:8000/api/getinventaris',
            method: "GET"
        },
        columns: [
            { data: 'rownum' },
            // { data: 'id' },
            { data: 'master_skpd.nama' },
            { data: 'master_barang.kode_barang' },
            { data: 'master_barang.nama' },
            { data: 'nama' },
            { data: 'alamat' },
            { data: 'status', render: sertifikat },
        ],

    });


    $.contextMenu({
        selector: 'tr td',
        trigger: 'right',
        callback: function (key, options) {
            var row = table.row(options.$trigger)
            const id = row.data().id;
            console.log(id)
            // Memanggil Modal Detail Data

            function callDetail() {
                $('#detailModal').modal('show');
                $('#detailTitle').empty("")
                $('#detailData').empty()

                $.ajax(
                    {
                        url: api + "/" + id,
                        dataType: "json",
                        async: false,
                        success: function (result) {
                            let inv = result.data
                            $.each(inv, (i, property) => {

                                const sertifikat = (property.status == 1) ? "Bersertifikat" : "Belum Bersertifikat";
                                const hb = property.nilai_aset,
                                    na = property.nilai_aset,
                                    lt = property.luas,
                                    ns = property.nilai_aset
                                console.log(property)
                                $('#detailTitle').append(property.master_skpd.nama)
                                $('#detailData').append(`
                                        <table class="table table-striped">
                                        <tr>
                                          <th>Pemilik Inventaris </th>
                                          <td>`+ property.master_skpd.nama + `</td>
                                        </tr>
                                        <tr>
                                          <th>Nama Inventaris </th>
                                          <td>`+ property.nama + `</td>
                                        </tr>
                                        <tr>
                                          <th>Kode Inventaris </th>
                                          <td>`+ property.master_barang.kode_barang + `</td>
                                        </tr>
                                        <tr>
                                          <th>Tahun Perolehan :</th>
                                          <td>` + property.tahun_perolehan + `</td>
                                        </tr>
                                        <tr>
                                          <th>Harga Beli </th>
                                          <td>`+ `Rp ` + rupiah(hb) + `</td>
                                        </tr>
                                        <tr>
                                          <th>Nilai Aset </th>
                                          <td>`+ `Rp ` + na + `</td>
                                        </tr>
                                        <tr>
                                          <th>Alamat </th>
                                          <td>`+ property.alamat + `</td>
                                        </tr>
                                        <tr>
                                          <th>Luas Tanah </th>
                                          <td>` + lt + ` Meter Persegi` + `</td>
                                        </tr>
                                        <tr>
                                          <th>No Sertifikat </th>
                                          <td>`+ property.no_dokumen_sertifikat + `</td>
                                        </tr>

                                        <tr>
                                          <th>Status </th>
                                          <td>`+ sertifikat + `</td>
                                        </tr>
                                        <tr>
                                          <th>Nilai Saat Ini </th>
                                          <td>`+ `Rp ` + ns + `</td>
                                        </tr>
                                    </table>
                                        `);
                            })
                        }
                    }
                )
            }

            // Memanggil Modal Detail Data

            function callMap() {
                $.ajax(
                    {
                        url: api + "/" + id,
                        dataType: "json",
                        async: false,
                        success: function (result) {
                            let inv = result.data
                            $.each(inv, (i, property) => {

                                // verifikasi sudah ada map atau belum
                                var verifMap = property.geometry
                                console.log(verifMap)
                                // if (!verifMap) {
                                //     alert('data spatial belum tersedia')
                                // } else {

                                $('#mapDetail').empty()
                                $('#mapTittle').empty()
                                $('#mapTittle').append('Peta Aset  ' + property.nama)
                                $('#mapDetail').append(`<div id="map" class="" style="height: 500px; width:100%;"></div>`)

                                var map = L.map('map').setView([-8.098611, 112.165278], 13);

                                L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
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
                                        var nf = Intl.NumberFormat();
                                        var seeArea = turf.area(layer.toGeoJSON());
                                        var ha = seeArea / 10000;
                                        var content = "<table class='table table-striped table-bordered table-sm'>" +
                                            "<tr><th colspan='2'>Luas</th></tr>" +
                                            "<tr><td>" +
                                            nf.format(ha.toFixed(2)) + " Hektare" +
                                            "</td></tr>" +
                                            "<tr><td>" +
                                            nf.format(seeArea.toFixed(2)) + " Meter²" +
                                            "</td></tr>" +
                                            "</table>"
                                        layer.bindPopup(content);
                                        console.log(seeArea);
                                        var g = JSON.stringify(layer.toGeoJSON())
                                        var g = JSON.parse(g)
                                        let gdb = JSON.stringify(g.geometry)

                                    });
                                });

                                map.on('pm:create', function (e) {
                                    console.log(e);
                                    var shape = e.shape,
                                        layer = e.layer
                                    var nf = Intl.NumberFormat();
                                    // alert(turf.area(layer.toGeoJSON()))

                                    console.log(JSON.stringify(layer.toGeoJSON()))
                                    if (shape === 'Polygon') {

                                        var seeArea = turf.area(layer.toGeoJSON());
                                        var ha = seeArea / 10000;
                                        var content = "<table class='table table-striped table-bordered table-sm'>" +
                                            "<tr><th colspan='2'>Luas</th></tr>" +
                                            "<tr><td>" +
                                            nf.format(ha.toFixed(2)) + " Hektare" +
                                            "</td></tr>" +
                                            "<tr><td>" +
                                            nf.format(seeArea.toFixed(2)) + " Meter²" +
                                            "</td></tr>" +
                                            "</table>"

                                        layer.bindPopup(content);
                                        var g = JSON.stringify(layer.toGeoJSON())
                                        // var g = JSON.parse(g)
                                        // let gdb = JSON.stringify(g.geometry)

                                        // console.log(g)
                                    }

                                });


                                // console.log(JSON.stringify(geo));

                                $('#mapModal').modal('show');

                                $('#mapModal').on('shown.bs.modal', function () {
                                    setTimeout(function () {
                                        map.invalidateSize();
                                        if (verifMap == null) {
                                            // alert('data spatial belum tersedia')
                                        } else {
                                            var x = property.geometry.polygon
                                            geo = JSON.parse(x)
                                            var poly = new L.geoJson(geo)
                                            point = L.marker(poly.getBounds().getCenter())
                                            // console.log(point)
                                            poly.addTo(map)
                                            // point.addTo(map)

                                            map.setView(point.getLatLng(), 18)
                                        }
                                    }, 200);
                                });
                                // }
                            })
                        }
                    }
                )
            }


            switch (key) {
                case 'detail':
                    callDetail()

                    break

                // context menu Map
                case 'map':

                    callMap()

                    break
                case 'edit':

                    $('#updateModal').modal('show');

                    break
                case 'print':
                    row.data().nama_inventaris
                    alert(row.data().nama_inventaris)
                    $('#editModal').modal('show');
                    break
                default:
                    break
            }
        },
        items: {
            "map": { name: "Lihat Peta Aset", icon: "delete" },
            "detail": { name: "Lihat Detail Aset", icon: "delete" },
            "edit": { name: "Edit Laporan Aset", icon: "delete" },
            "print": { name: "Print Laporan Aset", icon: "delete" },
        }
    })

});
