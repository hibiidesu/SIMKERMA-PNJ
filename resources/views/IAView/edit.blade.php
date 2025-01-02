@extends('layouts.app')
@section('heading', 'Edit Implementation Agreement')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="kForm" class="form form-vertical" method="post" action="{{ url('/admin/agreement/update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $ia->id }}">
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
                                    <label class="mb-2 fw-bold text-capitalize" for="nama_mitra">Nama Mitra <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="nama_mitra" name="nama_mitra" required>
                                        <option value="{{$ia->nama_mitra}}">{{$ia->nama_mitra}}</option>
                                        @foreach($kerjasamas as $kerjasama)
                                            <option value="{{ $kerjasama->mitra }} - {{ $kerjasama->kerjasama }}" {{ $ia->nama_mitra == $kerjasama->mitra. ' - '.$kerjasama->kerjasama ? 'selected' : '' }}>
                                                {{ $kerjasama->mitra }} - {{ $kerjasama->kerjasama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="dokumen_agreement">Dokumen agreement</label>
                                    <input type="file" id="dokumen_agreement" class="form-control" name="dokumen_agreement">
                                    @if($ia->dokumen_agreement)
                                        <p class="mt-2">Dokumen saat ini: {{ $ia->dokumen_agreement }}</p><br>
                                        <small class="text-muted">Jenis file: PDF,DO,DOCX<br>Max: 10MB<br>Biarkan kosong jika tidak ingin mengganti file</small>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row justify-content-center mt-2">
                            <div class="col-md-9">
                                <iframe src="{{ asset('dokumen_agreement/'.$ia->dokumen_agreement) }}" frameborder="0"
                                    class="w-100" height="580px"></iframe>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-custom mb-1">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#nama_mitra').select2({
            placeholder: 'Pilih Mitra atau Kerjasama',
            minimumInputLength: 0
        });

        const form = document.getElementById('kForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah Anda yakin ingin memperbarui data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, perbarui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        html: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    this.submit();
                }
            });
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    @endif
</script>
@endsection
