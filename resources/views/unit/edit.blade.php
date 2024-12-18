@extends('layouts.app')
@section('heading', 'Unit')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="kForm" class="form form-vertical" method="post" action="{{ url('/admin/unit/update') }}">
                    @csrf
                    <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="name">jenis kerja sama <span class="text-danger">*</span></label>
                                    <input type="text" id="name" class="form-control" name="name" required value="{{ $data->name }}">
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
@endsection
