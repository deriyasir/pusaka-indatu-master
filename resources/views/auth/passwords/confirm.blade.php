@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('body')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5 text-center">
                        <div class="brand-logo d-flex justify-content-center">
                            <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
                        </div>
                        <h4>Confirm Password</h4>
                        <h6 class="font-weight-light mt-3">Please confirm your password before continuing.</h6>
                        <form method="POST" action="{{ route('password.confirm') }}" class="mt-4">
                            @csrf
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
                                <button type="submit" class="btn btn-block btn-warning">CONFIRM PASSWORD</button>
                            </div>
                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="auth-link text-black" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
