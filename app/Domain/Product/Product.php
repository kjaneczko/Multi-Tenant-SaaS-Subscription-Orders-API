<?php

namespace app\Domain\Product;

use app\Domain\Tenant\TenantId;
use DateTime;

readonly class Product
{
    private function __construct(
        private ProductId $id,
        private TenantId $tenantId,
        private string $sku,
        private string $name,
        private string $slug,
        private string $description,
        private int $priceCents,
        private string $currency,
        private string $status,
        private ?DateTime $deletedAt,
    ) {}

    public static function create(
        ProductId $id,
        TenantId $tenantId,
        string $sku,
        string $name,
        string $slug,
        string $description,
        int $priceCents,
        string $currency,
        string $status,
        ?DateTime $deletedAt,
    ): self
    {
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

    public function currency(): string
    {
        return $this->currency;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function deletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}
