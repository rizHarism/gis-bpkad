@extends('adminlte::page')

@section('title', 'Dashboard | Simantab')

@section('content_header')
    <div class="mb-0"></div>
@stop

@section('content')
    <div class="container-fluid pb-5 ps-3 pe-3">
        <div class="card">
            <h5 class="card-header">Data SKPD</h5>
            <div class="card-body">
                <a href="{{ route('dataopd.create') }}" class="btn btn-primary">+ Data OPD</a>
                <hr />
                <table class="table table-striped table-hover table-bordered order-column" id="master_skpd">
                    <thead>
                        <tr>
                            <th>No</th>
                            {{-- <th>Id Master Barang</th> --}}
                            <th>Kode SKPD</th>
                            <th>Nama SKPD</th>
                            <th>Aksi</th>
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
    {{-- <script src="{{ asset('assets/leaflet/core/leaflet-src.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-providers.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin//js/L.Control.Layers.Minimap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/Control.MiniMap.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.Basemaps.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/L.Control.BetterScale.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/styledLayerControl.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet-geoman.min.js') }}"></script>
    <script src="{{ asset('assets/leaflet/plugin/js/leaflet.contextmenu.js') }}"></script>
    <script src="{{ asset('assets/inventaris/kib_a.js') }}"></script> --}}
    <script>
        $(function() {
            var table = $('#master_skpd').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/api/skpd',
                    method: "GET"
                },
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    // {
                    //     data: 'id_barang'
                    // },
                    {
                        data: 'kode_skpd'
                    },
                    {
                        data: 'nama_skpd'
                    },
                    {
                        data: 'id_skpd',
                        render: function(data) {
                            var editUrl = "{{ route('dataopd.edit', ':id') }}";
                            editUrl = editUrl.replace(':id', data);

                            var deleteUrl = "{{ route('dataopd.destroy', ':id') }}";
                            deleteUrl = deleteUrl.replace(':id', data);

                            var editButton = "<a class='btn btn-success' href='" + editUrl +
                                "'><i class='fas fa-edit'></i> Edit</a>";
                            var deleteButton =
                                "<button class='btn btn-danger btn-delete' data-url='" +
                                deleteUrl + "'><i class='fas fa-trash-alt'></i> Delete</button>";
                            var button = editButton + " " + deleteButton;

                            return button;
                        }
                    }

                ],

            });

            $(document).on("click", "button.btn-delete", function() {
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
                        alert(data);
                        table.draw();
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
            });
        });
    </script>
@stop
