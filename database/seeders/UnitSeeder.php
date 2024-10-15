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
            "PNJ",
            "Pasca Sarjana",
            "Teknik Manufaktur",
            "TIK",
            "TM",
            "AK",
            "AN",
            "TGP",
            "TS",
            "TE",
            "LSP",
            "Perpus PNJ",
            "WD 3",
            "UNIT TRAINING CENTER (PNJ)",
            "TMD",
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
