<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisDiurvan implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_diurvan');
    }

    public function fetchData(string $identifier): ?array
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://diurvanconsultores.com/apidiurvan/api/dniruc', [
            'documento' => "{$identifier}",
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
            'dni' => $data['message']['nro_documento'] ?? null,
            'nombres' => $data['message']['nombres'] ?? null,
            'apellido_paterno' => $data['message']['apellido_paterno'] ?? null,
            'apellido_materno' => $data['message']['apellido_materno'] ?? null,
        ];
    }
}
