<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Tenant\Tenant;
use App\Domain\Tenant\TenantId;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface TenantQueryInterface
{

    public function getById(TenantId $id): ?Tenant;

    /**
     * @return Tenant[]
     */
    public function paginate(PageRequest $pageRequest, ?string $tenantId = null): array;
}
