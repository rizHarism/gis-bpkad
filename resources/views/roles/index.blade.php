@extends('adminlte::page')

@section('title', 'Dashboard | Roles')

@section('content_header')
    <div class="h1 ">Roles</div>
@stop

@section('content')
<div class="container-fluid pb-5 ps-3 pe-3">
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>
    <hr />
    <table class="table table-striped table-hover table-bordered order-column" id="roles-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
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
        var table = $('#roles-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('roles.datatables') }}",
                method: "GET"
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'id', render: function (data){
                    var editUrl = "{{ route('roles.edit', ':id') }}";
                    editUrl = editUrl.replace(':id', data);

                    var deleteUrl = "{{ route('roles.destroy', ':id') }}";
                    deleteUrl = deleteUrl.replace(':id', data);

                    var editButton = "<a class='btn btn-default' href='" + editUrl + "'>Edit</a>";
                    var deleteButton = "<button class='btn btn-default btn-delete' data-url='" + deleteUrl + "'>Delete</button>";
                    var button = editButton + " " + deleteButton;

                    return button;
                }}
            ]
        });

        $(document).on("click","button.btn-delete",function() {
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
                        for (var i = 0; i < xhr.responseJSON.errors[item].length; i++) {
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
