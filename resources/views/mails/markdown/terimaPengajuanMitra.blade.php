@component('mail::message')

# Pengajuan Anda dengan ID {{ $kerjasama->id }} telah diterima oleh @if ($kerjasama->step == '3') **Tim Legal** @elseif ($kerjasama->step == '5') **Wadir 4** @elseif ($kerjasama->step == '7') **Direktur !!!**
@endif

**Detail Pengajuan:**


- Judul: **{{ $kerjasama->kerjasama }}**
- Tanggal Pengajuan: {{ $kerjasama->created_at->format('d-m-Y') }}
- Status: @if ($kerjasama->step == '3')
Diterima Tim Legal (Menunggu review Wadir 4)
@elseif ($kerjasama->step == '5')
Diterima Wadir 4 (Menunggu review Direktur)
@elseif ($kerjasama->step == '7')
Diterima Direktur
@endif


Terima kasih,<br>
{{ config('app.name') }} Politeknik Negeri Jakarta
@endcomponent
