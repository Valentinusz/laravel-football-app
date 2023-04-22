<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlayerPolicy {
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response {
        return $user->is_admin ? Response::allow() : response()->admin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Player $player): Response {
        return $user->is_admin ? Response::allow() : response()->admin();
    }
}
