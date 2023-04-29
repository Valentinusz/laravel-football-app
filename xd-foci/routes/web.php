<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\Authenticate;
use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function() {
    return view('home');
})->name('home');

Route::post('games/{game}/lock', [GameController::class, 'lock'])->name('games.lock');
Route::resource('games', GameController::class);

Route::post('teams/{team}/favourite', [TeamController::class, 'favourite'])
    ->name('teams.favourite')
    ->middleware(Authenticate::class);

Route::resource('teams', TeamController::class)->except(['destroy']);
Route::resource('games.events', EventController::class)->only(['create', 'store', 'destroy']);
Route::resource('teams.players', PlayerController::class)->only(['create', 'store', 'destroy']);

Route::get('/favourites', function() {
    $favouriteTeams = Auth::user()->teams()->select('teams.id');
    $games = Game::whereIn('home_team_id', $favouriteTeams)
        ->orWhereIn('away_team_id', $favouriteTeams)
        ->with('events')
        ->get();

    return view('favourites', ['games' => $games]);
})->name('favourites')->middleware(Authenticate::class);

Route::get('/table', function() {
    $teams = new Collection();

    foreach (Team::all() as $team) {
        /** @var Team $team */
        $teams->push(
            ['team' => $team, 'score' => $team->getScore(), 'goalDifference' => $team->getGoalDifference()]
        );
    }

    return view('table', ['teams' => $teams]);
})->name('table');

Route::middleware('auth')->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
