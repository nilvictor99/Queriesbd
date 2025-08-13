<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisMigo implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_migo');
    }

    public function fetchData(string $identifier)
    {
        $url = 'https://api.migo.pe/api/v1/dni';

        $response = Http::asJson()->post($url, [
            'token' => $this->token,
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
        $fullName = $data['nombre'] ?? '';
        $dni = $data['dni'] ?? null;

        $parts = explode(' ', trim($fullName));
        $apellidoPaterno = $parts[0] ?? null;
        $apellidoMaterno = $parts[1] ?? null;
        $nombres = implode(' ', array_slice($parts, 2));

        return [
            'dni' => $dni,
            'nombres' => $nombres ?: null,
            'apellido_paterno' => $apellidoPaterno,
            'apellido_materno' => $apellidoMaterno,
        ];
    }
}
