@extends('layouts.app')
@section('heading', 'Tambah Kriteria Mitra')

@section('styles')
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="kForm" class="form form-vertical" method="post" action="{{ url('/admin/kriteria/mitra/store') }}">
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
                                    <label class="mb-2 fw-bold text-capitalize" for="kriteria_mitra">Kriteria Mitra <span class="text-danger">*</span></label>
                                    <input type="text" id="kriteria_mitra" class="form-control" name="kriteria_mitra" required autofocus>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('kForm');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Loading...',
                    html: 'Memproses data ke server...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Submit the form
                this.submit();
            });
        });
    </script>
</section>
@endsection

@section('scripts')
@endsection
