<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $data = [
            "PNJ", //1
            "Pasca Sarjana",
            "Teknik Manufaktur",
            "Teknik Informatik dan Komputer", // 4
            "Teknik Mesin", // 5
            "Akuntansi", // 6
            "Administrasi Niaga", // 7
            "Teknik Grafika dan Penerbitan", // 8
            "Teknik Sipil", // 9
            "Teknk Elektro", // 10
            "LSP", // 11
            "Perpus PNJ", //12
            "WD 3", // 13
            "UNIT TRAINING CENTER (PNJ)", // 14
            "Bahasa Inggris untuk Komunikasi Bisnis dan Profesional", // 15
        ];
        Unit::truncate(); //kosongkan table
        \DB::table('unit')->insert([
            'id' => 0,
            'name' => "Lainnya",
        ]);
        foreach ($data as $item) {
            Unit::insert([
                'name' => $item
            ]);
        }
    }
}
