<?php

namespace App\Services;

use App\Repositories\Interfaces\PlayerRepositoryInterface;

class PlayerService extends Service
{
    /**
     * @var PlayerRepositoryInterface
     */
    protected $repository;

    /**
     * __construct
     *
     * @param  PlayerRepositoryInterface $repository
     * @return void
     */
    public function __construct(PlayerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
}