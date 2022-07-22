@extends('layouts.admin')

@section('title', 'Produk')

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Makanan</h4>
            <a href="{{ route('foods.create') }}" class="text-primary"><i class="mdi mdi-plus"></i> Tambah
                Makanan</a>
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
                <form action="{{ route('foods.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="cari" placeholder="Cari makanan..."
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
                                    Nama Makanan
                                </th>
                                <th>
                                    Satuan
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
                            @foreach ($foods as $food)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ asset('storage/foods/' . $food->image) }}" alt="image" />
                                    </td>
                                    <td>
                                        <strong>{{ $food->name }}</strong>
                                    </td>
                                    <td>
                                        {{ $food->satuan }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($food->price) }}
                                    </td>
                                    <td>
                                        {{ $food->views }} <i class="mdi mdi-eye"></i>
                                    </td>
                                    <td>
                                        <a href="{{ route('foods.edit', $food) }}" class="p-1 text-warning">
                                            <i class="mdi mdi-sm mdi-grease-pencil"></i>
                                        </a>
                                        <form action="{{ route('foods.destroy', $food) }}" method="post"
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
                {{ $foods->links() }}
            </div>
        </div>
    </div>
@endsection
