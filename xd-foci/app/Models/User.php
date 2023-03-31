<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class representing a user.
 *
 * @property integer $id Id of the user.
 * @property string $name Name of the user.
 * @property string $email Email address of the user.
 * @property Carbon $email_verified_at Datetime of the users email verification.
 * @property string $remember_token Remember token of the user.
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property bool $is_admin Boolean that is true when the user has admin privileges.
 * @property Collection<Team> $teams Favourite teams of the user.
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teams(): BelongsToMany {
        return $this->belongsToMany(Team::class)->withTimestamps();
    }
}
