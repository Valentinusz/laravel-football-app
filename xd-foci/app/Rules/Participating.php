<?php /** @noinspection ALL */

namespace App\Rules;

use App\Models\Game;
use App\Models\Player;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Illuminate\Validation\Validator;

/**
 * Validation rule for checking if a player participates (is member of either the home or the away team) in a game.
 * Does not check for the existance of the player and the game, those fields MUST BE VALIDATED BEFOREHAND.
 */
class Participating implements ValidationRule {
    /** @var Game game to check for participation */
    protected Game $game;

    public function __construct(Game $game) {
        $this->game = $game;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value Id of the player to validate.
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        $teamId = Player::find($value)->team_id;

        if ($teamId !== $this->game->home_team_id && $teamId !== $this->game->away_team_id) {
            $fail("The supplied player is not a member of the playing teams.");
        }
    }
}
