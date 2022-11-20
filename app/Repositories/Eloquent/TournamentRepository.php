<?php

namespace App\Repositories\Eloquent;

use App\Models\Tournament;
use App\Repositories\Interfaces\TournamentRepositoryInterface;

class TournamentRepository extends Repository implements TournamentRepositoryInterface
{
    /**
     * __construct
     *
     * @param  Tournament $model
     * @return void
     */
    public function __construct(Tournament $model)
    {
        $this->model = $model;
    }
}