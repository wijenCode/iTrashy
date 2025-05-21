<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransaksiSembako;
use App\Models\Sembako;
use App\Models\User;

class TransaksiSembakoSeeder extends Seeder
{
    public function run()
    {
        // Insert first transaction for Sembako
        TransaksiSembako::create([
            'user_id' => 1,  // assuming user with id 1 exists
            'sembako_id' => 1, // assuming sembako with id 1 exists
            'tanggal_transaksi' => now(),
            'status' => 'berhasil',
        ]);

        // Insert second transaction for Sembako
        TransaksiSembako::create([
            'user_id' => 2,  // assuming user with id 2 exists
            'sembako_id' => 2, // assuming sembako with id 2 exists
            'tanggal_transaksi' => now(),
            'status' => 'menunggu',
        ]);
    }
}