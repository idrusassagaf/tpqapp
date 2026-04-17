<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // CEK DULU: kalau kolom belum ada baru ditambah
        if (!Schema::hasColumn('santris', 'tgl_lahir')) {
            Schema::table('santris', function (Blueprint $table) {
                $table->date('tgl_lahir')->nullable();
            });
        }
    }

    public function down(): void
    {
        // CEK DULU: kalau kolom ada baru dihapus
        if (Schema::hasColumn('santris', 'tgl_lahir')) {
            Schema::table('santris', function (Blueprint $table) {
                $table->dropColumn('tgl_lahir');
            });
        }
    }
};
