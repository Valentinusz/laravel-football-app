<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\EventFactory;
use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Team and player seeding
        $teamCount = rand(10, 15); // generate 10-15

        /** @var Collection<Team> $teams */
        $teams = Team::factory($teamCount)->create();

        $teams->each(function($team) {
            // generate 11-14 players for each team
            $playersOfTeam = Player::factory(rand(11, 14))->create();

            // add players to team
            $playersOfTeam->each(function(Player $player) use (&$team) {
                $player->team()->associate($team); // Player N : 1 Team
                $player->save();
            });
        });

        // Game seeding
        /** @var GameFactory $gameFactory */
        $gameFactory = Game::factory();

        /** @var Collection<Game> $finishedGames */
        $finishedGames = $gameFactory->count($teamCount)->finished()->create();

        /** @var Collection<Game> $inProgressGames */
        $inProgressGames = $gameFactory->count(intdiv($teamCount, 4))->onGoing()->create();

        $finishedGames->each(function(Game $game) use (&$teams) {
            $playingTeams = $teams->random(2);
            $this->associateTeamsToGame($game, $playingTeams[0], $playingTeams[1]); // Team 1 : N Game
        });

        $inProgressGames->each(function(Game $game) use (&$teams) {
            if ($teams->count() >= 2) {
                $playingTeams = $teams->random(2);
                $game->homeTeam()->associate($playingTeams[0]);
                $game->awayTeam()->associate($playingTeams[1]);
                $game->save();

                // remove teams who are currently playing from collection
                $teams = $teams->diff($playingTeams);

                $this->associateTeamsToGame($game, $playingTeams[0], $playingTeams[1]);
            }
        });

        // Event seeding
        $finishedGames->each(function(Game $game) use (&$players) {
            // for finished games generate 10-15 events
            Event::factory(rand(10, 15))->create()->each(function (Event $event) use ($game) {
                    $this->makeEventAssociations($event, $game);
                }
            );
        });

        $inProgressGames->each(function(Game $game) use (&$players) {
            // for inProgress games generate events based on how long the game has been going for (gameLength / 8)
            $gameLength = now()->diffInMinutes(Carbon::parse($game->start));

            /** @var EventFactory $eventFactory */
            $eventFactory = Event::factory(intdiv($gameLength, 8));

            $eventFactory->inProgressGameEvent($gameLength)->create()->each(
                function (Event $event) use ($game) {
                    $this->makeEventAssociations($event, $game);
                }
            );
        });

        // User seeding

        /** @noinspection PhpDynamicAsStaticMethodCallInspection */
        User::firstOrCreate([
            'name' => 'Boda Bálint',
            'email' => 'admin@szerveroldali.hu',
            'email_verified_at' => now(),
            'password' =>  Hash::make('adminpwd'),
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);

        User::factory(10)->create()->each(
            function(User $user) use (&$teams) {
                $user->teams()->sync($teams->random(mt_rand(0, 4)));
            }
        );
    }

    /**
     * Creates association between two teams and a game.
     *
     * @param Game $game game to associate teams to.
     * @param Team $away team playing away from home.
     * @param Team $home team playing at home.
     * @return void
     */
    private function associateTeamsToGame(Game $game, Team $home, Team $away): void {
        $game->homeTeam()->associate($home);
        $game->awayTeam()->associate($away);
        $game->save();
    }

    /**
     * Create associations between a game and event, and between an event and player.
     *
     * @param Event $event
     * @param Game $game
     * @return void
     */
    private function makeEventAssociations(Event $event, Game $game): void {
        $event->game()->associate($game);

        // 50-50 that the player assigned to the event is from the away or the home team
        $event->player()->associate(mt_rand(0,1) ?
                                        $game->awayTeam->players->random() :
                                        $game->homeTeam->players->random()
        );
        $event->save();
    }
}
