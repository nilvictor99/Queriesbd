<?php

namespace App\Repositories\Models;

use App\Models\Ubigeo;

class UbigeoRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(Ubigeo $ubigeo)
    {
        parent::__construct($ubigeo, self::RELATIONS);
    }
}
