<?php

namespace app\Domain\Product;

use App\Domain\Currency;
use app\Domain\Exception\ValidationException;
use app\Domain\Tenant\TenantId;
use DateTime;
use DateTimeImmutable;

class Product
{
    private function __construct(
        private readonly ProductId          $id,
        private readonly TenantId           $tenantId,
        private string                      $sku,
        private string                      $name,
        private string                      $slug,
        private ?string                      $description,
        private int                         $priceCents,
        private Currency                    $currency,
        private ProductStatus               $status,
        private ?DateTime                   $deletedAt,
        private readonly ?DateTimeImmutable $createdAt,
        private readonly ?DateTimeImmutable $updatedAt,
    ) {}

    public static function create(
        ProductId     $id,
        TenantId      $tenantId,
        string        $sku,
        string        $name,
        string        $slug,
        ?string        $description,
        int           $priceCents,
        Currency      $currency,
        ProductStatus $status,
        ?DateTime     $deletedAt,
        ?DateTimeImmutable $createdAt,
        ?DateTimeImmutable $updatedAt,
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

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function priceCents(): int
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

    public function deletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }

    public function createdAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function changeSku(string $sku): void
    {
        $this->assertValidSku($sku);
        $this->sku = $sku;
    }

    public function changeName(string $name): void
    {
        $this->assertValidName($name);
        $this->name = $name;
    }

    public function changeSlug(string $slug): void
    {
        $this->assertValidSlug($slug);
        $this->slug = $slug;
    }

    public function changeDescription(string $description): void
    {
        $this->assertValidDescription($description);
        $this->description = $description;
    }

    public function changePriceCents(float $priceCents): void
    {
        $this->assertValidPriceCents($priceCents);
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

    public function changeDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    private function assertValidSku(string $sku): void
    {
        if (mb_strlen($sku) < 3) {
            throw new ValidationException(['sku' => ['Sku is too short. Must be at least 3 characters.']]);
        }

        if (mb_strlen($sku) > 255) {
            throw new ValidationException(['sku' => ['Sku is too long. Must be less than 256 characters.']]);
        }
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

    private function assertValidSlug(string $slug): void
    {
        if (mb_strlen($slug) < 3) {
            throw new ValidationException(['slug' => ['Slug is too short. Must be at least 3 characters.']]);
        }

        if (mb_strlen($slug) > 255) {
            throw new ValidationException(['slug' => ['Slug is too long. Must be less than 256 characters.']]);
        }
    }

    private function assertValidDescription(string $description): void
    {
        if ('' === $description) {
            throw new ValidationException(['description' => ['Description is required.']]);
        }
    }

    private function assertValidPriceCents(float $priceCents): void
    {
        if ($priceCents < 0) {
            throw new ValidationException(['priceCents' => ['Price must be greater than 0 or equal to 0.']]);
        }
    }
}
