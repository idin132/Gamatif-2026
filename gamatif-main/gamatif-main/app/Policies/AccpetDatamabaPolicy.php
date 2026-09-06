<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AccpetDatamaba;

class AccpetDatamabaPolicy
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
    public function view(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, AccpetDatamaba $dataMahasiswa): bool
    {
        return $user->role === 'admin';
    }
}
