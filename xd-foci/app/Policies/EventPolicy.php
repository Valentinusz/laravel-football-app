<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy {
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response {
        if (!$user->is_admin) {
            return Response::deny("Ez a funkció csak admin jogosultságú felhasználók számára érhető el");
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): Response {
        if (!$user->is_admin) {
            return Response::deny("Ez a funkció csak admin jogosultságú felhasználók számára érhető el");
        }

        if ($event->game->finished) {
            return Response::deny("A lezárt mérkőzésekhez kapcsolódó eseményeket nem lehet törölni");
        }

        return Response::allow();
    }
}
