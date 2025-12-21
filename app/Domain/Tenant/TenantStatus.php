<?php

namespace app\Domain\Tenant;

enum TenantStatus: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
}
