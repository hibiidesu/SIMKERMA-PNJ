@extends('layouts.app')
@section('heading', 'Edit surat')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Edit Surat</h4>
                    <button class="btn btn-danger" onclick="confirmDelete({{ $template->id }})">Delete</button>
                </div>
                <form class="form form-vertical" method="post" action="{{ route('template.update', $template->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
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
                                    <label class="mb-2 fw-bold text-capitalize" for="nama_surat">Nama Surat <span class="text-danger">*</span></label>
                                    <input type="text" id="nama_surat" class="form-control" name="nama_surat" value="{{ old('nama_surat', $template->nama_surat) }}" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="col-12 mb-2">
                                    <div class="form-group">
                                        <label class="mb-2 fw-bold text-capitalize" for="template_surat">Update surat: {{ $template->template_surat ?: 'Null' }}</label>
                                        <input type="file" id="template_surat" class="form-control" name="template_surat">
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file</small>
                                    </div>
                                </div>
                            @if($template->template_surat)
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize">Preview</label>
                                    <div>
                                        <embed src="{{ asset('/template_surat/' . $template->template_surat) }}" type="application/pdf" width="100%" height="600px" />
                                    </div>
                                </div>
                            </div>

                            @endif
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-1">Update</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Aksi ini akan menghapus data surat ini!  ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/admin/template/delete/${id}`;
        }
    })
}

// Update file input label with selected filename
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
})
</script>
@endsection
