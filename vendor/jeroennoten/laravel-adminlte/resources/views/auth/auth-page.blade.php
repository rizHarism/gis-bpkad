@extends('adminlte::master')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <style>
        .form-box {
            background-color: rgba(0, 0, 0, 0.3);
            margin: auto auto;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px #000;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 500px;
            height: 430px;
        }

    </style>
    {{-- <div class="form-box"> --}}
    <div class="{{ $auth_type ?? 'login' }}-box">



        {{-- Card Box --}}
        <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}"
            style="background-color: rgba(0, 0, 0, 0.3)">

            {{-- Card Header --}}
            @hasSection('auth_header')
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}"
                    style="background-color: rgba(0, 0, 0, 0.3);">
                    {{-- Logo --}}
                    <div class="{{ $auth_type ?? 'login' }}-logo">
                        <a href="{{ $dashboard_url }}">
                            <img src="{{ asset(config('adminlte.logo_img')) }}" height="50">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                    </div>
                    <hr>
                    <h3 class="card-title float-none text-center">
                        @yield('auth_header')
                    </h3>
                </div>
            @endif

            {{-- Card Body --}}
            <div class="card-body {{ $auth_type ?? 'login' }}-card-body {{ config('adminlte.classes_auth_body', '') }}"
                style="background-color: rgba(0, 0, 0, 0.3)">
                @yield('auth_body')
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}"
                    style="background-color: rgba(0, 0, 0, 0.3)">
                    @yield('auth_footer')
                </div>
            @endif

        </div>

    </div>
    {{-- </div> --}}
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
