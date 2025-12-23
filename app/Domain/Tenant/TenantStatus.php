<?php

namespace App\Domain\Tenant;

enum TenantStatus: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
}
