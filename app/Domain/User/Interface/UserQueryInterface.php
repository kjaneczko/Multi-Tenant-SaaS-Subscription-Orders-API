<?php

declare(strict_types=1);

namespace App\Domain\User\Interface;

use App\Application\Common\Query\PageRequest;
use App\Domain\Tenant\TenantId;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRole;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface UserQueryInterface
{
    public function getById(UserId $id): ?User;

    /**
     * @return User[]
     */
    public function paginate(
        PageRequest $pageRequest,
        ?TenantId $tenantId = null,
        ?UserRole $role = null,
        ?bool $isActive = null,
    ): array;
}
