<div id="sidebarV2" class="sidebarV2 collapsed " style=" margin-bottom: 100px; margin-right: 5px">
    <!-- Nav tabs -->
    <div class="sidebarV2-tabs">
        <ul role="tablist">
            <li><a href="#layers" role="tab"><i class="fas fa-layer-group"></i></a></li>
            <li><a href="#query" role="tab"><i class="fas fa-database"></i></a></li>
            <li><a href="#profile" role="tab"><i class="fa fa-user"></i></a></li>
            @if (auth()->user()->hasRole('Super-Admin'))
                <li><a href="/dashboard" role="tab"><i class="fa fa-cog"></i></a></li>
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
                        placeholder="Masukkan nama inventaris" />
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
                            <button type="button" id="clear" class="btn btn-secondary mt-4">Clear</button>
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
                    <img src="https://www.pngarts.com/files/6/User-Avatar-in-Suit-PNG.png" alt="Admin"
                        class="rounded-circle" width="150">
                    <div class="mt-3">

                        <h4>{{ Auth::user()->username }}</h4>
                        <p class="text-secondary mb-1">{{ Auth::user()->master_skpd->nama_skpd }}</p>
                        <hr>

                        <form method="POST" action="/logout">
                            {{ csrf_field() }}

                            <a href="#" class="btn btn-primary"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('adminlte::adminlte.log_out') }}
                            </a>
                        </form>
                    </div>
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
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div id="detailData"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="sertifikat" class="h4">
                                {{-- <iframe src="{{ asset('assets/document/03.KL.017 - STADION SUPRIYADI.pdf') }}"
                                    style="width: 100%;height: 63vh; position: relative;" allowfullscreen></iframe> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button> --}}
            </div>
        </div>
    </div>
</div>
