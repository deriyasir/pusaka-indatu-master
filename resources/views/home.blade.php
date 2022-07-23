@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- slide gambar --}}
    <section id="hero" class="splide" aria-label="Hero Image">
        <div class="splide__track">
            <ul class="splide__list">
                <li class="splide__slide hero" style="background-image: url({{ asset('images/1.jpg') }})">
                    {{-- <img class="img-fluid" src="{{ asset('images/1.jpg') }}" alt="Sample Image"> --}}
                    <div class="hero-content">
                        <div>
                            <h2><strong>Selamat Datang di Pusaka Indatu</strong></h2>
                            <p>Sajian kuliner khas</p>
                            <a href="/kuliner" class="btn btn-sm btn-outline-light border-2">Explore Kuliner <i
                                    class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </li>
                <li class="splide__slide hero" style="background-image: url({{ asset('images/2.jpg') }})">
                    {{-- <img class="img-fluid" src="{{ asset('images/2.jpg') }}" alt="Sample Image"> --}}
                    <div class="hero-content">
                        <div>
                            <h2><strong>Pusaka Indatu</strong></h2>
                            <p>Bumbu Aceh siap dimasak</p>
                            <a href="/produk" class="btn btn-sm btn-outline-light border-2">Explore produk <i
                                    class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </li>
                <li class="splide__slide hero" style="background-image: url({{ asset('images/2.jpg') }})">
                    {{-- <img class="img-fluid" src="{{ asset('images/3.jpg') }}" alt="Sample Image"> --}}
                    <div class="hero-content">
                        <div>
                            <h2><strong>Pusaka Indatu</strong></h2>
                            <p>Bumbu Aceh siap dimasak</p>
                            <a href="/kuliner" class="btn btn-sm btn-outline-light border-2">Explore Kuliner <i
                                    class="mdi mdi-arrow-right"></i></a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    {{-- produk bumbu --}}
    <section class="mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="text-muted m-0">Produk Bumbu</h4>
                @if ($products->count() > 5)
                    <a href="{{ route('produk') }}" class="text-dark"><i class="mdi mdi-arrow-right"></i> Tampilkan
                        Semua</a>
                @endif
        </div>
        <div id="produk" class="splide" aria-label="Produk Terbaru">
            <div class="splide__track py-2">
                <ul class="splide__list">
                    @foreach ($products as $product)
                        <li class="splide__slide bg-white" style="width: 100%">
                            <div class="shadow-sm p-2 rounded">
                                <a class="d-flex justify-content-center align-items-center" style="overflow: hidden;"
                                    href="{{ route('produk.detail', $product) }}">
                                    <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded"
                                        alt="Product Image">
                                </a>
                                <div class="text-center py-3">
                                    <p class="m-0">{{ $product->name }}</p>
                                    <small class="text-muted">Rp {{ number_format($product->price) }}</small>
                                </div>
                                <div class="text-center mb-2">
                                    <a href="{{ route('add-to-cart', $product) }}"
                                        class="btn btn-sm btn-outline-warning mb-2 w-100"><i class="fas fa-fw fa-plus"></i>
                                        Keranjang
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </section>

    {{-- kuliner --}}
    <section class="mt-5">
        <div class="d-flex" style="align-items: center; justify-content: space-between">
            <h6 class="text-muted m-0">Kuliner Aceh</h4>
                @if ($kuliner->count() > 5)
                    <a href="{{ route('kuliner') }}" class="text-dark">
                        <i class="mdi mdi-arrow-right"></i> Tampilkan Semua
                    </a>
                @endif
        </div>
        <div id="kuliner" class="splide" aria-label="Kulier Terbaru">
            <div class="splide__track py-2">
                <ul class="splide__list">
                    @foreach ($kuliner as $makanan)
                        <li class="splide__slide bg-white" style="width: 100%">
                            <div class="shadow-sm p-2 rounded text-dark">
                                <a class="d-flex justify-content-center align-items-center" style="overflow: hidden;"
                                    href="{{ route('kuliner.detail', $makanan) }}">
                                    <img src="{{ asset('storage/foods/' . $makanan->image) }}" class="img-fluid rounded"
                                        alt="Makanan Image">
                                </a>
                                <div class="text-center py-3">
                                    <p class="m-0">{{ $makanan->name }}</p>
                                    <small class="text-muted">Rp {{ number_format($makanan->price) }}</small>
                                </div>
                                <a class="btn btn-sm btn-outline-success" style="width: 100%"
                                    href="{{ route('kuliner.detail', $makanan) }}">
                                    Detail Makanan
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hero {
            background-size: cover;
            background-position: center center;
        }

        .hero-content {
            position: absolute;
            top: 0;
            left: 0;
            text-align: left;
            height: 100%;
            width: 100%;
            display: flex;
            color: #fff;
            padding-left: 50px;
            align-items: center;
            background: rgb(2, 0, 36);
            background: linear-gradient(207deg, transparent 0%, rgba(2, 0, 36, 0) 30%, #ffc107 100%);
        }

        #hero .splide__track {
            border-radius: 10px;
            overflow: hidden;
            z-index: 1;
        }

        #hero .splide__pagination {
            counter-reset: pagination-num;
            display: flex;
            justify-content: center;
            /* padding: 0; */
            margin-bottom: 10px;
            /* margin-bottom: -50px !important; */
        }

        #hero .splide__pagination__page {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 22px;
            height: 22px;
            border-radius: 2px !important;
            background: #fff;
            color: #000;
            font-size: 12px;
            font-weight: bold;
            margin: 0 5px;
            cursor: pointer;
            opacity: 1;
        }

        #hero .splide__slide {
            height: 350px;
            width: 100%;
            position: relative;
            background-color: aliceblue;
        }

        @media (max-width: 768px) {
            #hero .splide__slide {
                height: 230px;
            }

            #hero .splide__pagination {
                display: none;
            }
        }

        #hero .splide__pagination__page.is-active {
            background-color: #ED6D45 !important;
            color: #fff !important;
        }

        #hero .splide__pagination__page:before {
            counter-increment: pagination-num;
            content: counter(pagination-num);
        }
    </style>
@endpush

@push('scripts')
    <script>
        var hero = new Splide('#hero', {
            type: 'loop',
            autoplay: true,
        });
        hero.mount();

        var produk = new Splide('#produk', {
            type: 'slide',
            arrows: false,
            perPage: 5,
            breakpoints: {
                1024: {
                    perPage: 3,

                },
                767: {
                    perPage: 2,

                },
            },
            gap: '1em',
            updateOnMove: true,
            pagination: false,
            snap: true,
            padding: {
                right: '3em'
            },
            autoplay: true,
        });
        produk.mount();

        var kuliner = new Splide('#kuliner', {
            type: 'slide',
            drag: 'free',
            arrows: false,

            perPage: 5,
            breakpoints: {
                1024: {
                    perPage: 3,

                },
                767: {
                    perPage: 2,

                },
            },
            gap: '1em',
            updateOnMove: true,
            pagination: false,
            snap: true,
            padding: {
                right: '3em'
            },
            autoplay: true,
        });
        kuliner.mount();
    </script>
@endpush
