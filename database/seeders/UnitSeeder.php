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
            "Pasca Sarjana", // 2
            "Teknik Informatik dan Komputer", // 3
            "Teknik Mesin", // 4
            "Akuntansi", // 5
            "Administrasi Niaga", // 6
            "Teknik Grafika dan Penerbitan", // 7
            "Teknik Sipil", // 8
            "Teknk Elektro", // 9
            "LSP", // 10
            "Perpus PNJ", //11
            "WD 3", // 12
            "UNIT TRAINING CENTER (PNJ)", // 13
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
