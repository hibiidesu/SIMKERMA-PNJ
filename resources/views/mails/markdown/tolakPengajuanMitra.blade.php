@component('mail::message')

# Pengajuan Anda dengan ID {{ $kerjasama->id }} di Tolak oleh
@if ($kerjasama->step == '2')
    **Tim Legal**
@elseif ($kerjasama->step == '4')
    **Wadir 4**
@elseif ($kerjasama->step == '6')
    **Direktur**
@elseif ($kerjasama->step == '0')
    **Sistem**
@endif
<br>
Silahkan Tinjau Ulang Pengajuan anda.
**Detail Pengajuan:**

<br>
- Judul: {{ $kerjasama->kerjasama }} <br>
- Tanggal Pengajuan: {{ $kerjasama->created_at->format('d-m-Y') }} <br>
- Kegiatan {{ $kerjasama->kegiatan}} <br>
- Sifat : {{ $kerjasama->sifat}} <br>
- PIC PNJ :{{ $kerjasama->pic_pnj}} <br>
- PIC Industri : {{ $kerjasama->pic_industri}} <br>
- Status: @if ($kerjasama->step == '2')
Ditolak Tim Legal
@elseif ($kerjasama->step == '4')
Ditolak Wadir 4
@elseif ($kerjasama->step == '6')
Ditolak Direktur
@elseif ($kerjasama->step == '0')
Kadaluarsa
@endif <br>
- Catatan : {{ $kerjasama->catatan }} <br>

Terima kasih,<br>
{{ config('app.name') }} Politeknik Negeri Jakarta
@endcomponent
