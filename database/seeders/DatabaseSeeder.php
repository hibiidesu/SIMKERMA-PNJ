<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jenis_kerjasama;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UnitSeeder::class,
            JenisKerjasamaSeeder::class,
            pks::class,
            RoleSeeder::class,
            UserSeeder::class,
            KriteriaMitraSeeder::class,
            KriteriaKemitraanSeeder::class,
            prodiSeeder::class
        ]);
    }
}
