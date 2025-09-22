<?php

namespace App\Services\Models;

use App\Repositories\Models\UbigeoRepository;

class UbigeoService extends BaseService
{
    public function __construct(UbigeoRepository $repository)
    {
        parent::__construct($repository);
    }
}
