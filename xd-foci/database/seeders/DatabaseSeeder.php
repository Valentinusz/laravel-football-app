<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
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
        //Team::factory($teamCount)->create();

        $matchCount = 4 * $teamCount;

        $eventCount = $matchCount * 4;

        $playerCount = $teamCount * 12;
        Player::factory($teamCount)->create();
    }
}
