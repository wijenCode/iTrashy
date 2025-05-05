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
                'user_id' => 1,  // Assuming you have a user with ID 1 for testing
                'judul_konten' => $faker->sentence(),
                'deskripsi' => $faker->paragraph(),
                'gambar' => $faker->imageUrl(800, 600, 'business', true, 'Edukasi'), // Random image URL
                'konten' => $faker->paragraph(), // Content for articles or video description
                'jenis_konten' => $index % 2 == 0 ? 'artikel' : 'video', // Alternate between 'artikel' and 'video'
                'kategori' => $faker->word(), // Random category
            ]);
        }
    }
}

