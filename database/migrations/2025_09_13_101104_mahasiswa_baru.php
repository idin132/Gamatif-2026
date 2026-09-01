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
        Schema::create('mahasiswa_baru', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nim')->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('nomor_whatsapp');
            $table->string('email')->unique();
            
            // --- PERUBAHAN DI SINI ---
            $table->json('bukti_sosmed'); // Menggunakan JSON untuk menyimpan array path file
            $table->string('bukti_registrasi'); // Tetap string untuk satu path file
            
            $table->foreignId('kelompok_id')
                  ->nullable()
                  ->constrained('kelompoks')
                  ->nullOnDelete();

            // Bagian login
            $table->string('password'); // hashed password

            // Status akun
            $table->enum('status', ['tidak_aktif', 'aktif'])->default('tidak_aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_baru');
    }
};