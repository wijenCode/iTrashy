<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'username' => 'kevin',
            'email' => 'kevinadmin@gmail.com',
            'password' => Hash::make('kevin123'),  // Gunakan password hash
            'role' => 'admin',
        ]);
    }
} 