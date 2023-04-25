<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\Authenticate;
use App\Models\Game;
use Illuminate\Database\Query\JoinClause;
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

Route::get('/favourites', function() {
    $games = Game::join('team_user', function(JoinClause $join) {
        $join->on('home_team_id', '=', 'team_id')->orOn('away_team_id', '=', 'team_id');
    })->where('user_id', '=', \Illuminate\Support\Facades\Auth::id())->distinct()->get();

    return view('favourites', ['games' => $games]);
})->name('favourites')->middleware(Authenticate::class);

Route::post('games/{game}/lock', [GameController::class, 'lock'])->name('games.lock');
Route::resource('games', GameController::class);

Route::post('teams/{team}/favourite', [TeamController::class, 'favourite'])->name('teams.favourite')->middleware(Authenticate::class);
Route::resource('teams', TeamController::class)->except(['destroy']);

Route::resource('games.events', EventController::class)->only(
    ['create', 'store', 'destroy']
);

Route::resource('teams.players', PlayerController::class)->only(
    ['create', 'store', 'destroy']
);

Route::get('/table', function() {
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
            case -1:
                return 1;
            case 0:
            {
                switch ($team1['goalDifference'] <=> $team2['goalDifference']) {
                    case -1:
                        return 1;
                    case 0:
                        return strcmp($team1['team']->name, $team2['team']->name);
                    case 1:
                        return -1;
                }
            }
            case 1:
                return -1;
        }
        return 0;
    });

    return view('table', ['teams' => $teams]);
})->name('table');

Route::middleware('auth')->group(function() {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
