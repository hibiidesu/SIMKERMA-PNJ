@component('mail::message')

# Pengajuan Anda dengan ID {{ $kerjasama->id }} telah diterima. 
**Detail Pengajuan:**


- Judul: {{ $kerjasama->kerjasama }}
- Tanggal Pengajuan: {{ $kerjasama->created_at->format('d-m-Y') }}
- Status: Diterima

@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin/kerjasama/'. $kerjasama->id])
Lihat Pengajuan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
