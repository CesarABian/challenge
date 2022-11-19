<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;
    
    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * retrieves all models
     *
     * @param  array $column
     * @param  array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model
            ->newQuery()
            ->select($columns)
            ->with($relations)
            ->get();
    }
    
    /**
     * stores a model
     *
     * @param  array $attributes
     * @return Model|Collection
     */
    public function store(array $attributes): Model|Collection
    {
        return $this->model
            ->newQuery()
            ->create($attributes);
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
        return $this->model
            ->newQuery()
            ->select($columns)
            ->with($relations)
            ->find($id);
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
        return $this->model
            ->newQuery()
            ->select($columns)
            ->with($relations)
            ->where($column, $value)
            ->first();
    }
    
    /**
     * finds a model Where a condition is given
     *
     * @param  array $whereQuery
     * @return Collection
     */
    public function findWhere(array $whereQuery): Collection
    {
        return $this->model
            ->newQuery()
            ->where($whereQuery)
            ->get();
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
        $model = $this->model
            ->newQuery()
            ->find($id);
        $model->update($attributes);
        return $model;
    }
    
    /**
     * destroys a model
     *
     * @param  mixed $id
     * @return 
     */
    public function destroy(mixed $id)
    {
        return $this->model
            ->newQuery()
            ->find($id)
            ->delete();
    }
}
