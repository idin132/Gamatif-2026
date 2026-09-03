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
        Schema::create('data_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->foreignId('kelompok_id')->constrained('kelompoks', 'id');

            // Absensi Kehadiran
            $table->boolean('day_1')->default(false);
            $table->boolean('day_2')->default(false);
            $table->boolean('day_3')->default(false);

            // Hari 1
            $table->boolean('makanan_berat_day_1')->default(false);
            $table->boolean('susu_superhero_day_1')->default(false); // Ultramilk
            $table->boolean('raja_dangdut_day_1')->default(false);   // Roma
            $table->boolean('snack_rindu_day_1')->default(false);    // Dilan
            $table->boolean('wafer_terkenal_day_1')->default(false); // Superstar

            // Hari 2
            $table->boolean('makanan_berat_day_2')->default(false);
            $table->boolean('susu_monyet_day_2')->default(false);        // Nobo
            $table->boolean('roti_ketawa_day_2')->default(false);        // Aoka
            $table->boolean('cokelat_berjerawat_day_2')->default(false); // Beng-Beng
            $table->boolean('bintang_selanjutnya_day_2')->default(false);// Nextar

            // Hari 3
            $table->boolean('makanan_berat_day_3')->default(false);
            $table->boolean('biskuit_3_cara_day_3')->default(false);      // Oreo
            $table->boolean('air_keringat_atlet_day_3')->default(false);  // Pocari Sweat
            $table->boolean('susu_puncak_day_3')->default(false);         // Cimory
            $table->boolean('stik_sayuran_day_3')->default(false);        // Biskitop Vegetable

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mahasiswa');
    }
};