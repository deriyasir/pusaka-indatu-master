@extends('layouts.admin')

@section('title', 'Tambah Makanan')

@section('header')
    <script src="https://cdn.tiny.cloud/1/733yp9xmug926h0ymvz7wzgotatzwea8yypwb2jce48rykc1/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Tambah Makanan</h4>
            <a href="{{ route('foods.index') }}" class="text-primary"><i class="mdi mdi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('foods.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Makanan</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                            placeholder="Masukkan nama makanan" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control form-control-sm" id="satuan" name="satuan"
                            placeholder="Masukkan Satuan makanan" value="{{ old('satuan') }}">
                        @error('satuan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" class="form-control form-control-sm" id="price" name="price"
                            placeholder="Masukkan Harga makanan" value="{{ old('price') }}">
                        @error('price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi Makanan</label>
                        <textarea class="form-control form-control-sm" id="description" name="description" rows="30">
                            {{ old('description') }}
                        </textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image">Gambar Makanan</label>
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
