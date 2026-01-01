<?php

namespace App\Domain\Tenant\Interface;

use App\Application\Shared\Query\PageRequest;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;

interface TenantRepositoryInterface
{
    public function create(Tenant $tenant): Tenant;

    public function update(Tenant $tenant): bool;

    public function delete(Tenant $tenant): bool;

    public function findByIdOrFail(TenantId $id): Tenant;

    /**
     * @return Tenant[]
     */
    public function findAll(PageRequest $pageRequest): array;
}
