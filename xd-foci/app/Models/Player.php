<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class representing a player.
 * @mixin Builder
 *
 * @property integer $id Id of the player.
 * @property string $name Name of the player.
 * @property integer $number Number of the player.
 * @property Carbon $birthdate Datetime of the player's birth.
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Team $team Team of the player.
 * @property Collection<Event> $events Game events that are related to the player.
 */
class Player extends Model
{
    use HasFactory;

    public function team(): BelongsTo {
        return $this->belongsTo(Team::class);
    }

    public function events(): HasMany {
        return $this->hasMany(Event::class);
    }

    /**
     * Counts how many events of the specified type is associated with the player.
     *
     * @param EventType $eventType Type of the Event.
     * @return int
     */
    public function getEventCount(EventType $eventType): int {
        return Event::where('player_id', '=', $this->id)
            ->where('type', '=', $eventType->value)
            ->count();
    }
}
