@extends('adminlte::page')

@section('title', 'Administrator | Manajemen Roles')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    <?php $editable = isset($role); ?>
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <form id="edit-form" method="POST" class="form-horizontal"
                action="{{ $editable ? route('roles.update', ['role' => $role['id']]) : route('roles.store') }}">
                @method('PUT')
                {{ csrf_field() }}
                <h5 class="card-header">{{ $editable ? 'Edit Role' : 'Tambah Role' }}</h5>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" id="name" placeholder="name"
                                value="{{ $editable ? $role['name'] : '' }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="permissions" class="col-sm-2 col-form-label">Permissions</label>
                        <div class="col-sm-10">
                            <div class="row">
                                @foreach ($permissionsFormatted as $key => $permissionNames)
                                    <div class="col-sm-4" style="margin-bottom: 20px;">
                                        <span>{{ strtoupper($key) }}</span><br />
                                        @foreach ($permissionNames as $i => $permission)
                                            <div class="custom-control custom-checkbox">
                                                <input name="permission[]" class="custom-control-input" type="checkbox"
                                                    id="{{ $key . '-' . $permission['name'] . '-' . $i }}"
                                                    value="{{ $permission['value'] }}"
                                                    {{ $editable && in_array($permission['value'], $rolePermissions) ? 'checked="checked"' : '' }}>
                                                <label for="{{ $key . '-' . $permission['name'] . '-' . $i }}"
                                                    class="custom-control-label">{{ $permission['name'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">{{ $editable ? 'Simpan' : 'Simpan' }}</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-default float-right">Batal</a>
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
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    <script>
        $(function() {
            $("#edit-form").submit(function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    type: "{{ $editable ? 'PUT' : 'POST' }}",
                    url: $(this).attr('action'),
                    data: JSON.stringify({
                        name: $(this).find("input[name='name']").val(),
                        permission: $(this).find("input:checkbox:checked").map(function() {
                            return $(this).val();
                        }).get()
                    }),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        // alert(data);
                        swal.fire({
                            title: 'Berhasil',
                            text: data,
                            icon: 'success',
                        }).then(function() {
                            window.location = document.referrer;
                        });
                        // window.location = document.referrer;
                        // window.location = document.referrer;
                    },
                    error: (xhr, ajaxOptions, thrownError) => {
                        // alert(xhr.responseJSON.message);
                        if (xhr.responseJSON.hasOwnProperty('errors')) {
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
                return false;
            });
        });
    </script>
@stop
