<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function homeTeam() {
        $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam() {
        $this->belongsTo(Team::class, 'away_team_id');
    }
}
