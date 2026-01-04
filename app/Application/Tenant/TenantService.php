<?php

declare(strict_types=1);

namespace App\Application\Tenant;

use App\Application\Tenant\Command\CreateTenantCommand;
use App\Application\Tenant\Command\ListTenantCommand;
use App\Application\Tenant\Command\ShowTenantCommand;
use App\Application\Tenant\Handler\CreateTenantHandler;
use App\Application\Tenant\Handler\ListTenantHandler;
use App\Application\Tenant\Handler\ShowTenantHandler;
use App\Application\Tenant\Interface\TenantServiceInterface;
use App\Domain\Tenant\Tenant;

final readonly class TenantService implements TenantServiceInterface
{
    public function __construct(
        private ListTenantHandler $list,
        private ShowTenantHandler $show,
        private CreateTenantHandler $create,
    ) {}

    public function list(ListTenantCommand $command): array
    {
        return ($this->list)($command);
    }

    public function show(ShowTenantCommand $command): Tenant
    {
        return ($this->show)($command);
    }

    public function create(CreateTenantCommand $command): Tenant
    {
        return ($this->create)($command);
    }
}
