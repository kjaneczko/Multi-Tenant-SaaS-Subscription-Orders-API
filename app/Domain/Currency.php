<?php

namespace App\Domain;

enum Currency: string
{
    case USD = 'USD';
    case EUR = 'EUR';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
