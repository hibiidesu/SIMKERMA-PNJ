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
            'name' => "Muhammad Husain Al Ghazali",
            'email' => "muhammad.husain.al.ghazali.tik22@mhsw.pnj.ac.id",
            'username' => "admin123",
            'role_id' => 1,
            'password' => Hash::make("admin123"),
        ]);
        User::insert([
            'name' => "Nabil Falih Khairullah",
            'email' => "nabil.falih.khairullah.tik21@mhsw.pnj.ac.id",
            'username' => "pemimpin123",
            'role_id' => 2,
            'password' => Hash::make("pemimpin123"),
        ]);
        User::insert([
            'name' => "Farhan Dwi Oktavian",
            'email' => "farhan.dwi.oktavian.tik21@mhsw.pnj.ac.id",
            'username' => "legal123",
            'role_id' => 3,
            'password' => Hash::make("legal123"),
        ]);
        User::insert([
            'name' => "Muhammad Rajiful Haq Gea",
            'email' => "muhammad.rajiful.haq.gea.tik22@mhsw.pnj.ac.id",
            'username' => "pic123",
            'role_id' => 4,
            'password' => Hash::make("pic123"),
        ]);
        User::insert([
            'name' => "Tia Anata",
            'email' => "tia.anata.tik22@mhsw.pnj.ac.id",
            'username' => "direktur",
            'role_id' => 5,
            'password' => Hash::make("direktur123"),
        ]);
    }
}
