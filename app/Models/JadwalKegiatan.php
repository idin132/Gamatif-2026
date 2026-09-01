<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalKegiatan extends Model
{
    protected $table = 'jadwal_kegiatan';

    protected $guarded = ['id'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'jadwal_kegiatan_id');
    }

    public function izinKehadirans(): HasMany
    {
        return $this->hasMany(IzinKehadiran::class, 'jadwal_kegiatan_id');
    }
}