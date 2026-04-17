<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santris', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('nis')->unique(); // <-- NIS wajib & unik
            $table->string('nama');

            // Data dasar
            $table->string('jk', 1); // L / P
            $table->date('tgl_lahir');
            $table->integer('usia')->nullable();

            // Akademik
            $table->string('kelas');

            // Status
            $table->string('status_santri')->nullable();

            // Foto
            $table->string('foto')->nullable();

            // Relasi orangtua
            $table->foreignId('orangtua_id')->nullable()->constrained('orangtuas')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
