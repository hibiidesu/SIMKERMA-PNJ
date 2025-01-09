@extends('layouts.app')
@section('heading', 'Penerapan Persetujuan')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('admin/agreement/add') }}" class="btn btn-info"> <i class="fas fa-plus"></i> &nbsp; Tambah Agreement</a>
            </div>
            <div class="card-body">
                <div class="message form">

                </div>
                <table class="table-striped w-100 table-sm" id="datatable">
                    <thead>
                        <th width='3%'>No</th>
                        <th>Nama Mitra</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{  $loop->index+1  }}</td>
                                <td>{{ $item->nama_mitra }}</td>
                                <td class="gap-2">
                                    <a href="{{ url('admin/agreement/detail/'.$item->id) }}" class="btn btn-info">Lihat</a>
                                    <a href="{{ url('admin/agreement/edit/'.$item->id) }}" class="btn btn-custom">Edit</a>
                                    <button class="btn btn-danger delete-btn" data-id="{{ $item->id }}">Hapus</button>
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
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data & dokumen akan terhapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('admin/agreement/delete') }}/" + id;
                }
            })
        });
    });
</script>
</section>
@endsection
