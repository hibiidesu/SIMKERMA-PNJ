<?php

namespace Database\Seeders;

use App\Models\kriteria_kemitraan as kk;
use Illuminate\Database\Seeder;

class KriteriaKemitraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [

            "Pengembangan kurikulum bersama (merencanakan hasil (output)pembelajaran, konten, dan metode pembelajaran)",
            "Menyediakan kesempatan pembelajaran berbasis project (PBL) ",
            "Menyediakan program magang paling sedikit 1 (satu) semester penuh",
            "Menyediakan kesempatan kerja bagi lulusan",
            "Mengisi kegiatan pembelajaran dengan dosen tamu praktisi",
            "Menyediakan pelatihan (upskilling dan reskilling) bagi dosen maupun instruktur",
            "Menyediakan resource sharing sarana dan prasarana",
            "Menyelenggarakan teaching factory (TEFA) di kampus",
            "Menyelenggarakan program double degree atau joint degree",
            "Melakukan kemitraan penelitian",
        ];
        kk::truncate();
            foreach($data as $item){
                kk::insert([
                    'kriteria_kemitraan' => $item
                ]);
            }
    }
}
