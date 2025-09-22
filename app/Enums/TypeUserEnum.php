<?php

namespace App\Enums;

use App\Traits\Utils\HasEnums;

enum TypeUserEnum: string
{
    use HasEnums;

    case SIMPLE = 'Simple';
    case STAFF = 'Staff';
}
