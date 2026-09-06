<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class MahasiswaBaru extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'mahasiswa_baru';

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'nomor_whatsapp',
        'email',
        'bukti_sosmed',
        'bukti_registrasi',
        'kelompok_id',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'bukti_sosmed' => 'array',
        'status' => 'boolean',
    ];

    /**
     * Mendefinisikan relasi bahwa MahasiswaBaru ini milik satu Kelompok.
     */
    public function kelompok()
    {
        // Relasi 'belongsTo' ke model Kelompok.
        // Laravel akan otomatis mencari foreign key 'kelompok_id' di tabel ini.
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function izinKehadiran()
    {
        return $this->hasMany(IzinKehadiran::class);
    }
}
