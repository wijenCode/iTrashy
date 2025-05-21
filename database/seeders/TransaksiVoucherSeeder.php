<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransaksiVoucher;
use App\Models\Voucher;
use App\Models\User;

class TransaksiVoucherSeeder extends Seeder
{
    public function run()
    {
        TransaksiVoucher::create([
            'user_id' => 1,
            'voucher_id' => 1, // assuming voucher_id 1 exists in the Voucher table
            'tanggal_transaksi' => now(),
            'status' => 'berhasil',
        ]);

        TransaksiVoucher::create([
            'user_id' => 2,
            'voucher_id' => 2, // assuming voucher_id 2 exists in the Voucher table
            'tanggal_transaksi' => now(),
            'status' => 'menunggu',
        ]);
    }
}