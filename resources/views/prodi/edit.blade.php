@extends('layouts.app')
@section('heading', 'Edit Prodi')

@section('styles')
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/admin/prodi/update') }}">
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
                                    <label class="mb-2 fw-bold text-capitalize" for="unit_id">Unit<span class="text-danger">*</span></label>
                                    <select class="form-select" required id="unit_id" name="unit_id">
                                        <option value="{{ $prodi->unit_id }}">{{ $prodi->unit->name }}</option>
                                        @foreach ($unit as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="name">Nama Prodi<span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" required autofocus value="{{ $prodi->name }}">
                                    <input type="hidden" name="prodi_id" value="{{ $prodi->id }}">
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" style="background-color: #018797; border-color: #018797;"class="btn btn-primary mb-1">Submit</button>
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
