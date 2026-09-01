<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nama_barang_bawaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->enum('hari', ['day_1', 'day_2', 'day_3']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nama_barang_bawaans');
    }
};