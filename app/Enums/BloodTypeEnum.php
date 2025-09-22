<?php

namespace App\Enums;

use App\Traits\Utils\HasEnums;

enum BloodTypeEnum: string
{
    use HasEnums;

    case A_POSITIVE = 'A+';
    case A_NEGATIVE = 'A-';
    case B_POSITIVE = 'B+';
    case B_NEGATIVE = 'B-';
    case AB_POSITIVE = 'AB+';
    case AB_NEGATIVE = 'AB-';
    case O_POSITIVE = 'O+';
    case O_NEGATIVE = 'O-';
    case UNKNOWN = 'unknown';
}
