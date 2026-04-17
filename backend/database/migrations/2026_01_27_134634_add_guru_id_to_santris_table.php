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
        Schema::table('santris', function (Blueprint $table) {

            // kolom relasi ke guru
            $table->foreignId('guru_id')
                  ->nullable()
                  ->after('kelas')
                  ->constrained('gurus')
                  ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {

            // hapus foreign key dulu
            $table->dropForeign(['guru_id']);

            // hapus kolom
            $table->dropColumn('guru_id');

        });
    }
};
