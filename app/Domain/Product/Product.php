<?php

namespace App\Domain\Product;

use App\Domain\Currency;
use App\Domain\Exception\ValidationException;
use App\Domain\PriceCents;
use App\Domain\Sku;
use App\Domain\Slug;
use App\Domain\Tenant\TenantId;

class Product
{
    private function __construct(
        private readonly ProductId $id,
        private readonly TenantId $tenantId,
        private Sku $sku,
        private string $name,
        private Slug $slug,
        private ?string $description,
        private PriceCents $priceCents,
        private Currency $currency,
        private ProductStatus $status,
        private ?\DateTimeImmutable $deletedAt,
        private readonly ?\DateTimeImmutable $createdAt,
        private readonly ?\DateTimeImmutable $updatedAt,
    ) {
        $this->assertValidName($name);
    }

    public static function create(
        ProductId $id,
        TenantId $tenantId,
        Sku $sku,
        string $name,
        Slug $slug,
        ?string $description,
        PriceCents $priceCents,
        Currency $currency,
        ProductStatus $status,
        ?\DateTimeImmutable $deletedAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            sku: $sku,
            name: trim($name),
            slug: $slug,
            description: $description,
            priceCents: $priceCents,
            currency: $currency,
            status: $status,
            deletedAt: $deletedAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public static function reconstitute(
        ProductId $id,
        TenantId $tenantId,
        Sku $sku,
        string $name,
        Slug $slug,
        ?string $description,
        PriceCents $priceCents,
        Currency $currency,
        ProductStatus $status,
        ?\DateTimeImmutable $deletedAt,
        ?\DateTimeImmutable $createdAt,
        ?\DateTimeImmutable $updatedAt,
    ): self {
        return new self(
            id: $id,
            tenantId: $tenantId,
            sku: $sku,
            name: $name,
            slug: $slug,
            description: $description,
            priceCents: $priceCents,
            currency: $currency,
            status: $status,
            deletedAt: $deletedAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt,
        );
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function tenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function sku(): Sku
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): Slug
    {
        return $this->slug;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function priceCents(): PriceCents
    {
        return $this->priceCents;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function status(): ProductStatus
    {
        return $this->status;
    }

    public function deletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function createdAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeSku(Sku $sku): void
    {
        $this->sku = $sku;
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

    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }

    public function changePriceCents(PriceCents $priceCents): void
    {
        $this->priceCents = $priceCents;
    }

    public function changeCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public function changeStatus(ProductStatus $status): void
    {
        $this->status = $status;
    }

    public function changeDeletedAt(?\DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
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
