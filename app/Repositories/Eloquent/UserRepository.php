<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * __construct
     *
     * @param  User $model
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}