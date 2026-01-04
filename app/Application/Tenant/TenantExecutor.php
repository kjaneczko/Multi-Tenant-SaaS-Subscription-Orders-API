<?php

declare(strict_types=1);

namespace App\Application\Tenant;

use App\Application\Common\Query\PageRequest;
use App\Application\Tenant\Exception\TenantNotFoundException;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;

readonly class TenantExecutor
{
    public function __construct(
        private TenantRepositoryInterface $repository,
    ) {}

    public function getByIdOrFail(TenantId $id): Tenant
    {
        $tenant = $this->repository->getById($id);
        if (!$tenant) {
            throw new TenantNotFoundException();
        }

        return $tenant;
    }

    public function getAll(PageRequest $pageRequest): array
    {
        return $this->repository->getAll($pageRequest);
    }

    public function create(Tenant $tenant): Tenant
    {
        return $this->repository->create($tenant);
    }

    public function updateOrFail(Tenant $tenant): void
    {
        if (!$this->repository->update($tenant)) {
            throw new TenantNotFoundException();
        }
    }

    public function deleteOrFail(TenantId $id): void
    {
        $tenant = $this->getByIdOrFail($id);

        if (!$this->repository->delete($tenant)) {
            throw new TenantNotFoundException();
        }
    }
}
