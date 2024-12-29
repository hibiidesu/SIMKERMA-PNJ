@extends('layouts.app')
@section('heading', 'Kerja Sama')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/vendors/choices.js/choices.min.css') }}">
@endsection
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if (Auth::user()->role->role_name == 'admin')
                    <form class="form form-vertical" method="post" action="{{ url('/admin/kerjasama/update') }}" enctype="multipart/form-data">
                @elseif (Auth::user()->role->role_name == 'pic')
                    <form class="form form-vertical" method="post" action="{{ url('/pic/kerjasama/update') }}" enctype="multipart/form-data">
                @endif
                    @csrf
                    <input type="hidden" readonly required class="form-control" name="id" value="{{ $data->id }}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kerjasama">Kerja sama <span class="text-danger">*</span></label>
                                    <input type="text" id="kerjasama" class="form-control" name="kerjasama" required value="{{ $data->kerjasama }}">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="tanggal_mulai">tanggal mulai <span class="text-danger">*</span></label>
                                    <input type="date" id="tanggal_mulai" class="form-control" name="tanggal_mulai" required value="{{ $data->tanggal_mulai }}">
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="tanggal_selesai">tanggal selesai <span class="text-danger">*</span></label>
                                    <input type="date" id="tanggal_selesai" class="form-control" name="tanggal_selesai" required value="{{ $data->tanggal_selesai }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="nomor">nomor <span class="text-danger">*</span></label>
                                    <input type="text" id="nomor" class="form-control" name="nomor" value="{{ $data->nomor }}" required>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kegiatan">kegiatan</label>
                                    <textarea id="kegiatan" class="form-control" name="kegiatan" rows="3">{{ $data->kegiatan }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kerjasama">Sifat (Nasional / Internasional) <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sifat" id="sifat1" value="Nasional" required {{ $data->sifat == 'Nasional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sifat1">
                                            Nasional
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sifat" id="sifat2" value="Internasional" {{ $data->sifat == 'Internasional' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sifat2">
                                            Internasional
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="jenis_kerjasama_id">Jenis Kerja Sama <span class="text-danger">*</span></label>
                                    <select class="form-select" required id="jenis_kerjasama_id" name="jenis_kerjasama_id">
                                        <option value="">-</option>
                                        @foreach ($jenisKerjasama as $item)
                                        <option value="{{ $item->id }}" {{ $data->jenis_kerjasama_id == $item->id ? 'selected' : '' }}>{{ $item->jenis_kerjasama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <?php
                                    $explodeMitra = explode(',', $data->kriteria_mitra_id)
                                    ?>
                                    <label class="mb-2 fw-bold text-capitalize" for="kriteria_mitra_id">Kriteria Mitra <span class="text-danger">*</span></label>
                                    <select class="choices form-select" multiple="multiple" required id="kriteria_mitra_id" name="kriteria_mitra_id[]" multiple>
                                        @foreach ($kriteria_mitra as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $explodeMitra)? 'selected' : '' }}>{{ $item->id }}. {{ $item->kriteria_mitra }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <?php
                                $explodeKemitraan = explode(',', $data->kriteria_kemitraan_id)
                                ?>
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="kriteria_kemitraan_id">Kriteria Kemitraan <span class="text-danger">*</span></label>
                                    <select class="choices-2 form-select" multiple="multiple" required id="kriteria_kemitraan_id" name="kriteria_kemitraan_id[]" multiple>
                                        @foreach ($kriteria_kemitraan as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $explodeKemitraan)? 'selected' : '' }}>{{ $item->kriteria_kemitraan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <?php
                                    $explodedPKS = explode(',', $data->pks);
                                ?>
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="perjanjian">Jenis Perjanjian <span class="text-danger">*</span></label>
                                    <select class="choices-3 form-select" multiple="multiple" id="perjanjian" name="perjanjian[]" required>
                                        @foreach ($perjanjian as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $explodedPKS) ? 'selected' : '' }}>{{ $item->pks }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="jurusan">Jurusan / Unit <span class="text-danger">*</span></label>
                                    <?php
                                        $explodedUnit = explode(',', $data->jurusan);
                                    ?>
                                    <select class="choices-4 form-select" multiple="multiple" id="jurusan" name="jurusan[]" required>
                                        @foreach ($unit as $item)
                                        <option value="{{ $item->id }}" {{ in_array($item->id, $explodedUnit) ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="pic_pnj">Nama PIC PNJ <span class="text-danger">*</span></label>
                                    <input type="text" id="pic_pnj" class="form-control" name="pic_pnj" required value="{{ $data->pic_pnj }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="alamat_perusahaan">Alamat Perusahaan <span class="text-danger">*</span></label>
                                    <input type="text" id="alamat_perusahaan" class="form-control" name="alamat_perusahaan" required value="{{ $data->alamat_perusahaan }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="pic_industri">Nama PIC Industri/PT <span class="text-danger">*</span></label>
                                    <input type="text" id="pic_industri" class="form-control" name="pic_industri" required value="{{ $data->pic_industri }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="jabatan_pic_industri">Jabatan PIC Industri/PT <span class="text-danger">*</span></label>
                                    <input type="text" id="jabatan_pic_industri" class="form-control" name="jabatan_pic_industri" required value="{{ $data->jabatan_pic_industri }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="telp_industri">Telp. PIC Industri</label>
                                    <input type="tel" id="telp_industri" class="form-control" name="telp_industri" value="{{ $data->telp_industri }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="email">Email</label>
                                    <input type="email" id="email" class="form-control" name="email" value="{{ $data->email }}">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label class="mb-2 fw-bold text-capitalize" for="file">Surat Kerja Sama</label>
                                    <input type="file" id="file" class="form-control" name="file" accept="application/pdf">
                                    <div class="form-text text-muted">Upload surat kerja sama baru untuk mengganti surat kerja sama lama</div><br>

                                    @if ($data->file)
                                        <iframe src="{{ asset('surat_kerjasama/'.$data->file) }}" frameborder="0" class="w-100" height="580px"></iframe>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" style="background-color: #018797; border-color: #018797;class="btn btn-primary mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('admin/vendors/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/form-element-select.js') }}"></script>
@endsection
