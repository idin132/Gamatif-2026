<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JadwalKegiatan;

class JadwalKegiatanPolicy
{
    /**
     * Tentukan apakah user bisa melihat daftar jadwal kegiatan.
     */
    public function viewAny(User $user): bool
    {
        
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa melihat detail jadwal kegiatan.
     */
    public function view(User $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa membuat jadwal kegiatan.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa update jadwal kegiatan.
     */
    public function update(User $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa delete jadwal kegiatan.
     */
    public function delete(User $user, JadwalKegiatan $jadwalKegiatan): bool
    {
        return $user->role === 'admin';
    }
}
