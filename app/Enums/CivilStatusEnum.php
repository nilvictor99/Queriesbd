<?php

namespace App\Enums;

use App\Traits\Utils\HasEnums;

enum CivilStatusEnum: string
{
    use HasEnums;

    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';
    case SEPARATED = 'separated';
    case PARTNER = 'partner';
    case OTHER = 'other';
}
