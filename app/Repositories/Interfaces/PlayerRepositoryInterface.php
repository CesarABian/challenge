<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;


interface PlayerRepositoryInterface extends RepositoryInterface
{    
    /**
     * returns all models paginated and filtered
     *
     * @param  array $config
     * @param  array $columns
     * @param  array $relations
     * @return LengthAwarePaginator
     */
    public function allPaginatedAndFiltered(array $config, array $columns, array $relations): LengthAwarePaginator;
}