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
        Schema::create('sembako', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sembako');
            $table->text('deskripsi');
            $table->integer('jumlah_barang');
            $table->decimal('poin', 10, 2);
            $table->string('gambar');
            $table->enum('status', ['tersedia', 'kosong'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sembako');
    }
};
