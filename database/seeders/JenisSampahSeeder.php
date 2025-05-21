<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_sampah')->insert([
            [
                'nama_sampah' => 'Plastik PET',
                'poin_per_kg' => 500,
                'carbon_reduced' => 1.5,
                'kategori_sampah' => 'Sampah Anorganik',
                'gambar' => 'images/botol_plastik.png', // Ganti dengan path gambar yang sesuai
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sampah' => 'Kertas',
                'poin_per_kg' => 300,
                'carbon_reduced' => 0.8,
                'kategori_sampah' => 'Sampah Organik',
                'gambar' => 'images/kertas.png', // Ganti dengan path gambar yang sesuai
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sampah' => 'Kaleng',
                'poin_per_kg' => 1000,
                'carbon_reduced' => 2.0,
                'kategori_sampah' => 'Sampah Anorganik',
                'gambar' => 'images/kaleng.png', // Ganti dengan path gambar yang sesuai
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_sampah' => 'Kardus',
                'poin_per_kg' => 500,
                'carbon_reduced' => 0.5,
                'kategori_sampah' => 'Sampah Organik',
                'gambar' => 'images/kardus.png', // Ganti dengan path gambar yang sesuai
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
