<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Database\Factories\GameFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create(['email' => 'admin@szerveroldali.hu', 'password' => 'adminpwd', 'is_admin' => true]);
        \App\Models\User::factory(10)->create();

        $teamCount = rand(10, 15);
        Team::factory($teamCount)->create();

        $gameCount = [2 * $teamCount, $teamCount, 2 * $teamCount];

        /**
         * Specify type to avoid IDE warning.
         * @var GameFactory $gameFactory
         */
        $gameFactory = Game::factory();

        $finishedGames = $gameFactory->count($gameCount[0])->finished()->create();
        $inProgressGames = $gameFactory->count($gameCount[1])->inProgress()->create();
        $futureGames = $gameFactory->count($gameCount[2])->future()->create();

        $eventCount = array_sum($gameCount);
        Event::factory($eventCount)->create();

        $playerCount = $teamCount * 12;
        Player::factory($teamCount)->create();
    }
}
