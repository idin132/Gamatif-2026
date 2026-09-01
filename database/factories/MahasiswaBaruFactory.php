<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MahasiswaBaru>
 */
class MahasiswaBaruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap' => fake()->name(),
            'nim' => fake()->unique()->numerify('10122###'), // Membuat NIM 8 digit unik
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'tanggal_lahir' => fake()->dateTimeBetween('2000-01-01', '2005-12-31')->format('Y-m-d'),
            'alamat' => fake()->address(),
            'nomor_whatsapp' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'bukti_registrasi' => 'dummy/bukti_registrasi.pdf',
            'bukti_sosmed' => [
                'dummy/sosmed_1.jpg',
                'dummy/sosmed_2.png',
            ],
            'status' => fake()->boolean(),
            'password' => Hash::make('password'), // Password default untuk semua
        ];
    }
}