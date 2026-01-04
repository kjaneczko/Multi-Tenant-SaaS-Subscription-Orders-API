<?php

declare(strict_types=1);

namespace App\Domain;

enum SensitiveKeys: string
{
    case PASSWORD = 'password';
    case TOKEN = 'token';
    case REMEMBER_TOKEN = 'rememberToken';
    case AUTHORIZATION = 'authorization';
    case CARD = 'cardNumber';
    case CVV = 'cvv';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
