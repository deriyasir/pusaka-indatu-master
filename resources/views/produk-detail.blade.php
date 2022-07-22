@extends('layouts.app')

@section('title', $produk->name)

@section('content')
    <section>
        <div class="row">
            <div class="row col-md-9">
                <div class="col-md-5 col-sm-12 mb-4">
                    <div class="card p-2">
                        <img src="{{ asset('storage/products/' . $produk->image) }}" class="img-fluid" alt="image">
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 px-3">
                    <h2>{{ $produk->name }}</h4>
                        <small class="text-muted mb-3 d-block"><i class="mdi mdi-tag"></i> 2039 x dibeli | <i
                                class="mdi mdi-eye"></i>
                            {{ $produk->views }} x dilihat</small>
                        <h5 class="mb-3"><b>Rp {{ number_format($produk->price) }}</b></h5>
                        <hr>
                        <h6 class="text-muted mb-3">Detail Produk</h6>
                        <table class="text-muted" style="font-size: 12px;">
                            <tr>
                                <td>Berat</td>
                                <td class="px-2">:</td>
                                <td>{{ $produk->weight . ' ' . str()->plural('gram', $produk->weight) }}</td>
                            </tr>
                            <tr>
                                <td>Isi</td>
                                <td class="px-2">:</td>
                                <td>{{ $produk->pcs }}</td>
                            </tr>
                            <tr>
                                <td>Stok</td>
                                <td class="px-2">:</td>
                                <td>{{ $produk->stock }}</td>
                            </tr>
                        </table>
                        <p class="text-muted">{!! $produk->description !!}</p>

                </div>
            </div>
            <aside class="col-md-3">
                <div class="card p-3" style="width: 100%; position: sticky; top: 80px;" x-data="{ jumlah: 1, harga: '{{ $produk->price }}' }">
                    <small class="text-muted">Atur jumlah</small>
                    <hr>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="d-flex">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <a class="btn btn-outline-secondary" x-on:click="if(jumlah > 1) jumlah -= 1">-</a>
                                </div>
                                <input type="number" class="form-control text-center" id="jumlah" x-model="jumlah"
                                    name="jumlah">
                                <div class="input-group-append">
                                    <a class="btn btn-outline-secondary" x-on:click="jumlah += 1">+</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="text-muted">Subtotal</h6>
                            <h3><b>Rp <span x-text="new Intl.NumberFormat('en-US',).format(harga * jumlah)"></span></b></h3>
                        </div>
                        <a x-bind:href="'{{ route('add-to-cart', $produk) }}?qty=' + jumlah"
                            class="btn btn-sm btn-outline-warning mb-2 w-100  mt-3"><i class="mdi mdi-cart-outline"></i>
                            Tambah
                            Keranjang
                        </a>
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <button type="submit" class="btn btn-sm btn-warning text-white w-100">Beli Sekarang</button>
                    </form>
                </div>
            </aside>
        </div>
    </section>
    <hr class="my-4">
    <section class="mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-muted">Produk Lainnya</h4>
            @if ($products->count() > 4)
                <a href="{{ route('produk') }}" class="text-dark"><i class="mdi mdi-arrow-right"></i> Tampilkan seluruh
                    produk</a>
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
                                    <img src="{{ asset('storage/products/' . $product->image) }}"
                                        class="img-fluid rounded" alt="Product Image">
                                </a>
                                <div class="text-center py-3">
                                    <p class="m-0">{{ $product->name }}</p>
                                    <small class="text-muted">Rp {{ number_format($product->price) }}</small>
                                </div>
                                <div class="text-center mb-2">
                                    <a href="{{ route('add-to-cart', $product) }}"
                                        class="btn btn-sm btn-outline-warning mb-2 w-100"><i
                                            class="mdi mdi-cart-outline"></i> Tambah Keranjang
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
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
    </script>
@endpush
