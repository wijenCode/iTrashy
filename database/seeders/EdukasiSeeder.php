<?php

// database/seeders/EdukasiSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Edukasi;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class EdukasiSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create 10 dummy edukasi records (articles and videos)
        foreach (range(1, 10) as $index) {
            $jenis = $index % 2 == 0 ? 'artikel' : 'video';
            Edukasi::create([
                'user_id' => 1,  // Pastikan user dengan ID 1 ada
                'judul_konten' => $faker->sentence(),
                'konten' => $faker->paragraph(),
                'jenis_konten' => $jenis,
                'kategori' => $faker->word(),
                'gambar' => $faker->imageUrl(800, 600, 'business', true, 'Edukasi'),
                'video_url' => $jenis === 'video' ? $faker->url() : null,
            ]);
        }
    }
}
