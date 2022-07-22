@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('body')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Edit Admin</h4>
            <a href="{{ route('admin-management.index') }}" class="text-primary"><i class="mdi mdi-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin-management.update', $admin) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-sm" id="name" name="name"
                            placeholder="Masukkan nama lengkap" value="{{ old('name') ?? $admin->name }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <input type="text" class="form-control form-control-sm" id="email" name="email"
                            placeholder="Masukkan alamat email" value="{{ old('email') ?? $admin->email }}"
                            autocomplete="off">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password" name="password"
                                    placeholder="Masukkan Password" value="{{ old('password') }}">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password"
                                    name="password_confirmation" placeholder="Konfirmasi Password">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
