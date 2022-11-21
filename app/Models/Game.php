<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_a_id',
        'player_b_id',
        'winner_id',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }
}