<?php

declare(strict_types=1);

namespace App\Application\Product\Command;

use App\Application\Common\Interface\AuditableOperation;
use App\Domain\Currency;
use App\Domain\PriceCents;
use App\Domain\Sku;
use App\Domain\Slug;
use App\Domain\Tenant\TenantId;

final readonly class CreateProductCommand implements AuditableOperation
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

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
