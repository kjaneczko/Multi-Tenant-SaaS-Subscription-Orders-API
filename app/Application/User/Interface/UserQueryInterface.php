<?php

namespace App\Application\User\Interface;

use App\Application\Shared\Query\PageRequest;
use App\Domain\User\User;

/**
 * Read side (CQRS-lite) – paginacja + filtrowanie.
 */
interface UserQueryInterface
{
    /**
     * @return User[]
     */
    public function paginate(
        PageRequest $pageRequest,
        ?string $tenantId = null,
        ?string $role = null,
        ?bool $isActive = null,
    ): array;
}
