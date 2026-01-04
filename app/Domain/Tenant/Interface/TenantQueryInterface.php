<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Tenant\Tenant;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface TenantQueryInterface
{
    /**
     * @return Tenant[]
     */
    public function paginate(PageRequest $pageRequest, ?string $tenantId = null): array;
}
