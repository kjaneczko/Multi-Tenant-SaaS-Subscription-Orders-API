<?php

declare(strict_types=1);

namespace App\Domain\Tenant;

enum TenantStatus: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
