<?php

namespace App\Application\Tenant\Handler;

use App\Application\Tenant\Command\ShowTenantCommand;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\Tenant\Tenant;

readonly class ShowTenantHandler
{
    public function __construct(
        private TenantRepositoryInterface $repository,
    )
    {
    }

    public function __invoke(ShowTenantCommand $command): Tenant
    {
        return $this->repository->findByIdOrFail($command->id);
    }
}
