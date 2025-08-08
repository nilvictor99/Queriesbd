<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class DakuApiService implements ExternalApiInterface
{
    public function fetchData(string $identifier): ?array
    {
        $url = "https://daku.lat/api/reniec?dni={$identifier}";
        $response = Http::get($url);

        return $response->successful() ? $this->mapResponse($response->json()) : null;
    }

    public function mapResponse(array $response): array
    {
        return [
            'dni' => $response['datos']['dni'] ?? null,
            'nombres' => $response['datos']['nombre'] ?? null,
            'apellido_materno' => $response['datos']['apellidoM'] ?? null,
            'apellido_paterno' => $response['datos']['apellidoP'] ?? null,
            'nombre_completo' => $response['datos']['nombreCompleto'] ?? null,
            'direccion' => $response['datos']['direccion'] ?? null,
            'fecha_nacimiento' => $response['datos']['fechaDeNacimiento'] ?? null,
            'ubigeo' => $response['datos']['ubigeoReniec'] ?? null,
            'foto' => $response['datos']['foto'] ?? null,
        ];
    }
}
