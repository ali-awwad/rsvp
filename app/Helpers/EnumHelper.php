<?php

namespace App\Helpers;

use UnitEnum;

class EnumHelper
{
    public static function values(UnitEnum $enum): array
    {
        return collect($enum::cases())->pluck('value')->toArray();
    }
}
