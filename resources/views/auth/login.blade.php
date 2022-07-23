@extends('layouts.auth')

@section('title', 'Login')

@section('body')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper bg-white d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5 text-center">
                        <a href="{{ route('home') }}" class="brand-logo d-flex justify-content-center">
                            <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
                        </a>
                        <h4>Silahkan Login Disini!</h4>
                        {{-- <h6 class="font-weight-light mt-3">login untuk memulai.</h6> --}}
                        <form method="POST" action="{{ route('login') }}" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-warning">MASUK</button>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check form-check-warning">
                                    <label class="form-check-label text-muted">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        Ingat saya
                                    </label>

                                </div>
                                @if (Route::has('password.request'))
                                    <a class="auth-link text-black" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>
                            <small class="text-center mt-4 font-weight-light">
                                Belum punya akun? <a href="{{ route('register') }}" class="text-warning">Daftar Disini</a>
                            </small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
