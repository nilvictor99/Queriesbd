<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisPeruFact implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_peru_fact');
    }

    public function fetchData(string $identifier)
    {
        $url = "https://api.perufacturacion.com/api?api_token={$this->token}&json=dni&id={$identifier}";

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
            'apellido_paterno' => $data['apellido_paterno'] ?? null,
            'apellido_materno' => $data['apellido_materno'] ?? null,
        ];
    }
}
