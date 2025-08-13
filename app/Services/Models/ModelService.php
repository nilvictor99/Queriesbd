<?php

namespace App\Services\Models;

use App\Factories\Models\ModelServiceFactory;

class ModelService
{
    protected $factory;

    public function __construct(ModelServiceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Obtiene un servicio usando la fábrica.
     *
     * @return mixed
     */
    public function getService(string $service, array $params = [])
    {
        return $this->factory::make($service, $params);
    }
}
