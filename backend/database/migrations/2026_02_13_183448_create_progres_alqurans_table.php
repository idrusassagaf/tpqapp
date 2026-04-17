<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progres_alqurans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('santri_id');
            $table->unsignedBigInteger('guru_id');
            $table->string('juz')->nullable();
            $table->string('hal')->nullable();
            $table->string('progres')->nullable(); // 'Sudah LCR' / 'Belum LCR'
            $table->timestamps();

            // Foreign keys
            $table->foreign('santri_id')->references('id')->on('santris')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('gurus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_alqurans');
    }
};
