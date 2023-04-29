<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GamePolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Game $game): bool {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response {
        if (!$user->is_admin) {
            return response()->admin();
        }
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): Response {
        if (!$user->is_admin) {
            return response()->admin();
        }

        if (!$game->editable()) {
            return Response::deny("A mérkőzés lezárult ezért nem szerkeszthető");
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Game $game): Response {
        if (!$user->is_admin) {
            return response()->admin();
        }

        if (!$game->editable()) {
            return Response::deny("Lezárt vagy eseménnyel rendelkező mérkőzést nem lehet törölni");
        }

        return Response::allow();

    }

    /**
     * Determine whether the user can lock the model.
     */
    public function lock(User $user, Game $game): Response {
        if (!$user->is_admin) {
            return response()->admin();
        }

        if ($game->finished) {
            return Response::deny("A mérkőzés már le van zárva");
        }

        return Response::allow();
    }
}
