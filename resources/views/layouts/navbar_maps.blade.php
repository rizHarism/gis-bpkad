<div id="sidebarV2" class="sidebarV2 collapsed " style=" margin-bottom: 100px; margin-right: 5px">
    <!-- Nav tabs -->
    <div class="sidebarV2-tabs">
        <ul role="tablist">
            <li><a href="#layers" role="tab"><i class="fas fa-layer-group"></i></a></li>
            <li><a href="#query" role="tab"><i class="fas fa-database"></i></a></li>
            <li><a href="#profile" role="tab"><i class="fa fa-user"></i></a></li>
            <li><a href="#information" role="tab"><i class="fas fa-info-circle"></i></a></li>
            <li><a href="/dashboard" role="tab"><i class="fa fa-cog"></i></a></li>
        </ul>

        <ul role="tablist">
            <li><a href="#information" role="tab"><i class="fas fa-info-circle"></i></a></li>
        </ul>
    </div>

    <!-- Tab panes -->
    <div class="sidebarV2-content">
        <div class="sidebarV2-pane" id="layers">
            <h1 class="sidebarV2-header">
                Si-Mantab
                <span class="sidebarV2-close"><i class="fa fa-caret-right"></i></span>
            </h1>
        </div>

        <div class="sidebarV2-pane" id="query">
            <h1 class="sidebarV2-header">Query Pencarian<span class="sidebarV2-close"><i
                        class="fa fa-caret-right"></i></span>
            </h1>

            <div class="container-fluid">
                <p class="mt-3">Query Pencarian adalah fitur pencarian geometry data aset berdasarkan SKPD
                    terkait
                    dan letak kelurahan
                </p>

                <form id="queryGeom">
                    <div class="form-check form-control-sm mt-3">
                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1"
                            checked>
                        <label class="form-check-label fw-bold" for="flexRadioDefault1">
                            Bersertifikat
                        </label>
                    </div>
                    <div class="form-check form-control-sm">
                        <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="0">
                        <label class="form-check-label fw-bold" for="flexRadioDefault2">
                            Non Sertifikat
                        </label>
                    </div>

                    <select class="form-select mt-3 form-control-sm fw-bold" aria-label="Default select example"
                        id="data_skpd">
                        <option selected>Semua SKPD</option>
                    </select>

                    <select class="form-select mt-3 form-control-sm fw-bold" aria-label="Default select example">
                        <option selected>Semua Kelurahan</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
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

{{-- <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col ">
                            <div id="detailData"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="openMap">Understood</button>
            </div>
        </div>
    </div>
</div> --}}
