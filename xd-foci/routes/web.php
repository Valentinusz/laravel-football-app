<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('games/{game}/lock', [\App\Http\Controllers\GameController::class, 'lock'])->name('games.lock');
Route::resource('games', \App\Http\Controllers\GameController::class);
Route::resource('teams', \App\Http\Controllers\TeamController::class);

Route::resource('games.events', \App\Http\Controllers\EventController::class)->only(
    ['create','store','delete']
);

Route::resource('teams.players', \App\Http\Controllers\PlayerController::class)->only(
    ['create','store','delete']
);

Route::get('/table', function () {
    /** @var \Illuminate\Support\Collection<array> $teams */
    $teams = new \Illuminate\Support\Collection();

    foreach (\App\Models\Team::all() as $team) {
        /** @var \App\Models\Team $team */
        $teams->push(
            ['team' => $team, 'score' => $team->getScore(), 'goalDifference' => $team->getGoalDifference()]
        );
    }

    $teams = $teams->sort(function(array $team1, array $team2) {
        switch ($team1['score'] <=> $team2['score']) {
            case -1: return 1;
            case 0: {
                switch ($team1['goalDifference'] <=> $team2['goalDifference']) {
                    case -1: return 1;
                    case 0: return strcmp($team1['team']->name, $team2['team']->name);
                    case 1: return -1;
                }
            }
            case 1: return -1;
        }
        return 0;
    });

    return view('table', ['teams' => $teams]);
})->name('table');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
