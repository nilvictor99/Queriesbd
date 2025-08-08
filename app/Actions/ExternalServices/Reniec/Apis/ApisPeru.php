<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisPeru implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_peru');
    }

    public function fetchData(string $identifier)
    {
        $url = "https://dniruc.apisperu.com/api/v1/dni/{$identifier}?token={$this->token}";

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            return $this->mapResponse($data);
        }

        return null;
    }

    public function mapResponse(array $data): array
    {
        return [
            'dni' => $data['dni'] ?? null,
            'nombres' => $data['nombres'] ?? null,
            'apellido_paterno' => $data['apellidoPaterno'] ?? null,
            'apellido_materno' => $data['apellidoMaterno'] ?? null,
            'codigo_verificacion' => $data['codVerifica'] ?? null,
        ];
    }
}
