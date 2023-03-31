<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class representing an event that occurred during a game.
 * @mixin Builder
 *
 * @property integer $id Id of the event.
 * @property string $type Type of the event.
 * @property integer $minute Minute of the game the event occurred at.
 * @property Game $game Game the Event occurred in.
 * @property Carbon $created_at
 * @property Carbon $updated_at
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
