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
                <div class="alert alert-danger">
                    <p>{{ session('info') }}</p>
                </div>
                @endif
                <h1 class="fw-bold mb-5">Register</h1>
                <form method="post">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" value="{{$data["email"]}}" disabled id="email" class="form-control form-control-xl" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <input type="hidden" name="name" value="{{$data["name"]}}">
                    <input type="hidden" name="email" value="{{$data["email"]}}">
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
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="repassword" type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" name="repassword" required autocomplete="current-password" placeholder="Re-Enter Password">
                        <small id="emailHelp" class="form-text text-muted">Minimum 8 karakter</small>
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
