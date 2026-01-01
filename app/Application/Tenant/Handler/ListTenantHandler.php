<?php

namespace App\Application\Tenant\Handler;

use App\Application\Tenant\Command\ListTenantCommand;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;

readonly class ListTenantHandler
{
    public function __construct(
        private TenantRepositoryInterface $repository,
    )
    {
    }

    public function __invoke(ListTenantCommand $command): array
    {
        return $this->repository->findAll($command->pageRequest);
    }
}
