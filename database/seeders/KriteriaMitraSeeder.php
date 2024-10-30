<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\kriteria_mitra as km;

class KriteriaMitraSeeder extends Seeder
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
            "perusahaan multinasional",
            "perusahaan nasional berstandar tinggi",
            "perusahaan teknoiogi global",
            "perusahaan rintisan (startup compang) teknologi",
            "organisasi nirlaba kelas dunia",
            "institusi/organisasi multilateral",
            "perguruan tinggi, fakultas, atau program studi dalam bidang yang relevan",
            "instansi pemerintah, BUMN, dan/ atau BUMD",
            "rumah sakit",
            "UMKM",
            "lembaga riset pemerintah, swasta, nasional, maupun internasional",
            "lembaga kebudayaan berskala nasional/ bereputasi",
            "perguruan tinggi yang masuk dalam daftar QS200 berdasarkan bidang ilmu (QS200 by subject)",
        ];
        km::truncate();

            foreach($data as $item){
                km::insert([
                    'kriteria_mitra' => $item
                ]);
            }
    }
}
