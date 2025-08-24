<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de almacenamiento para cPanel
    |--------------------------------------------------------------------------
    |
    | Define las rutas de origen y destino para la copia de directorios
    | en entornos con cPanel. Estos valores pueden ser sobrescritos
    | en el archivo .env si es necesario.
    |
    */

    'storage' => [
        'origin_path' => env('CPANEL_ORIGIN_PATH'),
        'destination_path' => env('CPANEL_DESTINATION_PATH'),
    ],
];
