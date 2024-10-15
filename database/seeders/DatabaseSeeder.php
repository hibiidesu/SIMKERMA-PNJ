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
        ]);
        $this->call([
            JenisKerjasamaSeeder::class,
        ]);
        $this->call([
            pks::class,
        ]);
        $this->call([
            RoleSeeder::class,
        ]);
        $this->call([
            UserSeeder::class,
        ]);
    }
}
