<div class="container-fluid pb-5 ps-3 pe-3">
    <table class="table table-striped table-hover table-bordered order-column" id="inventaris_kib_a">
        <thead>
            <tr>
                <th>No</th>
                {{-- <th id="aksi">Aksi</th> --}}
                <th>Nama SKPD</th>
                {{-- <th>Kode Inventaris</th> --}}
                <th>Jenis Inventaris</th>
                <th>Nama Inventaris</th>
                <th>Alamat</th>
                <th>Status</th>
            </tr>
        </thead>
    </table>
</div>



{{-- <div class="modal fade" id="detailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col ">
                            ...
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
</div>

<div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col ">
                            <div id="">
                                <form>
                                    <div class="form-group form-group-sm">
                                        <div class="row align-items-center">
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputSkpd" class="form-label">Nama
                                                        SKPD</label>
                                                </div>
                                                <div class="col-10">
                                                    <select id="inputSkpd" class="form-select">
                                                        <option>Input SKPD</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputNamaInventaris" class="form-label">Nama
                                                        Inventaris</label>
                                                </div>
                                                <div class="col-9">
                                                    <select id="inputNamaInventaris" class="form-select ">
                                                        <option>Nama Inventaris</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputMasterBarang" class="form-label">Jenis
                                                        Inventaris</label>
                                                </div>
                                                <div class="col-9">
                                                    <select id="inputMasterBarang" class="form-select">
                                                        <option>Jenis Inventaris</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputTahunPerolehan" class="form-label">Tahun
                                                        Perolehan</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="inputTahunPerolehan" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputHargaBeli" class="form-label">Harga
                                                        Beli</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="inputHargaBeli"
                                                        class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputNilaiAset" class="form-label">Nilai
                                                        Aset</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="inputNilaiAset"
                                                        class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputAlamat" class="form-label">Alamat</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="inputNilaiAlamat"
                                                        class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputLuas" class="form-label">Luas
                                                        Tanah</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="inputNilaiLuas"
                                                        class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="inputNoSertifikat" class="form-label">Nomor
                                                        Sertifikat</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="inputNoSertifikat"
                                                        class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="tglSertifikat" class="form-label">Tanggal
                                                        Sertifikat</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="tglSertifikat" class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="statusSertifikat" class="form-label">Status</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="statusSertifikat"
                                                        class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="sumberDana" class="form-label">Sumber Dana</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="sumberDana" class="form-control input-sm">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2">
                                                    <label for="nilaiSekarang" class="form-label">Nilai Saat
                                                        Ini</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" id="nilaiSekarang"
                                                        class="form-control form-control-sm">
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
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
</div>

<div class="modal fade" id="mapModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapTittle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="co">
                        <div class="row">
                            ...
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


<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTitle">Inventaris Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- tabs --}}
                <div class="container-fluid">
                    <div class="card">
                        {{-- <h5 class="card-header">Featured</h5> --}}
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                        aria-selected="true">Peta</button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false">Detail</button>
                                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-contact" type="button" role="tab"
                                        aria-controls="nav-contact" aria-selected="false">Dokumen</button>
                                </div>
                            </nav>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <div class="mt-2" id="mapDetail">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <div class="mt-2" id="detailData">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                    aria-labelledby="nav-contact-tab">
                                    <div class="mt-2" id="dokumen">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Peta</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Detail</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Dokumen</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <div id="mapDetail">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div id="detailData">

                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        ...</div>
                </div> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container-fluid">

                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            {{-- <img src="..." class="d-block w-100" alt="..."> --}}
                        </div>
                        <div class="carousel-item">
                            {{-- <img src="..." class="d-block w-100" alt="..."> --}}
                        </div>
                        <div class="carousel-item">
                            {{-- <img src="..." class="d-block w-100" alt="..."> --}}
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Understood</button>
        </div>
    </div>
</div>
