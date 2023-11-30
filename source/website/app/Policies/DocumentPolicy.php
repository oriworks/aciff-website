<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('documents.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        return $user->hasPermissionTo('documents.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('documents.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        if ($user->hasPermissionTo('documents.update') || $user->id === $document->created_by) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can attach any tag to the model.
     */
    public function attachAnyTag(User $user, Document $document): bool
    {
        if ($user->hasPermissionTo('documents.attachAnyTag') || $user->id === $document->created_by) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can detach any tag to the model.
     */
    public function detachTag(User $user, Document $document, Tag $tag): bool
    {
        if ($user->hasPermissionTo('documents.detachTag') || $user->id === $document->created_by) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): void //: bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): void //: bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): void //: bool
    {
        if ($user->hasRole('admin-aciff')) {
            return true;
        }

        return false;
    }
}
