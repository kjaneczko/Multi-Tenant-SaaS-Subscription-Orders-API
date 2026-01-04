<?php

declare(strict_types=1);

namespace App\Application\Tenant\Handler;

use App\Application\Tenant\Command\ShowTenantCommand;
use App\Application\Tenant\Exception\TenantNotFoundException;
use App\Domain\Tenant\Interface\TenantQueryInterface;
use App\Domain\Tenant\Tenant;

readonly class ShowTenantHandler
{
    public function __construct(
        private TenantQueryInterface $repository,
    ) {}

    public function __invoke(ShowTenantCommand $command): Tenant
    {
        $tenant = $this->repository->getById($command->id);

        if (!$tenant) {
            throw new TenantNotFoundException();
        }

        return $tenant;
    }
}
