<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
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
