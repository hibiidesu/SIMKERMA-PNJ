@extends('layouts.app')
@section('heading', 'Template Surat')

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
                <div class="card-header">
                    @if (Auth::user()->role_id == 1)
                        <a href="{{ url('/admin/template/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add
                            New</a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="message form">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                <p>{{ session('success') }}</p>
                            </div>
                        @endif
                    </div>
                    <table class="table table-striped w-100 table-sm" id="datatable">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th>Nama Surat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    {{-- href to asset surat tos download --}}
                                    <td>
                                        {{ $item->nama_surat }}
                                    </td>
                                    <td>
                                        @if (Auth::user()->role_id != 1)
                                            <a target="_blank" rel="noopener noreferrer" class="btn btn-success"
                                                href="{{ url('template_surat/' . $item->template_surat) }}">Download</a>
                                        @else
                                            <div class="d-flex gap-2">
                                                <a href="{{ url('/admin/template/download/' . $item->id) }}"
                                                    class="btn btn-success">Download</a>
                                                <a href="{{ url('/admin/template/edit/' . $item->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <a href="#" class="btn btn-danger"
                                                    onclick="confirmDelete({{ $item->id }})">Delete</a>

                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Aksi ini akan menghapus data surat ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/template/delete/${id}`;
                    }
                });
                return false; // Prevent the default anchor action
            }
        </script>
    </section>
@endsection
@section('scripts')
