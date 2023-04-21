<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use App\Models\Game;
use App\Rules\Ongoing;
use App\Rules\Participating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class EventController extends Controller
{

    // add authorization
    public function __construct() {
        $this->authorizeResource(Event::class, 'event');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Game $game) {
        return view('event.add-event', ['game' => $game]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'game' => ['required', 'exists:games,id', new Ongoing()],
            'minute' => ['required', 'numeric', 'integer', 'between:1,90'],
            'type' => ['required', new Enum(EventType::class)],
            'player' => ['required', new Participating()]
        ]);

        var_dump($validated);

        return to_route('games.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
