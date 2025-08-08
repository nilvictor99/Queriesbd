<?php

namespace App\Repositories\ExternalServices;

use App\Contracts\ExternalApiInterface;

class ApiServiceFactory
{
    protected $services = [];

    public function register(string $alias, ExternalApiInterface $service)
    {
        $this->services[$alias] = $service;
    }

    public function getService(string $alias): ExternalApiInterface
    {
        if (! isset($this->services[$alias])) {
            throw new \Exception("Service {$alias} not found.");
        }

        return $this->services[$alias];
    }
}
