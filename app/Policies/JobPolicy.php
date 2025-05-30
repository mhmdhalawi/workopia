<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{


    /**
     * Determine whether the user can view a model.
     * 
     */
    public function view(User $user, string $id): Response
    {
        // Allow viewing if the user is an admin or the job belongs to the user
        if ($user->is_admin || $user->id === $id) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized.');
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->is_admin) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized.');
        }
    }

    /**
     * Determine whether the user can modify the model.
     */
    public function modify(User $user, string $id): Response
    {
        if ($user->is_admin || $user->id === $id) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized.');
        }
    }
}
