@extends('layouts.app')
@section('heading', 'Tambah Surat Baru')

@section('content')
    <section class="row">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="kForm" class="form form-vertical" method="post" action="{{ url('/admin/template/store') }}"
                        enctype="multipart/form-data">
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
                                        <label class="mb-2 fw-bold text-capitalize" for="nama_surat"> Nama Surat <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="nama_surat" class="form-control" name="nama_surat"
                                            required autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-2 fw-bold text-capitalize" for="template_surat">File Surat <span
                                                class="text-danger">*</span></label>
                                        <input type="file" id="template_surat" class="form-control" name="template_surat"
                                            required>
                                            <small class="text-muted">Jenis file: PDF,DO,DOCX<br>Max: 10MB</small>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-custom mb-1">Submit</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kForm');

            form.addEventListener('submit', function(e) {
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
