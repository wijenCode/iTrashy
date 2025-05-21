<?php
// database/seeders/DonasiSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donasi;

class DonasiSeeder extends Seeder
{
    public function run()
    {
        Donasi::create([
            'nama_donasi' => 'Bantuan Pendidikan',
            'deskripsi' => 'Donasi untuk membantu pendidikan anak-anak yang kurang mampu.',
            'donasi_terkumpul' => 5000000,
            'target_donasi' => 10000000,
            'gambar' => 'image_donasi.jpg',
        ]);

        Donasi::create([
            'nama_donasi' => 'Bantuan Kesehatan',
            'deskripsi' => 'Donasi untuk membantu biaya pengobatan bagi pasien yang tidak mampu.',
            'donasi_terkumpul' => 2000000,
            'target_donasi' => 5000000,
            'gambar' => 'image_donasi_kesehatan.jpg',
        ]);
    }
}