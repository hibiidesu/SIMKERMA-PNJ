<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "admin",
            "pemimpin",
            "legal",
            "pic",
            'direktur',
        ];
        Role::truncate(); //kosongkan table
        foreach ($data as $item) {
            Role::insert([
                'role_name' => $item
            ]);
        }
    }
}
