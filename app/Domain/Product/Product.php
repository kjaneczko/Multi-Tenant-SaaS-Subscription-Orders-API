<?php

namespace app\Domain\Product;

use App\Domain\Currency;
use app\Domain\Exception\ValidationException;
use app\Domain\Tenant\TenantId;

class Product
{
    private function __construct(
        private readonly ProductId $id,
        private readonly TenantId $tenantId,
        private string $sku,
        private string $name,
        private string $slug,
        private string $description,
        private int $priceCents,
        private Currency $currency,
        private ProductStatus $status,
        private ?\DateTime $deletedAt,
    ) {}

    public static function create(
        ProductId $id,
        TenantId $tenantId,
        string $sku,
        string $name,
        string $slug,
        string $description,
        int $priceCents,
        Currency $currency,
        ProductStatus $status,
        ?\DateTime $deletedAt,
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

    public function description(): string
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

    public function deletedAt(): ?\DateTime
    {
        return $this->deletedAt;
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

    public function changeDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    private function assertValidSku(string $sku): void
    {
        $ERR = ['sku' => []];

        if (strlen($sku) < 3) {
            $ERR['sku'][] = 'Sku is too short. Must be at least 3 characters.';
        }

        if (strlen($sku) > 255) {
            $ERR['sku'][] = 'Sku is too long. Must be less than 255 characters.';
        }

        if (!empty($ERR)) {
            throw new ValidationException($ERR);
        }
    }

    private function assertValidName(string $name): void
    {
        $ERR = ['name' => []];

        if ('' === $name) {
            $ERR['name'][] = 'Name is required.';
        }

        if (strlen($name) > 255) {
            $ERR['name'][] = 'Name is too long. Must be less than 255 characters.';
        }

        if (!empty($ERR)) {
            throw new ValidationException($ERR);
        }
    }

    private function assertValidSlug(string $slug): void
    {
        $ERR = ['slug' => []];

        if (strlen($slug) < 3) {
            $ERR['slug'][] = 'Slug is too short. Must be at least 3 characters.';
        }

        if (strlen($slug) > 255) {
            $ERR['slug'][] = 'Slug is too long. Must be less than 255 characters.';
        }

        if (!empty($ERR)) {
            throw new ValidationException($ERR);
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
