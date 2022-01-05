@extends('adminlte::page')

{{-- @section('title', 'Dashboard | Users') --}}
@section('title', 'Data Dasar | OPD')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <form id="edit-form" method="POST" class="form-horizontal"
                action="{{ isset($edit) ? route('dataopd.update', ['user' => $edit]) : route('dataopd.store') }}">
                @method('PUT')
                {{ csrf_field() }}
                <h5 class="card-header">Data OPD</h5>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                value="">
                        </div>
                    </div>
                    {{-- <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" name="username" class="form-control" id="username" placeholder="Username"
                                value="{{ $edit['username'] ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                value="{{ $edit['email'] ?? '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password" value="">
                            <span>{{ isset($edit) ? 'Fill blank if you don\'t want to change the password' : '' }}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="skpd" class="col-sm-2 col-form-label">SKPD</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="skpd" id="skpd">
                                <option value="">Pilih SKPD</option>
                                @foreach ($skpd as $_skpd)
                                    <option value="{{ $_skpd['id_skpd'] }}"
                                        {{ isset($edit) && $edit['skpd_id'] == $_skpd['id_skpd'] ? 'selected="selected"' : '' }}>
                                        {{ $_skpd['kode_skpd'] . ' - ' . $_skpd['nama_skpd'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-select " name="role" id="">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $_role)
                                    <option value="{{ $_role['id'] }}"
                                        {{ isset($edit) && !is_null($role) && $role['id'] == $_role['id'] ? 'selected="selected"' : '' }}>
                                        {{ $_role['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Submit</button>
                    <a href="{{ route('users.index') }}" class="btn btn-default float-right">Cancel</a>
                </div>
                <!-- /.card-footer -->
            </form>
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
    <script>
        $(function() {
            $("#edit-form").submit(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "{{ isset($edit) ? 'PUT' : 'POST' }}",
                    url: $(this).attr('action'),
                    data: JSON.stringify({
                        username: $(this).find("input[name='username']").val(),
                        email: $(this).find("input[name='email']").val(),
                        password: $(this).find("input[name='password']").val(),
                        skpd: $(this).find("select[name='skpd']").val(),
                        role: $(this).find("select[name='role']").val()
                    }),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        alert(data);
                        window.location = document.referrer;
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        alert(xhr.responseJSON.message);
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
                            for (item in xhr.responseJSON.errors) {
                                if (xhr.responseJSON.errors[item].length) {
                                    for (var i = 0; i < xhr.responseJSON.errors[item]
                                        .length; i++) {
                                        alert(xhr.responseJSON.errors[item][i]);
                                    }
                                }
                            }
                        }
                    }
                });
                return false;
            });
        });
    </script>
@stop
