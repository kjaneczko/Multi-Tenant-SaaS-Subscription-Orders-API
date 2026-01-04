<?php

declare(strict_types=1);

namespace App\Application\User\Handler;

use App\Application\User\Command\ListUserCommand;
use App\Domain\User\Interface\UserQueryInterface;

readonly class ListUserHandler
{
    public function __construct(
        private UserQueryInterface $query,
    ) {}

    public function __invoke(ListUserCommand $command): array
    {
        return $this->query->paginate(
            $command->pageRequest,
            $command->tenantId,
            $command->role,
            $command->isActive,
        );
    }
}
