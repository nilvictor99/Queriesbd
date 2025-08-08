<?php

namespace App\Actions\ExternalServices\Sunat;

use App\Actions\ExternalServices\BaseActionService;
use Illuminate\Http\Client\RequestException;
use Lorisleiva\Actions\Concerns\AsAction;

class GetSunatData extends BaseActionService
{
    use AsAction;

    protected array $apis = [
        'fetchFromPrimaryApi',
        'fetchFromBackupApi1',
    ];

    protected function validateRuc(string $ruc): bool
    {
        return preg_match('/^\d{11}$/', $ruc);
    }

    public function handle(string $ruc)
    {
        if (! $this->validateRuc($ruc)) {
            return $this->invalidRucResponse();
        }

        return $this->fetchDataFromApis($ruc);
    }

    protected function invalidRucResponse()
    {
        return response()->json([
            'error' => 'El RUC proporcionado no es válido. Debe contener exactamente 11 dígitos numéricos.',
        ], 422);
    }

    protected function fetchDataFromApis(string $ruc)
    {
        foreach ($this->apis as $apiMethod) {
            try {
                $response = $this->$apiMethod($ruc);

                if ($response !== null) {
                    return $this->successResponse($response);
                }
            } catch (RequestException $e) {
                $this->logWarning($apiMethod, $e);
            } catch (\Exception $e) {
                $this->logError($apiMethod, $e);
            }
        }

        return $this->failureResponse();
    }

    protected function fetchFromPrimaryApi(string $ruc)
    {
        return $this->makeApiRequest("https://api.apis.net.pe/v1/ruc?numero={$ruc}");
    }

    protected function fetchFromBackupApi1(string $ruc)
    {
        $token = config('services.api.apis_net_pe');

        return $this->makeApiRequest(
            "https://api.apis.net.pe/v2/ruc?numero={$ruc}",
            [
                'Authorization' => 'Bearer '.$token,
                'Referer' => 'https://apis.net.pe/api-consulta-ruc',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ]
        );
    }
}
