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
        Schema::create('jadwal_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama kegiatan
            $table->date('tanggal'); // Format YYYY-MM-DD (contoh: 2002-07-06)
            $table->time('waktu_mulai'); // Jam mulai
            $table->time('waktu_selesai'); // Jam selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kegiatan');
    }
};
