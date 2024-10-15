<?php

namespace Database\Seeders;

use App\Models\Jenis_kerjasama;
use Illuminate\Database\Seeder;

class JenisKerjasamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "Asosiasi",
            "Pendidikan",
            "Industri",
            "Instansi Pemerintah",
            "Pengabdian Masyarakat",
            "Swakelola"
        ];
        Jenis_kerjasama::truncate(); //kosongkan table
        \DB::table('jenis_kerjasamas')->insert([
            'id' => 0,
            'jenis_kerjasama' => "Lainnya",
        ]);
        foreach ($data as $item) {
            Jenis_kerjasama::insert([
                'jenis_kerjasama' => $item
            ]);
        }
    }
}
