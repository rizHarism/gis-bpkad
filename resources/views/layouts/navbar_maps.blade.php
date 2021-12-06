{{-- <nav class="navbar navbar-expand navbar-white navbar-light shadow-sm  mb-1 bg-body rounded">
    <!-- Left navbar links -->
    <ul class="navbar-nav ">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/logo-image/blitar.png') }}" alt="" width="24" height="30"
                    class="d-inline-block align-text-top me-2">
            </a>
            <h4 class="pt-2 fst-italic fw-bold fw-light">SIMANTAB Kota Blitar</h4>
        </div>
    </ul>

    @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')

    <!-- Right navbar links -->
    <ul class="navbar-nav ms-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/dashboard" class="nav-link">Dashboard</a>
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/dashboard" class="nav-link">Home</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                    class="fas fa-th-large"></i></a>
        </li>
    </ul>
</nav> --}}

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

                <div class="form-check form-control-sm mt-3">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                    <label class="form-check-label fw-bold" for="flexRadioDefault1">
                        Bersertifikat
                    </label>
                </div>
                <div class="form-check form-control-sm">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                    <label class="form-check-label fw-bold" for="flexRadioDefault2">
                        Non Sertifikat
                    </label>
                </div>

                <select class="form-select mt-3 form-control-sm fw-bold" aria-label="Default select example">
                    <option selected>Semua SKPD</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

                <select class="form-select mt-3 form-control-sm fw-bold" aria-label="Default select example">
                    <option selected>Semua Kelurahan</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>

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
