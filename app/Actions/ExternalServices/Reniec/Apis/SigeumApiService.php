<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class SigeumApiService implements ExternalApiInterface
{
    public function fetchData(string $identifier)
    {
        $url = "https://sigeun.unam.edu.pe/api/pide/reniec?dni={$identifier}";
        $response = Http::get($url);

        return $response->successful() ? $this->mapResponse($response->json()) : null;
    }

    public function mapResponse(array $response): array
    {
        return [
            'id_persona' => $response['data']['iPersId'] ?? null,
            'dni' => $response['data']['cReniecDni'] ?? null,
            'apellido_paterno' => $response['data']['cReniecApel_pate'] ?? null,
            'apellido_materno' => $response['data']['cReniecApel_mate'] ?? null,
            'nombres' => $response['data']['cReniecNombres'] ?? null,
            'ubigeo' => $response['data']['cReniecUbigeo'] ?? null,
            'direccion' => $response['data']['cReniecDireccion'] ?? null,
            'estado_civil' => $response['data']['cReniecEsta_civi'] ?? null,
            'restricciones' => $response['data']['cReniecRestricciones'] ?? null,
            'nombre_completo' => isset($response['data']) ? "{$response['data']['cReniecNombres']} {$response['data']['cReniecApel_pate']} {$response['data']['cReniecApel_mate']}" : null,
            'foto' => $response['data']['cReniecFotografia'] ?? null,
        ];
    }
}
