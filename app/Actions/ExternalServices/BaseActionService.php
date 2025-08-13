<?php

namespace App\Actions\ExternalServices;

class BaseActionService
{
    protected function mergeData(array $currentData, array $newData): array
    {
        foreach ($newData as $key => $value) {
            if (empty($currentData[$key]) && ! empty($value)) {
                $currentData[$key] = $value;
            }
        }

        return $currentData;
    }
}
