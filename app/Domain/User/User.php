<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Email;
use App\Domain\Exception\ValidationException;
use App\Domain\Tenant\TenantId;

class User
{
    private function __construct(
        private readonly UserId $id,
        private readonly TenantId $tenantId,
        private string $name,
        private Email $email,
        private ?\DateTimeImmutable $emailVerifiedAt,
        private string $password,
        private UserRole $role,
        private bool $isActive,
        private readonly ?\DateTimeImmutable $createdAt,
        private ?\DateTimeImmutable $updatedAt,
        private ?\DateTimeImmutable $deletedAt = null,
        private ?string $rememberToken = null,
    ) {
        $this->assertValidName($name);
    }

    public static function create(
        UserId $id,
        TenantId $tenantId,
        string $name,
        Email $email,
        ?\DateTimeImmutable $emailVerifiedAt,
        string $password,
        UserRole $role,
        bool $isActive,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
        ?\DateTimeImmutable $deletedAt = null,
        ?string $rememberToken = null,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            name: trim($name),
            email: $email,
            emailVerifiedAt: $emailVerifiedAt,
            password: $password,
            role: $role,
            isActive: $isActive,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            deletedAt: $deletedAt,
            rememberToken: $rememberToken,
        );
    }

    public static function reconstitute(
        UserId $id,
        TenantId $tenantId,
        string $name,
        Email $email,
        ?\DateTimeImmutable $emailVerifiedAt,
        string $password,
        UserRole $role,
        bool $isActive,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
        ?\DateTimeImmutable $deletedAt,
        ?string $rememberToken,
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
            deletedAt: $deletedAt,
            rememberToken: $rememberToken,
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

    public function email(): Email
    {
        return $this->email;
    }

    public function emailVerifiedAt(): ?\DateTimeImmutable
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

    public function deletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function rememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function changeName(string $name): void
    {
        $this->assertValidName($name);
        $this->name = $name;
        $this->touch();
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
        $this->emailVerifiedAt = null;
        $this->touch();
    }

    public function changeRole(UserRole $role): void
    {
        $this->role = $role;
        $this->touch();
    }

    public function deactivate(): void
    {
        $this->isActive = false;
        $this->touch();
    }

    public function activate(): void
    {
        $this->isActive = true;
        $this->touch();
    }

    public function markEmailVerified(\DateTimeImmutable $now): void
    {
        $this->emailVerifiedAt = $now;
        $this->touch();
    }

    public function changePassword(string $password): void
    {
        $this->password = $password;
        $this->touch();
    }

    public function remember(?string $token): void
    {
        $this->rememberToken = $token;
        $this->touch();
    }

    public function softDelete(\DateTimeImmutable $now): void
    {
        $this->deletedAt = $now;
        $this->touch();
    }

    public function restore(): void
    {
        $this->deletedAt = null;
        $this->touch();
    }

    private function touch(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
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
}
