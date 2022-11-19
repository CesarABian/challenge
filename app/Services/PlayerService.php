<?php

namespace App\Services;

use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
    
    /**
     * allPaginatedAndFiltered
     *
     * @param  array $extraData
     * @param  array $columns
     * @param  array $relations
     * @return LengthAwarePaginator
     */
    public function allPaginatedAndFiltered(
        array $extraData = [], array $columns = ['*'], array $relations = []
    ): LengthAwarePaginator
    {
        $config = [
            'perPage' => 15,
            'page' => null,
            'filters' => [],
            'orderBy' => '',
            'orderDirection' => ''
        ];
        foreach (array_keys($config) as $key) {
            if (!empty($extraData[$key])) {
                $config[$key] = $extraData[$key];
            }
        }
        return $this->repository->allPaginatedAndFiltered($config, $columns, $relations);
    }
}