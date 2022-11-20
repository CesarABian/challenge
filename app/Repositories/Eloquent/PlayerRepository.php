<?php

namespace App\Repositories\Eloquent;

use App\Models\Player;
use App\Repositories\Interfaces\PlayerRepositoryInterface;

class PlayerRepository extends Repository implements PlayerRepositoryInterface
{
    /**
     * __construct
     *
     * @param  Player $model
     * @return void
     */
    public function __construct(Player $model)
    {
        $this->model = $model;
    }
}