<?php

declare(strict_types=1);

namespace App\Application\Tenant\Handler;

use App\Application\Tenant\Command\ShowTenantCommand;
use App\Application\Tenant\TenantExecutor;
use App\Domain\Tenant\Tenant;

readonly class ShowTenantHandler
{
    public function __construct(
        private TenantExecutor $executor,
    ) {}

    public function __invoke(ShowTenantCommand $command): Tenant
    {
        return $this->executor->getByIdOrFail($command->id);
    }
}
