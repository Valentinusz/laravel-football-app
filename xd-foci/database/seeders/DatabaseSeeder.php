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
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(['email' => 'admin@szerveroldali.hu', 'password' => 'adminpwd', 'is_admin' => true]);
        User::factory(10)->create();

        // generate 10-15
        $teamCount = rand(10, 15);
        $teams = Team::factory($teamCount)->create();

        $teams->each(function($team) {
            // generate 11-14 players for each team
            $playersOfTeam = Player::factory(rand(11, 14))->create();

            // add players to team
            $playersOfTeam->each(function(Player $player) use (&$team) {
                $player->team()->associate($team);
                $player->save();
            });
        });

        // generate teamCount finished, teamCount / 2 inProgress and teamCount finished games
        $gameCount = [$teamCount, intdiv($teamCount, 2), $teamCount];

        /** @var GameFactory $gameFactory */
        $gameFactory = Game::factory();

        $finishedGames = $gameFactory->count($gameCount[0])->finished()->create();
        $inProgressGames = $gameFactory->count($gameCount[1])->inProgress()->create();
        $futureGames = $gameFactory->count($gameCount[2])->future()->create();

        // associate teams with games
        $finishedGames->each(function(Game $game) use (&$teams) {
            $this->associateTeamToGame($game, $teams);
        });

        $inProgressGames->each(function(Game $game) use (&$teams) {
            $this->associateTeamToGame($game, $teams);
        });

        $futureGames->each(function(Game $game) use (&$teams) {
            $this->associateTeamToGame($game, $teams);
        });

        // for finished games generate 10-15 events
        $finishedGames->each(function(Game $game) use (&$players) {
            $gameEvents = Event::factory(rand(10, 15))->create();

            $gameEvents->each(
                function (Event $event) use ($game) {
                    $this->makeEventAssociations($event, $game);
                }
            );
        });

        // for inProgress games generate events based on how long the game has been going for
        $inProgressGames->each(function(Game $game) use (&$players) {
            $gameLength = now()->diffInMinutes(Carbon::parse($game->start));

            // generate gamestart / 8 events
            /** @var EventFactory $eventFactory */
            $eventFactory = Event::factory(intdiv($gameLength, 8));
            $gameEvents = $eventFactory->inProgressGameEvent($gameLength)->create();

            $gameEvents->each(
                function (Event $event) use ($game) {
                    $this->makeEventAssociations($event, $game);
                }
            );
        });
    }

    private function associateTeamToGame(Game $game, Collection $teams) {
        $playingTeams = $teams->random(2);
        $game->homeTeam()->associate($playingTeams[0]);
        $game->awayTeam()->associate($playingTeams[1]);
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
