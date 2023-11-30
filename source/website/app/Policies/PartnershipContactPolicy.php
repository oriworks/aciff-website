<?php

namespace App\Policies;

use App\Models\PartnershipContact;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PartnershipContactPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PartnershipContact $partnershipContact): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PartnershipContact $partnershipContact): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PartnershipContact $partnershipContact): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PartnershipContact $partnershipContact): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PartnershipContact $partnershipContact): bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }
}
