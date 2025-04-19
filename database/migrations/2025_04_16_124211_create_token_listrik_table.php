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
        Schema::create('token_listrik', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_token');
            $table->decimal('poin', 10, 2);
            $table->enum('status', ['tersedia', 'kosong'])->default('tersedia');
            $table->string('kode_token')->unique();
            $table->string('nomor_pelanggan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_listrik');
    }
};
