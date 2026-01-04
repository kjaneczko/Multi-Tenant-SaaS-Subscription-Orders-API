<?php

declare(strict_types=1);

namespace App\Domain\User\Interface;

use App\Domain\User\User;
use App\Domain\User\UserId;

interface UserRepositoryInterface
{
    public function getById(UserId $id): ?User;

    public function create(User $user): void;

    public function update(User $user): bool;

    public function delete(UserId $id): bool;
}
