<?php

namespace App\Repositories\Models;

use App\Models\ReniecData;

class ReniecDataRepository extends BaseRepository
{
    const RELATIONS = [];

    public function __construct(ReniecData $reniecData)
    {
        parent::__construct($reniecData, self::RELATIONS);
    }

    public function findByDni(string $dni)
    {
        return $this->simpleFind(['document_number' => $dni]);
    }
}
