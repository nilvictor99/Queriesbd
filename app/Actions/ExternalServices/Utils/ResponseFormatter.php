<?php

namespace App\Actions\ExternalServices\Utils;

class ResponseFormatter
{
    protected array $formatMapping;

    public function __construct(array $formatMapping)
    {
        $this->formatMapping = $formatMapping;
    }

    public function format(array $data): array
    {
        $formatted = [];
        foreach ($this->formatMapping as $key => $mapKey) {
            $formatted[$key] = $data[$mapKey] ?? null;
        }

        return $formatted;
    }

    /**
     * Revertir el formato de los datos.
     */
    public function unformat(array $data): array
    {
        $unformatted = [];
        foreach ($this->formatMapping as $key => $mapKey) {
            $unformatted[$mapKey] = $data[$key] ?? null;
        }

        return $unformatted;
    }
}
