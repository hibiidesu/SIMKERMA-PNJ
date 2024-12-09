@extends('layouts.app')
@section('heading', 'Template Surat')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/admin/template/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add New</a>
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
                            <th>Nama Surat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            {{-- href to asset surat to download --}}
                            <td>{{ $item->nama_surat }}</td>
                            <td>
                                @if(Auth::user()->role_id == 1)
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/admin/template/delete/'. $item->id) }}" class="btn btn-danger">Delete</a>
                                </div>
                                @endif
                                <div class="d-flex">
                                    <a href="{{ url('/admin/template/download/'. $item->id) }}" class="btn btn-info">Download</a>
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
