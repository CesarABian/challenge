<?php

namespace App\Services;

use App\Repositories\Interfaces\TournamentRepositoryInterface;

class TournamentService extends Service
{
    /**
     * @var TournamentRepositoryInterface
     */
    protected $repository;

    /**
     * __construct
     *
     * @param  TournamentRepositoryInterface $repository
     * @return void
     */
    public function __construct(TournamentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}