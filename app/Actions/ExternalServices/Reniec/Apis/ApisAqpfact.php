<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisAqpfact implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_aqpfact');
    }

    public function fetchData(string $identifier)
    {
        $url = "https://apis.aqpfact.pe/api/dni/{$identifier}";

        $response = Http::withToken($this->token)
            ->accept('application/json')
            ->get($url);

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
