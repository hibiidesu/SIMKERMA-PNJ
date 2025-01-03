@extends('layouts.app')

@section('heading', 'Bidang Kerjasama')
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
                <a href="{{ url('/admin/bidang-kerjasama/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add New</a>
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
                            <th>Nama Bidang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->nama_bidang}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ url('/admin/bidang-kerjasama/edit/' . $item->id) }}"
                                            class="btn btn-custom">Edit</a>
                                    </div>
                                </td>
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
@endsection