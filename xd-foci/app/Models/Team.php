<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class representing a team.
 *
 * @property integer $id Id of the team.
 * @property string $name Name of the team.
 * @property string $shortname Short name of the team (maximum 4 chars).
 * @property string $image Image of the team. Nullable.
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Player> $players Players of the team.
 * @property Collection<Game> $games Games that the team was/is/will be part of.
 * @property Collection<User> $users Users that have added the team to their favourites.
 */
class Team extends Model
{
    use HasFactory;

    public function players(): HasMany {
        return $this->hasMany(Player::class);
    }

    public function games(): HasMany {
        return $this->hasMany(Game::class);
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
