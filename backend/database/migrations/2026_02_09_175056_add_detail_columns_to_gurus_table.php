<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {

            if (!Schema::hasColumn('gurus', 'foto')) {
                $table->string('foto')->nullable();
            }

            if (!Schema::hasColumn('gurus', 'tempat_lahir')) {
                $table->string('tempat_lahir', 100)->nullable();
            }

            if (!Schema::hasColumn('gurus', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable();
            }

            if (!Schema::hasColumn('gurus', 'no_kontak')) {
                $table->string('no_kontak', 20)->nullable();
            }

            if (!Schema::hasColumn('gurus', 'pendidikan')) {
                $table->string('pendidikan', 100)->nullable();
            }

            if (!Schema::hasColumn('gurus', 'status_guru')) {
                $table->string('status_guru', 20)->nullable();
            }

            if (!Schema::hasColumn('gurus', 'alamat')) {
                $table->text('alamat')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'foto')) $table->dropColumn('foto');
            if (Schema::hasColumn('gurus', 'tempat_lahir')) $table->dropColumn('tempat_lahir');
            if (Schema::hasColumn('gurus', 'tgl_lahir')) $table->dropColumn('tgl_lahir');
            if (Schema::hasColumn('gurus', 'no_kontak')) $table->dropColumn('no_kontak');
            if (Schema::hasColumn('gurus', 'pendidikan')) $table->dropColumn('pendidikan');
            if (Schema::hasColumn('gurus', 'status_guru')) $table->dropColumn('status_guru');
            if (Schema::hasColumn('gurus', 'alamat')) $table->dropColumn('alamat');
        });
    }
};
