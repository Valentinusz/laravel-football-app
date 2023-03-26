<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start');
            $table->boolean('finished')->default(false);

            $table->bigInteger('home_team_id')->nullable();
            $table->foreign('home_team_id')->references('id')->on('team');

            $table->bigInteger('away_team_id')->nullable();
            $table->foreign('home_team_id')->references('id')->on('team');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
