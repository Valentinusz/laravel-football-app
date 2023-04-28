<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Game;
use App\Rules\Participating;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;

class EventController extends Controller {
    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     */
    public function create(Game $game): View {
        $this->authorize('create', [Event::class, $game]);
        return view('add-event', ['game' => $game]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Game $game): RedirectResponse {
        $this->authorize('create', [Event::class, $game]);

        $validated = $request->validate([
            'minute' => ['required', 'numeric', 'integer', 'between:1,90'],
            'type' => ['required', new Enum(EventType::class)],
            'player_id' => ['required', 'exists:players,id', 'bail', new Participating($game)]
        ]);

        $validated['game_id'] = $game->id;
        Event::create($validated);

        return to_route('games.show', ['game' => $request['game']])->with('create', true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws AuthorizationException
     */
    public function destroy(Game $game, Event $event): RedirectResponse {
        $this->authorize('delete', [$event, $game]);
        return to_route('games.show', ['game' => $game])->with('delete', $event->delete());
    }
}
