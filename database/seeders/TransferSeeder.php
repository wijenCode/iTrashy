<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transfer;
use App\Models\User;
use App\Models\TransaksiTransfer;

class TransferSeeder extends Seeder
{
    public function run()
    {
        // Insert first transfer record
        Transfer::create([
            'user_id' => 1,  // assuming user with id 1 exists
            'e_wallet' => 'DANA',
            'no_telepon' => '081234567890',
            'poin_ditukar' => 100,
            'jumlah_transfer' => 1000000,
            'admin_fee' => 5000,
            'total_transfer' => 1005000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert second transfer record
        Transfer::create([
            'user_id' => 2,  // assuming user with id 2 exists
            'e_wallet' => 'OVO',
            'no_telepon' => '089876543210',
            'poin_ditukar' => 50,
            'jumlah_transfer' => 500000,
            'admin_fee' => 2500,
            'total_transfer' => 502500,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}