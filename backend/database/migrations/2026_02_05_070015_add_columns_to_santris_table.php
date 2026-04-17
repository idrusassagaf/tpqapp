<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santris', function (Blueprint $table) {

            // kalau kolom sudah ada, nanti kita atur aman pakai try-catch (di bawah)
            if (!Schema::hasColumn('santris', 'nis')) {
                $table->string('nis')->unique()->nullable()->after('nama');
            }

            if (!Schema::hasColumn('santris', 'jenis_kelamin')) {
                $table->string('jenis_kelamin', 1)->nullable()->after('nis');
            }

            if (!Schema::hasColumn('santris', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('jenis_kelamin');
            }

            if (!Schema::hasColumn('santris', 'alamat')) {
                $table->text('alamat')->nullable()->after('tgl_lahir');
            }

            if (!Schema::hasColumn('santris', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('alamat');
            }

            if (!Schema::hasColumn('santris', 'status')) {
                $table->string('status')->nullable()->after('no_hp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('santris', function (Blueprint $table) {

            if (Schema::hasColumn('santris', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('santris', 'no_hp')) {
                $table->dropColumn('no_hp');
            }

            if (Schema::hasColumn('santris', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('santris', 'tgl_lahir')) {
                $table->dropColumn('tgl_lahir');
            }

            if (Schema::hasColumn('santris', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }

            // nis unique drop harus hati-hati
            if (Schema::hasColumn('santris', 'nis')) {
                $table->dropUnique(['nis']);
                $table->dropColumn('nis');
            }
        });
    }
};
