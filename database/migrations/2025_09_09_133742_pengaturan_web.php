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
        Schema::create('pengaturan_web', function (Blueprint $table) {
            $table->id();
            $table->string("logo_unikom")->nullable();
            $table->string("logo_hmif")->nullable();
            $table->string("logo_kabinet")->nullable();
            $table->string("logo_gamatif")->nullable();
            $table->string("logo_maskot")->nullable();
            $table->string("admin_wa_1")->nullable();
            $table->string("admin_wa_2")->nullable();
            $table->string("email")->nullable();
            $table->string("buku_saku")->nullable();
            $table->string("nama_kegiatan")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_web');
    }
};
