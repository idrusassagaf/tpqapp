<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {

            // Kelas (dropdown di form)
            if (!Schema::hasColumn('santris', 'kelas')) {
                $table->string('kelas')->nullable()->after('nis');
            }

            // Foto (path file foto)
            if (!Schema::hasColumn('santris', 'foto')) {
                $table->string('foto')->nullable()->after('jenis_kelamin');
            }

        });
    }

    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {

            // Kalau SQLite kadang dropColumn error,
            // tapi kita tetap tulis begini dulu.
            if (Schema::hasColumn('santris', 'kelas')) {
                $table->dropColumn('kelas');
            }

            if (Schema::hasColumn('santris', 'foto')) {
                $table->dropColumn('foto');
            }

        });
    }
};
