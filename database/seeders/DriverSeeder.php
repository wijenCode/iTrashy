<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample driver users
        User::create([
            'username' => 'driver1',
            'email' => 'driver1@example.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Driver No. 1',
            'kota' => 'Jakarta',
            'kecamatan' => 'Menteng',
            'role' => 'driver',
            'level' => 1,
            'poin_terkumpul' => 0,
            'sampah_terkumpul' => 0,
        ]);

        User::create([
            'username' => 'driver2',
            'email' => 'driver2@example.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567891',
            'alamat' => 'Jl. Driver No. 2',
            'kota' => 'Jakarta',
            'kecamatan' => 'Kemang',
            'role' => 'driver',
            'level' => 1,
            'poin_terkumpul' => 0,
            'sampah_terkumpul' => 0,
        ]);

        User::create([
            'username' => 'driver3',
            'email' => 'driver3@example.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567892',
            'alamat' => 'Jl. Driver No. 3',
            'kota' => 'Jakarta',
            'kecamatan' => 'Senayan',
            'role' => 'driver',
            'level' => 1,
            'poin_terkumpul' => 0,
            'sampah_terkumpul' => 0,
        ]);
    }
}

// Jangan lupa run: php artisan db:seed --class=DriverSeeder