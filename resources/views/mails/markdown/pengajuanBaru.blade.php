@component('mail::message')

# Pengajuan {{ $kerjasama }} Sedang Menunggu Untuk Di Review. <br>
**Detail Pengajuan:** <br>


- Judul: {{ $kerjasama }} <br>
- Tanggal Pengajuan: {{ $tanggal_pengajuan }} <br>
- Tanggal Kegiatan : {{ $tanggal_mulai }} Sampai {{ $tanggal_selesai }} <br>
- Kegiatan : {{ $kegiatan }} <br>
- Sifat: {{ $sifat}} <br>
- PIC PNJ : {{ $pic_pnj }} <br>
- Status: Menunggu Review Legal<br>

Terima kasih,
Politeknik Negeri Jakarta<br>
{{ config('app.name') }}
@endcomponent
