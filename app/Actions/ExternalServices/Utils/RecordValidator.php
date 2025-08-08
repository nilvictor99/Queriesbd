<?php

namespace App\Actions\ExternalServices\Utils;

use App\Services\Models\ReniecDataService;

class RecordValidator
{
    protected $reniecDataService;

    public function __construct(ReniecDataService $reniecDataService)
    {
        $this->reniecDataService = $reniecDataService;
    }

    public function recordExists(array $criteria): bool
    {
        return $this->reniecDataService->exists($criteria);
    }
}
