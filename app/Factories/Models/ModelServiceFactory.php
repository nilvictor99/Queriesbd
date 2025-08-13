<?php

namespace App\Factories\Models;

use App\Services\Models\ReniecDataService;
use App\Services\Models\UserService;

class ModelServiceFactory
{
    protected static array $services = [
        'UserService' => UserService::class,
        'ReniecData' => ReniecDataService::class,
    ];

    /**
     * Instancia un servicio dinámicamente.
     *
     * @param  string  $service  Nombre del servicio a instanciar.
     * @param  array  $params  Parámetros opcionales para el constructor.
     * @return mixed
     *
     * @throws \Exception
     */
    public static function make(string $service, array $params = [])
    {
        if (! isset(self::$services[$service])) {
            throw new \InvalidArgumentException("Service {$service} not found.");
        }

        $serviceClass = self::$services[$service];

        return empty($params) ? app($serviceClass) : app()->makeWith($serviceClass, $params);
    }
}
