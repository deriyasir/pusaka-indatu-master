@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <section>
        <div class="mb-2 d-none d-md-inline">
            <h4 class="text-muted">Produk</h4>
        </div>
        @if (request()->has('cari'))
            <p>
                Hasil pencarian untuk <strong>{{ request()->cari }}</strong>
            </p>
        @endif
        <div id="produk" class="row">
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <div class="col-md-3 col-6 p-2">
                        <div class="shadow-sm rounded p-3">
                            <a class="d-flex justify-content-center align-items-center" style="overflow: hidden;"
                                href="{{ route('produk.detail', $product) }}">
                                <img src="{{ asset('storage/products/' . $product->image) }}" class="img-fluid rounded"
                                    alt="Product Image">
                            </a>
                            <div class="text-center py-3">
                                <p class="m-0">{{ $product->name }}</p>
                                <small class="text-muted">Rp {{ number_format($product->price) }}</small>
                            </div>
                            <div class="text-center">
                                <a href="{{ route('add-to-cart', [$product, 'type' => 'add']) }}"
                                    class="btn btn-sm btn-outline-warning mb-2 w-100"><i class="fas fa-fw fa-plus"></i>
                                    Keranjang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Produk tidak ditemukan</h4>
                </div>
            @endif
        </div>
    </section>
@endsection
