<?php

namespace App\Services\Utils\Storage;

use Illuminate\Support\Facades\Log;

class StorageForCpanelService
{
    private string $originPath;

    private string $destinationPath;

    public function __construct()
    {
        $this->originPath = config('cpanel.storage.origin_path');
        $this->destinationPath = config('cpanel.storage.destination_path');
    }

    /**
     * Copia recursivamente un directorio al destino.
     *
     * @param  string|null  $src  Directorio de origen (opcional)
     * @param  string|null  $dst  Directorio de destino (opcional)
     */
    public function copyDirectory(?string $src = null, ?string $dst = null): void
    {
        $src = $src ?? $this->originPath;
        $dst = $dst ?? $this->destinationPath;

        if (! $this->validateDirectories([$src])) {
            Log::info('Cancelando la copia: el directorio de origen no existe.');

            return;
        }

        if (! is_dir($dst)) {
            $this->createDirectory($dst);
        }

        $dir = opendir($src);
        if (! $dir) {
            Log::error("No se pudo abrir el directorio: $src");

            return;
        }

        try {
            while (($file = readdir($dir)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $srcPath = $src.DIRECTORY_SEPARATOR.$file;
                $dstPath = $dst.DIRECTORY_SEPARATOR.$file;

                if (is_dir($srcPath)) {
                    $this->copyDirectory($srcPath, $dstPath);
                } else {
                    $this->copyFile($srcPath, $dstPath);
                }
            }
        } finally {
            closedir($dir);
        }
    }

    /**
     * Valida que los directorios indicados existan.
     *
     * @param  array  $directories  Rutas de directorios a validar.
     * @return bool True si todos existen, false en caso contrario.
     */
    private function validateDirectories(array $directories): bool
    {
        foreach ($directories as $path) {
            if (! is_dir($path)) {
                Log::error("El directorio no existe: $path");

                return false;
            }
        }

        return true;
    }

    /**
     * Crea un directorio si no existe.
     *
     * @param  string  $path  Ruta del directorio a crear.
     */
    private function createDirectory(string $path): void
    {
        if (! is_dir($path) && ! mkdir($path, 0755, true) && ! is_dir($path)) {
            Log::error("No se pudo crear el directorio: $path");
        }
    }

    /**
     * Copia un archivo si no existe en el destino o si es más reciente.
     *
     * @param  string  $src  Ruta del archivo origen.
     * @param  string  $dst  Ruta del archivo destino.
     */
    private function copyFile(string $src, string $dst): void
    {
        if (! file_exists($dst) || filemtime($src) > filemtime($dst)) {
            if (! copy($src, $dst)) {
                Log::error("No se pudo copiar el archivo: $src → $dst");
            }
        }
    }
}
