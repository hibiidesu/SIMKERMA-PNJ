@extends('layouts.app')
@section('heading', 'User')

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
                    <a href="{{ url('/admin/user/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add New</a>
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
                    <table class="table table-striped w-100" id="datatable">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->role->role_name }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ url('/admin/user/edit/' . $item->id) }}"
                                                class="btn btn-custom">Edit</a>
                                            @if ($item->status == 0)
                                                <a href="{{ url('/admin/user/activate/' . $item->id) }}"
                                                    class="btn btn-success ms-2">Aktifkan</a>
                                            @else
                                                <a href="{{ url('/admin/user/deactivate/' . $item->id) }}"
                                                    class="btn btn-danger ms-2">nonaktifkan</a>
                                            @endif
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
