<?php

namespace App\Services;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


abstract class Service
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * retrieves all models
     *
     * @param  array $column
     * @param  array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->all($columns, $relations);
    }
    
    /**
     * stores a model
     *
     * @param  array $attributes
     * @return Model|Collection
     */
    public function store(array $attributes): Model|Collection
    {
        return $this->repository->store($attributes);
    }
    
    /**
     * finds a model
     *
     * @param  mixed $id
     * @param  array $columns
     * @param  array $relations
     * @return Model|Collection|null
     */
    public function find(mixed $id, array $columns = ['*'], array $relations = []): Model|Collection|null
    {
        return $this->repository->find($id, $columns, $relations);
    }
    
    /**
     * finds a model by
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  array $columns
     * @param  array $relations
     * @return ?Model
     */
    public function findBy(mixed $column, mixed $value, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->repository->findBy($column, $value, $columns, $relations);
    }
    
    /**
     * finds a model Where a condition is given
     *
     * @param  array $whereQuery
     * @return Collection
     */
    public function findWhere(array $whereQuery): Collection
    {
        return $this->repository->findWhere($whereQuery);
    }
    
    /**
     * updates a model
     *
     * @param  mixed $id
     * @param  array $attributes
     * @return Model
     */
    public function update(mixed $id, array $attributes): Model
    {
        return $this->repository->update($id, $attributes);
    }
    
    /**
     * destroys a model
     *
     * @param  mixed $id
     * @return 
     */
    public function destroy(mixed $id)
    {
        return $this->repository->destroy($id);
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