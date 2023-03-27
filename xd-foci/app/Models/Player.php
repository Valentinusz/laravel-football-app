<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class representing a player.
 *
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
}
