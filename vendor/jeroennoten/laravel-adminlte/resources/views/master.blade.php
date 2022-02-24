<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    <link rel="stylesheet" href="{{ asset('assets/leaflet/core/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/control.layers.minimap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/Control.MiniMap.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/L.Control.Basemaps.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/L.Control.BetterScale.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/styledLayerControl.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/leaflet-geoman.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/leaflet.contextmenu.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/leaflet-search.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/leaflet.responsive.popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/L.Control.Layers.Tree.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/leaflet-sidebar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/leaflet/plugin/css/leaflet.zoomhome.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        html,
        body #map-container {
            height: 100%;
        }

        #maps {
            /* position: absolute; */
            /* width: 100%; */
            display: block;
            position: absolute;
            height: auto;
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;
            margin-top: 0;
            margin-bottom: 0;
        }

        .leaflet-touch .leaflet-control-layers,
        .leaflet-touch .leaflet-bar {
            border: 50px none rgba(102, 13, 13, 0.2);
            background-clip: padding-box;
        }

        @keyframes fade {
            from {
                opacity: 0.5;
            }
        }

        .blinking {
            animation: fade 1s infinite alternate;
        }

    </style>

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">


        {{-- css bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>


        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        {{-- datatables css --}}
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> --}}
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

    {{-- Leaflet - geoman - turf - css & js --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script> --}}
    <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
    {{-- <link rel="stylesheet" href="{{ asset('assets/leaflet-geoman.css') }}" /> --}}
    {{-- <script src="{{ asset('assets/leaflet-geoman.min.js') }}"></script> --}}
    {{-- jquery contextmenu --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}


    <style>
        .input-xs {
            height: 22px;
            padding: 2px 5px;
            font-size: 12px;
            line-height: 1.5;
            /* If Placeholder of the input is moved up, rem/modify this. */
            border-radius: 3px;
        }

    </style>

    <style type="text/css">
        .overlayLoader {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            /* background: rgba(61, 37, 37, 0.8) url("https://c.tenor.com/I6kN-6X7nhAAAAAj/loading-buffering.gif") center no-repeat; */
            background: rgba(90, 94, 91, 0.35) url("{{ 'asset(assets/logo-image/preloader.gif)' }}") center no-repeat;
            /* background: rgba(255, 255, 255, 0.8) url("{{ asset('assets/logo-image/loader.gif') }}") center no-repeat; */
        }

        /* body {
            text-align: center;
        } */

        /* Turn off scrollbar when body element has the loading class */
        /* body.loading {
            overflow: hidden;
        } */

        /* Make spinner image visible when body element has the loading class */
        body.loading .overlayLoader {
            display: block;
        }

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(90, 94, 91, 0.809);
        }

        .preloader .loading {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font: 14px arial;
        }

    </style>

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}

    {{-- preloader --}}
    <div class="overlayLoader" width="500"></div>
    <div class="preloader">
        <div class="loading">
            <img src={{ asset('assets/logo-image/preloader.gif') }}>
        </div>
    </div>


    @yield('body')
    {{-- Base Scripts --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.contextMenu.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>

        {{-- jquery datatables --}}
        {{-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}
        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
