<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function players() {
        $this->hasMany(Player::class);
    }

    public function games() {
        $this->hasMany(Game::class);
    }

    public function users() {
        $this->belongsToMany(User::class);
    }
}
