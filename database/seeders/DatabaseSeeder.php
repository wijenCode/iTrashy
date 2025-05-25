<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Donasi;
use App\Models\Edukasi; 
use App\Models\JenisSampah;
use App\Models\Sembako;
use App\Models\SetorItem;
use App\Models\SetorSampah;
use App\Models\TransaksiDonasi;
use App\Models\TransaksiSembako;
use App\Models\TransaksiTransfer;
use App\Models\TransaksiVoucher;
use App\Models\Transfer;
use App\Models\Voucher;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UsersSeeder::class);               // Seed users first
        $this->call(DriverSeeder::class);              // Seed drivers next, as it depends on users
        $this->call(JenisSampahSeeder::class);         // Seed jenis sampah
        $this->call(SetorSampahSeeder::class);         // Seed setor sampah after users and drivers
        $this->call(SetorItemSeeder::class);           // Seed setor item after setor sampah
        $this->call(SembakoSeeder::class);             // Seed sembako if needed
        $this->call(VoucherSeeder::class);             // Seed voucher
        $this->call(TransaksiDonasiSeeder::class);     // Seed transaksi donasi
        $this->call(TransaksiSembakoSeeder::class);    // Seed transaksi sembako
        $this->call(TransaksiTransferSeeder::class);   // Seed transaksi transfer
        $this->call(TransaksiVoucherSeeder::class);    // Seed transaksi voucher
        $this->call(DonasiSeeder::class);              // Seed donasi at last if it depends on previous data
    }
}
