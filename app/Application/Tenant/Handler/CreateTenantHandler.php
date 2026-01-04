<?php

declare(strict_types=1);

namespace App\Application\Tenant\Handler;

use App\Application\Common\Interface\SlugGeneratorInterface;
use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Application\Tenant\Command\CreateTenantCommand;
use App\Domain\Tenant\Interface\TenantRepositoryInterface;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;
use App\Domain\Tenant\TenantStatus;

readonly class CreateTenantHandler
{
    public function __construct(
        private TenantRepositoryInterface $repository,
        private UuidGeneratorInterface    $uuid,
        private SlugGeneratorInterface    $slug,
    ) {}

    public function __invoke(
        CreateTenantCommand $command,
    ): Tenant {
        $tenant = Tenant::create(
            id: new TenantId($this->uuid->generate()),
            name: $command->name,
            slug: $this->slug->generate($command->name),
            status: TenantStatus::ACTIVE,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        return $this->repository->create($tenant);
    }
}
