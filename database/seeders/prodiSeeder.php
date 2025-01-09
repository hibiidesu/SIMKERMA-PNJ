<?php

namespace Database\Seeders;

use App\Models\prodi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class prodiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['name' => 'D1 - Bahasa Inggris untuk Komunikasi Bisnis dan Profesional S1 Terapan', 'unit_id' => 6],
            ['name' => 'D1 - Teknik Komputer dan Jaringan', 'unit_id' => 3],
            ['name' => 'D1 - Teknik Mesin', 'unit_id' => 4],
            ['name' => 'D2 - Alat Berat, Kampus di Pusat Pengembangan dan Pelatihan PTK', 'unit_id' => 4],
            ['name' => 'D2 - Teknik Grafika Kab. Demak', 'unit_id' => 7],
            ['name' => 'D2 - Teknik Grafika Kota Pekalongan', 'unit_id' => 7],
            ['name' => 'D2 - Teknik Konversi Energi, Kampus di Pusat Pengembangan & Pelatihan PTK', 'unit_id' => 4],
            ['name' => 'D2 - Teknik Manufaktur Mesin', 'unit_id' => 4],
            ['name' => 'D2 - Teknik Mesin K. Kota Pekalongan', 'unit_id' => 4],
            ['name' => 'D2 - Teknik Mesin Kab. Demak', 'unit_id' => 4],
            ['name' => 'D2 - Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran K. Demak', 'unit_id' => 6],
            ['name' => 'D3 - Administrasi Bisnis', 'unit_id' => 6],
            ['name' => 'D3 - Akuntansi', 'unit_id' => 5],
            ['name' => 'D3 - Alat Berat', 'unit_id' => 4],
            ['name' => 'D3 - Elektronika Industri', 'unit_id' => 9],
            ['name' => 'D3 - Keuangan Dan Perbankan', 'unit_id' => 5],
            ['name' => 'D3 - Konstruksi Gedung', 'unit_id' => 8],
            ['name' => 'D3 - Konstruksi Sipil', 'unit_id' => 8],
            ['name' => 'D3 - Manajemen Pemasaran Untuk Warga Negara Berkebutuhan Khusus', 'unit_id' => 5],
            ['name' => 'D3 - Penerbitan', 'unit_id' => 7],
            ['name' => 'D3 - Teknik Grafika', 'unit_id' => 7],
            ['name' => 'D3 - Teknik Konversi Energi', 'unit_id' => 4],
            ['name' => 'D3 - Teknik Listrik', 'unit_id' => 9],
            ['name' => 'D3 - Teknik Mesin', 'unit_id' => 4],
            ['name' => 'D3 - Teknik Mesin (Kampus Kab. Demak)', 'unit_id' => 4],
            ['name' => 'D3 - Telekomunikasi', 'unit_id' => 9],
            ['name' => 'D4 - Administrasi Bisnis Terapan', 'unit_id' => 6],
            ['name' => 'D4 - Akuntansi Keuangan', 'unit_id' => 5],
            ['name' => 'D4 - Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'unit_id' => 6],
            ['name' => 'D4 - BroadBand Multimedia', 'unit_id' => 9],
            ['name' => 'D4 - Desain Grafis', 'unit_id' => 7],
            ['name' => 'D4 - Instrumentasi Dan Kontrol Industri', 'unit_id' => 9],
            ['name' => 'D4 - Keuangan dan Perbankan', 'unit_id' => 5],
            ['name' => 'D4 - Keuangan Dan Perbankan Syari ah', 'unit_id' => 5],
            ['name' => 'D4 - Manajemen Keuangan', 'unit_id' => 5],
            ['name' => 'D4 - Manufaktur', 'unit_id' => 4],
            ['name' => 'D4 - Manufaktur (Kampus Kota Pekalongan)', 'unit_id' => 4],
            ['name' => 'D4 - Pembangkit Tenaga Listrik', 'unit_id' => 4],
            ['name' => 'D4 - Teknik Informatika', 'unit_id' => 3],
            ['name' => 'D4 - Teknik KontrukSi Gedung', 'unit_id' => 8],
            ['name' => 'D4 - Teknik Mesin (Kampus Kab. Demak)', 'unit_id' => 4],
            ['name' => 'D4 - Teknik Multimedia dan Jaringan', 'unit_id' => 3],
            ['name' => 'D4 - Teknik Multimedia Digital', 'unit_id' => 3],
            ['name' => 'D4 - Teknik Otomasi Listrik Industri', 'unit_id' => 9],
            ['name' => 'D4 - Teknik Perancangan Jalan Dan Jembatan', 'unit_id' => 8],
            ['name' => 'D4 - Teknologi Industri Cetak kemasan', 'unit_id' => 7],
            ['name' => 'D4 - Teknologi Rekayasa Cetak Dan Grafis 3 Dimensi', 'unit_id' => 7],
            ['name' => 'D4 - Teknologi Rekayasa Konversi Energi', 'unit_id' => 4],
            ['name' => 'D4 - Teknologi Rekayasa Pemeliharaan Alat Berat', 'unit_id' => 4],
            ['name' => 'D4 - Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran', 'unit_id' => 6],
            ['name' => 'D4 - Usaha Jasa Konvensi, Perjalanan Insentif, dan Pameran (Kampus Kab. Demak)', 'unit_id' => 6],
            ['name' => 'S2 Terapan - Rekayasa Teknologi Manufaktur', 'unit_id' => 4],
            ['name' => 'S2 Terapan - Teknik Elektro', 'unit_id' => 9],
            ['name' => 'S3 - Test', 'unit_id' => 4],
        ];
        prodi::truncate();
        foreach ($data as $item) {
            prodi::insert([
                'name' => $item['name'],
                'unit_id' => $item['unit_id'],
            ]);
        }

    }
}
