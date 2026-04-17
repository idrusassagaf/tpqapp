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
       Schema::create('orangtuas', function (Blueprint $table) {
    $table->id();

    $table->string('nama_ayah')->nullable();
    $table->string('nama_ibu')->nullable();

    $table->string('pekerjaan_ayah')->nullable();
    $table->string('pekerjaan_ibu')->nullable();

    $table->string('status_orangtua', 50);

    $table->string('no_kontak', 20)->nullable();
    $table->text('alamat')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orangtuas');
    }
};
