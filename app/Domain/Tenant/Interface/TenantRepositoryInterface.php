<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;

interface TenantRepositoryInterface
{
    public function create(Tenant $tenant): void;

    public function update(Tenant $tenant): bool;

    public function delete(Tenant $tenant): bool;

    public function getById(TenantId $id): ?Tenant;

    /**
     * @return Tenant[]
     */
    public function getAll(PageRequest $pageRequest): array;
}
