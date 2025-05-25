<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransaksiTransfer;
use App\Models\Transfer;
use App\Models\User;

class TransaksiTransferSeeder extends Seeder
{
    public function run()
    {
        TransaksiTransfer::create([
            'user_id' => 1,
            'transfer_id' => 1, // assuming transfer_id 1 exists in the Transfer table
            'tanggal_transaksi' => now(),
            'status' => 'berhasil',
        ]);

        TransaksiTransfer::create([
            'user_id' => 2,
            'transfer_id' => 2, // assuming transfer_id 2 exists in the Transfer table
            'tanggal_transaksi' => now(),
            'status' => 'menunggu',
        ]);

        TransaksiTransfer::create([
            'user_id' => 1,
            'transfer_id' => 1,
            'tanggal_transaksi' => now(),
            'status' => 'gagal',
        ]);
    }
}