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
                                <td><a href={{ url('admin/agreement/detail/'.$item->id) }} target="_blank" rel="noopener noreferrer" class="btn btn-info">detail</a></td>

                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
