@extends('layouts.app')
@section('heading', 'User')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/vendors/choices.js/choices.min.css') }}">
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger">
                        <p>{{session('error')}}</p>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        <p>{{session('success')}}</p>
                    </div>
                @endif
                @if ($errors->any())
                <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Request::segment(2) == 'my-profile')
                    <form class="form form-vertical" method="post" action="{{ url('/'.Request::segment(1).'/my-profile/update') }}">
                @else
                    <form class="form form-vertical" method="post" action="{{ url('/admin/user/update') }}">
                        <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                @endif
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="name">Nama <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" required value="{{ $data->name }}">
                                </div>
                            </div>
                            @if (Request::segment(2) != 'my-profile')
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" id="username" class="form-control" name="username" required value="{{ $data->username }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" id="email" class="form-control" name="email" required value="{{ $data->email }}">
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="role_id">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role_id" name="role_id" required>
                                        <option value="">-</option>
                                        @foreach ($role as $item)
                                        <option value="{{ $item->id }}" {{ $data->role_id == $item->id ? 'selected' : '' }}>{{ $item->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="password">Password</label>
                                    <input type="password" id="password" class="form-control" name="password" >
                                    <small id="emailHelp" class="form-text text-muted">Abaikan jika tidak ingin mengubah password</small>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="re_password">Masukan Ulang Password</label>
                                    <input type="password" id="re_password" class="form-control" name="re_password" >
                                    <small id="emailHelp" class="form-text text-muted">Abaikan jika tidak ingin mengubah password</small>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('admin/vendors/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/form-element-select.js') }}"></script>
@endsection
