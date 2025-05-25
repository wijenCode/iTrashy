<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransaksiDonasi;
use App\Models\Donasi;
use App\Models\User;

class TransaksiDonasiSeeder extends Seeder
{
    public function run()
    {
        TransaksiDonasi::create([
            'user_id' => 1,  // assuming user with id 1 exists
            'donasi_id' => 1, // assuming donasi with id 1 exists
            'tanggal_transaksi' => now(),
            'status' => 'berhasil',
        ]);

        TransaksiDonasi::create([
            'user_id' => 2,  // assuming user with id 2 exists
            'donasi_id' => 2, // assuming donasi with id 2 exists
            'tanggal_transaksi' => now(),
            'status' => 'menunggu',
        ]);

        TransaksiDonasi::create([
            'user_id' => 1,
            'donasi_id' => 1,
            'tanggal_transaksi' => now(),
            'status' => 'gagal',
        ]);
    }
}