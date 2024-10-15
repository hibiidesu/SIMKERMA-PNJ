@extends('layouts.app')
@section('heading', 'Unit')

@section('styles')
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/admin/unit/store') }}">
                    @csrf
                    <div class="form-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="name">Unit Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" required autofocus>
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
