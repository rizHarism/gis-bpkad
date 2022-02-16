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
                <table class="table table-striped table-hover table-bordered order-column table-sm" id="master_skpd">
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
    {{-- swall --}}
    <script src="{{ asset('assets/swal/sweetalert2.js') }}"></script>
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
                            var id = data;

                            var deleteUrl = "{{ route('dataopd.destroy', ':id') }}";
                            deleteUrl = deleteUrl.replace(':id', data);

                            var editButton = "<a class='btn btn-success btn-sm' href='" + editUrl +
                                "'><i class='fas fa-edit fa-xs'></i> Edit</a>";
                            var deleteButton =
                                "<button class='btn btn-danger btn-delete btn-sm' data-url='" +
                                deleteUrl + "' data-value='" +
                                id + "'><i class='fas fa-trash-alt fa-xs'></i> Hapus</button>";
                            var button = editButton + " " + deleteButton;

                            return button;
                        }
                    }

                ],

            });

            $(document).on("click", "button.btn-delete", function() {
                var id = $(this).data('value');
                $.getJSON('opd/' + id, (result) => {
                    // let property = result;
                    console.log(result);
                    var confirmNama = result;
                    Swal.fire({
                        text: 'Hapus Data \"' +
                            confirmNama + '\"',
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
                                    if (data.value == 0) {
                                        Swal.fire(
                                            'Error',
                                            data.message,
                                            'warning',
                                        )
                                    } else if (data.value == 1) {
                                        Swal.fire(
                                            'Berhasil',
                                            data.message,
                                            'success',
                                        )
                                    }
                                    table.draw();
                                },
                                error: (xhr, ajaxOptions, thrownError) => {
                                    alert(xhr.responseJSON.message);
                                    if (xhr.responseJSON.hasOwnProperty(
                                            'errors')) {
                                        for (item in xhr.responseJSON.errors) {
                                            if (xhr.responseJSON.errors[item]
                                                .length) {
                                                for (var i = 0; i < xhr
                                                    .responseJSON.errors[
                                                        item]
                                                    .length; i++) {
                                                    alert(xhr.responseJSON
                                                        .errors[item][i]);
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
        });
    </script>
@stop
