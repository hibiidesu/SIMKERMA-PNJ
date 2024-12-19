@extends('layouts.app')
@section('heading', 'Detail')
@section('content')
<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <p><Strong>Nama Mitra</Strong> : <Strong>{{ $ia->nama_mitra }}</Strong></p>
                @if ($ia->dokumen_agreement)
                <p>
                    <strong>Dokumen Agreement : </strong>
                <div class="row justify-content-center mt-2">
                    <div class="col-md-9">
                        <iframe src="{{ asset('dokumen_agreement/'.$ia->dokumen_agreement) }}" frameborder="0"
                            class="w-100" height="580px"></iframe>
                    </div>
                </div>
                </p>
                @else
                <p>
                    <strong>Surat Kerja sama:</strong>
                <div class="text-danger">Tidak ada surat kerja sama</div>
                </p>
                @endif
                <table class="table table-striped w-100 table-sm" id="datatable">
                    <thead>
                        <th>no</th>
                        <th>Nama Pengajuan</th>
                        <th>Jenis Pengajuan</th>
                    </thead>
                    <tbody>
                        @foreach ($dataKerjasama as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->kerjasama }}</td>
                            {{-- ada bug di pks  --}}
                             <td>{{ $item->pks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
