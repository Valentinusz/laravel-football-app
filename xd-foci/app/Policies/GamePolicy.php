<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GamePolicy {
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null {
        // authorize admin
        if ($user->is_admin) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Game $game): bool {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {}

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): bool {}

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Game $game): bool {}

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Game $game): bool {}

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Game $game): bool {}
}