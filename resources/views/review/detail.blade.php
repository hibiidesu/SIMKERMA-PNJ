@extends('layouts.app')
@section('heading', 'Review Kerja Sama')
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <h5 class="text-center page-heading"><span>TIMELINE PENGAJUAN</span></h5>
                <div class="row">
                    <!-- Tanggal Pengajuan-->
                    <div class="col-sm">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <i class="fas fa-user align" style="font-size:48px;"></i>
                                </div>
                                <br>
                                <p class="text-center"><strong>Tanggal Pengajuan</strong></p>
                                <p class="text-center">{{ $data->created_at->format('d-m-Y') }}</p>
                                <p class="text-center">Mengajukan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Review Legal (step 3 or 2 for rejection) -->
                    @php
                        $legalReview = $data->log_persetujuan->firstWhere('step', 3);
                        $legalRejection = $data->log_persetujuan->firstWhere('step', 2);
                    @endphp
                    @if($legalReview)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Legal</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($legalReview->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center text-dark">
                                        <span class="bg-success text-white">Diterima</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($legalRejection)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Legal (Ditolak)</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($legalRejection->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center">
                                        <span class="bg-danger text-white">Ditolak</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tanggal Disetujui Wadir (step 5 or 4 for rejection) -->
                    @php
                        $wadirReview = $data->log_persetujuan->firstWhere('step', 5);
                        $wadirRejection = $data->log_persetujuan->firstWhere('step', 4);
                    @endphp
                    @if($wadirReview)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Disetujui Wadir</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($wadirReview->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center text-dark">
                                        <span class="bg-success text-white">Diterima</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($wadirRejection)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Wadir (Ditolak)</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($wadirRejection->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center">
                                        <span class="bg-danger text-white">Ditolak</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tanggal Diterima Direktur (step 7 or 6 for rejection) -->
                    @php
                        $direkturReview = $data->log_persetujuan->firstWhere('step', 7);
                        $direkturRejection = $data->log_persetujuan->firstWhere('step', 6);
                    @endphp
                    @if($direkturReview)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Diterima Direktur</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($direkturReview->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center text-dark">
                                        <span class="bg-success text-white">Diterima</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($direkturRejection)
                        <div class="col-sm">
                            <div class="card shadow h-auto">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <i class="fas fa-user align" style="font-size:48px;"></i>
                                    </div>
                                    <br>
                                    <p class="text-center"><strong>Tanggal Review Direktur (Ditolak)</strong></p>
                                    <p class="text-center">{{ \Carbon\Carbon::parse($direkturRejection->created_at)->format('d-m-Y') }}</p>
                                    <p class="text-center">
                                        <span class="bg-danger text-white">Ditolak</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body text-dark">
                <div class="row">
                    <div class="order-md-0 order-1 col-12 col-md-8">
                        <h4>{{ $data->kerjasama }}</h4>
                        <p>
                            <span>{{ $data->mitra }} - {{ $data->nomor }}</span>
                        </p>
                    </div>


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
                        <div class="fw-bold">Jenis Kerja sama :</div>
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
                    <div class="d-flex">

                        <div class="fw-bold">Prodi:</div>

                        <div class="ps-2">
                            @if($prodi != "")
                                @foreach ($prodi as $item)
                                    @if ($loop->index < count($prodi) - 1)
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
                    <strong>Surat Kerja sama:</strong>
                    <div class="row justify-content-center mt-2">
                        <div class="col-md-9">
                            <iframe src="{{ asset('surat_kerjasama/'.$data->file) }}" frameborder="0" class="w-100" height="580px"></iframe>
                        </div>
                    </div>
                </p>
                @else
                <p>
                    <strong>Surat Kerja sama:</strong>
                    <div class="text-danger">Tidak ada surat kerja sama</div>
                </p>
                @endif
                <table class="table table-sm text-dark my-3">
                    <tr>
                        <td class="py-2 fw-bold">Nama PIC PNJ</td>
                        <td class="p-0">{{ $data->pic_pnj }}</td>
                    </tr>
                    <tr>
                        <td class="py-2 fw-bold px-0" width="38%">Jabatan PIC Industri/PT</td>
                        <td class="py-0">{{ $data->jabatan_pic_industri }}</td>
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
    @if ($data->log_persetujuan)
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">
                    Log Persetujuan
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm text-dark w-100" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->log_persetujuan as $item)
                        <tr>
                            <td>{{ $loop->index+ 1 }}</td>
                            <td>{{ $item->created_at->format('d-m-Y H:m:s') }}</td>
                            <td>{{ $item->getStep() .' Oleh '. $item->user->name.'('.$item->user->role->role_name.')'   }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
    @if (Auth::user()->role->role_name=="pemimpin")
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Action</div>
            </div>
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/pemimpin/review/tolak') }}" >
                    @csrf
                    <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="catatan">Catatan <span class="text-danger">*</span></label>
                                    <textarea name="catatan" id="catatan" cols="30" class="form-control" rows="3" required></textarea>
                                    <div class="form-text text-muted">Abaikan jika anda menyetujui kerja sama ini</div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ url('/pemimpin/review/terima/'. $data->id) }}" class="btn btn-success mb-1 action-btn">Setujui</a>
                                <button type="submit" class="btn btn-danger mb-1 action-btn" style="margin-left: 5px">Tolak</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role->role_name=="admin" && $data->step != 7 && $data->catatan)
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Catatan</div>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <h6>{{ $data->reviewer->name}}</h6>
                    <p> {{ $data->catatan}} </p>
                    @if ((Auth::user()->role->role_name == 'admin' )&& ($data->step == '2' || $data->step == '4' || $data->step == '6' || $data->step == '0'))
                    <form id="hapus" action="{{url('/admin/pengajuan-kerjasama/delete/'. $data->id)}}">
                        <a href="{{ url('/admin/pengajuan-kerjasama/edit/'. $data->id) }}" class="btn btn-primary action-btn">Edit</a>
                        <button class="btn btn-danger delete-btn action-btn"  type="button"><i class="fa fa-trash"></i> Hapus</button>
                       </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role->role_name=="admin" && $data->step == 7 && $data->reviewer_id)
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Direview oleh</div>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <h6>{{ $data->reviewer->name}}</h6>

                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Dokumen Tertanda Tangan</div>

            </div>
            <div class="card-body">
                <div class="form-body">
                    <br>
                    <form class="form form-vertical" method="post" action="{{ url('/admin/pengajuan-kerjasama/dokumenakhir') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                            <label for="dokumen" class="mb-2 fw-bold text-capitalize">Dokumen Tertanda Tangan</label>
                            <input type="file" name="dokumen" id="dokumen" class="form-control">
                            <br>
                            <button type="submit" class="btn btn-success mb-1 action-btn" style="margin-left: 5px">Kirim</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role->role_name=="pic" && $data->step != 7 && $data->catatan)
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Catatan</div>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <h6>{{ $data->reviewer->name}}</h6>
                    <p> {{ $data->catatan}} </p>
                    @if (Auth::user()->role->role_name == 'pic' && ($data->step == '2' || $data->step == '4' || $data->step == '6' || $data->step == '0'))
                    <form id="hapus" action="{{url('/pic/pengajuan-kerjasama/delete/'. $data->id)}}">
                        <a href="{{ url('/pic/pengajuan-kerjasama/edit/'. $data->id) }}" class="btn btn-primary action-btn">Edit</a>
                        <button class="btn btn-danger delete-btn"  type="button"><i class="fa fa-trash"></i> Hapus</button>
                       </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @elseif(Auth::user()->role->role_name=="pic" && $data->step == 7 && $data->reviewer_id)
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Direview oleh</div>
            </div>
            <div class="card-body">
                <div class="form-body">
                    <h6>{{ $data->reviewer->name}}</h6>
                </div>
            </div>
        </div>
    </div>
    @elseif (Auth::user()->role->role_name=="legal")
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Action</div>
            </div>
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/legal/review/tolak') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="catatan">Catatan <span class="text-danger">*</span></label>
                                    <textarea name="catatan" id="catatan" cols="30" class="form-control" rows="3" required></textarea>
                                    <br>
                                    <label for="nomor" class="mb-2 fw-bold text-capitalize">Nomor</label>
                                    <input type="text" name="nomor" id="nomor" class="form-control">
                                    <label for="dokumen" class="mb-2 fw-bold text-capitalize">Dokumen Perbaikan</label>
                                    <input type="file" name="dokumen" id="dokumen" class="form-control">
                                    <div class="form-text text-muted">Abaikan jika anda menyetujui kerja sama ini</div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ url('/legal/review/terima/'. $data->id) }}" class="btn btn-success mb-1 action-btn">Setujui</a>
                                <button type="submit" class="btn btn-danger mb-1 action-btn" style="margin-left: 5px">Tolak</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @elseif (Auth::user()->role->role_name=="direktur")
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <div class="card-title fw-bold text-dark">Action</div>
            </div>
            <div class="card-body">
                <form class="form form-vertical" method="post" action="{{ url('/direktur/review/tolak') }}" >
                    @csrf
                    <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="catatan">Catatan <span class="text-danger">*</span></label>
                                    <textarea name="catatan" id="catatan" cols="30" class="form-control" rows="3" required></textarea>
                                    <div class="form-text text-muted">Abaikan jika anda menyetujui kerja sama ini</div>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ url('/direktur/review/terima/'. $data->id) }}" class="btn btn-success mb-1 action-btn">Setujui</a>
                                <button type="submit" class="btn btn-danger mb-1 action-btn" style="margin-left: 5px">Tolak</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endif
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelectorAll('.action-btn');

        actionButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const url = this.href || this.form.action;
                const form = this.closest('form');
                if (form && form.id === 'hapus' && this.classList.contains('delete-btn')) {
                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menghapus?',
                        text: "Anda tidak akan dapat mengembalikan ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitForm(form);
                        }
                    });
                    return;
                }

                if (this.tagName === 'BUTTON' && this.type === 'submit') {
                    if (form && !form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                }

                showLoadingAndSubmit(this);
            });
        });

        function showLoadingAndSubmit(element) {
            Swal.fire({
                title: 'Loading...',
                html: 'Memproses data ke server...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                if (element.tagName === 'A') {
                    window.location.href = element.href;
                } else if (element.tagName === 'BUTTON') {
                    element.form.submit();
                }
            }, 100);
        }

        function submitForm(form) {
            Swal.fire({
                title: 'Loading...',
                html: 'Memproses data ke server...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                form.submit();
            }, 100);
        }
    });
</script>
@endsection
