<?php

namespace App\Services\Models;

use App\Actions\ExternalServices\Reniec\ReniecFormatter;
use App\Repositories\Models\ReniecDataRepository;
use App\Services\Auth\AuthService;

class ReniecDataService extends BaseService
{
    protected $authService;

    protected ReniecFormatter $reniecFormatter;

    public function __construct(ReniecDataRepository $reniecDataRepository, AuthService $authService, ReniecFormatter $reniecFormatter)
    {
        parent::__construct($reniecDataRepository);
        $this->authService = $authService;
        $this->reniecFormatter = $reniecFormatter;
    }

    public function findByDniUnFormat(string $dni)
    {
        return $this->reniecFormatter->unformat($this->findByDni($dni)->toArray());
    }
}
