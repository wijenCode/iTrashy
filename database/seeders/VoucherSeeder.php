<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Voucher;
use App\Models\TransaksiVoucher;
use App\Models\User;

class VoucherSeeder extends Seeder
{
    public function run()
    {
        Voucher::create([
            'nama_voucher' => 'Voucher Belanja 50K',
            'deskripsi' => 'Voucher belanja senilai 50 ribu rupiah.',
            'jumlah_voucher' => 200,
            'poin' => 100.00,
            'gambar' => 'voucher_belanja.jpg',
            'status' => 'tersedia',
        ]);

        Voucher::create([
            'nama_voucher' => 'Voucher Makanan 25K',
            'deskripsi' => 'Voucher makanan senilai 25 ribu rupiah.',
            'jumlah_voucher' => 300,
            'poin' => 50.00,
            'gambar' => 'voucher_makanan.jpg',
            'status' => 'tersedia',
        ]);
    }
}
