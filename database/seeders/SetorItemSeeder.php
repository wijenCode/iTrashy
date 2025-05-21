<?php

namespace Database\Seeders;

use App\Models\SetorSampah;
use App\Models\JenisSampah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetorItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get some existing setor_sampah_id and jenis_sampah_id
        $setorSampahIds = SetorSampah::all()->pluck('id')->toArray();
        $jenisSampahIds = JenisSampah::all()->pluck('id')->toArray();

        // Loop to create fake setor_item records
        foreach ($setorSampahIds as $setorSampahId) {
            foreach ($jenisSampahIds as $jenisSampahId) {
                // Generate random weight between 0.25 and 5 kg
                $berat = rand(25, 500) / 100; // random weight in kg (from 0.25 to 5)
                
                // Calculate points for each type of waste
                $poinPerKg = JenisSampah::find($jenisSampahId)->poin_per_kg;
                $poin = $berat * $poinPerKg;

                // Insert data into the 'setor_item' table
                DB::table('setor_item')->insert([
                    'setor_sampah_id' => $setorSampahId,
                    'jenis_sampah_id' => $jenisSampahId,
                    'berat' => $berat,
                    'poin' => $poin,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
