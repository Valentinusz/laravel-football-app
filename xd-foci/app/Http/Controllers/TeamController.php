<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

        $team->image = null;
        if ($request->hasFile('image')) {
            $team->image = $request->file('image')->store('public');
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
    public function edit(Team $team): View {
        return view('create-edit-team', ['team' => $team]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Team $team): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', Rule::unique('teams')->ignore($team->id)],
            'shortname' => ['required', Rule::unique('teams')->ignore($team->id)],
            'image' => ['nullable', 'file', 'image']
        ]);

        $team->name = $validated['name'];
        $team->shortname = $validated['shortname'];
        if ($team->image !== null && $request->hasFile('image')) {
            //remove old image
            Storage::delete($team->image);

            // upload new image
            $team->image = $request->file('image')->store('public');
        }
        $team->save();

        return to_route('teams.index');
    }

    public function favourite(Request $request, Team $team): RedirectResponse {
        /** @var User $user */
        $user = auth()->user();
        $user->teams()->toggle([$team->id]);
        return redirect()->back();
    }
}
