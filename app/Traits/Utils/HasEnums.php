<?php

namespace App\Traits\Utils;

trait HasEnums
{
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    public static function options(?string $translationPrefix = null): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) use ($translationPrefix) {
            $key = $case->value;

            $value = $translationPrefix
                ? trans("$translationPrefix.".ucfirst($key))
                : trans(ucfirst($key));

            if ($value === "$translationPrefix.$key" || $value === $key) {
                $value = ucfirst($key);
            }

            return [$key => $value];
        })->toArray();
    }
}
