<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify enum to allow '0' and '1'
        DB::statement("ALTER TABLE mahasiswa_baru MODIFY status ENUM('tidak_aktif', 'aktif', '0', '1') DEFAULT 'tidak_aktif'");

        // Update existing data: 'aktif' to '1', 'tidak_aktif' to '0', others to '0'
        DB::statement("UPDATE mahasiswa_baru SET status = CASE WHEN status = 'aktif' THEN '1' WHEN status = 'tidak_aktif' THEN '0' ELSE '0' END");

        // Change column to boolean
        DB::statement("ALTER TABLE mahasiswa_baru MODIFY status BOOLEAN DEFAULT 0");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back to enum with temp values
        DB::statement("ALTER TABLE mahasiswa_baru MODIFY status ENUM('tidak_aktif', 'aktif', '0', '1') DEFAULT 'tidak_aktif'");

        // Update data back: 1 to 'aktif', 0 to 'tidak_aktif'
        DB::statement("UPDATE mahasiswa_baru SET status = CASE WHEN status = 1 THEN 'aktif' ELSE 'tidak_aktif' END");

        // Change back to original enum
        DB::statement("ALTER TABLE mahasiswa_baru MODIFY status ENUM('tidak_aktif', 'aktif') DEFAULT 'tidak_aktif'");
    }
};
