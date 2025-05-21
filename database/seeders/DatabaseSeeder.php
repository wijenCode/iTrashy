<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(JenisSampahSeeder::class);
        $this->call(SetorSampahSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EdukasiSeeder::class);
        $this->call([
            DonasiSeeder::class,
            TransaksiDonasiSeeder::class,
            SembakoSeeder::class,
            TransaksiSembakoSeeder::class,
            VoucherSeeder::class,
            TransaksiVoucherSeeder::class,
            TransferSeeder::class,
            TransaksiTransferSeeder::class,
        ]);
    }
}
