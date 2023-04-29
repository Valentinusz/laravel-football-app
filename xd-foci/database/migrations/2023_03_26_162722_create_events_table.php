<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            // also change EventFactory when changing this enum
            $table->enum('type', array_column(\App\Models\EventType::cases(), 'value'));
            $table->unsignedTinyInteger('minute');

            $table->unsignedInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');

            $table->unsignedInteger('player_id');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('events');
    }
};
