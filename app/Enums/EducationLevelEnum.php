<?php

namespace App\Enums;

use App\Traits\Utils\HasEnums;

enum EducationLevelEnum: string
{
    use HasEnums;

    case UNEDUCATED = 'unedicated';
    case PRESCHOOL = 'preschool';
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case HIGH_SCHOOL = 'high_school';
    case TECHNICAL = 'technical';
    case BACHELOR_DEGREE = 'bachelor_degree';
    case MASTER_DEGREE = 'master_degree';
    case DOCTORATE = 'doctorate';
    case POSTDOCTORAL = 'postdoctoral';
}
