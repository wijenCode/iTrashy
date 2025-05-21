<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SetorSampahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil user_id dan jenis_sampah_id yang sudah ada
        $userId = DB::table('users')->first()->id; // Misalnya mengambil user pertama
        $jenisSampahId = DB::table('jenis_sampah')->first()->id; // Misalnya mengambil jenis sampah pertama

        DB::table('setor_sampah')->insert([
            [
                'user_id' => $userId, // ID user yang melakukan setor
                'alamat' => 'Jl. Raya No. 10, Jakarta', // Alamat
                'status' => 'menunggu', // Status setor
                'tanggal_setor' => Carbon::now()->toDateString(), // Tanggal setor
                'waktu_setor' => Carbon::now()->toTimeString(), // Waktu setor
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId, // ID user yang melakukan setor
                'alamat' => 'Jl. Merdeka No. 5, Bandung', // Alamat
                'status' => 'dikonfirmasi', // Status setor
                'tanggal_setor' => Carbon::now()->toDateString(), // Tanggal setor
                'waktu_setor' => Carbon::now()->toTimeString(), // Waktu setor
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
