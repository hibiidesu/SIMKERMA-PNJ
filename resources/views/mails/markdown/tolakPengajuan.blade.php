@component('mail::message')

# Pengajuan Anda dengan ID {{ $kerjasama->id }} di Tolak. <br>
Silahkan Tinjau Ulang Pengajuan anda.
**Detail Pengajuan:**

<br>
- Title: {{ $kerjasama->kerjasama }} <br>
- Tanggal Pengajuan: {{ $kerjasama->created_at->format('d-m-Y') }} <br>
- Kegiatan {{ $kerjasama->kegiatan}} <br>
- Sifat : {{ $kerjasama->sifat}} <br>
- PIC PNJ :{{ $kerjasama->pic_pnj}} <br>
- PIC Industri : {{ $kerjasama->pic_industri}} <br>
- Status: Ditolak <br>
- Catatan : {{ $catatan }} <br>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin/kerjasama/detail/'. $kerjasama->id])
Lihat Pengajuan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
