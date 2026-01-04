<?php

declare(strict_types=1);

namespace App\Application\Common;

enum AuditCategory: string
{
    case ACCESS = 'access';
    case AUDIT = 'audit';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
