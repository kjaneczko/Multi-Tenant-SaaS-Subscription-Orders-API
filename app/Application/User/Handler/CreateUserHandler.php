<?php

namespace App\Application\User\Handler;

use App\Application\Shared\Interface\UuidGeneratorInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\Interface\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $users,
        private UuidGeneratorInterface  $uuid,
    ) {}

    public function __invoke(CreateUserCommand $command): UserId
    {
        $id = new UserId($this->uuid->generate());

        $user = User::create(
            id: $id,
            tenantId: $command->tenantId,
            name: $command->name,
            email: $command->email,
            emailVerifiedAt: null,
            password: $command->password,
            role: $command->role,
            isActive: true,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $this->users->create($user);

        return $id;
    }
}
