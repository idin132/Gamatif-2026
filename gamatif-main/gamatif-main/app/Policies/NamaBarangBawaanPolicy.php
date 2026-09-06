<?php

namespace App\Policies;

use App\Models\BarangBawaan;
use App\Models\User;

class NamaBarangBawaanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

       public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BarangBawaan $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }
}
