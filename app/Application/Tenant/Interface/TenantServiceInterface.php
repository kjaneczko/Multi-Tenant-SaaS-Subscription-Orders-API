<?php

declare(strict_types=1);

namespace App\Application\Tenant\Interface;

use App\Application\Tenant\Command\CreateTenantCommand;
use App\Application\Tenant\Command\ListTenantCommand;
use App\Application\Tenant\Command\ShowTenantCommand;
use App\Domain\Tenant\Tenant;

interface TenantServiceInterface
{
    /**
     * @return Tenant[]
     */
    public function list(ListTenantCommand $command): array;

    public function show(ShowTenantCommand $command): Tenant;

    public function create(CreateTenantCommand $command): Tenant;
}
