@extends('adminlte::master')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('body')
    @include('layouts.navbar_maps')

    <div id="maps"></div>

    <script src="{{ asset('assets/leaflet/core/leaflet-src.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin//js/L.Control.Layers.Minimap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/Control.MiniMap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Basemaps.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.BetterScale.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/styledLayerControl.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-geoman.min.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.contextmenu.js') }}"> </script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-sidebar.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-search.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.responsive.popup.js') }}"></script>
    <script src="{{ asset('assets/inventaris/maps.js') }}"></script>

    <script>
        // var api = 'http://127.0.0.1:8000/api/inventaris'

        // function rupiah(x) {
        //     x = x.toString();
        //     var pattern = /(-?\d+)(\d{3})/;
        //     while (pattern.test(x))
        //         x = x.replace(pattern, "$1.$2");
        //     return x;
        // }

        // var map = L.map('maps', {
        //     zoomControl: false,
        //     contextmenu: false,
        //     contextmenuWidth: 140,
        //     contextmenuItems: [{
        //         text: 'Show coordinates',
        //         callback: showCoordinates
        //     }, {
        //         text: 'Center map here',
        //         callback: centerMap
        //     }, '-', {
        //         text: 'Zoom in',
        //         icon: 'images/zoom-in.png',
        //         callback: zoomIn
        //     }, {
        //         text: 'Zoom out',
        //         icon: 'images/zoom-out.png',
        //         callback: zoomOut
        //     }]
        // }).setView([-8.098244, 112.165077], 13);

        // var osm = L.tileLayer.provider('OpenStreetMap.Mapnik', {
        //     maxZoom: 19
        // });
        // var esri = L.tileLayer.provider('Esri.WorldImagery', {
        //     maxZoom: 19
        // }).addTo(map);
        // var basemaps = [esri, osm]

        // // L.PM.setOptIn(true);

        // L.control.basemaps({
        //     basemaps: basemaps,
        //     position: "bottomright"
        // }).addTo(map);

        // var p1 = new L.GeoJSON(null);
        // var p2 = new L.GeoJSON(null);
        // var p3 = new L.GeoJSON(null);
        // var p4 = new L.GeoJSON(null);


        // var overlays = [{
        //     groupName: "Aset Tanah",
        //     expanded: true,
        //     layers: {
        //         " Tanah Bersertifikat": p1,
        //         " Tanah Non Sertifikat": p2,
        //     }
        // }, {
        //     groupName: "Aset Bangunan",
        //     expanded: true,
        //     layers: {
        //         " Bangunan Berdokumen": p3,
        //         " Bangunan Nondokumen": p4,
        //         // "   Rice Plant ": batas6
        //     }
        // }];

        // var options = {
        //     container_width: "300px",
        //     container_maxHeight: "350px",
        //     group_maxHeight: "80px",
        //     exclusive: false,
        //     collapsed: true,

        // };

        // var control = L.Control.styledLayerControl(null, overlays, options);
        // // alert(control)

        // var sertifikatStyle = {
        //     "color": "#84ff00",
        //     "weight": 1,
        //     "opacity": 1
        // };
        // var nonSertifikatStyle = {
        //     "color": "#ff7700",
        //     "weight": 1,
        //     "opacity": 1
        // };

        // function getAsetSertifikat() {
        //     $.ajax({

        //         url: api,
        //         dataType: "json",
        //         async: false,
        //         success: function(result) {

        //             let inv = result.data
        //             // console.log(inv)
        //             $.each(inv, (i, property) => {
        //                 var id = property.id
        //                 var geo = property.geometry
        //                 console.log(id)
        //                 var status = property.status
        //                 if (geo !== null && status == 1) {
        //                     var x = JSON.parse(geo.polygon)
        //                     // console.log(geo.polygon)
        //                     // alert(geo)
        //                     // x.properties["id"] = id
        //                     console.log(x)
        //                     var layer = L.geoJSON(x, {
        //                         style: sertifikatStyle
        //                     })
        //                     layer.addTo(map)



        //                     layer.on('click', function() {

        //                         // alert(JSON.stringify(x.properties.id))
        //                         // function callDetail() {
        //                         //     $('#detailModal').modal('show');
        //                         //     $('#detailTitle').empty("")
        //                         //     $('#detailData').empty()

        //                         $.ajax({
        //                             url: api + "/" + id,
        //                             dataType: "json",
        //                             async: false,
        //                             success: function(result) {
        //                                 let inv = result.data
        //                                 $.each(inv, (i, property) => {

        //                                     const sertifikat = (property
        //                                             .status == 1) ?
        //                                         "Bersertifikat" :
        //                                         "Belum Bersertifikat";
        //                                     const hb = property
        //                                         .nilai_aset,
        //                                         na = property
        //                                         .nilai_aset,
        //                                         lt = property
        //                                         .luas,
        //                                         ns = property
        //                                         .nilai_aset

        //                                     // $('#detailTitle').append(
        //                                     //     'Aset Milik' + ' ' +
        //                                     //     property.master_skpd
        //                                     //     .nama)
        //                                     // $('#detailData').append(`
    //                                 var content = `<table class="table table-striped">
        //                                                                             <tr>
        //                                                                               <th>Pemilik Inventaris</th>
        //                                                                               <td>` + property.master_skpd.nama + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Nama Inventaris</th>
        //                                                                               <td>` + property.nama + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Kode Inventaris</th>
        //                                                                               <td>` + property.master_barang.kode_barang + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Tahun Perolehan</th>
        //                                                                               <td>` + property.tahun_perolehan + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Harga Beli</th>
        //                                                                               <td>` + `Rp ` + rupiah(hb) + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Nilai Aset</th>
        //                                                                               <td>` + `Rp ` + rupiah(na) + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Alamat</th>
        //                                                                               <td>` + property.alamat + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Luas Tanah</th>
        //                                                                               <td>` + rupiah(lt) +` Meter Persegi` + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>No Sertifikat</th>
        //                                                                               <td>` + property.no_dokumen_sertifikat + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Status</th>
        //                                                                               <td>` + sertifikat + `</td>
        //                                                                             </tr>
        //                                                                             <tr>
        //                                                                               <th>Nilai Saat Ini</th>
        //                                                                               <td>` + `Rp ` + rupiah(ns) + `</td>
        //                                                                             </tr>
        //                                                                         </table>`
    //                                 var popup = L.responsivePopup()
    //                                     .setContent(
    //                                         content)

    //                                 layer.bindPopup(popup)
    //                                     .openPopup();
    //                                 // `);
        //                                 })
        //                             }
        //                         })
        //                         // }
        //                         // callDetail()
        //                     });

        //                     map.on('overlayremove', function(eventLayer) {
        //                         if (eventLayer.name === " Tanah Bersertifikat") {
        //                             map.removeLayer(layer)
        //                         }
        //                     });
        //                 }
        //             })
        //         }
        //     })

        // };



        // function getAsetNonSertifikat() {
        //     $.ajax({

        //         url: api,
        //         dataType: "json",
        //         async: false,
        //         success: function(result) {

        //             let inv = result.data
        //             // console.log(inv)
        //             $.each(inv, (i, property) => {
        //                 var id = property.id
        //                 var geo = property.geometry
        //                 var status = property.status
        //                 if (geo !== null && status == 0) {
        //                     b
        //                     var x = JSON.parse(geo)
        //                     x.properties["id"] = id
        //                     var layer = L.geoJSON(x, {
        //                         style: nonSertifikatStyle
        //                     })
        //                     layer.addTo(map)
        //                     layer.on('click', function() {
        //                         function callDetail() {
        //                             $('#detailModal').modal('show');
        //                             $('#detailTitle').empty("")
        //                             $('#detailData').empty()

        //                             $.ajax({
        //                                 url: api + "/" + id,
        //                                 dataType: "json",
        //                                 async: false,
        //                                 success: function(result) {
        //                                     let inv = result.data
        //                                     $.each(inv, (i, property) => {

        //                                         const sertifikat = (property
        //                                                 .status == 1) ?
        //                                             "Bersertifikat" :
        //                                             "Belum Bersertifikat";
        //                                         const hb = property
        //                                             .nilai_aset,
        //                                             na = property
        //                                             .nilai_aset,
        //                                             lt = property
        //                                             .luas,
        //                                             ns = property
        //                                             .nilai_aset

        //                                         $('#detailTitle').append(
        //                                             'Aset Milik' + ' ' +
        //                                             property.master_skpd
        //                                             .nama)
        //                                         $('#detailData').append(`
    //                                 <table class="table table-striped">
    //                                 <tr>
    //                                   <th>Pemilik Inventaris </th>
    //                                   <td>` + property.master_skpd.nama + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Nama Inventaris </th>
    //                                   <td>` + property.nama + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Kode Inventaris </th>
    //                                   <td>` + property.master_barang.kode_barang + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Tahun Perolehan :</th>
    //                                   <td>` + property.tahun_perolehan + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Harga Beli </th>
    //                                   <td>` + `Rp ` + rupiah(hb) + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Nilai Aset </th>
    //                                   <td>` + `Rp ` + rupiah(na) + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Alamat </th>
    //                                   <td>` + property.alamat + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Luas Tanah </th>
    //                                   <td>` + rupiah(lt) + ` Meter Persegi` + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>No Sertifikat </th>
    //                                   <td>` + property.no_dokumen_sertifikat + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Status </th>
    //                                   <td>` + sertifikat + `</td>
    //                                 </tr>
    //                                 <tr>
    //                                   <th>Nilai Saat Ini </th>
    //                                   <td>` + `Rp ` + rupiah(ns) + `</td>
    //                                 </tr>
    //                             </table>
    //                                 `);
        //                                     })
        //                                 }
        //                             })
        //                         }
        //                         callDetail()
        //                     });
        //                     map.on('overlayremove', function(eventLayer) {
        //                         if (eventLayer.name === " Tanah Non Sertifikat") {
        //                             map.removeLayer(layer)
        //                         }
        //                     });
        //                 }
        //             })
        //         }
        //     })

        // };

        // map.on('overlayadd', function(eventLayer) {
        //     if (eventLayer.name === " Tanah Bersertifikat") {
        //         getAsetSertifikat();
        //     }
        //     if (eventLayer.name === " Tanah Non Sertifikat") {
        //         getAsetNonSertifikat();
        //     }
        //     console.log(eventLayer.name)
        // });

        // // console.log(overlays[0])
        // control.addTo(map)
        // L.control.betterscale().addTo(map);



        // var batasKota = {
        //     "color": "#ffe312",
        //     "weight": 2,
        //     "opacity": 1
        // };

        // var batas = new L.GeoJSON.AJAX("{{ asset('assets/leaflet/geojson/batas_kecamatan.json') }}", {
        //     style: batasKota,
        //     pmIgnore: true
        // });
        // batas.addTo(map)







        // map.on('pm:create', (e) => {
        //     var layer = e.layer,
        //         shape = e.shape,
        //         nf = Intl.NumberFormat();

        //     if (shape === 'Polygon') {

        //         var seeArea = turf.area(layer.toGeoJSON());
        //         var ha = seeArea / 10000;
        //         var content = "<table class='table table-striped table-bordered table-sm'>" +
        //             "<tr><th colspan='2'>Luas</th></tr>" +
        //             "<tr><td>" +
        //             nf.format(ha.toFixed(2)) + " Hektare" +
        //             "</td></tr>" +
        //             "<tr><td>" +
        //             nf.format(seeArea.toFixed(2)) + " Meter²" +
        //             "</td></tr>" +
        //             "</table>"

        //         layer.bindPopup(content);
        //         var g = JSON.stringify(layer.toGeoJSON())
        //         // var g = JSON.parse(g)
        //         // let gdb = JSON.stringify(g.geometry)

        //         // console.log(g)
        //     }

        //     console.log(JSON.stringify(layer.toGeoJSON()))
        //     // NewClass.pm.enable()
        // })
        // // membuat control sendiri

        // L.Control.Watermark = L.Control.extend({
        //     onAdd: function(map) {
        //         var img = L.DomUtil.create('img')
        //         img.src = '{{ asset('assets/logo-image/logo-center-bpkad-yellow.png') }}'
        //         img.style.width = '250px'
        //         // img.style.margin = '50px'

        //         return img;
        //     },

        //     onRemove: function(map) {
        //         // Nothing to do here
        //     }
        // });

        // L.control.watermark = function(opts) {
        //     return new L.Control.Watermark(opts);
        // }

        // L.control.watermark({
        //     position: 'topleft'
        // }).addTo(map);
        // L.control.zoom().addTo(map)
        // map.pm.addControls({
        //     drawMarker: true,
        //     drawCircleMarker: false,
        //     drawPolyline: false,
        //     drawRectangle: true,
        //     drawPolygon: true,
        //     drawCircle: false,
        //     cutPolygon: false,
        //     rotateMode: false,
        //     editControls: true,
        // });


        // // context menu

        // function showCoordinates(e) {
        //     alert(e.latlng);
        // }

        // function centerMap(e) {
        //     map.panTo(e.latlng);
        // }

        // function zoomIn(e) {
        //     map.zoomIn();
        // }

        // function zoomOut(e) {
        //     map.zoomOut();
        // }

        // // sidebar v2
        // // var sidebar = L.control.sidebarV2('sidebarV2', {
        // //     position: "right"
        // // }).addTo(map);

        // L.Control.textbox = L.Control.extend({
        //     onAdd: function(map) {

        //         var text = L.DomUtil.create('div');
        //         text.id = "info_text";
        //         text.innerHTML = "<strong>koselamase</strong>"
        //         return text;
        //     },

        //     onRemove: function(map) {
        //         // Nothing to do here
        //     }
        // });
        // L.control.textbox = function(opts) {
        //     return new L.Control.textbox(opts);
        // }
        // L.control.textbox({
        //     position: 'topleft'
        // }).addTo(map);

        // //leaflet search
        // function searchByAjax(text, callResponse) //callback for 3rd party ajax requests
        // {
        //     var q = text
        //     console.log(q)
        //     return $.ajax({
        //         url: api + '/' + q +
        //             '/search',
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function(json) {
        //             const x = json.data
        //             $.each(x, (i, property) => {
        //                 property.point = [property.geometry.lat, property.geometry.lng]
        //                 property['name'] = property.master_skpd.nama + " - " + property.nama
        //             })
        //             callResponse(x);
        //         }
        //     });
        // }
        // map.addControl(new L.Control.Search({
        //     sourceData: searchByAjax,
        //     propertyLoc: 'point',
        //     propertyName: 'name',
        //     filterData: function(text, records) {
        //         return (records);
        //     },
        //     text: 'Lokasi',
        //     markerLocation: true
        // }));
    </script>


@stop
