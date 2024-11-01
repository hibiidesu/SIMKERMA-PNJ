<?php

namespace Database\Seeders;

use App\Models\kriteria_mitra as km;
use Illuminate\Database\Seeder;

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
            "Perusahaan Multinasional",
            "Perusahaan Nasional Berstandar Tinggi",
            "Perusahaan Teknoiogi Global",
            "Perusahaan Rintisan (Startup Compang) Teknologi",
            "Organisasi Nirlaba Kelas Dunia",
            "Institusi/Organisasi Multilateral",
            "Perguruan Tinggi, Fakultas, atau Program Studi Dalam Bidang yang Relevan",
            "Instansi Pemerintah, BUMN, dan/atau BUMD",
            "Rumah Sakit",
            "UMKM",
            "Lembaga Riset Pemerintah, Swasta, Nasional, Maupun Internasional",
            "Lembaga Kebudayaan Berskala Nasional/Bereputasi",
            "Perguruan Tinggi Yang Masuk Dalam Daftar QS200 Berdasarkan Bidang Ilmu (QS200 By Subject)",
        ];
        km::truncate();
            foreach($data as $item){
                km::insert([
                    'kriteria_mitra' => $item
                ]);
            }
    }
}
