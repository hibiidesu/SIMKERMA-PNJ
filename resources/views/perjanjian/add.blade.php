@extends('layouts.app')
@section('heading', 'Perjanjian')
{{-- {{ Auth::user()->role->role_name }} --}}

@section('styles')
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/admin/perjanjian-kerjasama/store') }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="pks">Nama Perjanjian (PKS) <span class="text-danger">*</span></label>
                                    <input type="text" id="pks" class="form-control" name="pks" required>
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
@endsection
