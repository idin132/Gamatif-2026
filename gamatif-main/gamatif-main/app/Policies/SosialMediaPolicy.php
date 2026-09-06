<?php

namespace App\Policies;

use App\Models\User;

class SosialMediaPolicy
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
    
       public function view(User $user): bool
    {
        return $user->role === 'admin';
    }
}
