@component('mail::message')

# Pengajuan Anda dengan ID {{ $kerjasama->id }} telah diterima. 
**Detail Pengajuan:**


- Judul: {{ $kerjasama->kerjasama }}
- Tanggal Pengajuan: {{ $kerjasama->created_at->format('d-m-Y') }}
- Status: Diterima

@component('mail::button', ['url' => env('APP_URL').'/admin/kerjasama/detail/'. $kerjasama->id], 'color::success')
Lihat Pengajuan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
