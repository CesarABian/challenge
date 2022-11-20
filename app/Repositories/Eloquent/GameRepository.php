<?php

namespace App\Repositories\Eloquent;

use App\Models\Game;
use App\Repositories\Interfaces\GameRepositoryInterface;

class GameRepository extends Repository implements GameRepositoryInterface
{
    /**
     * __construct
     *
     * @param  Game $model
     * @return void
     */
    public function __construct(Game $model)
    {
        $this->model = $model;
    }
}