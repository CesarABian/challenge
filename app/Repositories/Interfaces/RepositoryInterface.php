<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


interface RepositoryInterface
{
    /**
     * retrieves all models
     *
     * @param  array $column
     * @param  array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;
    
    /**
     * stores a model
     *
     * @param  array $attributes
     * @return Model
     */
    public function store(array $attributes): Model|Collection;
    
    /**
     * finds a model
     *
     * @param  mixed $id
     * @param  array $columns
     * @param  array $relations
     * @return Model|Collection|null
     */
    public function find(mixed $id, array $columns = ['*'], array $relations = []): Model|Collection|null;
    
    /**
     * finds a model by
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  array $columns
     * @param  array $relations
     * @return ?Model
     */
    public function findBy(mixed $column, mixed $value, array $columns = ['*'], array $relations = []): ?Model;
    
    /**
     * finds a model Where a condition is given
     *
     * @param  array $whereQuery
     * @return Collection
     */
    public function findWhere(array $whereQuery): Collection;
    
    /**
     * updates a model
     *
     * @param  mixed $id
     * @param  array $attributes
     * @return Model
     */
    public function update(mixed $id, array $attributes): Model;
    
    /**
     * destroys a model
     *
     * @param  mixed $id
     * @return ?bool
     */
    public function destroy(mixed $id): ?bool;

    /**
     * returns all models paginated and filtered
     *
     * @param  array $config
     * @param  array $columns
     * @param  array $relations
     * @return LengthAwarePaginator
     */
    public function allPaginatedAndFiltered(array $config, array $columns, array $relations): LengthAwarePaginator;
    
    /**
     * truncate
     *
     * @return void
     */
    public function truncate(): void;
}
