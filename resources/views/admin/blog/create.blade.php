@extends('layouts.admin')

@section('title', 'Tambah Artikel')

@section('header')
    <script src="https://cdn.tiny.cloud/1/733yp9xmug926h0ymvz7wzgotatzwea8yypwb2jce48rykc1/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Tambah Artikel</h4>
            <a href="{{ route('blog.index') }}" class="text-primary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control form-control-sm" id="title" name="title"
                            placeholder="Masukkan judul artikel" value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Kategori</label>
                                <select class="form-control form-control-sm" id="category" name="category">
                                    <option value="" disabled>Pilih Kategori</option>
                                    <option @selected(old('category') == 'resep') value="resep">RESEP</option>
                                    <option @selected(old('category') != 'resep') value="artikel">INFORMASI</option>
                                </select>
                            </div>
                            @error('category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product">Produk Terkait ( *jika kategori <strong>RESEP</strong> )</label>
                                <select class="form-control form-control-sm" id="product" name="product_id">
                                    <option value="" selected>Tidak ada</option>
                                    @foreach ($products as $product)
                                        <option @selected(old('product_id') == $product->id) value="{{ $product->id }}">
                                            {{ $product->name }} | {{ $product->weight }} gram x {{ $product->pcs }} |
                                            Rp. {{ number_format($product->price) }} </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="headline">Pokok Berita</label>
                        <textarea class="form-control form-control-sm" id="headline" name="headline" rows="3">{{ old('headline') }}</textarea>
                        @error('headline')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Konten</label>
                        <textarea class="form-control form-control-sm" id="content" name="content" rows="30">
                            {{ old('content') }}
                        </textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#content',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>
@endsection
