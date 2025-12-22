<?php

namespace app\Domain\Tenant;

use app\Domain\Exception\ValidationException;

class Tenant
{
    private function __construct(
        private readonly TenantId $id,
        private string $name,
        private string $slug,
        private TenantStatus $status,
        private readonly ?\DateTimeImmutable $createdAt,
        private readonly ?\DateTimeImmutable $updatedAt,
    ) {
        self::assertValidName($name);
        self::assertValidSlug($slug);
    }

    public static function create(
        TenantId $id,
        string $name,
        string $slug,
        TenantStatus $status,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self
    {
        return new self(
            id: $id,
            name: trim($name),
            slug: trim($slug),
            status: $status,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function reconstitute(
        TenantId $id,
        string $name,
        string $slug,
        TenantStatus $status,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        self::assertValidName($name);
        self::assertValidSlug($slug);

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

    public function slug(): string
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
        self::assertValidName($name);
        $this->name = $name;
    }

    public function changeSlug(string $slug): void
    {
        self::assertValidSlug($slug);
        $this->slug = $slug;
    }

    public function changeStatus(TenantStatus $status): void
    {
        $this->status = $status;
    }

    private static function assertValidName(string $name): void
    {
        if ('' === trim($name)) {
            throw new ValidationException(['name' => ['Name is required.']]);
        }

        if (mb_strlen($name) > 255) {
            throw new ValidationException(['name' => ['Name is too long. Must be less than 256 characters.']]);
        }
    }

    private static function assertValidSlug(string $slug): void
    {
        if ('' === trim($slug)) {
            throw new ValidationException(['slug' => ['Slug is required.']]);
        }

        if (mb_strlen($slug) > 255) {
            throw new ValidationException(['slug' => ['Slug is too long. Must be less than 256 characters.']]);
        }
    }
}
