<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setor_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->onDelete('cascade');
            $table->decimal('total_pendapatan_poin', 10, 2);
            $table->decimal('total_berat', 10, 2);
            $table->string('alamat');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditolak', 'selesai'])->default('menunggu');
            $table->date('tanggal_setor');
            $table->time('waktu_setor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setor_sampah');
    }
};
