<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Team::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('teams', ['teams' => Team::orderBy('name')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
        return view('create-edit-team');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'unique:teams,name'],
            'shortname' => ['required', 'unique:teams,short_name'],
            'image' => ['nullable', 'file', 'image']
        ]);

        $team = Team::make(['name' => $validated['name'], 'shortname' => $validated['shortname']]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public');
            $team->image = $path;
        } else {
            $team->image = null;
        }

        $team->save();

        return to_route('teams.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team): View {
        return view('team', ['team' => $team]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}
}
