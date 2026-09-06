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
        Schema::create('barang_sitaan', function (Blueprint $table) {
            $table->id();
           $table->foreignId('kelompok_id')->constrained('kelompoks')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('barang_sitaan');
            $table->string('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_sitaan');
    }
};
