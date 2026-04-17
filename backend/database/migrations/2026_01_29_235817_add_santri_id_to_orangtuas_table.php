<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orangtuas', function (Blueprint $table) {
            $table->foreignId('santri_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('santris')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orangtuas', function (Blueprint $table) {
            $table->dropForeign(['santri_id']);
            $table->dropColumn('santri_id');
        });
    }
};
