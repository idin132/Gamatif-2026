<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PengaturanWeb;

class PengaturanWebPolicy
{
    /**
     * Tentukan apakah user bisa melihat semua data.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa melihat detail data.
     */
    public function view(User $user, PengaturanWeb $pengaturanWeb): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa membuat data baru.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa update data.
     */
    public function update(User $user, PengaturanWeb $pengaturanWeb): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Tentukan apakah user bisa delete data.
     */
    public function delete(User $user, PengaturanWeb $pengaturanWeb): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Helper: cek apakah user adalah admin.
     */
    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }
}