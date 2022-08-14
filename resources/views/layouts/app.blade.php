<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('admin/images/logo-mini.svg') }}" type="image/svg">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css">
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: true,
                // footer: "<small><a class='text-dark' href='{{ route('cart') }}'>Lihat Keranjang</a></small>"
            })
        </script>
    @endif
    <div id="app">
        {{-- navbar untuk desktop --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm d-none d-md-block">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('admin/images/logo.svg') }}" alt="logo" height="30" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="mx-2 nav-item">
                            <a href="{{ route('home') }}"
                                class="nav-link {{ Request::is('/') ? 'active' : '' }}">{{ __('Beranda') }}</a>
                        </li>
                        <li class="mx-2 nav-item">
                            <a href="{{ route('produk') }}"
                                class="nav-link {{ Request::is('produk*') ? 'active' : '' }}">{{ __('Produk') }}</a>
                        </li>
                        <li class="mx-2 nav-item">
                            <a href="{{ route('kuliner') }}"
                                class="nav-link {{ Request::is('kuliner*') ? 'active' : '' }}">{{ __('Kuliner') }}</a>
                        </li>
                        <li class="mx-2 nav-item">
                            <a href="{{ route('artikel') }}"
                                class="nav-link {{ Request::is('artikel*') ? 'active' : '' }}">{{ __('Artikel') }}</a>
                        </li>
                        <li class="mx-2 nav-item">
                            <a class="nav-link" id="search-btn"><i class="fas fa-fw fa-search"></i></a>
                        </li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav
                                ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white btn btn-sm btn-warning py-1 px-3"
                                        href="{{ route('login') }}">
                                        <b>
                                            <i class="mdi mdi-login"></i>
                                            {{ __('Login') }}
                                        </b>
                                    </a>
                                </li>
                            @endif
                        @else
                            @can('is_user')
                                <li class="nav-item">
                                    <a href="{{ route('cart') }}" class="nav-link">
                                        <i class="fas fa-fw fa-cart-shopping"></i>
                                        <span class="badge bg-warning">{{ auth()->user()->cart()->count() ?? '-' }}</span>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ explode(' ', Auth::user()->name)[0] }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @can('is_admin')
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            <i class="mdi mdi-view-dashboard-outline"></i>
                                            {{ __('Dashboard') }}
                                        </a>
                                    @elsecan('is_user')
                                        <a class="dropdown-item" href="{{ route('profil') }}">
                                            <i class="mdi mdi-account"></i>
                                            Profil
                                        </a>
                                        <a class="dropdown-item" href="{{ route('pesanan-saya') }}">
                                            <i class="mdi mdi-shopping"></i>
                                            Pesanan Saya
                                        </a>
                                    @endcan
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="mdi mdi-logout"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- navbar untuk di mobile --}}
        <nav class="navbar d-block d-md-none bg-white">
            <div class="d-flex justify-content-between align-items-center py-2 px-3">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('admin/images/logo.svg') }}" alt="logo" height="30" />
                </a>
                @auth
                    @can('is_user')
                        <a href="{{ route('cart') }}" class="text-dark">
                            <i class="fas fa-fw fa-cart-shopping"></i>
                            <span class="badge bg-warning">{{ auth()->user()->cart()->count() }}</span>
                        </a>
                    @endcan
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="text-dark">
                        Login
                        <i class="fas fa-fw fa-sign-in"></i>
                    </a>
                @endguest
            </div>
        </nav>

        <div id="content-online">
            <section class="mt-4" id="form-cari">
                <div class="container">
                    <div class="card">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0" id="basic-addon1"><i
                                    class="fas fa-fw fa-search"></i></span>
                            <input type="text" class="form-control bg-white border-0" id="input-cari"
                                placeholder="Cari sesuatu.." value="{{ request('cari') }}">
                        </div>
                        <div id="search-result" class="d-none">
                            <hr class="my-0">
                            <div class="d-flex flex-column p-2" style="gap: 5px">
                                <a class="text-dark" id="cari-produk" href="asd">
                                    <strong><i class="fas fa-fw fa-arrow-right"></i></strong> cari
                                    '<strong><span class="search-value text-primary"></span></strong>' di
                                    <strong>Produk</strong>
                                </a>
                                <a class="text-dark" id="cari-kuliner" href="asd">
                                    <strong><i class="fas fa-fw fa-arrow-right"></i></strong> cari
                                    '<strong><span class="search-value text-primary"></span></strong>' di
                                    <strong>Kuliner</strong>
                                </a>
                                <a class="text-dark" id="cari-artikel" href="asd">
                                    <strong><i class="fas fa-fw fa-arrow-right"></i></strong> cari
                                    '<strong><span class="search-value text-primary"></span></strong>' di
                                    <strong>Artikel</strong>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script>
                let tombol_search = document.getElementById('search-btn');
                let form_cari = document.getElementById('form-cari');
                let input_cari = document.getElementById('input-cari');
                let search_result = document.getElementById('search-result');
                let search_value = document.querySelectorAll('.search-value');
                let cari_produk = document.getElementById('cari-produk');
                let cari_kuliner = document.getElementById('cari-kuliner');
                let cari_artikel = document.getElementById('cari-artikel');

                var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

                if (width > 768) {
                    form_cari.classList.add('d-none');
                }

                tombol_search.addEventListener('click', function() {
                    form_cari.classList.toggle('d-none');
                });

                input_cari.addEventListener('keyup', function() {
                    let keyword = input_cari.value;
                    if (keyword.length > 0) {
                        search_result.classList.remove('d-none');
                        search_value.forEach(function(item) {
                            item.innerHTML = keyword;
                        });
                        cari_produk.href = "{{ route('produk') }}?cari=" + keyword;
                        cari_kuliner.href = "{{ route('kuliner') }}?cari=" + keyword;
                        cari_artikel.href = "{{ route('artikel') }}?cari=" + keyword;
                    } else {
                        search_result.classList.add('d-none');
                    }
                });
            </script>

            <main class="py-4">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>

        <div id="content-offline" class="d-flex justify-content-center align-items-center" style="height: 80vh">
            <h1>Ops, Kamu Offline!</h1>
        </div>

        <div class="box py-4"></div>

        <footer class="d-block d-md-none fixed-bottom shadow-md">
            <div class="d-flex bg-white align-items-center" style="height: 65px">
                <a href="{{ route('kuliner') }}"
                    class="p-2 text-center w-100 {{ Request::is('kuliner*') ? 'text-warning' : 'text-muted' }}">
                    <h6 class="m-0"><i class="fas fa-fw fa-bowl-food"></i></h6>
                    <small>Kuliner</small>
                </a>
                <a href="{{ route('produk') }}"
                    class="p-2 text-center w-100 {{ Request::is('produk*') ? 'text-warning' : 'text-muted' }}">
                    <h6 class="m-0"><i class="fas fa-fw fa-boxes-stacked"></i></h6>
                    <small>Produk</small>
                </a>
                <a href="{{ route('home') }}"
                    class="p-2 text-center w-100 {{ Request::is('/') ? 'text-warning' : 'text-muted' }}">
                    <h6 class="m-0"><i class="fas fa-fw fa-home"></i></h6>
                    <small>Beranda</small>
                </a>
                <a href="{{ route('artikel') }}"
                    class="p-2 text-center w-100 {{ Request::is('artikel*') ? 'text-warning' : 'text-muted' }}">
                    <h6 class="m-0"><i class="fas fa-fw fa-newspaper"></i></h6>
                    <small>Artikel</small>
                </a>
                <a href="{{ route('profil') }}"
                    class="p-2 text-center w-100 {{ Request::is('profil*') ? 'text-warning' : 'text-muted' }}">
                    <h6 class="m-0"><i class="fas fa-fw fa-user"></i></h6>
                    <small>Profil</small>
                </a>
            </div>
        </footer>

        <footer class="text-center text-lg-start bg-light text-muted d-none d-md-block">
            <section class="container d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
                <div class="me-5 d-none d-lg-block">
                    <span>Terhubung dengan kami di social media : </span>
                </div>
                <div>
                    <a target="_blank" href="https://facebook.com/" class="me-4 text-reset">
                        <i class="mdi mdi-facebook"></i>
                    </a>
                    <a target="_blank" href="https://twitter.com/" class="me-4 text-reset">
                        <i class="mdi mdi-twitter"></i>
                    </a>
                    <a target="_blank" href="https://instagram.com/pusakaindatu5" class="text-reset">
                        <i class="mdi mdi-instagram"></i>
                    </a>
                </div>
            </section>
            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <div class="row mt-3">
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">Pusaka Indatu</h6>
                            <p>
                                Here you can use rows and columns to organize your footer content. Lorem ipsum
                                dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet consectetur
                                adipisicing elit. Illum, error?
                            </p>
                        </div>
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">
                                Produk
                            </h6>
                            <p>
                                <a href="{{ route('produk') }}" class="text-reset">Bumbu Masakan</a>
                            </p>
                            <p>
                                <a href="{{ route('kuliner') }}" class="text-reset">Makanan Kuliner Aceh</a>
                            </p>
                        </div>
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">
                                Kontak
                            </h6>
                            <p>Jl. Banda Aceh - Medan, No. 2A, Lampoih Saka - Sigli</p>
                            <p>info@pusakaindatu.com</p>
                            <p>+ 628 2258727370</p>
                        </div>
                    </div>
                </div>
            </section>
            <div class="text-center p-4 bg-light">
                © {{ date('Y') }} Copyright |
                <a class="text-reset fw-bold" href="{{ route('home') }}">Pusaka Indatu</a>
            </div>
        </footer>
    </div>
    <script>
        // check if window is online, if not, show offline page
        if (navigator.onLine) {
            document.getElementById('content-online').classList.remove('d-none');
            document.getElementById('content-offline').classList.add('d-none');
        } else {
            document.getElementById('content-online').classList.add('d-none');
            document.getElementById('content-offline').classList.remove('d-none');
        }
    </script>
    @stack('scripts')
</body>

</html>
