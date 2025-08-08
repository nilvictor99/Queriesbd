<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisPeruDev implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_peru_dev');
    }

    public function fetchData(string $identifier): ?array
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://apiperu.dev/api/dni', [
            'dni' => $identifier,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            return $this->mapResponse($data);
        }

        return null;
    }

    public function mapResponse(array $data): array
    {
        return [
            'dni' => $data['data']['numero'] ?? null,
            'nombres' => $data['data']['nombres'] ?? null,
            'apellido_paterno' => $data['data']['apellido_paterno'] ?? null,
            'apellido_materno' => $data['data']['apellido_materno'] ?? null,
            'codigo_verificacion' => $data['data']['codigo_verificacion'] ?? null,
        ];
    }
}
