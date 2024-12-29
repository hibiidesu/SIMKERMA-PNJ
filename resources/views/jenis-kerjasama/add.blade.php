@extends('layouts.app')
@section('heading', 'Jenis Kerja Sama')

@section('styles')
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/admin/jenis-kerjasama/store') }}">
                    @csrf
                    <div class="form-body">
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="jenis_kerjasama">jenis kerja sama <span class="text-danger">*</span></label>
                                    <input type="text" id="jenis_kerjasama" class="form-control" name="jenis_kerjasama" required>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                           <button type="submit" class="btn mb-1" style="background-color: #018797; color: white;">Submit</button>
                           </div>

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
