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
                @if ($errors->any())
                <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form form-vertical" method="post" action="{{ url('/admin/user/store') }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="name">Nama <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" id="username" class="form-control" name="username" required>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="text" id="email" class="form-control" name="email">
                                </div>
                            </div>

                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="role_id">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" required id="role_id" name="role_id">
                                        <option value="">-</option>
                                        @foreach ($role as $item)
                                        <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="re_password">Masukan Ulang Password <span class="text-danger">*</span></label>
                                    <input type="password" id="re_password" class="form-control" name="re_password">
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-1" style="background-color: #018797; border-color: #018797;">Submit</button>
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
