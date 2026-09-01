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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mahasiswa_baru_id')
                ->constrained('mahasiswa_baru')
                ->onDelete('cascade');

            $table->foreignId('jadwal_kegiatan_id')
                ->constrained('jadwal_kegiatan')
                ->onDelete('cascade');

            $table->enum('status', ['hadir', 'telat', 'izin', 'sakit', 'alpa'])
                ->default('alpa');

            // waktu_absen otomatis pakai created_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absesi');
    }
};
