<?php

declare(strict_types=1);

namespace App\Application\Product\Command;

use App\Application\Common\AuditCategory;
use App\Application\Common\Interface\AuditableOperation;
use App\Domain\EntityType;
use App\Domain\Product\ProductId;

readonly class ShowProductCommand implements AuditableOperation
{
    public function __construct(
        public ProductId $productId,
    ) {}

    public function auditCategory(): AuditCategory
    {
        return AuditCategory::AUDIT;
    }

    public function auditAction(): string
    {
        return EntityType::PRODUCT->value.'.show';
    }

    public function auditEntityType(): ?EntityType
    {
        return EntityType::PRODUCT;
    }

    public function auditEntityId(): ?string
    {
        return $this->productId->toString();
    }

    public function auditPayload(): array
    {
        return get_object_vars($this);
    }
}
