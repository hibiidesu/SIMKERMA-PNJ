@extends('layouts.app')
@section('heading', 'Review Kerja Sama')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @if (Auth::user()->role->role_name == 'admin')
                    <a href="{{ url('/admin/pengajuan-kerjasama/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add New</a>
                @elseif (Auth::user()->role->role_name == 'pic')
                    <a href="{{ url('/pic/pengajuan-kerjasama/add') }}" class="btn btn-info"><i class="fas fa-plus"></i> &nbsp;Add New</a>
                @endif
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
                <table class="table table-striped table-sm table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>Name</th>
                            <th>Nomor</th>
                            <th width="15%">Created at</th>
                            <th width="10%">Created by</th>
                            <th width="3%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            @if (Auth::user()->role->role_name == 'admin')
                            <td> <a href="{{ url('/admin/pengajuan-kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'pemimpin')
                            <td> <a href="{{ url('/pemimpin/review/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'pic')
                            <td> <a href="{{ url('/pic/pengajuan-kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @endif
                            <td>{{ $item->nomor }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                {{ $item->user->username }}
                            </td>
                            <td>
                                @if ($item->step == '1')
                                    <span class="badge bg-warning text-dark mt-lg-0 mt-2">Menunggu Review</span>
                                @elseif ($item->step == '2')
                                    @if ($item->catatan)
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak dengan Catatan</span>
                                    @else
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak</span>
                                    @endif
                                @elseif ($item->step == '3')
                                    <span class="badge bg-success text-white mt-lg-0 mt-2">Diterima</span>
                                @endif
                            </td>

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
