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
        Schema::table('edukasi', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->string('video_url')->nullable()->after('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('edukasi', function (Blueprint $table) {
            $table->text('deskripsi')->after('judul_konten');
            $table->dropColumn('video_url');
        });
    }
}; 