{{-- @extends('adminlte::auth.login') --}}
@extends('adminlte::master')
@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@section('body')
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            /* font-family: sans-serif; */
            /* background-position: center; */
            background: url('assets/logo-image/login-bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;

        }

        .form-box {
            background-color: rgba(0, 0, 0, 0.4);
            margin: auto auto;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 0 10px rgb(214, 203, 203);
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 500px;
            height: 430px;
        }

        .login-box {
            width: 280px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #d7e6d8;
        }

        .login-box h1 {
            float: left;
            font-size: 20px;
            border-bottom: 6px solid #2c6c2f;
            margin-bottom: 50px;
            padding: 13px 0;
        }

        .textbox {
            width: 100%;
            overflow: hidden;
            font-size: 20px;
            padding: 8px 0;
            margin: 8px 0;

        }

        .textbox i {
            width: 26px;
            float: right;
            text-align: center;
            color: #d7e6d8;
            /* border: rgb(235, 225, 225) */
        }

        .textbox input {
            border: none;
            outline: none;
            background: none;
            color: #d7e6d8;
            font-size: 18px;
            width: 80%;
            float: left;
            margin: 0 10px;
            border-bottom: 1px solid #2c6c2f;
        }

        .invalid-feedback {

            padding-left: 10px;
            font-size: 10px;
        }

        .btn {
            width: 100%;
            background: rgb(15, 138, 56);
            border: 2px solid #2c6c2f;
            color: #d7e6d8;
            padding: 5px;
            font-size: 18px;
            cursor: pointer;
            margin: 12px 0;
        }

        .btn:hover {
            background: rgb(22, 167, 70);
            cursor: pointer;
            color: #000;
        }

        .logo {
            font-size: 1.5vh;
            font-style: italic;
            margin-left: 40px;
            margin-top: 30px;
            color: #f7faf7;
        }

        .logo span {
            font-size: 3vh;
            font-weight: bold;
            padding: 50px, 50px;
            margin-left: 5px;
            top: 50%;
        }

        .logo img {
            margin-top: -10px;
            height: 42px;
            width: 34px;
        }

    </style>

    {{-- <div class="logo container"> --}}
    <div class="container-fluid">
        <div class="logo">
            <div class="row">
                <div class="col-md-4">
                    <img class="img-responsive" src="{{ asset('assets/logo-image/blitar.png') }}" alt=""> <label><span> GIS
                            Aset Kota
                            Blitar
                        </span></label>
                    <hr class="mt-0 mb-0" style="width:70%;">
                    <p class="mb-0 mt-1">Badan Pendapatan Keuangan dan Aset Daerah</p>
                    <p class="mt-0">Kota Blitar</p>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}

    <div class="form-box">
        <form action="{{ $login_url }}" method="post">
            @csrf
            <div class="login-box">
                <h1> Halaman Login</h1>
                <div class="textbox">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="{{ __('adminlte::adminlte.username') }}"
                        class=" @error('username') is-invalid @enderror" autocomplete="off" required>

                    @error('username')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="textbox">
                    <i id="eye" class="fas fa-eye-slash" onmousedown="showPass()" onmouseup="hidePass()"></i>
                    <input id="password" type="password" name="password"
                        placeholder="{{ __('adminlte::adminlte.password') }}"
                        class=" @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>

                <button type=submit
                    class="btn btn-block mt-5 {{ config('adminlte.classes_auth_btn', 'btn-flat btn-success') }}">

                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>

        </form>
    </div>
    <script>
        function showPass() {
            var x = document.getElementById("password");
            var y = document.getElementById("eye");

            x.type = "text";
            y.className = "fas fa-eye ";

        }

        function hidePass() {
            var x = document.getElementById("password");
            var y = document.getElementById("eye");

            x.type = "password";
            y.className = "fas fa-eye-slash";
        }
    </script>
@stop
