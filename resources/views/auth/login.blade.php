@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/pages/auth.css') }}">
@endsection
@section('content-auth')
<div id="auth" class="bg-light">
    <div class="row justify-content-center h-100">
        <div class="col-xl-5 col-12">
            <div id="auth-left" class="bg-white border">
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
                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <h2 class="text-center justify-content-center">Info!</h2>
                        <p>{{ session('info')}}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h2 class="text-center justify-content-center">Error!</h2>
                        <p>{{ session('error')}}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <h1 class="fw-bold mb-5">Log in.</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="username" type="text" class="form-control form-control-xl @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>
                        {{-- <input type="text" class="form-control form-control-xl" placeholder="Username"> --}}
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        {{-- <input type="password" class="form-control form-control-xl" placeholder="Password"> --}}
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-gray-600" for="remember">
                            Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" style="background-color: #018797; border-color: #018797;">Log in</button>
                </form>
                <a href="{{ route('sso.login') }}"
                        class="btn btn-success btn-block btn-lg mt-3 d-flex align-items-center text-center justify-content-center">
                        <div>
                            <img src="{{ asset('img/logo-pnj.png') }}" alt="Logo" width="28" height="28">
                        </div>
                        <div class="ms-2">
                            Log In with SSO PNJ
                        </div>
                    </a>
                {{-- @if (Route::has('password.request'))
                <div class="text-center mt-5 text-lg fs-4">
                    <p><a class="font-bold" href="{{ route('password.request') }}">Forgot password?</a>.</p>
                </div>
                @endif --}}
            </div>
        </div>
        {{-- <div class="col-xl-7 d-none d-xl-block">
            <div id="auth-right"></div>
        </div> --}}
    </div>
</div>
@endsection
