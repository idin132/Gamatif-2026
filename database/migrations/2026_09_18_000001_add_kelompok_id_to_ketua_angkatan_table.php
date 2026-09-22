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
        Schema::table('ketua_angkatan', function (Blueprint $table) {
            if (!Schema::hasColumn('ketua_angkatan', 'kelompok_id')) {
                $table->foreignId('kelompok_id')->nullable()->constrained('kelompoks')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ketua_angkatan', function (Blueprint $table) {
            if (Schema::hasColumn('ketua_angkatan', 'kelompok_id')) {
                $table->dropConstrainedForeignId('kelompok_id');
            }
        });
    }
};
