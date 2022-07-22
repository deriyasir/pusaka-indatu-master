@extends('layouts.app')

@section('title', 'Produk')

@section('content')
    <section>
        <div class="mb-2">
            <h4 class="text-muted">Produk</h4>
        </div>
        <div id="produk" class="row">
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
                            <a href="{{ route('add-to-cart', $product) }}"
                                class="btn btn-sm btn-outline-warning mb-2 w-100"><i class="mdi mdi-cart-outline"></i>
                                Tambah
                                Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
