@component('mail::message')

# Pengajuan {{ $kerjasama->kerjasama }} Sedang Menunggu Untuk Di Review. <br>
**Detail Pengajuan:** <br>


- Judul: {{ $kerjasama->kerjasama }} <br>
- Tanggal Pengajuan: {{ $kerjasama->tanggal_pengajuan }} <br>
- Tanggal Kegiatan : {{ $kerjasama->tanggal_mulai }} Sampai {{ $kerjasama->tanggal_selesai }} <br>
- Kegiatan : {{ $kerjasama->kegiatan }} <br>
- Sifat: {{ $kerjasama->sifat}} <br>
- PIC PNJ : {{ $kerjasama->pic_pnj }} <br>
- Status: Menunggu Review Legal<br>

@component('mail::button', ['url' => env('APP_URL').'/'.$path.'/review/detail/'.$kerjasama->id, 'color::success'])
Lihat Pengajuan
@endcomponent

Terima kasih,<br>
{{ config('app.name') }} Politeknik Negeri Jakarta
@endcomponent
