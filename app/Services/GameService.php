<?php

namespace App\Services;

use App\Repositories\Interfaces\GameRepositoryInterface;

class GameService extends Service
{
    /**
     * @var GameRepositoryInterface
     */
    protected $repository;

    /**
     * __construct
     *
     * @param  GameRepositoryInterface $repository
     * @return void
     */
    public function __construct(GameRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}