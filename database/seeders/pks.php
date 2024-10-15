<?php

namespace Database\Seeders;

use App\Models\pks as PksM;
use Illuminate\Database\Seeder;

class pks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $data = [
            "MOU",
            "MOA",
            "Adendum PKS",
        ];
        PksM::truncate(); //kosongkan table
        \DB::table('pks')->insert([
            'id' => 0,
            'pks' => "Lainnya",
        ]);
        foreach ($data as $item) {
            PksM::insert([
                'pks' => $item
            ]);
        }
    }
}
