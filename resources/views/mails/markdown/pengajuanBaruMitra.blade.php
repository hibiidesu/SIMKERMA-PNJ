@component('mail::message')

# Pengajuan {{ $kerjasama->kerjasama }} Sedang Menunggu Untuk Di Review. <br>
**Detail Pengajuan:** <br>

- ID Pengajuan : {{ $kerjasama->id }} <br>
- Judul: {{ $kerjasama->kerjasama }} <br>
- Tanggal Pengajuan: {{ $kerjasama->tanggal_pengajuan }} <br>
- Tanggal Kegiatan : {{ $kerjasama->tanggal_mulai }} Sampai {{ $kerjasama->tanggal_selesai }} <br>
- Kegiatan : {{ $kerjasama->kegiatan }} <br>
- Sifat: {{ $kerjasama->sifat}} <br>
- PIC PNJ : {{ $kerjasama->pic_pnj }} <br>
- Status: Menunggu Review Legal<br>

Terima kasih,<br>
{{ config('app.name') }} Politeknik Negeri Jakarta
@endcomponent
