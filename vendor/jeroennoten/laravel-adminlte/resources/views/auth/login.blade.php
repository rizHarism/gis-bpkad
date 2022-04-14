@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">

@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

{{-- @section('auth_header', __('adminlte::adminlte.login_message')) --}}

@section('auth_body')
    <style>
        body {
            background: url("{{ asset('assets/logo-image/background.jpg') }}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: 100%;
        }

        .form-box {
            background-color: rgba(0, 0, 0, 0.1);
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

    <form action="{{ $login_url }}" method="post">
        @csrf


        <div class="input-group mb-3">
            <input type="username" name="username" class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username') }}" placeholder="{{ __('adminlte::adminlte.username') }}" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="{{ __('adminlte::adminlte.password') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span id="eye" class="fas fa-eye-slash {{ config('adminlte.classes_auth_icon', '') }}"
                        onmousedown="showPass()" onmouseup="hidePass()"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label for="remember">
                        {{ __('adminlte::adminlte.remember_me') }}
                    </label>
                </div>
            </div>

            <div class="col-5">
                <button type=submit
                    class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>

    </form>
    <script>
        function showPass() {
            var x = document.getElementById("password");
            var y = document.getElementById("eye");
            // if (x.type === "password") {
            // x.type = "text";
            // y.className = "fas fa-eye {{ config('adminlte.classes_auth_icon', '') }}"
            // } else {
            x.type = "text";
            y.className = "fas fa-eye {{ config('adminlte.classes_auth_icon', '') }}"

            // }
        }

        function hidePass() {
            var x = document.getElementById("password");
            var y = document.getElementById("eye");
            // if (x.type === "password") {
            // x.type = "text";
            // y.className = "fas fa-eye {{ config('adminlte.classes_auth_icon', '') }}"
            // } else {
            x.type = "password";
            y.className = "fas fa-eye-slash {{ config('adminlte.classes_auth_icon', '') }}"

            // }
        }
    </script>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    {{-- @if ($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif --}}

    {{-- Register link --}}
    {{-- @if ($register_url)
        <p class="my-0">
            <a href="{{ $register_url }}">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif --}}
@stop

@section('css')
    <style>
        body {
            background-color: yellow;
        }

    </style>
    {{-- <link rel="stylesheet" href="{{ asset('assets/datatables/table.css') }}"> --}}

@stop
