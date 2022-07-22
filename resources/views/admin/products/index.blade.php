@extends('layouts.admin')

@section('title', 'Produk')

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Produk</h4>
            <a href="{{ route('products.create') }}" class="text-primary"><i class="mdi mdi-plus"></i> Tambah
                Produk</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="cari" placeholder="Cari produk..."
                            value="{{ request()->cari }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mb-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>
                                    Gambar
                                </th>
                                <th>
                                    Nama Produk
                                </th>
                                <th>
                                    Stok
                                </th>
                                <th>
                                    Harga
                                </th>
                                <th>
                                    Dilihat
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ asset('storage/products/' . $product->image) }}" alt="image" />
                                    </td>
                                    <td>
                                        <div>
                                            <strong class="d-block mb-1">{{ $product->name }}</strong>
                                            <small>{{ $product->weight }} gram x {{ $product->pcs }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $product->stock }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($product->price) }}
                                    </td>
                                    <td>
                                        {{ $product->views }} <i class="mdi mdi-eye"></i>
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product) }}" class="p-1 text-warning">
                                            <i class="mdi mdi-sm mdi-grease-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="post"
                                            class="d-inline" onsubmit="return confirm('yakin dihapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 p-1 text-danger">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
