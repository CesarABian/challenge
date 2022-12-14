<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    /**
     * @var $fillable
     */
    protected $fillable = [
        'name',
        'last_name',
        'ability',
        'force',
        'velocity',
        'reaction',
        'genre',
    ];
}
