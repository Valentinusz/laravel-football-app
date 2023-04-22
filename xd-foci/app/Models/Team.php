<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class representing a team.
 * @mixin Builder
 *
 * @property integer $id Id of the team.
 * @property string $name Name of the team.
 * @property string $shortname Short name of the team (maximum 4 chars).
 * @property string $image Image of the team. Nullable.
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Player> $players Players of the team.
 * @property Collection<Game> $homeGames Games played at home that the team was/is/will be part of.
 * @property Collection<Game> $awayGames Games played away from home that the team was/is/will be part of.
 * @property Collection<User> $users Users that have added the team to their favourites.
 */
class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'shortname', 'image'];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected function image(): Attribute {
        return Attribute::make(
            get: function (?string $value) {
                if ($value === null) {
                    return asset('images/dummy.png');
                }

                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    return \Illuminate\Support\Facades\Storage::url($value);
                }
                return $value;
            }
        );
    }

    public function players(): HasMany {
        return $this->hasMany(Player::class);
    }

    public function homeGames(): HasMany {
        return $this->hasMany(Game::class, 'home_team_id')->orderBy('start');
    }

    public function awayGames(): HasMany {
        return $this->hasMany(Game::class, 'away_team_id')->orderBy('start');
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Merged collection containing the values of the homeGames and awayGames properties.
     *
     * @return Collection<Game>
     */
    public function games(): Collection {
        return $this->homeGames->merge($this->awayGames);
    }

    /**
     * Calculates the points of the team.
     *
     * @return int Points of the team.
     */
    public function getScore(): int {
        $score = 0;
        foreach ($this->homeGames as $game) {
            $gameScore = $game->score();

            switch ($gameScore['home'] <=> $gameScore['away']) {
                case -1:
                    break;
                case 0:
                    $score++;
                    break;
                case 1:
                    $score += 3;
                    break;
            }
        }

        foreach ($this->awayGames as $game) {
            $gameScore = $game->score();

            switch ($gameScore['home'] <=> $gameScore['away']) {
                case -1:
                    $score += 3;
                    break;
                case 0:
                    $score++;
                    break;
                case 1:
                    break;
            }
        }

        return $score;
    }

    /**
     * Calculates the goal difference (goals scored - goals conceded) of the team.
     *
     * @return int Goal difference.
     */
    public function getGoalDifference(): int {
        $scored = 0;
        $conceded = 0;

        foreach ($this->games() as $game) {
            $gameScore = $game->score();
            $isHome = $this->id === $game->homeTeam->id;
            $scored += $isHome ? $gameScore['home'] : $gameScore['away'];
            $conceded += $isHome ? $gameScore['away'] : $gameScore['home'];
        }

        return $scored - $conceded;
    }
}
