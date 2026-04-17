<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {

            // hanya tambah status_guru
            if (!Schema::hasColumn('gurus', 'status_guru')) {
                $table->string('status_guru')->nullable()->after('kehadiran');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {

            if (Schema::hasColumn('gurus', 'status_guru')) {
                $table->dropColumn('status_guru');
            }
        });
    }
};
