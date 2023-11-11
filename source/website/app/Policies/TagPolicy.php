<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TagPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('tags.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tag $tag): bool
    {
        return $user->hasPermissionTo('tags.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('tags.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tag $tag): bool
    {
        return $user->hasPermissionTo('tags.update');
    }

    /**
     * Determine whether the user can attach any tag to the model.
     */
    public function attachDocument(User $user, Tag $tag, Document $document): bool
    {
        if ($user->hasPermissionTo('documents.attachDocument') || $user->id === $document->created_by) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can detach any tag to the model.
     */
    public function detachDocument(User $user, Tag $tag, Document $document): bool
    {
        if ($user->hasPermissionTo('documents.detachDocument') || $user->id === $document->created_by) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag): bool
    {
        return $user->hasPermissionTo('tags.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tag $tag): bool
    {
        return $user->hasPermissionTo('tags.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tag $tag): bool
    {
        return $user->hasPermissionTo('tags.forceDelete');
    }
}
