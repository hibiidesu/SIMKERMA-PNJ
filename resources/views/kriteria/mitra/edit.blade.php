@extends('layouts.app')
@section('heading', 'Edit Kriteria Mitra')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/admin/kriteria/mitra/update') }}">
                    @csrf
                    <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kriteria_mitra">Kriteria Mitra <span class="text-danger">*</span></label>
                                    <input type="text" id="kriteria_mitra" class="form-control" name="kriteria_mitra" required value="{{ $data->kriteria_mitra }}">
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
