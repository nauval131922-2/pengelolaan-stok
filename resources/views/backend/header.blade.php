<style>
    .custom-container {
        width: 100%;
        max-width: 100%;
        padding-left: 15px;
        padding-right: 15px;
    }
</style>

<header id="page-topbar" style="
padding-left: 15px;
padding-right: 15px;
">
    <div class="navbar-header" style="
    margin-right: 0px;
    margin-left: 0px;
    max-width: 100%;
">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box"
                style="
            padding-left: 15px;
            padding-right: 15px;
        ">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/favicon.png') }}" alt="logo-sm" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/favicon.png') }}" alt="logo-dark" height="20">
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-sm-light" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-light" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse"
                data-bs-target="#topnav-menu-content">
                <i class="ri-menu-2-line align-middle"></i>
            </button>


        </div>

        <div class="d-flex">

            <div class="dropdown d-inline-block d-lg-none ms-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ri-search-line"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="mb-3 m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="ri-search-line"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>



            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded header-profile-user" id="fotoUserLoginDiHeader"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1" id="namaUserLoginDiHeader"></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                            class="ri-user-line align-middle me-1"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="dropdown-item text-danger" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout
                    </a>
                </div>

            </div>


        </div>
    </div>

</header>

<div class="topnav"
    style="
padding-left: 15px;
padding-right: 15px;
background-color: #fff;
box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
">
    <div class="custom-container">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}" style="color:#6c757d!important">
                            <i class="ri-dashboard-line me-2"></i> Dashboard
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                            style="color:#6c757d!important">
                            </i>Stok <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-data"
                                    role="button">
                                    Data <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-data">
                                    <a href="{{ route('master-satuan-index') }}" class="dropdown-item">Master
                                        Satuan</a>
                                    <a href="{{ route('master-kategori-index') }}" class="dropdown-item">Master Kategori</a>
                                    <a href="{{ route('master-barang-index') }}" class="dropdown-item">Master Barang</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-data"
                                    role="button">
                                    Mutasi <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-data">
                                    <a href="data-inbox.html" class="dropdown-item">Barang Masuk</a>
                                    <a href="data-inbox.html" class="dropdown-item">Barang Keluar</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-data"
                                    role="button">
                                    Laporan <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-data">
                                    <a href="data-inbox.html" class="dropdown-item">Saldo Barang</a>
                                    <a href="data-inbox.html" class="dropdown-item">Kartu Stok</a>
                                </div>
                            </div>
                        </div>
                    </li>




                </ul>
            </div>
        </nav>
    </div>
</div>
