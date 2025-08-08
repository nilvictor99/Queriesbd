<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class MiApiService implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.mi_api.token');
    }

    public function fetchData(string $identifier): ?array
    {
        $url = "https://miapi.cloud/v1/dni/{$identifier}";
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Accept' => 'application/json',
        ])->get($url);

        return $response->successful() ? $this->mapResponse($response->json()) : null;
    }

    public function mapResponse(array $response): array
    {
        return [
            'dni' => $response['datos']['dni'] ?? null,
            'nombres' => $response['datos']['nombres'] ?? null,
            'apellido_materno' => $response['datos']['ape_paterno'] ?? null,
            'apellido_paterno' => $response['datos']['ape_materno'] ?? null,
            'direccion' => $response['datos']['domiciliado']['direccion'] ?? null,
            'distrito' => $response['datos']['domiciliado']['distrito'] ?? null,
            'provincia' => $response['datos']['domiciliado']['provincia'] ?? null,
            'departamento' => $response['datos']['domiciliado']['departamento'] ?? null,
            'ubigeo' => $response['datos']['domiciliado']['ubigeo'] ?? null,
        ];
    }
}
