<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Game;
use App\Rules\Ongoing;
use App\Rules\Participating;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class EventController extends Controller {
    public function __construct() {
        $this->authorizeResource(Event::class);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Game $game) {
        return view('event.add-event', ['game' => $game]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'game' => ['required', 'exists:games,id', 'bail', new Ongoing()],
            'minute' => ['required', 'numeric', 'integer', 'between:1,90'],
            'type' => ['required', new Enum(EventType::class)],
            'player' => ['required', 'exists:players,id', 'bail', new Participating()]
        ]);

        Event::create(
            [
                'type' => $request->type,
                'minute' => $request->minute,
                'game_id' => $request->game,
                'player_id' => $request->player
            ]
        );

        return to_route('games.show', ['game' => $request['game']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game, Event $event) {
        return to_route('games.show', ['game' => $game]);
    }
}
