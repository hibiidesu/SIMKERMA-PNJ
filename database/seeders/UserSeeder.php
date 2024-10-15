<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        User::truncate(); //kosongkan table
        User::insert([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'username' => "admin",
            'role_id' => 1,
            'password' => Hash::make("admin123"),
        ]);
        User::insert([
            'name' => "pemimpin",
            'email' => "pemimpin@gmail.com",
            'username' => "pemimpin",
            'role_id' => 2,
            'password' => Hash::make("pemimpin123"),
        ]);
    }
}
