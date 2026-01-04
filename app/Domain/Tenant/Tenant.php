<?php

declare(strict_types=1);

namespace App\Domain\Tenant;

use App\Domain\Exception\ValidationException;
use App\Domain\Slug;

class Tenant
{
    private function __construct(
        private readonly TenantId $id,
        private string $name,
        private Slug $slug,
        private TenantStatus $status,
        private readonly ?\DateTimeImmutable $createdAt,
        private readonly ?\DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidName($name);
    }

    public static function create(
        TenantId $id,
        string $name,
        Slug $slug,
        TenantStatus $status,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            name: trim($name),
            slug: $slug,
            status: $status,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function reconstitute(
        TenantId $id,
        string $name,
        Slug $slug,
        TenantStatus $status,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            name: $name,
            slug: $slug,
            status: $status,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public function id(): TenantId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function status(): TenantStatus
    {
        return $this->status;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeName(string $name): void
    {
        $this->assertValidName($name);
        $this->name = $name;
    }

    public function changeSlug(Slug $slug): void
    {
        $this->slug = $slug;
    }

    public function changeStatus(TenantStatus $status): void
    {
        $this->status = $status;
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
