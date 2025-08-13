<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisNetV1 implements ExternalApiInterface
{
    public function fetchData(string $identifier)
    {
        $url = "https://api.apis.net.pe/v1/dni?numero={$identifier}";

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
            'dni' => $data['numeroDocumento'] ?? null,
            'nombres' => $data['nombres'] ?? null,
            'apellido_paterno' => $data['apellidoPaterno'] ?? null,
            'apellido_materno' => $data['apellidoMaterno'] ?? null,
        ];
    }
}
