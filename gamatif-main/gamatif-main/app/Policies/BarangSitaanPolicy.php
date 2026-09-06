<?php

namespace App\Policies;

use App\Models\BarangSitaan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BarangSitaanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->email === 'admin@gmail.com';
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, BarangSitaan $barangSitaan): bool
    // {
    //     return $user->email === 'admin@gmail.com';
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BarangSitaan $barangSitaan): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BarangSitaan $barangSitaan): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, BarangSitaan $barangSitaan): bool
    // {
    //     return $user->email === 'admin@gmail.com';
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BarangSitaan $barangSitaan): bool
    {
        return $user->email === 'admin@gmail.com';
    }
    // public function deleteAny(User $user, BarangSitaan $barangSitaan): bool
    // {
    //     return $user->email === 'admin@gmail.com';
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restoreAny(User $user, BarangSitaan $barangSitaan): bool
    // {
    //     return $user->email === 'admin@gmail.com';
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDeleteAny(User $user, BarangSitaan $barangSitaan): bool
    // {
    //     return $user->email === 'admin@gmail.com';
    // }
}
