<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'john_doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password123'), // Jangan lupa mengenkripsi password
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 1',
                'kota' => 'Jakarta',
                'kecamatan' => 'Cengkareng',
                'foto_profile' => 'path/to/profile.jpg', // Ganti dengan path yang sesuai
                'poin_terkumpul' => 1000,
                'sampah_terkumpul' => 150.25,
                'level' => 'explorer',
                'role' => 'user',
                'remember_token' => Str::random(10),
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'jane_smith',
                'email' => 'jane@example.com',
                'password' => bcrypt('password456'),
                'no_telepon' => '089876543210',
                'alamat' => 'Jl. Pahlawan No. 2',
                'kota' => 'Bandung',
                'kecamatan' => 'Sumurbandung',
                'foto_profile' => 'path/to/profile2.jpg', // Ganti dengan path yang sesuai
                'poin_terkumpul' => 500,
                'sampah_terkumpul' => 75.10,
                'level' => 'warrior',
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'mike_taylor',
                'email' => 'mike@example.com',
                'password' => bcrypt('password789'),
                'no_telepon' => '087654321098',
                'alamat' => 'Jl. Kemerdekaan No. 3',
                'kota' => 'Surabaya',
                'kecamatan' => 'Gubeng',
                'foto_profile' => 'path/to/profile3.jpg', // Ganti dengan path yang sesuai
                'poin_terkumpul' => 2000,
                'sampah_terkumpul' => 250.75,
                'level' => 'master',
                'role' => 'driver',
                'remember_token' => Str::random(10),
                'email_verified_at' => Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
   ]);
}
}
