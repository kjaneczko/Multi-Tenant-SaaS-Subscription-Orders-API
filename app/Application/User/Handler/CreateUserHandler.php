<?php

declare(strict_types=1);

namespace App\Application\User\Handler;

use App\Application\Common\Interface\UuidGeneratorInterface;
use App\Application\User\Command\CreateUserCommand;
use App\Application\User\UserExecutor;
use App\Domain\User\User;
use App\Domain\User\UserId;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserExecutor $executor,
        private UuidGeneratorInterface $uuid,
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

        $this->executor->create($user);

        return $id;
    }
}
