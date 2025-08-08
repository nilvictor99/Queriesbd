<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class Data extends Model
{
    use Searchable;

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'document_number',
        'cod_verificacion',
        'paternal_last_name',
        'maternal_last_name',
        'name',
        'gender',
        'date_of_birth',
        'date_of_death',
        'department',
        'province',
        'district',
        'marital_status',
        'education_level',
        'height',
        'registration_date',
        'issue_date',
        'expiration_date',
        'father',
        'mother',
        'restrictions',
        'address',
        'ubigeo_reniec',
        'ubigeo_inei',
        'ubigeo_sunat',
        'postal_code',
        'photo',
    ];

    #[SearchUsingFullText(['document_number'])]
    public function toSearchableArray(): array
    {
        return [
            'document_number' => $this->document_number,
            'name' => $this->name,
            'last_name' => $this->last_name,
        ];
    }
}
