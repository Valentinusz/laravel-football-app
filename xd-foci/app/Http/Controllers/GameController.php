<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller {
    // add lock to resource ability map
    protected function resourceAbilityMap(): array {
        return array_merge(parent::resourceAbilityMap(), [
            'lock' => 'lock'
        ]);
    }

    public function __construct() {
        $this->authorizeResource(Game::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View {
        return view('games', [
            'finished' => Game::where('finished', '=', true)
                ->orderBy('start')
                ->paginate(10),
            'ongoing' => Game::where('finished', '=', false)
                ->where('start', '<=', Carbon::now())
                ->orderBy('start')
                ->get(),
            'future' => Game::where('finished', '=', false)
                ->where('start', '>', Carbon::now())
                ->orderBy('start')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        return view('create-edit-game');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'start' => ['required', 'date', 'after:now'],
            'home_team_id' => ['required'],
            'away_team_id' => ['required', 'different:home_team_id']
        ]);

        $validated['finished'] = false;
        Game::create($validated);

        return to_route('games.index')->with('create', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game): View {
        return view('game', [
            'game' => $game
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game): View {
        return view('create-edit-game', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game): RedirectResponse {
        $validated = $request->validate([
            'start' => ['required', 'date', 'after:now'],
            'home_team_id' => ['required'],
            'away_team_id' => ['required', 'different:home_team_id']
        ]);

        $game->update($validated);

        return to_route('games.index')->with('update', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game): RedirectResponse {
        //
        return to_route('games.index')->with('delete', Game::destroy($game->id));
    }

    public function lock(Game $game): RedirectResponse {
        $game->update(['finished' => true]);

        return to_route('games.show', $game);
    }
}
