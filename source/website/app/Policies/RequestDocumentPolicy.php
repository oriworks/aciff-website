<?php

namespace App\Policies;

use App\Models\RequestDocument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestDocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('requestDocuments.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RequestDocument $requestDocument): bool
    {
        return $user->hasPermissionTo('requestDocuments.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('requestDocuments.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RequestDocument $requestDocument): bool
    {
        return $user->hasPermissionTo('requestDocuments.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequestDocument $requestDocument): bool
    {
        return $user->hasPermissionTo('requestDocuments.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequestDocument $requestDocument): bool
    {
        return $user->hasPermissionTo('requestDocuments.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequestDocument $requestDocument): bool
    {
        return $user->hasPermissionTo('requestDocuments.forceDelete');
    }
}
