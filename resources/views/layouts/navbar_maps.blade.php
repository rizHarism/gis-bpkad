<div id="sidebarV2" class="sidebarV2 collapsed " style=" margin-bottom: 100px; margin-right: 5px">
    <!-- Nav tabs -->
    <div class="sidebarV2-tabs">
        <ul role="tablist">
            <li><a href="#layers" title="Layer Wilayah" role="tab"><i class="fas fa-layer-group"></i></a></li>
            <li><a href="#query" title="Pencarian Aset" role="tab"><i class="fas fa-search"></i></a></li>
            <li><a href="#profile" title="Profil Pengguna" role="tab"><i class="fas fa-user-cog"></i></a></li>
            @if (auth()->user()->hasRole('Super-Admin'))
                <li><a href="/dashboard" title="Admin Dashboard" role="tab"><i class="fas fa-sign-in-alt"></i></a></li>
            @endif
        </ul>

        <ul role="tablist">
            <li><a href="#information" role="tab"><i class="fas fa-info-circle"></i></a></li>
        </ul>
    </div>

    <!-- Tab panes -->
    <div class="sidebarV2-content">
        <div class="sidebarV2-pane" id="layers">
            <h1 class="sidebarV2-header">
                Layer Wilayah dan Aset BMD
                <span class="sidebarV2-close"><i class="fa fa-caret-right"></i></span>
            </h1>
        </div>

        <div class="sidebarV2-pane" id="query">
            <h1 class="sidebarV2-header">Query Pencarian<span class="sidebarV2-close"><i
                        class="fa fa-caret-right"></i></span>
            </h1>

            <div class="container-fluid">
                {{-- <div class=" form-control-sm mt-3"> --}}
                <div class="form-group form-group-sm mt-3">
                    <label class="fw-bold" style="font-size: 14px">
                        PENCARIAN ASET SATUAN
                    </label>
                    <input type="text" name="inventarisSearch" id="inventarisSearch" class="form-control input-lg"
                        placeholder="Masukkan nama inventaris / Dinas" autocomplete="off" />
                    <div id="inventarisList">
                    </div>
                </div>
                {{-- </div> --}}
            </div>
            <hr>
            {{-- <p class="mt-3">Pencarian geometry bidang tanah aset berdasarkan SKPD terkait, kelurahan dan
                    sertifikat
                </p> --}}
            <div class="container-fluid">

                <div class="form-check form-control-sm mt-3">
                    <input class="form-check-input" type="radio" name="varQuery" id="queryOpd1" value="opd" checked>
                    <label class="form-check-label fw-bold" for="queryOpd1">
                        PENCARIAN BERDASARKAN OPD PENGELOLA
                    </label>
                </div>
                <div class="form-check form-control-sm">
                    <input class="form-check-input" type="radio" name="varQuery" id="queryOpd2" value="sertifikat">
                    <label class="form-check-label fw-bold" for="queryOpd2">
                        PENCARIAN BERDASARKAN NOMOR SERTIFIKAT
                    </label>
                </div>
            </div>
            <div class="container-fluid">

                {{-- <hr> --}}


                <form method="POST" id="queryGeom">
                    {{ csrf_field() }}
                    <div id="varChange" class="mt-3">
                        <label for="">Pilih OPD</label>
                        <select class="form-select form-control-sm fw-bold" aria-label="Default select example"
                            id="dataSkpd">
                            <option selected>Semua OPD</option>
                        </select>

                        {{-- <input class="mt-3 form-control form-control-sm fw-bold" type="number" name="noSertifikat"
                            id="noSertifikat"> --}}
                    </div>
                    <div id="kelChange" class="mt-2">
                        <label for="">Pilih Kelurahan</label>
                        <select class="form-select form-control-sm fw-bold" aria-label="Default select example"
                            id="data_kelurahan">
                            <option selected>Semua Kelurahan</option>

                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-3 align-center">
                            <button type="" class="btn btn-primary mt-4">Cari</button>
                        </div>
                        <div class="col-md-3 align-center">
                            <button type="button" id="clear" class="btn btn-secondary mt-4">Hapus</button>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <hr> --}}
        </div>

        <div class="sidebarV2-pane" id="profile">
            <h1 class="sidebarV2-header">Profile<span class="sidebarV2-close"><i class="fa fa-caret-right"></i></span>
            </h1>
            <div class="container-fluid mt-5">

                <div class="d-flex flex-column align-items-center text-center">
                    <img id="avatar-image2" src="{{ asset('assets/avatar/' . Auth::user()->avatar) }}" alt="Admin"
                        class="rounded-circle" width="150" height="150" style="cursor:pointer">
                    <div class="mt-3">

                        <h4>{{ Auth::user()->username }}</h4>
                        <p class="text-secondary mb-1">{{ Auth::user()->master_skpd->nama_skpd }}</p>
                        <hr>

                        <div class="row">
                            <div class="col">
                                <a data-target="#editProfile" data-toggle="modal" href="#editModal"
                                    class="btn btn-success"> &nbsp; Edit &nbsp;</a>
                            </div>
                            <div class="col">
                                <form method="POST" action="/logout">
                                    {{ csrf_field() }}

                                    <a href="#" class="btn btn-danger"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('adminlte::adminlte.log_out') }}
                                    </a>
                                </form>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        {{-- modal edit profile --}}
        <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="editProfile" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileTitle">Edit Profile</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" onclick="defaultAvatar()"
                            aria-label="Tutup"></button>
                    </div>

                    <form id="editProfile-form" method="POST" class="form-horizontal" name="invent"
                        action="{{ route('users.selfupdate', ['user' => Auth::user()->id]) }}"
                        enctype="multipart/form-data">
                        {{-- @method('PUT') --}}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="file-input">
                                        <a title="Edit Foto">
                                            <img id="avatar-image"
                                                src="{{ asset('assets/avatar/' . Auth::user()->avatar) }}" alt="Admin"
                                                class="rounded-circle" width="150" height="150" style="cursor:pointer">
                                        </a>
                                    </label>
                                    <p class="" style="font-style: italic; font-size: 12px">
                                        *klik untuk merubah foto</p>
                                    <input id="file-input" type="file" style="display: none;" />
                                    {{-- <p>klik foto untuk mengubah</p> --}}
                                </div>
                                <div class="col-md-8 d-flex align-items-center">
                                    <div class="form-group mt-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"
                                                id="inputGroup-sizing-default">Username</span>
                                            <input type="text" id="username" class="form-control"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default"
                                                value="{{ Auth::user()->username }}"
                                                placeholder="Masukkan nama pengguna baru">
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-default">&nbsp;Password
                                            </span>
                                            <input type="password" id="password" class="form-control"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-default"
                                                placeholder="Masukkan kata sandi baru">
                                            <p class="ms-4" style="font-style: italic; font-size: 12px">
                                                *kosongkan isian jika tidak ingin
                                                merubah password</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="defaultAvatar()"
                                data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="sidebarV2-pane" id="information">
            <h1 class="sidebarV2-header">Informasi Aplikasi<span class="sidebarV2-close"><i
                        class="fa fa-caret-right"></i></span>
            </h1>
        </div>

        <div class="sidebarV2-pane" id="settings">
            <h1 class="sidebarV2-header">Settings<span class="sidebarV2-close"><i class="fa fa-caret-right"></i></span>
            </h1>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTitle">Modal title</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div id="detailData"></div>
                            <div class="modalMap">
                                <div id="minimap" class="h4" style="height: 20vh"></div>
                            </div>
                        </div>
                        <div class="col-md-6" style="">
                            <div id="sertifikat" class="h4" style="20">
                                {{-- <iframe src="{{ asset('assets/document/03.KL.017 - STADION SUPRIYADI.pdf') }}"
                                    style="width: 100%;height: 63vh; position: relative;" allowfullscreen></iframe> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
            </div>
        </div>
    </div>
</div>
