@extends('layouts.app')
@section('heading', 'Prodi')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/admin/prodi/add') }}" class="btn btn-info"style="background-color: #018797; border-color: #018797;" ><i class="fas fa-plus"></i> &nbsp;Add New</a>
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
            </div>
                <table class="table table-striped w-100 table-sm" id="datatable">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>Prodi Name</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prodi as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->unit->name }} ({{ $item->unit->id }})</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ url('/admin/prodi/edit/'. $item->id) }}" style="background-color: #018797; border-color: #018797;" class="btn btn-primary">Edit</a>
                                    <form action="{{ url('/admin/prodi/delete/' . $item->id) }}" method="POST" class="delete-form">
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
