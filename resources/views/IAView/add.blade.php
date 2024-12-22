@extends('layouts.app')
@section('heading', 'Tambah Agreement Baru')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="kForm" class="form form-vertical" method="post" action="{{ url('/admin/agreement/store') }}" enctype="multipart/form-data">
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
                                    <label class="mb-2 fw-bold text-capitalize" for="nama_mitra">Nama Mitra <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="nama_mitra" name="nama_mitra" required>
                                        <option value="">Pilih Mitra</option>
                                    </select>
                                    <input type="hidden" id="mitra_id" name="mitra_id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="dokumen_agreement">Dokumen agreement <span class="text-danger">*</span></label>
                                    <input type="file" id="dokumen_agreement" class="form-control" name="dokumen_agreement" required>
                                    <small class="text-muted">Jenis file: PDF,DO,DOCX<br>Max: 10MB</small>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <table class="table table-striped w-100 table-sm" id="datatable">
                    <thead>
                        <th width="3%">No</th>
                        <th>Judul Pengajuan</th>
                        <th>Jenis Dokumen</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->index+ 1 }}</td>
                            <td>{{ $item->kerjasama }}</td>
                            <td>{{ $item->pks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
            ajax: {
                url: '/admin/api/getAllKerjasama',
                dataType: 'json',
                delay: 50,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                            .filter(item => {
                                const searchTerm = $('#nama_mitra').data('select2').dropdown.$search.val().toLowerCase();
                                return item.mitra.toLowerCase().includes(searchTerm) || item.kerjasama.toLowerCase().includes(searchTerm);
                            })
                            .map(item => ({
                                id: `${item.mitra} - ${item.kerjasama}`,
                                text: `${item.mitra} - ${item.kerjasama}`
                            }))
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Mitra atau Kerjasama',
            minimumInputLength: 0
        }).on('select2:select', function(e) {
            var data = e.params.data;
            $('#mitra_id').val(data.id);
        });

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
