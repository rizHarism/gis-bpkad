<section class="content">
    <div class="container-fluid">
        <div class="card">
            <h5 class="card-header">Edit Inventaris</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7">
                        <div id="map" style="min-height: 500px; height:600px ;max-height: 1000px"></div>
                    </div>

                    <div class="col-md-5 mb-0 fw-normal">
                        <div class="container-fluid ms-3">
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic m">Nama :</label>
                                <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1"
                                    placeholder="">
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic">Tahun Perolehan
                                    :</label>
                                <select class="form-select" aria-label="Default select example">
                                    {{ $last = date('Y') - 120 }}
                                    {{ $now = date('Y') }}

                                    @for ($i = $now; $i >= $last; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic">Nilai Aset :</label>
                                <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1"
                                    placeholder="">
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic ">Alamat :</label>
                                <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1"
                                    placeholder="">
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic ">Kelurahan :</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic ">Kecamatan :</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic">No Sertifikat :</label>
                                <input type="text" class="form-control form-control-sm" id="exampleFormControlInput1"
                                    placeholder="">
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic">SKPD Pengelola :</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="mb-2 me-5 ">
                                <label for="" class="form-label mb-0 fst-italic">Kategori Aset :</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="me-5" style="text-align: right">
                                <a href="#" class="btn btn-primary mt-5 ms-auto">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>

</script>
