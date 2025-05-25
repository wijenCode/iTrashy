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
        Schema::table('transfer', function (Blueprint $table) {
            $table->string('bank')->nullable()->after('no_telepon');
            $table->integer('poin_ditukar')->after('bank');
            // Make existing columns nullable
            $table->string('e_wallet')->nullable()->change();
            $table->string('no_telepon')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfer', function (Blueprint $table) {
            $table->dropColumn(['bank', 'poin_ditukar']);
            // Revert nullable changes if necessary (optional)
            // $table->string('e_wallet')->nullable(false)->change();
            // $table->string('no_telepon')->nullable(false)->change();
        });
    }
};
