<?php

namespace App\Policies;

use App\Models\User;
use App\Models\task;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
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
    public function view(User $user, task $task): bool
    {
        if($user->id === $task ->creator_id) {
            return true;
        }

        if($task->project && $user->memberships->contains($task->project)) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, task $task): bool
    {
        return $user->id === $task->creator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, task $task): bool
    {
        return $user->id === $task->creator_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, task $task): bool
    {
        return false;
    }
}
