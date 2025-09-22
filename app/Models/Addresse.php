<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Addresse extends Model
{
    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'ubigeo_cod',
        'address',
        'reference',
    ];

    public function addressable()
    {
        return $this->morphTo();
    }

    public function ubigeo()
    {
        return $this->belongsTo(ubigeo::class, 'ubigeo_cod', 'cod_ubigeo');
    }

    public function scopeSearchAddress(Builder $query, $search)
    {
        return $query->whereRaw('address ILIKE ?', ["%{$search}%"]);
    }
}
