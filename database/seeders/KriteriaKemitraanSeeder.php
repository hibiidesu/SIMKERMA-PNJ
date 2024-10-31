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

            "1. Pengembangan kurikulum bersama (merencanakan hasil (output)pembelajaran, konten, dan metode pembelajaran)",
            "2. Menyediakan kesempatan pembelajaran berbasis project (PBL) ",
            "3. Menyediakan program magang paling sedikit 1 (satu) semester penuh",
            "4. Menyediakan kesempatan kerja bagi lulusan",
            "5. Mengisi kegiatan pembelajaran dengan dosen tamu praktisi",
            "6. Menyediakan pelatihan (upskilling dan reskilling) bagi dosen maupun instruktur",
            "7. Menyediakan resource sharing sarana dan prasarana",
            "8. Menyelenggarakan teaching factory (TEFA) di kampus",
            "9. Menyelenggarakan program double degree atau joint degree",
            "10. Melakukan kemitraan penelitian",
        ];
        kk::truncate();
            foreach($data as $item){
                kk::insert([
                    'kriteria_kemitraan' => $item
                ]);
            }
    }
}
