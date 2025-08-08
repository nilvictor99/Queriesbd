<?php

namespace App\Actions\ExternalServices\Reniec\Apis;

use App\Contracts\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class ApisNetV2 implements ExternalApiInterface
{
    private string $token;

    public function __construct()
    {
        $this->token = config('services.reniec.token_apis_net_pe');
    }

    public function fetchData(string $identifier)
    {
        $url = "https://api.apis.net.pe/v2/reniec/dni?numero={$identifier}";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
            'Referer' => 'https://apis.net.pe/api-consulta-dni',
            'User-Agent' => 'laravel/http-client',
            'Accept' => 'application/json',
        ])->get($url);

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
            'codigo_verificacion' => $data['digitoVerificador'] ?? null,
        ];
    }
}
