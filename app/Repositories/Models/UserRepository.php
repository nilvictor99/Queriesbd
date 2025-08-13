<?php

namespace App\Repositories\Models;

use App\Models\User;

class UserRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(User $model)
    {
        parent::__construct($model, self::RELATIONS);
    }
}
