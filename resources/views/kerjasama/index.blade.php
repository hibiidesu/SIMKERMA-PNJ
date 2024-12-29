@extends('layouts.app')
@section('heading', 'Kerja Sama')

@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
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

                @if (Request::get('filter'))
                    @if (Auth::check() && Auth::user()->role->role_name == 'admin')
                        <a href="{{ url('admin/kerjasama/export'.str_replace(url('/admin/kerjasama'), '', URL::full())) }}" class="btn btn-primary" style="float: right;"><i class="fas fa-file-excel"></i> Generate Excel</a>
                    @elseif (Auth::check() && Auth::user()->role->role_name == 'pemimpin')
                        <a href="{{ url('pemimpin/kerjasama/export'.str_replace(url('/pemimpin/kerjasama'), '', URL::full())) }}" class="btn btn-primary" style="float: right;"><i class="fas fa-file-excel"></i> Generate Excel</a>
                    @elseif (Auth::check() && Auth::user()->role->role_name == 'pic')
                        <a href="{{ url('pemimpin/kerjasama/export'.str_replace(url('/pic/kerjasama'), '', URL::full())) }}" class="btn btn-primary" style="float: right;"><i class="fas fa-file-excel"></i> Generate Excel</a>
                    @endif
                @else
                    @if (Auth::check() && Auth::user()->role->role_name == 'admin')
                    <a href="{{ url('admin/kerjasama/export') }}" 
                    class="btn" 
                    style="background-color: #018797; border-color: #018797; color: white; float: right;">
                    <i class="fas fa-file-excel"></i> Generate Excel
                    </a>
                    @elseif (Auth::check() && Auth::user()->role->role_name == 'pemimpin')
                    <a href="{{ url('pemimpin/kerjasama/export') }}" 
                    class="btn" 
                    style="background-color: #018797; border-color: #018797; color: white; float: right;">
                    <i class="fas fa-file-excel"></i> Generate Excel
                    </a>
                    @elseif (Auth::check() && Auth::user()->role->role_name == 'pic')
                    <a href="{{ url('pic/kerjasama/export') }}" 
                    class="btn" 
                    style="background-color: #018797; border-color: #018797; color: white; float: right;">
                   <i class="fas fa-file-excel"></i> Generate Excel
                   </a>
                    @endif
                @endif

                <form action="" method="get">
                    <h5>Filter:</h5>
                    <div style="display: flex; flex-wrap: nowrap; gap: 20px; justify-content: space-between;">
                        <div class="form-group">
                            <label for="date">Masa Berlaku</label>
                            <div class="form-group" style="flex: 1 1 15%; min-width: 120px;">
                                <select name="date" id="date" class="form-select">
                                    <option value="1" {{ Request::get('date') == '1' ? 'selected' : '' }}>Semua</option>
                                    <option value="2" {{ Request::get('date') == '2' ? 'selected' : '' }}>Masih Berlaku</option>
                                    <option value="3" {{ Request::get('date') == '3' ? 'selected' : '' }}>Segera Berakhir</option>
                                    <option value="4" {{ Request::get('date') == '4' ? 'selected' : '' }}>Sudah Berakhir</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sifat">Sifat</label>
                            <div class="form-group" style="flex: 1 1 15%; min-width: 120px;">
                                <select name="sifat" id="sifat" class="form-select">
                                    <option value="all" {{ Request::get('sifat') == 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="Lokal" {{ Request::get('sifat') == 'Lokal' ? 'selected' : '' }}>Lokal</option>
                                    <option value="Nasional" {{ Request::get('sifat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                    <option value="Internasional" {{ Request::get('sifat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Jenis kerja sama</label>
                            <div class="form-group" style="flex: 1 1 15%; min-width: 120px;">
                                <select class="form-select" required id="type" name="type">
                                    <option value="all">Semua</option>
                                    @foreach ($jenisKerjasama as $item)
                                    <option value="{{ $item->id + 1 }}" {{ Request::get('type') == $item->id + 1 ? 'selected' : '' }}>{{ $item->jenis_kerjasama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Kriteria Kemitraan</label>
                            <div class="form-group" style="flex: 1 1 15%; min-width: 120px;">
                                <select class="form-select" required id="k_kemitraan" name="k_kemitraan">
                                    <option value="all">Semua</option>
                                    @foreach ($kriteria_kemitraan_filter as $item)
                                    <option value="{{ $item->id}}" {{ Request::get('k_kemitraan') == $item->id  ? 'selected' : '' }}>{{ $item->kriteria_kemitraan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">Kriteria Mitra</label>
                            <div class="form-group" style="flex: 1 1 15%; min-width: 120px;">
                                <select class="form-select" required id="k_mitra" name="k_mitra">
                                    <option value="all">Semua</option>
                                    @foreach ($kriteria_mitra_filter as $item)
                                    <option value="{{ $item->id}}" {{ Request::get('k_mitra') == $item->id ? 'selected' : '' }}>{{ $item->kriteria_mitra }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="form-group" style="flex: 1 1 18%; min-width: 150px;">
                        <button class="btn btn-primary mt-4" type="submit" name="filter" value="true" style="background-color: #018797; border-color: #018797; color: white;"> Terapkan
                        </button>
                                @if (Request::get('filter'))
                                    @if (Auth::check() && Auth::user()->role->role_name == 'admin')
                                        <a href="{{ url('admin/kerjasama') }}" class="btn btn-secondary mt-4" title="Hapus Filter"><i class="fas fa-times"></i></a>
                                    @elseif (Auth::check() && Auth::user()->role->role_name == 'pemimpin')
                                        <a href="{{ url('pemimpin/kerjasama') }}" class="btn btn-secondary mt-4" title="Hapus Filter"><i class="fas fa-times"></i></a>
                                    @elseif (Auth::check() && Auth::user()->role->role_name == 'legal')
                                        <a href="{{ url('legal/kerjasama') }}" class="btn btn-secondary mt-4" title="Hapus Filter"><i class="fas fa-times"></i></a>
                                    @elseif (Auth::check() && Auth::user()->role->role_name == 'direktur')
                                        <a href="{{ url('direktur/kerjasama') }}" class="btn btn-secondary mt-4" title="Hapus Filter"><i class="fas fa-times"></i></a>
                                    @elseif (Auth::check() && Auth::user()->role->role_name == 'pic')
                                        <a href="{{ url('pic/kerjasama') }}" class="btn btn-secondary mt-4" title="Hapus Filter"><i class="fas fa-times"></i></a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <table class="table table-striped table-sm table-sm" id="datatable">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>Nama Mitra</th>
                            <th>Kerjasama</th>
                            <th>Nomor</th>
                            <th>Tanggal Berlaku</th>
                            <th>Sifat</th>
                            {{-- <th>Kriteria Kemitraan</th>
                            <th>Kriteria Mitra</th> --}}
                            <th>Jenis Kerja Sama</th>
                            <th>Jenis Perjanjian</th>
                            <th>Unit</th>
                            <th>Prodi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->mitra }}</td>
                            @if (Auth::user()->role->role_name == 'admin')
                            <td> <a href="{{ url('/admin/kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'pemimpin')
                            <td> <a href="{{ url('/pemimpin/kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'direktur')
                            <td> <a href="{{ url('/direktur/kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @elseif (Auth::user()->role->role_name == 'pic')
                            <td> <a href="{{ url('/pic/kerjasama/detail/'. $item->id) }}" >{{ $item->kerjasama }}</a>   </td>
                            @endif
                            <td>{{ $item->nomor }}</td>
                            <td>
                                @if ($item->tanggal_selesai > date('Y-m-d'))
                                    @if (date('Y') - date('Y', strtotime($item->tanggal_selesai)) == 0 && date('m') - date('m', strtotime($item->tanggal_selesai)) >= -3)
                                        <span class="badge bg-warning text-dark">
                                            {{ date('Y/m/d', strtotime($item->tanggal_mulai)).' - '. date('Y/m/d', strtotime($item->tanggal_selesai)) }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            {{ date('Y/m/d', strtotime($item->tanggal_mulai)).' - '. date('Y/m/d', strtotime($item->tanggal_selesai)) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-danger">
                                        {{ date('Y/m/d', strtotime($item->tanggal_mulai)).' - '. date('Y/m/d', strtotime($item->tanggal_selesai)) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($item->sifat == 'Nasional')
                                    <span class="badge bg-info text-dark mt-lg-0 mt-2">{{ $item->sifat }}</span>
                                @elseif ($item->sifat == 'Internasional')
                                    <span class="badge bg-primary mt-lg-0 mt-2">{{ $item->sifat }}</span>
                                @endif
                            </td>
                            {{-- <td>
                                @foreach (explode(',', $item->kriteria_kemitraan_id) as $kmt )
                                @if ($loop->index + 1 < count(explode(',', $item->kriteria_kemitraan_id)))
                                {{ $kriteria_kemitraan[$kmt].', ' }}
                                @else
                                {{ $kriteria_kemitraan[$kmt] }}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach (explode(',', $item->kriteria_mitra_id) as $kt)
                                @if ($loop->index + 1 < count(explode(',', $item->kriteria_mitra_id)))
                                    {{ $kriteria_mitra[$kt] ?? '' }},
                                @else
                                    {{ $kriteria_mitra[$kt] ?? '' }}
                                @endif
                            @endforeach

                            </td> --}}

                            <td>{{ $item->jenis_kerjasama->jenis_kerjasama }}</td>
                            <td>
                                @foreach (explode(',', $item->pks) as $x)
                                    @if ($loop->index + 1 < count(explode(',', $item->pks)))
                                    {{ $perjanjian[$x].', ' }}
                                    @else
                                    {{ $perjanjian[$x] }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @if ($item->jurusan)
                                    @foreach (explode(',', $item->jurusan) as $x)
                                        @if ($loop->index + 1 < count(explode(',', $item->jurusan)))
                                        {{ $unit[$x].', ' }}
                                        @else
                                        {{ $unit[$x] }}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($item->prodi)
                                    @php
                                        $prodiArray = explode(',', $item->prodi);
                                    @endphp
                                    @foreach ($prodiArray as $index => $x)
                                        @if (array_key_exists($x, $prodi))
                                         {{ $prodi[$x] }}{{ $index + 1 < count($prodiArray) ? ', ' : '' }}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            {{-- <td>
                                <a href="{{ url('/admin/kerjasama/detail/'. $item->id) }}" class="btn btn-primary">Detail</a>
                            </td> --}}
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
