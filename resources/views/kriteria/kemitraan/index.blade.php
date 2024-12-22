@extends('layouts.app')
@section('heading', 'Kriteria Kemitraan')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/admin/kriteria/kemitraan/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add New</a>
            </div>
            <div class="card-body">
            <div class="message form">
                @if (session('error'))
                    <div class="alert alert-danger">
                        <p>{{session('error')}}</p>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        <p>{{session('success')}}</p>
                    </div>
                @endif
                @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
            </div>
                <table class="table table-striped w-100 table-sm" id="datatable">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>Nama Kriteria Kemitraan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->kriteria_kemitraan }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/admin/kriteria/kemitraan/edit/'. $item->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ url('/admin/kriteria/kemitraan/delete/' . $item->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn">Delete</button>
                                    </form>
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
