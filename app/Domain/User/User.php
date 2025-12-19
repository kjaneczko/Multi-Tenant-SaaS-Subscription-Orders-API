<?php

namespace app\Domain\User;

use app\Domain\Tenant\TenantId;
use DateTime;

readonly class User
{
    private function __construct(
        private UserId $id,
        private TenantId $tenantId,
        private string $name,
        private string $email,
        private ?DateTime $emailVerifiedAt,
        private string $password,
        private string $role,
        private bool $isActive,
    ) {}

    public static function create(
        UserId $id,
        TenantId $tenantId,
        string $name,
        string $email,
        ?DateTime $emailVerifiedAt,
        string $password,
        string $role,
        bool $isActive,
    ): self
    {
        return new self(
            id: $id,
            tenantId: $tenantId,
            name: $name,
            email: $email,
            emailVerifiedAt: $emailVerifiedAt,
            password: $password,
            role: $role,
            isActive: $isActive,
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function tenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function emailVerifiedAt(): ?DateTime
    {
        return $this->emailVerifiedAt;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function role(): string
    {
        return $this->role;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
