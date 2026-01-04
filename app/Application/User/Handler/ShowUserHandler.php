<?php

declare(strict_types=1);

namespace App\Application\User\Handler;

use App\Application\User\Command\ShowUserCommand;
use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\Interface\UserQueryInterface;
use App\Domain\User\User;

readonly class ShowUserHandler
{
    public function __construct(
        private UserQueryInterface $repository,
    ) {}

    public function __invoke(ShowUserCommand $command): User
    {
        $user = $this->repository->getById($command->id);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
