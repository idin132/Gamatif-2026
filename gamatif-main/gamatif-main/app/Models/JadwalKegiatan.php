<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kegiatan';

    protected $fillable = [
        'nama',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function izinKehadiran()
    {
        return $this->hasMany(IzinKehadiran::class);
    }
}
