<?php

namespace app\Domain\User;

use app\Domain\Exception\ValidationException;
use app\Domain\Tenant\TenantId;

readonly class User
{
    private function __construct(
        private UserId $id,
        private TenantId $tenantId,
        private string $name,
        private string $email,
        private ?\DateTime $emailVerifiedAt,
        private string $password,
        private UserRole $role,
        private bool $isActive,
        private ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidName($name);
        $this->assertValidEmail($email);
    }

    public static function create(
        UserId $id,
        TenantId $tenantId,
        string $name,
        string $email,
        ?\DateTime $emailVerifiedAt,
        string $password,
        UserRole $role,
        bool $isActive,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            name: $name,
            email: $email,
            emailVerifiedAt: $emailVerifiedAt,
            password: $password,
            role: $role,
            isActive: $isActive,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
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

    public function emailVerifiedAt(): ?\DateTime
    {
        return $this->emailVerifiedAt;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    private function assertValidName(string $name): void
    {
        if ('' === $name) {
            throw new ValidationException(['name' => ['Name is required.']]);
        }

        if (mb_strlen($name) > 255) {
            throw new ValidationException(['name' => ['Name is too long. Must be less than 256 characters.']]);
        }
    }

    private function assertValidEmail(string $email): void
    {
        if ('' === $email) {
            throw new ValidationException(['email' => ['Email is required.']]);
        }

        if (mb_strlen($email) > 255) {
            throw new ValidationException(['email' => ['Email is too long. Must be less than 256 characters.']]);
        }
    }
}
