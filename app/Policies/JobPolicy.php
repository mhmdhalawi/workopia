<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
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
    public function modify(User $user, Job $job): Response
    {
        if ($user->is_admin || $user->id === $job->user_id) {
            return Response::allow();
        } else {
            return Response::deny('Unauthorized.');
        }
    }
}
