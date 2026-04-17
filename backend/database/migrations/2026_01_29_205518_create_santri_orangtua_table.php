<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('santri_orangtua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained('santris')->cascadeOnDelete();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('santri_orangtua');
    }
};
