<?php

declare(strict_types=1);

namespace App\Domain\User;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case MANAGER = 'manager';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
