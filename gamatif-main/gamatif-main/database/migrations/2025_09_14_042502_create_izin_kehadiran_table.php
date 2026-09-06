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
        Schema::create('izin_kehadiran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mahasiswa_baru_id')
                ->constrained('mahasiswa_baru')
                ->onDelete('cascade');

            $table->foreignId('jadwal_kegiatan_id')
                ->constrained('jadwal_kegiatan')
                ->onDelete('cascade');

            $table->enum('keterangan', ['izin', 'sakit']);
            $table->string('catatan');
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kehadiran');
    }
};
