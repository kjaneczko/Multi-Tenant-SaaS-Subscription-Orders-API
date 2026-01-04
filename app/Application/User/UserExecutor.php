<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\Interface\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;

readonly class UserExecutor
{
    public function __construct(
        private UserRepositoryInterface $repository,
    ) {}

    public function getByIdOrFail(UserId $id): User
    {
        $user = $this->repository->getById($id);
        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function create(User $user): void
    {
        $this->repository->create($user);
    }

    public function updateOrFail(User $user): void
    {
        if (!$this->repository->update($user)) {
            throw new UserNotFoundException();
        }
    }

    public function deleteOrFail(UserId $id): void
    {
        if (!$this->repository->delete($id)) {
            throw new UserNotFoundException();
        }
    }
}
