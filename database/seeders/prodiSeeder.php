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
            ['name' => 'Konstruksi Sipil', 'unit_id' => 9],
            ['name' => 'Konstruksi Gedung', 'unit_id' => 9],
            ['name' => 'Teknik Perancangan Jalan dan Jembatan', 'unit_id' => 9],
            ['name' => 'Teknik Konstruksi Gedung', 'unit_id' => 9],
            ['name' => 'Teknik Mesin', 'unit_id' => 5],
            ['name' => 'Teknik Mesin - Kampus Kab. Demak', 'unit_id' => 5],
            ['name' => 'Teknik Konversi Energi', 'unit_id' => 5],
            ['name' => 'Alat Berat', 'unit_id' => 5],
            ['name' => 'Manufaktur', 'unit_id' => 5],
            ['name' => 'Teknologi Rekayasa Manufaktur (d.h. Manufaktur)', 'unit_id' => 5],
            ['name' => 'Manufaktur - Kampus Kota Pekalongan', 'unit_id' => 5],
            ['name' => 'Pembangkit Tenaga Listrik', 'unit_id' => 5],
            ['name' => 'Teknologi Rekayasa Pembangkit Energi(d.h. Pembangkit Tenaga Listrik)', 'unit_id' => 5],
            ['name' => 'Teknologi Rekayasa Konversi Energi', 'unit_id' => 5],
            ['name' => 'Teknologi Rekayasa Perawatan Alat Berat', 'unit_id' => 5],
            ['name' => 'Magister Rekayasa Teknologi Manufaktur', 'unit_id' => 5],
            ['name' => 'Elektronika Industri', 'unit_id' => 10],
            ['name' => 'Teknik Listrik', 'unit_id' => 10],
            ['name' => 'Telekomunikasi', 'unit_id' => 10],
            ['name' => 'Instrumentasi Kontrol Industri', 'unit_id' => 10],
            ['name' => 'Teknik Otomasi Listrik Industri', 'unit_id' => 10],
            ['name' => 'Broadband Multimedia', 'unit_id' => 10],
            ['name' => 'Magister Teknik Elektro', 'unit_id' => 10],
            ['name' => 'Akuntansi', 'unit_id' => 6],
            ['name' => 'Keuangan dan Perbankan', 'unit_id' => 6],
            ['name' => 'Akuntansi Keuangan', 'unit_id' => 6],
            ['name' => 'Keuangan dan Perbankan', 'unit_id' => 6],
            ['name' => 'Keuangan dan Perbankan Syariah', 'unit_id' => 6],
            ['name' => 'Manajemen Keuangan', 'unit_id' => 6],
            ['name' => 'Manajemen Pemasaran (WNBK)', 'unit_id' => 6],
            ['name' => 'Administrasi Bisnis', 'unit_id' => 7],
            ['name' => 'Administrasi Bisnis Terapan', 'unit_id' => 7],
            ['name' => 'Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran /MICE', 'unit_id' => 7],
            ['name' => 'Usaha Jasa Konvensi, Perjalanan Insentif dan Pameran /MICE - Kampus Kab. Demak', 'unit_id' => 7],
            ['name' => 'Bahasa Inggris untuk Komunikasi Bisnis dan Profesional', 'unit_id' => 7],
            ['name' => 'Penerbitan', 'unit_id' => 8],
            ['name' => 'Teknik Grafika', 'unit_id' => 8],
            ['name' => 'Desain Grafis', 'unit_id' => 8],
            ['name' => 'Teknologi Industri Cetak Kemasan', 'unit_id' => 8],
            ['name' => 'Teknologi Rekayasa Cetak Dan Grafis 3 Dimensi', 'unit_id' => 8],
            ['name' => 'Teknik Informatika', 'unit_id' => 4],
            ['name' => 'Teknik Multimedia Digital', 'unit_id' => 4],
            ['name' => 'Teknik Multimedia dan Jaringan', 'unit_id' => 4],
            ['name' => 'Teknik Komputer dan Jaringan', 'unit_id' => 4],
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
