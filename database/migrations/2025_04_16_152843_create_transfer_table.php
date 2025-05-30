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
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('e_wallet')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('bank')->nullable();
            $table->integer('poin_ditukar');
            $table->decimal('jumlah_transfer', 15, 2);
            $table->decimal('admin_fee', 15, 2);
            $table->decimal('total_transfer', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
