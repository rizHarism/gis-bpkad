<section class="content">
    <div class="container-fluid ">
        <div class="card">
            <h5 class="card-header">Jumlah Aset Tanah</h5>
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3 class="mt-3" id="all_aset"></h3>
                                <p class="fs-3 mt-2">Seluruh Aset Tanah</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 class="mt-3" id="bersertifikat"></h3>

                                <p class="fs-3 mt-2">Aset Bersertifikat</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 class="mt-3" id="non_sertifikat"></h3>

                                <p class="fs-3 mt-2">Aset Belum Bersertifikat</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-globe-americas"></i>
                            </div>
                            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                        </div>
                    </div>
                    <!-- ./col -->


                </div>
            </div>
        </div>
        <!-- Small boxes (Stat box) -->


    </div>
    <div class="container-fluid">
        {{-- <div class="card"> --}}
        {{-- <h5 class="card-header">Jumlah Aset Tanah</h5> --}}
        {{-- <div class="card-body"> --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Aset Bersertifikat</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="allsertifikat"
                            style="min-height: 250px; height: 400; max-height: 400px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Aset Bersertifikat Terpetakan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="mapped"
                            style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>

        </div>
        {{-- </div> --}}
        {{-- </div> --}}
    </div>
    <!-- PIE CHART -->



</section>
