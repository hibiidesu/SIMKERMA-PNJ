@component('mail::message')

# Pengajuan Anda dengan ID {{ $kerjasama->id }} di Tolak oleh
@if ($kerjasama->step == '2')
    **Tim Legal**
@elseif ($kerjasama->step == '4')
    **Wadir 4**
@elseif ($kerjasama->step == '6')
    **Direktur**
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
@endifk <br>
- Catatan : {{ $kerjasama->catatan }} <br>

@component('mail::button', ['url' => env('APP_URL').'/'.$kerjasama->user->role->role_name.'/review/detail/'.$kerjasama->id, 'color::success'])
Lihat Pengajuan
@endcomponent

Terima kasih,<br>
{{ config('app.name') }} Politeknik Negeri Jakarta
@endcomponent
