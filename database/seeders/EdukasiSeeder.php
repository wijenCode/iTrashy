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
            // Insert dummy data into 'edukasi' table
            Edukasi::create([
                'user_id' => 1, // Assuming user_id 1 exists
                'judul_konten' => $faker->sentence,
                'konten' => $faker->paragraph,
                'gambar' => $faker->imageUrl(640, 480, 'nature'),
                'video_url' => $faker->url,
                'jenis_konten' => $faker->randomElement(['artikel', 'video']),
                'kategori' => $faker->randomElement(['Daur Ulang', 'Style Hidup', 'Kesehatan', 'Lingkungan']),
            ]);
        }
    }
}
