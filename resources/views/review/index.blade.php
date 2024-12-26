@extends('layouts.app')
@section('heading', 'Tambah / Review Kerja Sama')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                @if (Auth::user()->role->role_name == 'admin')
                    <a href="{{ url('/admin/pengajuan-kerjasama/record') }}" class="btn btn-primary"><i class="fas fa-clipboard"></i> &nbsp;Add New Record</a>
                    <a href="{{ url('/admin/pengajuan-kerjasama/add') }}" class="btn btn-success"><i class="fas fa-plus"></i> &nbsp;Add New Request</a>
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
                            <th>Mitra</th>
                            <th>Judul</th>
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
                            <td>{{ $item->mitra }}</td>
                            @if (Auth::user()->role->role_name == 'admin')
                            <td> <a href="{{ url('/admin/pengajuan-kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'legal')
                            <td> <a href="{{ url('/legal/review/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'pemimpin')
                            <td> <a href="{{ url('/pemimpin/review/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'direktur')
                            <td> <a href="{{ url('/direktur/review/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'pic')
                            <td> <a href="{{ url('/pic/pengajuan-kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @endif
                            <td>{{ $item->nomor }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                {{ $item->user->username }}
                            </td>
                            <td>
                                @if ($item->step == '0')
                                <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak System</span>
                                @elseif ($item->step == '1')
                                    <span class="badge bg-warning text-black mt-lg-0 mt-2">Menunggu Review Legal</span>
                                @elseif ($item->step == '2')
                                    @if ($item->catatan)
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak dengan Catatan Legal</span>
                                    @else
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak Legal</span>
                                    @endif
                                @elseif ($item->step == '3')
                                    <span class="badge bg-warning text-black mt-lg-0 mt-2">Menunggu Review WD4</span>
                                @elseif ($item->step == '4')
                                    @if ($item->catatan)
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak dengan Catatan WD4</span>
                                    @else
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak WD4</span>
                                    @endif
                                @elseif ($item->step == '5')
                                    <span class="badge bg-warning text-black mt-lg-0 mt-2">Menunggu Review Direktur</span>
                                @elseif ($item->step == '6')
                                    @if ($item->catatan)
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak dengan Catatan Direktur</span>
                                    @else
                                        <span class="badge bg-danger text-white mt-lg-0 mt-2">Ditolak Direktur</span>
                                    @endif
                                @elseif ($item->step == '7')
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
