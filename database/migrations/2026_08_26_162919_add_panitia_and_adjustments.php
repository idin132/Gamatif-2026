<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel absensi panitia
        Schema::create('absensi_panitia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jadwal_kegiatan_id')->constrained('jadwal_kegiatan')->cascadeOnDelete();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->default('alpa');
            $table->timestamps();
        });

        // Kuota & pengumuman
        Schema::table('kelompoks', function (Blueprint $table) {
            $table->integer('kuota')->default(20);
        });

        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('konten');
            $table->timestamps();
        });
    }
};
