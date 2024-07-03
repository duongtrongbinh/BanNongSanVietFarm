<?php

namespace App\Enum;

enum  TypeUnitEnum: string
{
    case CHAI = '0';
    case GRAMS = '1';
    case KILOGAM = '2';

    case KILOGRAMS = '3';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
