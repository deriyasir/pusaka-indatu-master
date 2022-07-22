@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('header')
    <script src="https://cdn.tiny.cloud/1/733yp9xmug926h0ymvz7wzgotatzwea8yypwb2jce48rykc1/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Edit Produk</h4>
            <a href="{{ route('products.index') }}" class="text-primary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                            placeholder="Masukkan nama produk" value="{{ old('name') ?? $product->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight">Berat ( gram )</label>
                                <input type="text" class="form-control form-control-sm" id="weight" name="weight"
                                    placeholder="Masukkan berat produk" value="{{ old('weight') ?? $product->weight }}">
                                @error('weight')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pcs">Isi</label>
                                <input type="text" class="form-control form-control-sm" id="pcs" name="pcs"
                                    placeholder="Masukkan berat produk" value="{{ old('pcs') ?? $product->pcs }}">
                                @error('pcs')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="number" class="form-control form-control-sm" id="price" name="price"
                                    placeholder="Masukkan Harga produk" value="{{ old('price') ?? $product->price }}">
                                @error('price')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stok</label>
                                <input type="number" class="form-control form-control-sm" id="stock" name="stock"
                                    placeholder="Masukkan jumlah stok produk"
                                    value="{{ old('stock') ?? $product->stock }}">
                                @error('stock')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Produk</label>
                        <textarea class="form-control form-control-sm" id="description" name="description" rows="30">
                            {{ old('description') ?? $product->description }}
                        </textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar Produk</label>
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
            selector: 'textarea#description',
            toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
        });
    </script>
@endsection
