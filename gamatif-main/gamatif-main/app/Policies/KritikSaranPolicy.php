<?php

namespace App\Policies;

use App\Models\User;

class KritikSaranPolicy
{
    /**
     * Tentukan apakah user bisa melihat daftar kritik & saran
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa melihat detail kritik & saran
     */
    public function view(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa membuat kritik & saran
     * (kalau memang hanya admin, bisa true. Kalau bukan, ubah sesuai kebutuhan)
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa update kritik & saran
     */
    public function update(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa hapus kritik & saran
     */
    public function delete(User $user): bool
    {
        return $user->role === 'admin';
    }
}
