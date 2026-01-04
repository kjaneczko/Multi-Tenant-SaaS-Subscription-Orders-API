<?php

declare(strict_types=1);

namespace App\Application\Tenant\Handler;

use App\Application\Tenant\Command\ListTenantCommand;
use App\Application\Tenant\TenantExecutor;

readonly class ListTenantHandler
{
    public function __construct(
        private TenantExecutor $executor,
    ) {}

    public function __invoke(ListTenantCommand $command): array
    {
        return $this->executor->getAll($command->pageRequest);
    }
}
