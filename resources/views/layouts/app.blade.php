<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Chartist CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/style.min.css') }}">
</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="navbar-brand" href="{{ route('dashboard.index') }}">
                        <img src="{{ asset('assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                        <!-- Light Logo icon -->
                        <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                        </b>
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="../assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                            <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" />
                        </span>
                    </a>
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="mdi mdi-menu"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark"
                                href="javascript:void(0)"><i class="mdi mdi-magnify me-1"></i> <span
                                    class="font-16">Search</span></a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a
                                    class="srh-btn"><i class="mdi mdi-window-close"></i></a>
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="../assets/images/users/profile.png" alt="user" class="rounded-circle"
                                    width="31">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
    aria-labelledby="navbarDropdown">
    
    <!-- Profile -->
    <a class="dropdown-item" href="javascript:void(0)">
        <i class="ti-user m-r-5 m-l-5"></i>
        {{ session('user.nama') }}
    </a>

    <!-- Divider -->
    <div class="dropdown-divider"></div>

    <!-- Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="dropdown-item text-danger">
            <i class="ti-power-off m-r-5 m-l-5"></i>
            Logout
        </button>
    </form>
</ul>

                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">

                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard.index') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('produks.index') }}" aria-expanded="false">
                                <i class="mdi mdi-face"></i><span class="hide-menu">Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('penjualan.index') }}" aria-expanded="false">
                                <i class="mdi mdi-border-all"></i><span class="hide-menu">Pembelian</span>
                            </a>
                        </li>
                        
                       @if (session('user.role') == 'admin')
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('users.index') }}" aria-expanded="false">
                                <i class="ti ti-users"></i>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="link"><i
                                            class="mdi mdi-home-outline fs-4"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
                        <h1 class="mb-0 fw-bold">Dashboard</h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Core Libraries -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- App Style Switcher -->
    <script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>

    <!-- Waves Effect -->
    <script src="{{ asset('assets/js/waves.js') }}"></script>

    <!-- Sidebar Menu -->
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Chartist Charts -->
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>

    <!-- Dashboard Page Scripts -->
    <script src="{{ asset('assets/js/pages/dashboard1.js') }}"></script>

    <!-- Optional Iconify -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>

</html>
