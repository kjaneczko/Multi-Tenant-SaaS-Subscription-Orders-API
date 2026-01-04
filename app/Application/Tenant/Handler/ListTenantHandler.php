<?php

declare(strict_types=1);

namespace App\Application\Tenant\Handler;

use App\Application\Tenant\Command\ListTenantCommand;
use App\Domain\Tenant\Interface\TenantQueryInterface;

readonly class ListTenantHandler
{
    public function __construct(
        private TenantQueryInterface $repository,
    ) {}

    public function __invoke(ListTenantCommand $command): array
    {
        return $this->repository->paginate($command->pageRequest);
    }
}
