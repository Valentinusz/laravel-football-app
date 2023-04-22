<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TeamPolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Team $team): bool {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response {
        return $user->is_admin ? Response::allow() : response()->admin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Team $team): bool {
        return $user->is_admin ? Response::allow() : response()->admin();
    }
}
