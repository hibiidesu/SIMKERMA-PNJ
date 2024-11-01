@extends('layouts.app')
@section('heading', 'Kerja Sama')
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <div class="row">
                    <div class="order-md-0 order-1 col-12 col-md-8">
                        <h4>{{ $data->kerjasama }}</h4>
                        <p>
                            <span>{{ $data->nomor }}</span>
                        </p>
                    </div>
                    @if (Auth::user()->role->role_name == 'admin')
                        <div class="order-md-1 order-0 col-12 col-md-4 text-md-end mb-md-0 mb-3">
                            <a href="{{ url('/admin/kerjasama/detail/'. $data->kerjasama_id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Kerja Sama</a>
                        </div>
                    @elseif (Auth::user()->role->role_name == 'pemimpin')
                        <div class="order-md-1 order-0 col-12 col-md-4 text-md-end mb-md-0 mb-3">
                            <a href="{{ url('/pemimpin/kerjasama/detail/'. $data->kerjasama_id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Kerja Sama</a>
                        </div>
                    @elseif (Auth::user()->role->role_name == 'pic')
                        <div class="order-md-1 order-0 col-12 col-md-4 text-md-end mb-md-0 mb-3">
                            <a href="{{ url('/pic/kerjasama/detail/'. $data->kerjasama_id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat Kerja Sama</a>
                        </div>
                    @endif

                </div>
                <p>
                    @if ($data->tanggal_selesai > date('Y-m-d'))
                        <span class="fs-6 badge bg-success">
                            {{ date('d F Y', strtotime($data->tanggal_mulai)) }} s/d {{ date('d F Y', strtotime($data->tanggal_selesai)) }}
                        </span>
                    @else
                        <span class="fs-6 badge bg-danger">
                            {{ date('d F Y', strtotime($data->tanggal_mulai)) }} s/d {{ date('d F Y', strtotime($data->tanggal_selesai)) }}
                        </span>
                    @endif
                    @if ($data->sifat == 'Nasional')
                        <span class="fw-bold fs-6 badge bg-info text-dark mt-lg-0 mt-2">{{ $data->sifat }}</span>
                    @elseif ($data->sifat == 'Internasional')
                        <span class="fw-bold fs-6 badge bg-warning text-dark mt-lg-0 mt-2">{{ $data->sifat }}</span>
                    @elseif ($data->sifat == 'Lokal')
                        <span class="fw-bold fs-6 badge bg-success text-light mt-lg-0 mt-2">{{ $data->sifat }}</span>
                    @endif
                </p>
                <div class="my-3">
                    <div class="d-flex">
                        <div class="fw-bold">Jenis Kerja Sama :</div>
                        <div class="ps-2">{{ $data->jenis_kerjasama->jenis_kerjasama }}</div>
                    </div>
                    <div class="d-flex">
                        <div class="fw-bold">Jenis Perjanjian :</div>
                        <div class="ps-2">
                            @foreach ($perjanjian as $item)
                                @if ($loop->index < count($perjanjian) - 1)
                                    {{ $item->pks }},&nbsp;
                                @else
                                    {{ $item->pks }}
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="fw-bold">Jurusan / Unit :</div>
                        <div class="ps-2">
                            @if($unit != "")
                                @foreach ($unit as $item)
                                    @if ($loop->index < count($unit) - 1)
                                        {{ $item->name }},&nbsp;
                                    @else
                                        {{ $item->name }}
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <p>
                    <strong>Kegiatan:</strong>
                    <br>{{ $data->kegiatan }}
                </p>
                @if ($data->file)
                <p>
                    <strong>Surat Kerja Sama:</strong>
                    <div class="row justify-content-center mt-2">
                        <div class="col-md-9">
                            <iframe src="{{ asset('surat_kerjasama/'.$data->file) }}" frameborder="0" class="w-100" height="580px"></iframe>
                        </div>
                    </div>
                </p>
                @else
                <p>
                    <strong>Surat Kerja Sama:</strong>
                    <div class="text-danger">Tidak ada surat kerja sama</div>
                </p>
                @endif
                <table class="table table-sm text-dark my-3">
                    <tr>
                        <td class="py-2 fw-bold">Nama PIC PNJ</td>
                        <td class="p-0">{{ $data->pic_pnj }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold">Alamat Perusahaan</td>
                        <td class="p-0">{{ $data->alamat_perusahaan }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold">Nama PIC Industri/PT</td>
                        <td class="p-0">{{ $data->pic_industri }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold">Jabatan PIC Industri/PT</td>
                        <td class="p-0">{{ $data->jabatan_pic_industri }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold">Telp. PIC Industri</td>
                        <td class="p-0">{{ $data->telp_industri }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold">Email</td>
                        <td class="p-0">{{ $data->email }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</section>
@endsection
