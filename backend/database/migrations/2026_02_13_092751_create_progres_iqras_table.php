<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progres_iqras', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('santri_id')->unique();

            $table->integer('iqra')->nullable(); // 1 - 6
            $table->integer('hal')->nullable();

            $table->string('status')->default('Belum Lancar'); // Lancar / Belum Lancar
            $table->string('ulang_lanjut')->default('Ulang');  // Ulang / Lanjut

            $table->timestamps();

            $table->foreign('santri_id')->references('id')->on('santris')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progres_iqras');
    }
};
