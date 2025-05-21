<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sembako;
use App\Models\TransaksiSembako;
use App\Models\User;

class SembakoSeeder extends Seeder
{
    public function run()
    {
        Sembako::create([
            'nama_sembako' => 'Beras 5kg',
            'deskripsi' => 'Beras kualitas premium 5kg',
            'jumlah_barang' => 100,
            'poin' => 50.00,
            'gambar' => 'beras_5kg.jpg',
            'status' => 'tersedia',
        ]);

        Sembako::create([
            'nama_sembako' => 'Minyak Goreng 1L',
            'deskripsi' => 'Minyak goreng berkualitas 1L',
            'jumlah_barang' => 150,
            'poin' => 30.00,
            'gambar' => 'minyak_goreng_1L.jpg',
            'status' => 'tersedia',
        ]);
    }
}