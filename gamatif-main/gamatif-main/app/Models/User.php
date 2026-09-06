<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Kelompok;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'kelompok',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        Log::info('canAccessPanel dipanggil untuk user id: ' . $this->id);
        return true; // Ganti logika ini sesuai kebutuhan akses kamu
    }

    // Kalau kamu mau, method ini bisa kamu hapus atau biarkan, tapi Filament default pakai canAccessPanel()
    public function canAccessFilament(): bool
    {
        Log::info('canAccessFilament dipanggil untuk user id: ' . $this->id);
        return true;
    }
    public function kelompok()
    {
        return $this->hasOne(kelompok::class, 'user_id', 'id');
    }
}
