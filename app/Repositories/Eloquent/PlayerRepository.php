<?php

namespace App\Repositories\Eloquent;

use App\Models\Player;
use App\Repositories\Interfaces\PlayerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PlayerRepository extends Repository implements PlayerRepositoryInterface
{
    /**
     * __construct
     *
     * @param  Player $model
     * @return void
     */
    public function __construct(Player $model)
    {
        $this->model = $model;
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
}