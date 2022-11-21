<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

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
        if (!$id instanceof Model) {
            $model = $this->model
                ->newQuery()
                ->find($id);
            $model->update($attributes);
            return $model;
        }
        $id->update($attributes);
        return $id;
    }
    
    /**
     * destroys a model
     *
     * @param  mixed $id
     * @return ?bool
     */
    public function destroy(mixed $id): ?bool
    {
        if (!$id instanceof Model) {
            return $this->model
                ->newQuery()
                ->find($id)
                ->delete();
        }
        return $id->delete();
    }

    /**
     * returns all models paginated and filtered
     *
     * @param  array $config
     * @param  array $columns
     * @param  array $relations
     * @return LengthAwarePaginator
     */
    public function allPaginatedAndFiltered(array $config, array $columns, array $relations): LengthAwarePaginator
    {
        $players = $this->model
            ->newQuery()
            ->select($columns)
            ->with($relations);

        if (!empty($config['filters'])) {
            foreach ($config['filters'] as $key => $value) {
                if (empty($key) || empty($value)) {
                    continue;
                }
                if ($key === 'q') {
                    $qArray = explode(' ', $value);
                    foreach ($qArray as $qWord) {
                        $players->orWhere(function (Builder $query) use ($qWord) {
                            $query->where('name', 'like', "%$qWord%")
                                ->orWhere('last_name', 'like', "%$qWord%");
                        });
                    }
                }
            }
        }
        if (!empty($config['orderBy'])) {
            $players->orderBy($config['orderBy'], $config['orderDirection']);
        } else {
            $players->latest();
        }
        return $players->paginate($config['perPage'], $columns, 'page', $config['page'])
            ->withQueryString();
    }
    
    /**
     * truncate
     *
     * @return void
     */
    public function truncate(): void
    {
        $this->model::truncate();
    }
}
