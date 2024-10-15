
@extends('admin.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/pages/auth.css') }}">
@endsection
@section('content-auth')
<div id="auth">
    <div class="row justify-content-center h-100">
        <div class="col-xl-5 col-12">
            <div id="auth-left" class="border">
                <div class="auth-logo mb-5">
                    <a href="{{ url('/') }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <img src="{{ asset('img/logo-pnj.png') }}" alt="logo" style="height: 55px">
                            </div>
                            <div class="h2 fw-bolder ps-2 mt-3" style="font-family: 'Viga'; color: #088A9A">SIMKERMA</div>
                        </div>
                    </a>
                </div>
                <br>
                <br>
                <h1 class="fw-bold mb-5">Forgot Password</h1>
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send Password Reset Link</button>
                </form>
                <div class="text-center mt-5 text-lg fs-4">
                    <p class='text-gray-600'>Remember your account? <a href="{{ url('/login') }}" class="font-bold">Log in</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
