<?php /** @noinspection ALL */

namespace App\Rules;

use App\Models\Game;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Validation rule for checking if a game is still in progress.
 * Does not check game existance, that should be validated beforehand.
 */
class Ongoing implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        /** @var int $value Game Id to validate. */
        if (Game::find($value)->finished) {
            $fail('Game must be ongoing.');
        }
    }
}
