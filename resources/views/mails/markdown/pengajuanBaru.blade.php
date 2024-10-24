@component('mail::message')

# Pengajuan Anda  {{ $kerjasama }} Sedang Menunggu Untuk Di Review. <br>
**Detail Pengajuan:** <br>


- Judul Kerjasama: {{ $kerjasama }} <br>
- Tanggal Pengajuan: {{ $tanggal_pengajuan }} <br>
- Tanggal Kegiatan : {{ $tanggal_mulai }} Sampai {{ $tanggal_selesai }} <br>
- Kegiatan : {{ $kegiatan }} <br>
- Sifat: {{ $sifat}} <br>
- PIC PNJ : {{ $pic_pnj }} <br>
- Status: Menunggu <br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
