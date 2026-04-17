<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orangtuas', function (Blueprint $table) {

            if (!Schema::hasColumn('orangtuas', 'alamat')) {
                $table->string('alamat')->nullable();
            }

            if (!Schema::hasColumn('orangtuas', 'no_kontak')) {
                $table->string('no_kontak')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('orangtuas', function (Blueprint $table) {

            if (Schema::hasColumn('orangtuas', 'alamat')) {
                $table->dropColumn('alamat');
            }

            if (Schema::hasColumn('orangtuas', 'no_kontak')) {
                $table->dropColumn('no_kontak');
            }

        });
    }
};
