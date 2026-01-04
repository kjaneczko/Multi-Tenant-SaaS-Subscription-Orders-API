<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Interface;

use App\Domain\Tenant\Tenant;

interface TenantRepositoryInterface
{
    public function create(Tenant $tenant): Tenant;

    public function update(Tenant $tenant): bool;

    public function delete(Tenant $tenant): bool;
}
