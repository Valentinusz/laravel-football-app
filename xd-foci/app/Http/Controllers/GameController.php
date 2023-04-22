<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\LockedHttpException;

class GameController extends Controller {
    public function __construct() {
        $this->authorizeResource(Game::class, 'game');
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
                ->orderBy('start')
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('create-edit-game');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validate = $request->validate([
            'start' => ['required', 'date', 'after:now'],
            'home_team_id' => ['required'],
            'away_team_id' => ['required', 'different:home_team_id']
        ]);

        $data = $request->all();
        $request['finished'] = false;
        Game::create($data);

        return redirect('games');
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game) {
        return view('game', [
            'game' => $game
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Game $game) {
        return view('create-edit-game', ['game' => $game]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game) {
        $validate = $request->validate([
            'start' => ['required', 'date', 'after:now'],
            'home_team_id' => ['required'],
            'away_team_id' => ['required', 'different:home_team_id']
        ]);

        $game->update($request->all());

        return redirect('games');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game) {
        //
    }
}
