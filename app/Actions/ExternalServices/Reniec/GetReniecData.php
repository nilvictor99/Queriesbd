<?php

namespace App\Actions\ExternalServices\Reniec;

use App\Actions\ExternalServices\BaseActionService;
use App\Actions\ExternalServices\Reniec\Apis\ApisAqpfact;
use App\Actions\ExternalServices\Reniec\Apis\ApisDiurvan;
use App\Actions\ExternalServices\Reniec\Apis\ApisMigo;
use App\Actions\ExternalServices\Reniec\Apis\ApisNetV1;
use App\Actions\ExternalServices\Reniec\Apis\ApisNetV2;
use App\Actions\ExternalServices\Reniec\Apis\ApisPeru;
use App\Actions\ExternalServices\Reniec\Apis\ApisPeruDev;
use App\Actions\ExternalServices\Reniec\Apis\ApisPeruFact;
use App\Actions\ExternalServices\Utils\RecordValidator;
use App\Actions\ExternalServices\Utils\ResponseFormatter;
use App\Repositories\ExternalServices\ApiServiceFactory;
use App\Services\Models\ReniecDataService;
use Illuminate\Support\Facades\Log;
use Lorisleiva\Actions\Concerns\AsAction;

class GetReniecData extends BaseActionService
{
    use AsAction;

    protected ReniecDataService $ReniecDataService;

    protected ApiServiceFactory $factory;

    protected RecordValidator $validator;

    protected ResponseFormatter $formatter;

    protected ReniecFormatter $reniecFormatter;

    public function __construct(
        ApiServiceFactory $factory,
        RecordValidator $validator,
        ReniecDataService $ReniecDataService,
        ReniecFormatter $reniecFormatter
    ) {
        $this->factory = $factory;
        $this->validator = $validator;
        $this->ReniecDataService = $ReniecDataService;
        $this->reniecFormatter = $reniecFormatter;
        $this->initializeApiServices();
    }

    public function handle(string $dni)
    {
        if (! preg_match('/^\d{8}$/', $dni)) {
            return response()->json(['error' => 'Invalid DNI'], 422);
        }

        if ($this->validator->recordExists(['document_number' => $dni])) {
            return response()->json($this->ReniecDataService->findByDniUnFormat($dni));
        }

        $data = $this->fetchFromApisInOrder($dni, ['apisNetV1', 'apisNetV2', 'apisPeru', 'apisPeruFact', 'apisPeruDev', 'apisDiurvan', 'apisAqpfact', 'apisMigo']);

        if (empty($data['dni'])) {
            return response()->json(['error' => 'No se pudo obtener datos de ninguna API.'], 500);
        }

        $formattedData = $this->reniecFormatter->formatData($data);
        $this->ReniecDataService->create($formattedData);

        return response()->json($data);
    }

    private function fetchFromApisInOrder(string $dni, array $apiOrder): ?array
    {
        foreach ($apiOrder as $alias) {
            $apiService = $this->factory->getService($alias);

            try {
                $data = $apiService->fetchData($dni);

                if (! empty($data)) {
                    Log::info("✅ API usada: {$alias}");

                    return $data;
                }

            } catch (\Exception $e) {
                Log::warning("API falló: {$alias}", ['exception' => $e]);
            }
        }

        return null;
    }

    protected function initializeApiServices(): void
    {
        $this->factory->register('apisNetV1', new ApisNetV1);
        $this->factory->register('apisNetV2', new ApisNetV2);
        $this->factory->register('apisAqpfact', new ApisAqpfact);
        $this->factory->register('apisMigo', new ApisMigo);
        $this->factory->register('apisPeru', new ApisPeru);
        $this->factory->register('apisPeruFact', new ApisPeruFact);
        $this->factory->register('apisDiurvan', new ApisDiurvan);
        $this->factory->register('apisPeruDev', new ApisPeruDev);
    }
}
