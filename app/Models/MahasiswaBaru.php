<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MahasiswaBaru extends Authenticatable
{
    use Notifiable;

    protected $table = 'mahasiswa_baru';

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'bukti_sosmed' => 'array',
        'status' => 'boolean',
        'password' => 'hashed',
    ];

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class, 'mahasiswa_baru_id');
    }

    public function izinKehadirans(): HasMany
    {
        return $this->hasMany(IzinKehadiran::class, 'mahasiswa_baru_id');
    }
}