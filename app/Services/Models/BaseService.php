<?php

namespace App\Services\Models;

use App\Services\Service;
use Exception;

abstract class BaseService extends Service
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->repository, $method)) {
            return $this->repository->$method(...$parameters);
        }

        throw new Exception("Method {$method} not found in ".static::class);
    }
}
