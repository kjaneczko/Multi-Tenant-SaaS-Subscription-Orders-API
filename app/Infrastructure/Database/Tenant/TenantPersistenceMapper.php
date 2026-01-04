<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Tenant;

use App\Domain\Slug;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;
use App\Domain\Tenant\TenantStatus;
use App\Models\TenantModel;

final readonly class TenantPersistenceMapper
{
    public static function toDomain(TenantModel $tenant): Tenant
    {
        return Tenant::reconstitute(
            id: new TenantId($tenant->id),
            name: $tenant->name,
            slug: new Slug($tenant->slug),
            status: TenantStatus::from($tenant->status),
            createdAt: new \DateTimeImmutable($tenant->created_at),
            updatedAt: new \DateTimeImmutable($tenant->updated_at),
        );
    }

    public static function toPersistence(Tenant $tenant): array
    {
        return [
            'id' => $tenant->id()->toString(),
            'name' => $tenant->name(),
            'slug' => $tenant->slug()->toString(),
            'status' => $tenant->status()->value,
            'created_at' => $tenant->createdAt()->format('Y-m-d H:i:s'),
            'updated_at' => $tenant->updatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
