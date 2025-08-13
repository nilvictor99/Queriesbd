<?php

namespace App\Contracts;

interface ExternalApiInterface
{
    public function fetchData(string $identifier);

    public function mapResponse(array $response): array;
}
