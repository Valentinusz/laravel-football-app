<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class representing an event that occurred during a game.
 *
 * @property Game $game Game related to the Event.
 * @property Player $player Player related to the Event.
 */
class Event extends Model
{
    use HasFactory;

    public function game(): BelongsTo {
        return $this->belongsTo(Game::class);
    }

    public function player(): BelongsTo {
        return $this->belongsTo(Player::class);
    }
}
