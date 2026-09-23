<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Absensi;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function nomorWhatsapp(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                // Hapus karakter non-angka
                $number = preg_replace('/[^0-9]/', '', $value);

                // Ubah awalan 0 menjadi 62
                if (str_starts_with($number, '0')) {
                    $number = '62' . substr($number, 1);
                }

                return $number; // Menghasilkan format 6282119678835
            }
        );
    }
}