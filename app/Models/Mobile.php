<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Mobile extends Model
{
    protected $fillable = [
        'mobileable_id',
        'mobileable_type',
        'mobile_type',
        'mobile_number',
        'country_code',
        'verified_at',
    ];

    public function scopeSearchNumber(Builder $query, $search)
    {
        return $query->whereRaw('mobile_number ILIKE ?', ["%{$search}%"]);
    }
}
