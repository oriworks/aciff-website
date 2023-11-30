<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return true;
        }

        if ($user->hasRole('admin-history') && ($model->hasRole('admin-history') || $model->hasRole('history'))) {
            return true;
        }

        if ($user->hasRole('admin-aciff') && ($model->hasRole('admin-aciff') || $model->hasRole('aciff'))) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin-history', 'admin-aciff']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return true;
        }

        if ($user->hasRole('admin-history') && ($model->hasRole('admin-history') || $model->hasRole('history'))) {
            return true;
        }

        if ($user->hasRole('admin-aciff') && ($model->hasRole('admin-aciff') || $model->hasRole('aciff'))) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): void //: bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): void //: bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): void //: bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }
}
