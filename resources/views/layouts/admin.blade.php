<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - Pusaka Indatu</title>
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    @yield('header')
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin/images/icon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-scroller">
            <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex justify-content-center">
                    <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                        <a class="navbar-brand brand-logo" href="{{ route('home') }}">
                            <img src="{{ asset('admin/images/logo.svg') }}" alt="logo" /></a>
                        <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}">
                            <img src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo" /></a>
                        <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                            data-toggle="minimize">
                            <span class="mdi mdi-sort-variant"></span>
                        </button>
                    </div>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                                id="profileDropdown">
                                {{-- <img src="{{ asset('admin/images/faces/face5.jpg') }}" alt="profile" /> --}}
                                <span class="nav-profile-name">{{ auth()->user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                aria-labelledby="profileDropdown">
                                <div class="dropdown-item">
                                    <i class="mdi mdi-settings"></i>
                                    <a href="" class="text-dark text-decoration-none">Pengaturan</a>
                                </div>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline dropdown-item">
                                    @csrf
                                    <i class="mdi mdi-logout"></i>
                                    <button type="submit" class="btn btn-sm p-0 m-0">
                                        Keluar</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                        data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link text-dark">
                                <i class="mdi mdi-home menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog.index') }}" class="nav-link text-dark">
                                <i class="mdi mdi-newspaper menu-icon"></i>
                                <span class="menu-title">Artikel</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link text-dark">
                                <i class="mdi mdi-basket menu-icon"></i>
                                <span class="menu-title">Produk</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('foods.index') }}" class="nav-link text-dark">
                                <i class="mdi mdi-food menu-icon"></i>
                                <span class="menu-title">Makanan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('orders.index') }}" class="nav-link text-dark">
                                <i class="mdi mdi-credit-card-multiple menu-icon"></i>
                                <span class="menu-title">Data Order</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin-management.index') }}" class="nav-link text-dark">
                                <i class="mdi mdi-account-key menu-icon"></i>
                                <span class="menu-title">Manajemen Admin</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        @yield('body')
                    </div>
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <script src="{{ asset('admin/vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/js/template.js') }}"></script>
    <script src="{{ asset('admin/js/dashboard.js') }}"></script>
    <script src="{{ asset('admin/js/data-table.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.bootstrap4.js') }}"></script>
    @yield('scripts')
</body>

</html>
