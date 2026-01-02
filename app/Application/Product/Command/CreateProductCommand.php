<?php

namespace App\Application\Product\Command;

use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Sku;
use App\Domain\Slug;
use App\Domain\Tenant\TenantId;

final readonly class CreateProductCommand
{
    public function __construct(
        public TenantId $tenantId,
        public string $name,
        public Slug $slug,
        public Sku $sku,
        public PriceCents $priceCents,
        public Currency $currency,
        public ?string $description,
    ) {}
}
