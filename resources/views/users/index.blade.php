@extends('adminlte::page')

@section('title', 'Administrator | Users Manajemen')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <h5 class="card-header">List User</h5>
            <div class="card-body">
                <a href="{{ route('users.create') }}" class="btn btn-primary">+ User</a>
                <hr />
                <table class="table table-striped table-hover table-bordered order-column table-sm" id="users-table"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Username</th>
                            {{-- <th>Email</th> --}}
                            <th>Nama SKPD</th>
                            <th>Role</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                </table>
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
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
    <script>
        $(function() {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.datatables') }}",
                    method: "GET"
                },
                columns: [{
                        data: "DT_RowIndex",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'username'
                    },
                    // {
                    //     data: 'email'
                    // },
                    {
                        data: 'master_skpd.nama_skpd'
                    },
                    {
                        data: 'roles[0].name'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            var editUrl = "{{ route('users.edit', ':id') }}";
                            editUrl = editUrl.replace(':id', data);

                            var deleteUrl = "{{ route('users.destroy', ':id') }}";
                            deleteUrl = deleteUrl.replace(':id', data);

                            var editButton = "<a class='btn btn-success btn-sm' href='" + editUrl +
                                "'><i class='fas fa-edit fa-xs'></i> Edit</a>";
                            var deleteButton =
                                "<button class='btn btn-danger btn-delete btn-sm' data-url='" +
                                deleteUrl +
                                "'><i class='fas fa-trash-alt fa-xs'></i> Delete</button>";
                            var button = editButton + " " + deleteButton;

                            return button;
                        }
                    }
                ]
            });

            $(document, '#users-table tbody').on("click", "button.btn-delete", function() {
                var data = table.row($(this).parents('tr')).data()
                var name = data['username'];
                // console.log(data);
                Swal.fire({
                    text: 'Hapus User \"' +
                        name + '\"',
                    title: ' Apakah Anda yakin ?',
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
                            url: $(this).data('url'),
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: (data) => {
                                // alert(data);
                                Swal.fire(
                                    'Berhasil',
                                    data,
                                    'success',
                                )
                                table.draw();
                            },
                            error: (xhr, ajaxOptions, thrownError) => {
                                alert(xhr.responseJSON.message);
                                if (xhr.responseJSON.hasOwnProperty('errors')) {
                                    for (item in xhr.responseJSON.errors) {
                                        if (xhr.responseJSON.errors[item].length) {
                                            for (var i = 0; i < xhr.responseJSON.errors[
                                                    item]
                                                .length; i++) {
                                                alert(xhr.responseJSON.errors[item][i]);
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
