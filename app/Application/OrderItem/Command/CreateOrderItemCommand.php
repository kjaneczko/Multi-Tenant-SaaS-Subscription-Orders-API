<?php

declare(strict_types=1);

namespace App\Application\OrderItem\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\Order\OrderId;
use App\Domain\PriceCents;
use App\Domain\Product\ProductId;
use App\Domain\Sku;
use App\Domain\Tenant\TenantId;

final readonly class CreateOrderItemCommand implements AuditableOperation
{
    public function __construct(
        public TenantId $tenantId,
        public OrderId $orderId,
        public ProductId $productId,
        public string $productNameSnapshot,
        public Sku $skuSnapshot,
        public int $quantity,
        public PriceCents $unitPriceCents,
    ) {}

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::ORDER_ITEM->value.'.create';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::ORDER_ITEM;
    }

    public function auditEntityId(): ?string
    {
        return null;
    }
}
