<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy {
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Game $game): Response {
        if (!$user->is_admin) {
            return response()->admin();
        }

        if ($game->finished || $game->start->gt(now())) {
            return Response::deny("Eseményt csak folyamatban lévő mérkőzésekhez lehet hozzáadni");
        }

        return Response::allow();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): Response {
        if (!$user->is_admin) {
            return response()->admin();
        }

        if ($event->game->finished) {
            return Response::deny("A lezárt mérkőzésekhez kapcsolódó eseményeket nem lehet törölni");
        }

        return Response::allow();
    }
}
