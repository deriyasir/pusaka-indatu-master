@extends('layouts.auth')

@section('title', 'Reset')

@section('body')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5 text-center">
                        <div class="brand-logo d-flex justify-content-center">
                            <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
                        </div>
                        <h4>Reset Password</h4>
                        <h6 class="font-weight-light mt-3">Enter your email address.</h6>
                        @if (session('status'))
                            <div class="alert alert-success mt- font-weight-bold" role="alert">
                                <small>{{ session('status') }}</small>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="my-3">
                                <button type="submit" class="btn btn-block btn-warning">SEND PASSWORD RESET LINK</button>
                            </div>
                            <small class="text-center mt-4 font-weight-light">
                                <a href="{{ route('login') }}" class="text-warning">Back</a>
                            </small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
