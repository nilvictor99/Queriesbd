<?php

namespace App\Actions\ExternalServices\Reniec;

use App\Actions\ExternalServices\Utils\ResponseFormatter;

class ReniecFormatter extends ResponseFormatter
{
    protected array $formatResponse = [
        'document_number' => 'dni',
        'cod_verificacion' => 'codigo_verificacion',
        'paternal_last_name' => 'apellido_paterno',
        'maternal_last_name' => 'apellido_materno',
        'name' => 'nombres',
        'gender' => 'genero',
        'date_of_birth' => 'fecha_nacimiento',
        'date_of_death' => 'fecha_defuncion',
        'department' => 'departamento',
        'province' => 'provincia',
        'district' => 'distrito',
        'marital_status' => 'estado_civil',
        'education_level' => 'nivel_educativo',
        'height' => 'altura',
        'registration_date' => 'fecha_inscripcion',
        'issue_date' => 'fecha_emision',
        'expiration_date' => 'fecha_expiracion',
        'father' => 'padre',
        'mother' => 'madre',
        'restrictions' => 'restricciones',
        'address' => 'direccion',
        'ubigeo_reniec' => 'ubigeo',
        'ubigeo_inei' => 'ubigeo_inei',
        'ubigeo_sunat' => 'ubigeo_sunat',
        'postal_code' => 'codigo_postal',
        'photo' => 'foto',
    ];

    public function __construct()
    {
        parent::__construct($this->formatResponse);
    }

    /**
     * Formatear fechas de tipo "DD/MM/YYYY" a "YYYY-MM-DD"
     *
     * @param  string|null  $date
     * @return string|null
     */
    private function formatDate($date)
    {
        if ($date) {
            $dateFormatted = \Carbon\Carbon::createFromFormat('d/m/Y', $date);
            if ($dateFormatted) {
                return $dateFormatted->format('Y-m-d');
            }
        }

        return null;
    }

    /**
     * Formatear el array de datos, aplicando el formateo de fechas.
     */
    public function formatData(array $data): array
    {
        $formattedData = parent::format($data);

        foreach ($formattedData as $key => $value) {
            if (strpos($key, 'date') !== false && $value) {
                $formattedData[$key] = $this->formatDate($value);
            }
        }

        return $formattedData;
    }
}
