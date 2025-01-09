<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\bidangKerjasama;

class BidangSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Beasiswa/Ikatan Dinas',
            'Corporate Social Responsibility',
            'Double Degree',
            'Jasa Kepada DUDI',
            'Joint Degree',
            'Joint Research',
            'Kelas Industri',
            'Kelas Kerja sama Antar Perguruan Tinggi',
            'Konferensi Internasional',
            'Kunjungan Industri',
            'Magang / Praktek Kerja Lapangan (PKL) Mahasiswa',
            'Magang / Praktek Kerja Lapangan (PKL) Dosen',
            'Pameran',
            'Pelatihan dari Dunia Kerja',
            'Pembelajaran',
            'Pendampingan Kewirausahaan',
            'Pengabdian dan Pendampingan Masyarakat',
            'Penggunaan Sarpras',
            'Penyelarasan Kurikulum',
            'Penyerapan Lulusan',
            'Pertukaran Mahasiswa',
            'Pertukaran Dosen',
            'Produksi',
            'Promosi',
            'Publikasi Ilmiah',
            'Riset Terapan',
            'Sarana',
            'Sertifikasi Kompetensi',
            'Short Course',
            'Teaching Factory / Pembelajaran Basis Proyek',
            'Dosen/Tenaga Ahli dari Dunia Kerja (Dosen Tamu)'
        ];

        bidangKerjasama::truncate(); // Empty the table

        // Insert the first record
        bidangKerjasama::create([
            'id' => 0,
            'nama_bidang' => 'Lainnya',
        ]);

        // Insert the rest of the data
        foreach ($data as $item) {
            bidangKerjasama::create([
                'nama_bidang' => $item
            ]);
        }
    }
}
