<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    /**
     * @var array $fillable
     */
    protected array $fillable = [
        'player_a_id',
        'player_b_id',
        'winner_id',
    ];
    
    /**
     * player_a
     *
     * @return BelongsTo
     */
    public function player_a(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_a_id');
    }
    
    /**
     * player_b
     *
     * @return BelongsTo
     */
    public function player_b(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_b_id');
    }
    
    /**
     * winner
     *
     * @return BelongsTo
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }
}