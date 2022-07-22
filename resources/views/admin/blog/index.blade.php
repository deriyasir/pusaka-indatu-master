@extends('layouts.admin')

@section('title', 'Artikel')

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Artikel</h4>
            <a href="{{ route('blog.create') }}" class="text-primary"><i class="mdi mdi-plus"></i> Tambah
                Artikel</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row">
            @foreach ($blogs as $blog)
                <div class="col-lg-4 col-sm-12 col-md-6">
                    <div class="card p-1 mb-3 position-relative">
                        <span
                            class="badge badge-info position-absolute top-2 left-2">{{ str()->upper($blog->category) }}</span>
                        <img class="card-img-top" src="{{ asset('storage/blogs/' . $blog->image) }}"
                            alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ $blog->title }}</h5>
                            <p class="card-text">{{ $blog->headline }}</p>
                            <small><strong>{{ $blog->author->name }}</strong> -
                                {{ $blog->created_at->diffForHumans() }}</small>
                            @if ($blog->product())
                                <hr>
                                <div class="d-flex">
                                    <img height="50" class="rounded"
                                        src="{{ asset('storage/products/' . $blog->product->image) }}"
                                        alt="Gambar Produk">
                                    <div class="detail ml-2">
                                        <p><strong>{{ $blog->product->name }}</strong></p>
                                        <small>{{ $blog->product->weight }} gram x {{ $blog->product->pcs }} | Rp.
                                            {{ number_format($blog->product->price) }}</small>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <small class="d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="{{ route('blog.edit', $blog) }}"
                                        class="p-1 rounded text-white bg-warning mr-2"><i
                                            class="mdi mdi-grease-pencil"></i></a>
                                    <form action="{{ route('blog.destroy', $blog) }}" method="post"
                                        class="d-inline" onsubmit="return confirm('yakin dihapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 p-1 rounded text-white bg-danger"><i
                                                class="mdi mdi-delete"></i></button>
                                    </form>
                                </div>
                                <span><i class="mdi mdi-eye"></i> {{ $blog->views }}</span>
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
