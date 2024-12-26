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
            ['name' => 'D3 - Konstruksi Sipil', 'unit_id' => 9],
            ['name' => 'D3 - Konstruksi Gedung', 'unit_id' => 9],
            ['name' => 'D4 - Teknik Perancangan Jalan dan Jembatan', 'unit_id' => 9],
            ['name' => 'D4 - Teknik Konstruksi Gedung', 'unit_id' => 9],
            ['name' => 'D3 - Teknik Mesin', 'unit_id' => 5],
            ['name' => 'D3 - Teknik Mesin - Kampus Kab. Demak', 'unit_id' => 5],
            ['name' => 'D3 - Teknik Konversi Energi', 'unit_id' => 5],
            ['name' => 'D3 - Alat Berat', 'unit_id' => 5],
            ['name' => 'D4 - Manufaktur', 'unit_id' => 5],
            ['name' => 'D4 - Teknologi Rekayasa Manufaktur (d.h. Manufaktur)', 'unit_id' => 5],
            ['name' => 'D4 - Manufaktur - Kampus Kota Pekalongan', 'unit_id' => 5],
            ['name' => 'D4 - Pembangkit Tenaga Listrik', 'unit_id' => 5],
            ['name' => 'D4 - Teknologi Rekayasa Pembangkit Energi(d.h. Pembangkit Tenaga Listrik)', 'unit_id' => 5],
            ['name' => 'D4 - Teknologi Rekayasa Konversi Energi', 'unit_id' => 5],
            ['name' => 'D4 - Teknologi Rekayasa Perawatan Alat Berat', 'unit_id' => 5],
            ['name' => 'S2 - Magister Rekayasa Teknologi Manufaktur', 'unit_id' => 5],
            ['name' => 'D3 - Elektronika Industri', 'unit_id' => 10],
            ['name' => 'D3 - Teknik Listrik', 'unit_id' => 10],
            ['name' => 'D3 - Telekomunikasi', 'unit_id' => 10],
            ['name' => 'D4 - Instrumentasi Kontrol Industri', 'unit_id' => 10],
            ['name' => 'D4 - Teknik Otomasi Listrik Industri', 'unit_id' => 10],
            ['name' => 'D4 - Broadband Multimedia', 'unit_id' => 10],
            ['name' => 'S2 - Magister Teknik Elektro', 'unit_id' => 10],
            ['name' => 'D3 - Akuntansi', 'unit_id' => 6],
            ['name' => 'D3 - Keuangan dan Perbankan', 'unit_id' => 6],
            ['name' => 'D4 - Akuntansi Keuangan', 'unit_id' => 6],
            ['name' => 'D4 - Keuangan dan Perbankan', 'unit_id' => 6],
            ['name' => 'D4 - Keuangan dan Perbankan Syariah', 'unit_id' => 6],
            ['name' => 'D4 - Manajemen Keuangan', 'unit_id' => 6],
            ['name' => 'D3 - Manajemen Pemasaran (WNBK)', 'unit_id' => 6],
            ['name' => 'D3 - Administrasi Bisnis', 'unit_id' => 7],
            ['name' => 'D4 - Administrasi Bisnis Terapan', 'unit_id' => 7],
            ['name' => 'D4 - Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran /MICE', 'unit_id' => 7],
            ['name' => 'D4 - Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran /MICE - Kampus Kab. Demak', 'unit_id' => 7],
            ['name' => 'D4 - Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'unit_id' => 7],
            ['name' => 'D3 - Penerbitan', 'unit_id' => 8],
            ['name' => 'D3 - Teknik Grafika', 'unit_id' => 8],
            ['name' => 'D4 - Desain Grafis', 'unit_id' => 8],
            ['name' => 'D4 - Teknologi Industri Cetak Kemasan', 'unit_id' => 8],
            ['name' => 'D4 - Teknologi Rekayasa Cetak Dan Grafis 3 Dimensi', 'unit_id' => 8],
            ['name' => 'D4 - Teknik Informatika', 'unit_id' => 4],
            ['name' => 'D4 - Teknik Multimedia Digital', 'unit_id' => 4],
            ['name' => 'D4 - Teknik Multimedia dan Jaringan', 'unit_id' => 4],
            ['name' => 'D1 - Teknik Komputer dan Jaringan', 'unit_id' => 4],
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
