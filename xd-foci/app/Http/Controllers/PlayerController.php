<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlayerController extends Controller {

    // add authorization
    public function __construct() {
        $this->authorizeResource(Player::class, 'player');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Team $team) {
        return view('add-player', ['team' => $team]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'team_id' => ['required', 'exists:teams,id'],
            'name' => ['required'],
            'number' => ['required', 'numeric', 'integer'],
            'birthdate' => ['required', 'date']
        ]);

        Player::create($request->all());

        return to_route('teams.show', ['team' => $request->team_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
