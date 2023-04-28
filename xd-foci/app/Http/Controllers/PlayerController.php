<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlayerController extends Controller {
    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(Team $team): View {
        $this->authorize('create', [Player::class, $team]);
        return view('add-player', ['team' => $team]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Team $team): RedirectResponse {
        $this->authorize('create', [Player::class, $team]);

        $validated = $request->validate([
            'name' => ['required'],
            'number' => ['required', 'numeric', 'integer'],
            'birthdate' => ['required', 'date']
        ]);

        $validated['team_id'] = $team->id;
        Player::create($validated);

        return to_route('teams.show', ['team' => $team])->with('create', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Team $team, Player $player) {
        $this->authorize('delete', [$player, $team]);

        return to_route('teams.show', ['team' => $team])
            ->with('delete', $player->events->isEmpty() && $player->delete());
    }
}
