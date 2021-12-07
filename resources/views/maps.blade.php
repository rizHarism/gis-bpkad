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
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Layers.Tree.js') }}"></script>
    <script src="{{ asset('assets/swal2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/inventaris/maps.js') }}"></script>

@stop
