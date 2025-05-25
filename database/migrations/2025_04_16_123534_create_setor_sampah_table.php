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
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->json('driver_tolak')->nullable();
            $table->string('alamat');
            $table->enum('status', ['menunggu', 'dikonfirmasi', 'ditolak', 'selesai'])->default('menunggu');
            $table->string('kode_kredensial', 10)->nullable();
            $table->date('tanggal_setor');
            $table->time('waktu_setor');
            $table->timestamp('tanggal_diambil')->nullable();
            $table->text('catatan_driver')->nullable();
            $table->timestamps();

            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
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
