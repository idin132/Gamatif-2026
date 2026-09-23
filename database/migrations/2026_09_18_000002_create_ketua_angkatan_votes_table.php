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
        Schema::create('ketua_angkatan_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_baru_id')->constrained('mahasiswa_baru')->cascadeOnDelete();
            $table->foreignId('ketua_angkatan_id')->constrained('ketua_angkatan')->cascadeOnDelete();
            $table->timestamps();

            $table->unique('mahasiswa_baru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketua_angkatan_votes');
    }
};
